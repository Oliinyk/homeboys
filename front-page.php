<?php
get_header();

$p_id = get_the_ID();
$id_param = ['id' => $p_id];

$filter_exclude_fields = [
    'width',
    'manufacturer',
    'series',
    'model',
];

$home_hero__params = array_merge( $id_param, [ 'params' => ['filter_exclude_fields' => $filter_exclude_fields] ] );

$find_home__params = [
    'classes' => 'dark-section',
    'filter'  => false,
];

// Overlay
get_template_part( 'template-parts/modules/nav_overlay', null );

// Hero section
get_template_part( 'template-parts/modules/section', 'hero', $home_hero__params );

// Welcome srction
get_template_part( 'template-parts/modules/section', 'welcome', $id_param );

// Partner section
get_template_part( 'template-parts/modules/section', 'partner', ['title' => true] );

// Contact section
get_template_part( 'template-parts/modules/section', 'contact' );

// Video review section
get_template_part( 'template-parts/modules/section', 'our_people' );

// Blog previewe section
get_template_part( 'template-parts/modules/section', 'blog' );

// Find Home section
get_template_part( 'template-parts/modules/section', 'find_home', $find_home__params );

get_footer();