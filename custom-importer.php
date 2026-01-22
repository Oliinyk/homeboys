<?php
/**
 * ГЛАВНЫЙ МЕТОД: Импорт постов через SQL + Мета + Галереи
 */
function smart_post_import($xml_path, $post_type, $keys_map, $limit = -1, $offset = 0) {
    global $wpdb;
    
    if (!file_exists($xml_path)) return "<div style='color:red;'>СТОП: Файл не найден.</div>";
    $xml = simplexml_load_file($xml_path);
    if (!$xml) return "<div style='color:red;'>СТОП: Ошибка XML.</div>";

    $processed_in_xml = 0; 
    $imported_count = 0;

    echo "<div style='font-family:monospace; background:#f4f4f4; padding:20px; border:1px solid #ccc;'>";
    echo "<h3>🚀 СИНХРОНИЗАЦИЯ: [$post_type] | Offset: $offset | Limit: $limit</h3>";

    foreach ($xml->channel->item as $item) {
        $wp_ns = $item->children('wp', true);
        if ((string)$wp_ns->post_type !== $post_type) continue;

        $processed_in_xml++; 
        if ($processed_in_xml <= $offset) continue;
        if ($limit !== -1 && $imported_count >= $limit) break;

        $imported_count++;
        $old_id = (int)$wp_ns->post_id;
        $title = (string)$item->title;
        $content = (string)$item->children('content', true)->encoded;
        $post_name = (string)$wp_ns->post_name;

        echo "<div style='background:#fff; border-left:4px solid #333; margin-bottom:15px; padding:10px;'>";
        echo "<b>Запись #$processed_in_xml</b> (XML ID: $old_id) — $title <br>";

        // --- ЛОГИКА ПОИСКА МОСТА ---
        $post_id_in_db = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE ID = %d AND post_type = %s", $old_id, $post_type));
        
        if (!$post_id_in_db) {
            $post_id_in_db = $wpdb->get_var($wpdb->prepare(
                "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type = %s LIMIT 1", 
                $post_name, $post_type
            ));
            if ($post_id_in_db) echo "<span style='color:purple;'>[MATCHED BY SLUG]</span> Найден старый пост с ID $post_id_in_db <br>";
        }

        $target_id = $post_id_in_db;

        if (!$target_id) {
            $wpdb->insert($wpdb->posts, [
                'ID'             => $old_id,
                'post_title'     => $title,
                'post_content'   => $content,
                'post_status'    => 'publish',
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
                'post_type'      => $post_type,
                'post_name'      => $post_name,
                'post_date'      => (string)$wp_ns->post_date,
                'post_author'    => 1,
            ]);
            $target_id = $old_id;
            echo "<span style='color:green;'>[NEW]</span> Создан с сохранением ID.<br>";
        };

        $xml_metas = [];
        foreach ($wp_ns->postmeta as $meta) {
            $xml_metas[(string)$meta->meta_key] = (string)$meta->meta_value;
        }

        foreach ($keys_map as $xml_key => $config) {
            $carbon_key = is_array($config) ? $config['key'] : $config;
            $type = (isset($config['type'])) ? $config['type'] : 'text';
            $val  = isset($xml_metas[$xml_key]) ? $xml_metas[$xml_key] : '';

            // if ( $val == '' ) {
            //     continue;
            // }

            if ( $type === 'content' ) {
                if ( isset( $xml_metas[ $xml_key ] ) ) {
                    $content = $xml_metas[ $xml_key ];
                    echo "<span style='color:orange;'>[CONTENT UPDATED FROM META: {$xml_key}]</span><br>";
                }

            echo "<span style='color:blue;'>[UPDATE]</span> Синхронизировано с ID $target_id.<br>";
                continue;
            } elseif ($type === 'gallery') {
                echo "Начинаю импорт галереи<br>";
                _gallery_import($target_id, $carbon_key, $val, $xml);
            } elseif ($type === 'file') {
                $attach_node = $xml->xpath('//item[wp:post_id="' . $val . '"]');
                if ($attach_node) {
                    $at_wp = $attach_node[0]->children('wp', true);
                    $file_id = download_external_file_with_original_name(
                        (string)$at_wp->attachment_url, 
                        $target_id, 
                        (string)$attach_node[0]->title, 
                        (string)$at_wp->post_date
                    );
                    if ($file_id && !is_wp_error($file_id)) {
                        update_post_meta($target_id, '_' . $carbon_key, $file_id);
                        echo " — Файл [$carbon_key]: OK (ID: $file_id)<br>";
                    }
                }
            } elseif ($type === 'int') {
                $numeric_val = preg_replace('/[^0-9]/', '', $val);
                update_post_meta($target_id, '_' . $carbon_key , $numeric_val);
            } else {
                update_post_meta($target_id, '_' . $carbon_key , $val);
            }
        }

        $wpdb->update($wpdb->posts, [
                'post_title'     => $title,
                'post_content'   => $content, 
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
                'post_name'      => $post_name
            ], ['ID' => $target_id]);
            echo "<span style='color:blue;'>[UPDATE]</span> Синхронизировано с ID $target_id.<br>";

        clean_post_cache($target_id);
        echo "</div>";
    }
    echo "<h3>✅ Готово.</h3></div>";
    return "";
}

/**
 * ИМПОРТ ГАЛЕРЕИ И КАРТИНОК
 */
function _gallery_import( $post_id, $carbon_key, $raw_value, $xml ) {
    $xml->registerXPathNamespace('wp', 'http://wordpress.org/export/1.2/');
    $xml_ids = maybe_unserialize( $raw_value );

    // echo "<pre>";
    // var_dump($xml->xpath("//item[wp:post_id={$xml_ids[0]}]"));
    // echo "</pre>";

    // return;

    if ( empty( $xml_ids ) || ! is_array( $xml_ids ) ) {
        echo " — Галерея пуста (meta empty).<br>";
        return;
    }

    $final_ids = [];

    foreach ( $xml_ids as $xml_attach_id ) {
        $attach_node = $xml->xpath("//item[wp:post_id={$xml_attach_id}]");

        if ( ! $attach_node ) {
            echo "attach_node $xml_attach_id NOT FOUND <br>";
            continue;
        }

        $attach = $attach_node[0];
        $wp     = $attach->children('wp', true);

        $url   = (string) $wp->attachment_url;
        $title = (string) $attach->title;
        $date  = (string) $wp->post_date;
        $mime  = (string) $wp->post_mime_type;

        // if ( strpos( $mime, 'image/' ) !== 0 ) {
        //     continue;
        // }

        $id = download_external_file_with_original_name( $url, $post_id, $title, $date );

        echo "Файл галереи {$id}";

        if ( $id && ! is_wp_error( $id ) ) {
            $final_ids[] = (int) $id;
        }
    }

    if ( empty( $final_ids ) ) {
        echo " — Галерея не собрана.<br>";
        return;
    }

    $final_ids = array_values( array_unique( $final_ids ) );

    global $wpdb;
    $wpdb->delete(
        $wpdb->postmeta,
        [ 'post_id' => $post_id ],
        [ '%d' ]
    );

    foreach ( $final_ids as $i => $id ) {
        update_post_meta( $post_id, "_{$carbon_key}|||{$i}|value", $id );
    }

    echo "Галерея обновлена ({$post_id}), элементов: " . count($final_ids) . "<br>";
}


function find_attachment_by_external_hash( $hash ) {
    global $wpdb;

    return (int) $wpdb->get_var( $wpdb->prepare(
        "
        SELECT post_id
        FROM {$wpdb->postmeta}
        WHERE meta_key = '_external_file_hash'
        AND meta_value = %s
        LIMIT 1
        ",
        $hash
    ));
}

/**
 * СКАЧИВАНИЕ ФАЙЛА С ПРОВЕРКОЙ ПО ИМЕНИ
 */
function download_external_file_with_original_name( $url, $parent_id = 0, $title = '', $post_date = '' ) {

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $tmp = download_url( $url );
    if ( is_wp_error( $tmp ) ) {
        return $tmp;
    }

    $hash = md5_file( $tmp );

    if ( $existing_id = find_attachment_by_external_hash( $hash ) ) {
        @unlink( $tmp );

        echo "( already exists )<br>";
        return $existing_id;
    }

    $filename = basename( parse_url( $url, PHP_URL_PATH ) );

    $file = [
        'name'     => $filename,
        'tmp_name' => $tmp
    ];

    $attachment_id = media_handle_sideload( $file, $parent_id, $title );

    if ( is_wp_error( $attachment_id ) ) {
        @unlink( $tmp );
        return $attachment_id;
    }

    update_post_meta( $attachment_id, '_external_file_hash', $hash );

    echo "( uploaded )<br>";

    if ( $post_date ) {
        wp_update_post([
            'ID'        => $attachment_id,
            'post_date' => $post_date
        ]);
    }

    return $attachment_id;
}

function mark_existing_attachments_with_hash() {

    $args = [
        'post_type' => 'attachment',
        'post_status'    => 'inherit',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_query'     => [
            [
                'key'     => '_external_file_hash',
                'compare' => 'NOT EXISTS'
            ]
        ]
    ];

    $attachment_ids = get_posts( $args );

    $processed = 0;

    foreach ( $attachment_ids as $att_id ) {

        $file = get_attached_file( $att_id );

        if ( ! $file || ! file_exists( $file ) ) {
            continue;
        }

        $hash = md5_file( $file );

        if ( ! $hash ) {
            continue;
        }

        update_post_meta( $att_id, '_external_file_hash', $hash );
        $processed++;

        echo "Attachment {$att_id}: meta-hash updated<br>";
    }

    echo "Marked hash for {$processed} files";
    return $processed;
}

function deduplicate_attachments_by_hash( $dry_run = true ) {
    global $wpdb;

    $duplicates = scan_duplicate_attachments_by_hash();
    $log = [];

    foreach ( $duplicates as $group ) {

        $keep_id = $group['keep'];

        foreach ( $group['dupes'] as $dupe_id ) {

            // 1. Перепривязка _thumbnail_id
            if ( ! $dry_run ) {
                $wpdb->update(
                    $wpdb->postmeta,
                    [ 'meta_value' => $keep_id ],
                    [ 'meta_key' => '_thumbnail_id', 'meta_value' => $dupe_id ]
                );
            }

            // 2. Перепривязка всех meta (галереи, ACF, serialized)
            $meta_rows = $wpdb->get_results( $wpdb->prepare(
                "
                SELECT post_id, meta_key, meta_value
                FROM {$wpdb->postmeta}
                WHERE meta_value = %s
                ",
                $dupe_id
            ));

            foreach ( $meta_rows as $row ) {

                $new_value = maybe_unserialize( $row->meta_value );

                if ( is_array( $new_value ) ) {
                    array_walk_recursive( $new_value, function ( &$v ) use ( $dupe_id, $keep_id ) {
                        if ( (int)$v === (int)$dupe_id ) {
                            $v = $keep_id;
                        }
                    });

                    $new_value = maybe_serialize( $new_value );
                } elseif ( (int)$row->meta_value === (int)$dupe_id ) {
                    $new_value = $keep_id;
                } else {
                    continue;
                }

                if ( ! $dry_run ) {
                    $wpdb->update(
                        $wpdb->postmeta,
                        [ 'meta_value' => $new_value ],
                        [
                            'post_id'  => $row->post_id,
                            'meta_key'=> $row->meta_key
                        ]
                    );
                }
            }

            // 3. Удаление attachment
            if ( ! $dry_run ) {
                wp_delete_attachment( $dupe_id, true );
            }

            $log[] = [
                'kept'    => $keep_id,
                'removed' => $dupe_id
            ];
        }
    }

    return $log;
}

function scan_duplicate_attachments_by_hash() {
    global $wpdb;

    $rows = $wpdb->get_results(
        "
        SELECT meta_value AS hash, COUNT(*) AS cnt
        FROM {$wpdb->postmeta}
        WHERE meta_key = '_external_file_hash'
        GROUP BY meta_value
        HAVING cnt > 1
        ",
        ARRAY_A
    );

    $report = [];

    foreach ( $rows as $row ) {

        $hash = $row['hash'];

        $ids = $wpdb->get_col( $wpdb->prepare(
            "
            SELECT post_id
            FROM {$wpdb->postmeta}
            WHERE meta_key = '_external_file_hash'
            AND meta_value = %s
            ORDER BY post_id ASC
            ",
            $hash
        ));

        $report[] = [
            'hash'  => $hash,
            'keep'  => (int) $ids[0],
            'dupes' => array_map( 'intval', array_slice( $ids, 1 ) )
        ];
    }

    return $report;
}

$plans_import_file = get_template_directory() . '/plans.WordPress.2025-12-23.xml';
$galeries_import_file = get_template_directory() . '/galleries.WordPress.2026-01-06.xml';

$plans_keys = [
    'plan_name'             => [ 'key' => 'plan_name' ],
    'plan_order'            => [ 'key' => 'plan_order' ],
    'plan_beds'             => [ 'key' => 'plan_beds' ],
    'plan_baths'            => [ 'key' => 'plan_baths' ],
    'plan_size'             => [ 'key' => 'plan_size' ],
    'plan_price'            => [ 'key' => 'plan_price', 'type' => 'int' ],
    'plan_series'           => [ 'key' => 'plan_series' ],
    'plan_manufacturer'     => [ 'key' => 'plan_manufacturer' ],
    'plan_number'           => [ 'key' => 'plan_number' ],
    'plan_width'            => [ 'key' => 'plan_width' ],
    'plan_type'             => [ 'key' => 'plan_type' ],
    'plan_tour'             => [ 'key' => 'plan_tour' ],
    'plan_location'         => [ 'key' => 'plan_location' ],
    'matterport_embed'      => [ 'key' => 'matterport_embed' ],
    'youtube_embed'         => [ 'key' => 'youtube_embed' ],
    'plan_description'      => [ 'key' => 'plan_description' ],

    // 'plan_brochure'  => [ 'key' => 'plan_brochure'  , 'type' => 'file' ],
    // 'plan_brochure2' => [ 'key' => 'plan_brochure2' , 'type' => 'file' ],
    // 'plan_brochure3' => [ 'key' => 'plan_brochure3' , 'type' => 'file' ],
    // 'plan_brochure4' => [ 'key' => 'plan_brochure4' , 'type' => 'file' ],
    // 'plan_photos'    => [ 'key' => 'plan_photos'    , 'type' => 'gallery' ],
];

$galeries_keys = [
    'gallery_name'        => [ 'key' => 'gallery_name' ],
    'gallery_description' => [ 'key' => 'gallery_description' ],
    'gallery_photos'      => [ 'key' => 'gallery_photos', 'type' => 'gallery' ],
];

// echo '<pre>';
// print_r( mark_existing_attachments_with_hash() );
// echo '</pre>';

// echo '<pre>';
// print_r( scan_duplicate_attachments_by_hash() );
// echo '</pre>';

// echo '<pre>';
// print_r( deduplicate_attachments_by_hash(false) );
// echo '</pre>';

// echo smart_post_import( $plans_import_file, 'plans', $plans_keys, 50 );