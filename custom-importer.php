<?php
/**
 * ГЛАВНЫЙ МЕТОД: Импорт постов через SQL + Мета + Галереи
 */
function smart_post_import($xml_path, $post_type, $keys_map, $limit = -1, $offset = 0) {
    global $wpdb;
    
    if (!file_exists($xml_path)) return "<div style='color:red;'>СТОП: Файл $xml_path не найден.</div>";
    $xml = simplexml_load_file($xml_path);
    if (!$xml) return "<div style='color:red;'>СТОП: Ошибка парсинга XML.</div>";

    $processed_in_xml = 0; 
    $imported_count = 0;

    echo "<div style='font-family:monospace; background:#f4f4f4; padding:20px; border:1px solid #ccc;'>";
    echo "<h3>🚀 Запуск импорта: Тип [$post_type] | Offset: $offset | Limit: $limit</h3>";

    foreach ($xml->channel->item as $item) {
        $wp_ns = $item->children('wp', true);
        if ((string)$wp_ns->post_type !== $post_type) continue;

        $processed_in_xml++; 
        if ($processed_in_xml <= $offset) continue;
        if ($limit !== -1 && $imported_count >= $limit) break;

        $imported_count++;
        $old_id = (int)$wp_ns->post_id;
        $title = (string)$item->title;
        $post_name = (string)$wp_ns->post_name;
        $post_date = (string)$wp_ns->post_date;
        $content = (string)$item->children('content', true)->encoded;

        echo "<div style='background:#fff; border-left:4px solid #333; margin-bottom:15px; padding:10px;'>";
        echo "<b>#$processed_in_xml (XML ID: $old_id)</b>: $title <br>";

        $db_post = $wpdb->get_row($wpdb->prepare("SELECT ID, post_type FROM $wpdb->posts WHERE ID = %d", $old_id));
        $target_id = $old_id;

        if (!$db_post) {
            // INSERT: Закрываем комментарии и пингбэки сразу
            $wpdb->insert($wpdb->posts, [
                'ID'             => $old_id,
                'post_title'     => $title,
                'post_content'   => $content,
                'post_status'    => 'publish',
                'comment_status' => 'closed', // КОММЕНТЫ ЗАКРЫТЫ
                'ping_status'    => 'closed',
                'post_type'      => $post_type,
                'post_name'      => $post_name,
                'post_date'      => $post_date,
                'post_author'    => 1,
            ]);
            echo "<span style='color:green;'>[NEW]</span> Создан с ID $old_id. Комментарии закрыты.<br>";
        } 
        elseif ($db_post->post_type === $post_type) {
            // UPDATE: Обновляем контент и закрываем комментарии
            $wpdb->update($wpdb->posts, [
                'post_title'     => $title,
                'post_content'   => $content,
                'comment_status' => 'closed', // КОММЕНТЫ ЗАКРЫТЫ
                'ping_status'    => 'closed',
            ], ['ID' => $old_id]);
            echo "<span style='color:blue;'>[UPDATE]</span> Обновлен ID $old_id. Комментарии закрыты.<br>";
        } 
        else {
            // SHIFT: Создаем новый пост через wp_insert_post
            $target_id = wp_insert_post([
                'post_title'     => $title,
                'post_content'   => $content,
                'post_status'    => 'publish',
                'comment_status' => 'closed', // КОММЕНТЫ ЗАКРЫТЫ
                'ping_status'    => 'closed',
                'post_type'      => $post_type,
                'post_name'      => $post_name,
                'post_date'      => $post_date,
            ]);
            echo "<span style='color:orange;'>[SHIFT]</span> ID $old_id занят. Новый ID: $target_id.<br>";
        }

        // МЕТА-ДАННЫЕ
        $xml_metas = [];
        foreach ($wp_ns->postmeta as $meta) {
            $xml_metas[(string)$meta->meta_key] = (string)$meta->meta_value;
        }

        foreach ($keys_map as $xml_key => $config) {
            $carbon_key = is_array($config) ? (isset($config['key']) ? $config['key'] : $config[0]) : $config;
            $type = (is_array($config) && isset($config['type'])) ? $config['type'] : 'text';
            $val = isset($xml_metas[$xml_key]) ? $xml_metas[$xml_key] : '';

            if ($type === 'gallery') {
                _gallery_import($target_id, $carbon_key, $val, $xml);
            } else {
                update_post_meta($target_id, '_' . $carbon_key, $val);
            }
        }
        clean_post_cache($target_id);
        echo "</div>";
    }
    echo "<h3>✅ Готово. Обработано: $imported_count</h3></div>";
    return "";
}

/**
 * ИМПОРТ ГАЛЕРЕИ И КАРТИНОК
 */
function _gallery_import($post_id, $carbon_key, $raw_value, $xml) {
    // Получаем список вложений из XML для этого поста
    $attachments = $xml->xpath("//item[wp:post_parent=$post_id and wp:post_type='attachment']");
    
    if (empty($attachments)) {
        echo " — Галерея пуста (аттачменты не найдены).<br>";
        return;
    }

    $final_ids = [];

    foreach ($attachments as $attach) {
        $img_url = (string)$attach->children('wp', true)->attachment_url;
        $img_title = (string)$attach->title;
        $img_date = (string)$attach->children('wp', true)->post_date;

        // Загружаем/ищем файл
        $current_id = download_external_file_with_original_name($img_url, $post_id, $img_title, $img_date);

        if ($current_id && !is_wp_error($current_id)) {
            $final_ids[] = (int)$current_id;
        }
    }

    // КЛЮЧЕВОЙ МОМЕНТ: Убираем дубликаты ID перед сохранением
    $final_ids = array_unique($final_ids);

    // Чистим старые мета-поля этой галереи перед записью, чтобы не плодить мусор
    global $wpdb;
    $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE post_id = %d AND meta_key LIKE %s", $post_id, '_' . $carbon_key . '%'));

    // Записываем в формате Carbon Fields
    foreach ($final_ids as $index => $id) {
        update_post_meta($post_id, "_{$carbon_key}|||$index|value", $id);
        echo "  → Добавлено фото ID $id в позицию $index<br>";
    }
    
    echo " — Итого в галерее: " . count($final_ids) . " фото.<br>";
}

/**
 * СКАЧИВАНИЕ ФАЙЛА С ПРОВЕРКОЙ ПО ИМЕНИ
 */
function download_external_file_with_original_name($url, $parent_id, $title, $xml_date = '') {
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    global $wpdb;
    static $md5_cache = []; 

    if (empty($url)) return false;

    // 1. Ищем, есть ли у нас уже этот URL
    $existing = $wpdb->get_row($wpdb->prepare(
        "SELECT p.ID, pm.meta_value as last_sync 
         FROM {$wpdb->posts} p 
         LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id AND pm.meta_key = '_xml_last_mod'
         WHERE p.ID = (SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_original_source_url' AND meta_value = %s LIMIT 1)",
        $url
    ));

    // 2. Если файл есть И дата в XML совпадает с нашей — отдаем ID (пропускаем скачивание)
    if ($existing && $existing->last_sync === $xml_date) {
        return $existing->ID;
    }

    // 3. Если даты нет или она новее — качаем и проверяем MD5
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    $tmp = download_url($url);
    if (is_wp_error($tmp)) return $tmp;

    $file_hash = md5_file($tmp);

    // Проверяем: может файл тот же (MD5 совпал), просто дата в XML обновилась?
    $id_by_hash = $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_source_md5' AND meta_value = %s LIMIT 1",
        $file_hash
    ));

    if ($id_by_hash) {
        @unlink($tmp);
        update_post_meta($id_by_hash, '_xml_last_mod', $xml_date); // Обновляем дату
        return $id_by_hash;
    }

    // 4. Если MD5 реально другой — это новая картинка. Загружаем!
    $file_name = basename(parse_url($url, PHP_URL_PATH));
    $id = media_handle_sideload(['name' => $file_name, 'tmp_name' => $tmp], $parent_id, $title);
    
    if (!is_wp_error($id)) {
        update_post_meta($id, '_source_md5', $file_hash);
        update_post_meta($id, '_original_source_url', $url);
        update_post_meta($id, '_xml_last_mod', $xml_date);
    }

    return $id;
}