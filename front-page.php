<?php
get_header();

$p_id     = get_the_ID();
$id_param = ['id' => $p_id];

// Gallery
$gallery        = carbon_get_theme_option( 'front_page_slideshow' );
$include_filter = carbon_get_theme_option( 'front_page_include_filter' );
$filter_title   = carbon_get_theme_option( 'front_page_filter_title' );

$gallery_images = array_map(function ($value) {
    return ['slide' => $value];
}, $gallery);

$filter_exclude_fields = [
    'width',
    'manufacturer',
    'series',
    'model',
];

$hero_params = [
    'home_hero_slider' => $gallery_images,
    'hero_filter_title' => $filter_title,
    'include_filter' => $include_filter,
    'filter_exclude_fields' => $filter_exclude_fields,
];

$home_hero__params = array_merge( $id_param, $hero_params );

$find_home__params = [
    'classes' => 'dark-section',
    'filter'  => false,
];

// Overlay
get_template_part( 'template-parts/modules/nav_overlay', null );

// Hero section
get_template_part( 'template-parts/modules/section', 'home__hero', $home_hero__params );

// Welcome srction
get_template_part( 'template-parts/modules/section', 'welcome' );

// Partner section
get_template_part( 'template-parts/modules/section', 'partner', ['is_home' => true, 'title' => true] );

// Contact section
get_template_part( 'template-parts/modules/section', 'contact' );

// Video review section
get_template_part( 'template-parts/modules/section', 'our_people' );

// Blog previewe section
get_template_part( 'template-parts/modules/section', 'blog' );

// Find Home section
get_template_part( 'template-parts/modules/section', 'find_home', $find_home__params );

get_footer();