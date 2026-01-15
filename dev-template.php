<?php
/**
 * Template name: DEVELOP
 */
wp_head();

echo "<h1> >>> DEV PAGE</h1>";

if ( ! isset( $_GET['run'] ) ) {
    return;
};

$import_post_type = isset( $_GET['im_type'] ) ? $_GET['im_type'] : 'plans';
$import_limit     = isset( $_GET['im_limit'] ) ? intval( $_GET['im_limit'] ) : 10;
$import_offset    = isset( $_GET['im_offset'] ) ? intval( $_GET['im_offset'] ) : 0;

$plans_import_file      = get_template_directory() . '/plans.WordPress.2025-12-23.xml';
$galleries_import_file  = get_template_directory() . '/galleries.WordPress.2026-01-06.xml';

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

$galleries_keys = [
    'gallery_name'        => [ 'key' => 'gallery_name' ],
    'gallery_description' => [ 'key' => 'gallery_description' ],
    'gallery_photos'      => [ 'key' => 'gallery_photos', 'type' => 'gallery' ],
];

$import_file = '';
$keys        = [];

switch ( $import_post_type ) {
    case 'plans' :
        $import_file = $plans_import_file;
        $keys        = $plans_keys;
        break;
    case 'galleries' :
        $import_file = $galleries_import_file;
        $keys        = $galleries_keys;
        break;
}

if ( 'import' == $_GET['run'] ) {
    echo smart_post_import( $import_file, $import_post_type, $keys, $import_limit, $import_offset );
}

if ( 'mark_attachments' == $_GET['run'] ) {
    echo '<pre>';
        print_r( mark_existing_attachments_with_hash() );
    echo '</pre>';
}

if ( 'scan_duplicate' == $_GET['run'] ) {
    echo '<pre>';
        print_r( scan_duplicate_attachments_by_hash() );
    echo '</pre>';
}

if ( 'deduplicate_attachments' == $_GET['run'] ) {
    $dry_run = isset( $_GET['dry_run'] ) ? $_GET['dry_run'] !== 0 : true ;

    echo '<pre>';
        print_r( deduplicate_attachments_by_hash( $dry_run ) );
    echo '</pre>';
}
wp_footer();