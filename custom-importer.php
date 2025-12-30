<?php
require_once(ABSPATH . 'wp-load.php');

global $wpdb;

$fields_to_fix = [
    // 'plan_order', 
    // 'plan_beds',
    // 'plan_baths',
    'plan_garages',
    // 'plan_size',
    // 'plan_price',
    // 'plan_type',
    'plan_style',
    // 'plan_tour',
    // 'plan_description',
    // 'plan_photos',
    // 'plan_number',
    // 'plan_manufacturer',
    // 'plan_width',
    // 'plan_brochure',
    // 'plan_brochure2',
    // 'plan_brochure3',
    // 'plan_brochure4',
    // 'plan_series',
    // 'plan_location',
    'plan_features',
    'display_homes',
    'display_communities',
    // 'matterport_embed',
    // 'youtube_embed',
];


// foreach ($fields_to_fix as $field) {
//     $wpdb->query($wpdb->prepare(
//         "UPDATE {$wpdb->postmeta} SET meta_key = %s WHERE meta_key = %s",
//         '_' . $field, 
//         $field        
//     ));
// }
// echo "Ключи обновлены под стандарт Carbon Fields!";

$xml_file_path = get_template_directory() . '/homeboys.WordPress.2025-12-23.xml';

if (!is_super_admin()) die('Доступ запрещен');
set_time_limit(0);

if (!file_exists($xml_file_path)) {
    die("Файл $xml_file_path не найден.");
}

// 2. Используем уникальное имя переменной, чтобы не конфликтовать с WP
$my_custom_xml_data = simplexml_load_file($xml_file_path, 'SimpleXMLElement', LIBXML_NOCDATA);


// require_once(ABSPATH . 'wp-admin/includes/image.php');
// require_once(ABSPATH . 'wp-admin/includes/file.php');
// require_once(ABSPATH . 'wp-admin/includes/media.php');

// if (!is_super_admin()) die('Доступ запрещен');
// set_time_limit(0);

// $xml_file = get_template_directory() . '/homeboys.WordPress.2025-12-23.xml';
// $xml = simplexml_load_file($xml_file, 'SimpleXMLElement', LIBXML_NOCDATA);
// $namespaces = $xml->getNamespaces(true);

// echo "Начинаем загрузку медиафайлов...<br>";

// foreach ($xml->channel->item as $item) {
//     $wp = $item->children($namespaces['wp']);
    
//     // Нас интересуют только вложения (attachment)
//     if ((string)$wp->post_type !== 'attachment') continue;

//     $file_url = (string)$wp->attachment_url;
//     $parent_id_old = (string)$wp->post_parent; // ID родителя из старой базы
//     $post_title = (string)$item->title;

//     // 1. Проверяем, не загружен ли уже этот файл
//     $existing_id = attachment_url_to_postid(basename($file_url));
//     if ($existing_id) {
//         echo "Файл уже существует: " . basename($file_url) . "<br>";
//         continue;
//     }

//     // 2. Загружаем файл в Media Library
//     $attachment_id = media_sideload_image($file_url, 0, $post_title, 'id');

//     if (!is_wp_error($attachment_id)) {
//         echo "Загружено: " . basename($file_url) . " (ID: $attachment_id)<br>";
        
//         // 3. Пытаемся найти новый ID родительского поста
//         // Т.к. мы переносили посты по заголовкам, ищем родителя по заголовку
//         if ($parent_id_old > 0) {
//             $parent_item = null;
//             // Ищем в XML заголовок родителя по его старому ID
//             foreach ($xml->channel->item as $parent_search) {
//                 $ps_wp = $parent_search->children($namespaces['wp']);
//                 if ((string)$ps_wp->post_id == $parent_id_old) {
//                     $parent_title = (string)$parent_search->title;
//                     $new_parent = get_page_by_title($parent_title, OBJECT, 'plans');
                    
//                     if ($new_parent) {
//                         // Устанавливаем миниатюру (Featured Image)
//                         set_post_thumbnail($new_parent->ID, $attachment_id);
//                         echo "--- Привязано как миниатюра к: " . $parent_title . "<br>";
//                     }
//                     break;
//                 }
//             }
//         }
//     } else {
//         echo "Ошибка загрузки " . $file_url . ": " . $attachment_id->get_error_message() . "<br>";
//     }
// }