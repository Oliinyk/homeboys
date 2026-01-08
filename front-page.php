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

$home_hero__params = array_merge( $id_param, [ 'filter_exclude_fields' => $filter_exclude_fields ] );

$find_home__params = [
    'classes' => 'dark-section',
    'filter'  => false,
];
?>
    <div class="nav-overlay" id="navOverlay"></div>

    <?php
    get_template_part( 'template-parts/modules/section', 'hero', $home_hero__params );
    get_template_part( 'template-parts/modules/section', 'welcome', $id_param );
    get_template_part( 'template-parts/modules/section', 'partner', $id_param );
    get_template_part( 'template-parts/modules/section', 'contact', $id_param );
    get_template_part( 'template-parts/modules/section', 'our_people' );
    get_template_part( 'template-parts/modules/section', 'blog' );
    get_template_part( 'template-parts/modules/section', 'find_home', $find_home__params );

get_footer();