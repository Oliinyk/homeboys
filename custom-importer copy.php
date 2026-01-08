<?php
/**
 * ГЛАВНЫЙ МЕТОД: Импорт постов через SQL + Мета + Галереи
 */
function smart_post_import($xml_path, $post_type, $keys_map, $limit = -1, $offset = 0) {
    global $wpdb;
    if (!file_exists($xml_path)) return "Файл не найден.";
    $xml = simplexml_load_file($xml_path);
    if (!$xml) return "Ошибка XML.";

    $count = 0;        // Счетчик обработанных (импортированных)
    $skipped = 0;      // Счетчик пропущенных по офсету
    $processed = 0;    // Общий счетчик найденных постов нужного типа

    foreach ($xml->channel->item as $item) {
        $wp_ns = $item->children('wp', true);
        
        // Фильтруем по типу поста
        if ((string)$wp_ns->post_type !== $post_type) continue;

        // 1. Логика OFFSET
        if ($skipped < $offset) {
            $skipped++;
            continue;
        }

        // 2. Логика LIMIT
        if ($limit !== -1 && $count >= $limit) break;

        $old_id = (int)$wp_ns->post_id;
        $title = (string)$item->title;
        $content = (string)$item->children('content', true)->encoded;
        $post_date = (string)$wp_ns->post_date;

        // СОЗДАНИЕ/ОБНОВЛЕНИЕ ПОСТА
        $exists = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE ID = %d", $old_id));
        if (!$exists) {
            $wpdb->insert($wpdb->posts, [
                'ID'                => $old_id,
                'post_title'        => $title,
                'post_content'      => $content,
                'post_status'       => 'publish',
                'post_type'         => $post_type,
                'post_name'         => (string)$wp_ns->post_name,
                'post_date'         => $post_date,
                'post_date_gmt'     => $post_date,
                'post_author'       => 1,
            ]);
            clean_post_cache($old_id);
            echo "<b>[NEW]</b> ID {$old_id}: {$title}<br>";
        } else {
            echo "<b>[SKIP]</b> ID {$old_id} уже существует.<br>";
        }

        // СБОР МЕТА И ОБРАБОТКА (твои ключи + MD5 логика внутри _gallery_import)
        $xml_metas = [];
        foreach ($wp_ns->postmeta as $meta) {
            $xml_metas[(string)$meta->meta_key] = (string)$meta->meta_value;
        }

        foreach ($keys_map as $xml_key => $config) {
            $carbon_key = is_array($config) ? (isset($config['key']) ? $config['key'] : $config[0]) : $config;
            $type = (is_array($config) && isset($config['type'])) ? $config['type'] : 'text';
            $val = isset($xml_metas[$xml_key]) ? $xml_metas[$xml_key] : '';

            if ($type === 'gallery') {
                _gallery_import($old_id, $carbon_key, $val, $xml);
            } else {
                update_post_meta($old_id, '_' . $carbon_key, $val);
            }
        }

        $count++;
    }
    return "<br>Обработано постов: {$count}. Пропущено по офсету: {$skipped}.";
}

/**
 * ИМПОРТ ГАЛЕРЕИ И КАРТИНОК
 */
function _gallery_import($post_id, $carbon_key, $raw_value, $xml_object) {
    global $wpdb;
    $data = maybe_unserialize($raw_value);
    $old_ids = is_array($data) ? $data : [];
    if (empty($old_ids)) {
        preg_match_all('/\d+/', (string)$raw_value, $matches);
        $old_ids = array_unique(array_filter(array_map('intval', $matches[0])));
    }

    $final_ids = [];
    foreach ($old_ids as $old_id) {
        $img_url = ''; $img_title = '';
        foreach ($xml_object->channel->item as $item) {
            $wp = $item->children('wp', true);
            if ((int)$wp->post_id === (int)$old_id) {
                $img_url = !empty($wp->attachment_url) ? (string)$wp->attachment_url : (string)$item->guid;
                $img_title = (string)$item->title;
                break;
            }
        }

        if ($img_url) {
            // Загружаем или находим уже существующую по имени файла
            $current_id = download_external_file_with_original_name($img_url, $post_id, $img_title);

            if ($current_id && !is_wp_error($current_id)) {
                // Пытаемся занять оригинальный ID, если он свободен
                if ((int)$current_id !== (int)$old_id) {
                // 1. Проверяем, кто сейчас сидит на месте $old_id
                $occupied_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE ID = %d", $old_id));

                if ($occupied_id) {
                    // 2. ЕСЛИ ЗАНЯТО: Находим самый большой ID в базе и выталкиваем туда текущего владельца
                    $max_id = $wpdb->get_var("SELECT MAX(ID) FROM $wpdb->posts") + 1;
                    
                    // Отодвигаем "жильца", чтобы освободить место для нашей картинки
                    $wpdb->update($wpdb->posts, ['ID' => $max_id], ['ID' => $old_id]);
                    $wpdb->update($wpdb->postmeta, ['post_id' => $max_id], ['post_id' => $old_id]);
                    
                    echo "";
                }

                // 3. Теперь место ТОЧНО свободно. Перебиваем ID картинки на нужный
                $wpdb->update($wpdb->posts, ['ID' => $old_id], ['ID' => $current_id]);
                $wpdb->update($wpdb->postmeta, ['post_id' => $old_id], ['post_id' => $current_id]);
                clean_post_cache($old_id);
                $current_id = $old_id;
            }
                $final_ids[] = $current_id;
            }
        }
    }

    // Запись структуры Carbon Fields
    if ($carbon_key !== 'thumbnail_placeholder' && !empty($final_ids)) {
        $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE post_id = %d AND (meta_key = %s OR meta_key LIKE %s)", $post_id, '_' . $carbon_key, '_' . $carbon_key . '|||%'));
        foreach ($final_ids as $index => $id) {
            $wpdb->insert($wpdb->postmeta, [
                'post_id'    => $post_id,
                'meta_key'   => "_{$carbon_key}|||{$index}|value",
                'meta_value' => $id
            ]);
        }
    }
}

/**
 * СКАЧИВАНИЕ ФАЙЛА С ПРОВЕРКОЙ ПО ИМЕНИ
 */
function download_external_file_with_original_name($url, $parent_id, $title) {
    global $wpdb;
    static $md5_cache = []; 

    if (empty($url)) return false;

    // 1. Статический кеш (текущий PHP процесс)
    if (isset($md5_cache[$url])) return $md5_cache[$url];

    // 2. Поиск по URL в базе (прошлые PHP процессы)
    $existing_id = $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_original_source_url' AND meta_value = %s LIMIT 1",
        $url
    ));
    if ($existing_id) {
        $md5_cache[$url] = $existing_id;
        return $existing_id;
    }

    // --- СКАЧИВАЕМ ДЛЯ ПРОВЕРКИ MD5 ---
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $tmp = download_url($url);
    if (is_wp_error($tmp)) return $tmp;

    $file_hash = md5_file($tmp);

    // 3. ПРОВЕРКА ПО MD5 В БАЗЕ
    $id_by_hash = $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_source_md5' AND meta_value = %s LIMIT 1",
        $file_hash
    ));

    if ($id_by_hash) {
        @unlink($tmp);
        update_post_meta($id_by_hash, '_original_source_url', $url);
        $md5_cache[$url] = $id_by_hash;
        return $id_by_hash;
    }

    // 4. ЗАЩИТА "ОТ ОЧЕРЕДИ": проверяем, не загружает ли кто-то этот хеш ПРЯМО СЕЙЧАС
    $lock_key = 'import_lock_' . $file_hash;
    if (get_transient($lock_key)) {
        @unlink($tmp);
        sleep(1); // Ждем секунду и пробуем найти в базе снова (рекурсия)
        return download_external_file_with_original_name($url, $parent_id, $title);
    }
    set_transient($lock_key, 'true', 30); // Ставим замок на 30 сек

    // 5. ГРУЗИМ
    $file_name = basename(parse_url($url, PHP_URL_PATH));
    $id = media_handle_sideload(['name' => $file_name, 'tmp_name' => $tmp], $parent_id, $title);
    
    if (!is_wp_error($id)) {
        update_post_meta($id, '_source_md5', $file_hash);
        update_post_meta($id, '_original_source_url', $url);
        $md5_cache[$url] = $id;
    }

    delete_transient($lock_key); // Снимаем замок
    return $id;
}