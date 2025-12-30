<?php
add_action( 'init'                      , 'hb2_register_post_types', 10 );
add_filter( 'hb2_locations_list'        , 'hb2_get_locations_list' );
add_filter( 'hb2_get_manufacturers_list', 'hb2_get_manufacturers_list' );
add_filter( 'hb2_get_series_list'       , 'hb2_get_series_list' );
add_filter( 'hb2_get_width_list'        , 'hb2_get_width_list' );
add_filter( 'hb2_get_type_list'         , 'hb2_get_type_list' );

// Register custom post types
function hb2_register_post_types() {
    register_post_type( 'plans', [
        'label' => null,
        'labels' => [
            'name'                  => __( 'Plans', 'home-boys-2' ),
            'singular_name'         => __( 'Plan', 'home-boys-2' ),
            'add_new'               => __( 'Add New Plan', 'home-boys-2' ),
            'add_new_item'          => __( 'Add Plan', 'home-boys-2' ),
            'edit_item'             => __( 'Edit Plan', 'home-boys-2' ),
            'new_item'              => __( 'New Plan', 'home-boys-2' ),
            'view_item'             => __( 'View Plan', 'home-boys-2' ),
            'search_items'          => __( 'Search', 'home-boys-2' ),
            'not_found'             => __( 'Not Found', 'home-boys-2' ),
            'not_found_in_trash'    => __( 'Not Found in Trash', 'home-boys-2' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Home Plans', 'home-boys-2' ),
        ],
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => false,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'rest_base'           => null,
        'show_in_nav_menus'   => true,
        'menu_icon'           => 'dashicons-admin-home',
        'menu_position'       => 100,
        'hierarchical'        => false,
        'supports'            => ['title', 'shedule-settings', 'thumbnail', 'page-attributes'],
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );

    register_post_type( 'stories', [
        'label' => null,
        'labels' => [
            'name'                  => __( 'Stories', 'home-boys-2' ),
            'singular_name'         => __( 'Story', 'home-boys-2' ),
            'add_new'               => __( 'Add New Story', 'home-boys-2' ),
            'add_new_item'          => __( 'Add Story', 'home-boys-2' ),
            'edit_item'             => __( 'Edit Story', 'home-boys-2' ),
            'new_item'              => __( 'New Story', 'home-boys-2' ),
            'view_item'             => __( 'View Story', 'home-boys-2' ),
            'search_items'          => __( 'Search', 'home-boys-2' ),
            'not_found'             => __( 'Not Found', 'home-boys-2' ),
            'not_found_in_trash'    => __( 'Not Found in Trash', 'home-boys-2' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Stories', 'home-boys-2' ),
        ],
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => false,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'rest_base'           => null,
        'show_in_nav_menus'   => true,
        'menu_icon'           => 'dashicons-format-video',
        'menu_position'       => 100,
        'hierarchical'        => false,
        'supports'            => ['title', 'editir', 'shedule-settings', 'thumbnail'],
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );
}

// Get locations list
function hb2_get_locations_list() {
    $locations = carbon_get_theme_option( 'locations_list' );
    return is_array( $locations ) ? $locations : [];
}

// Get manufacturers list
function hb2_get_manufacturers_list() {
    $manufacturers = carbon_get_theme_option( 'manufacturers_list' );

    $uot = [];

    if ( is_array( $manufacturers ) ) {
        foreach ( $manufacturers as $manuf ) {
            $uot[ intval( $manuf['manufacturer_key'] ) ] = $manuf['manufacturer_name'];
        }
    }

    return $uot;
}

// Get series list
function hb2_get_series_list() {
    $series = carbon_get_theme_option( 'series_list' );

    $out = [];

    if ( is_array( $series ) ) {
        foreach ( $series as $ser ) {
            $out[ intval( $ser['series_key'] ) ] = $ser['series_name'];
        }
    }

    return $out;
}

// Get plan width options list
function hb2_get_width_list() {
    $widths = carbon_get_theme_option( 'plan_width_options' );

    $out = [];

    if ( is_array( $widths ) ) {
        foreach ( $widths as $width ) {
            $out[ intval( $width['width_key'] ) ] = $width['width_label'];
        }
    }

    return $out;
}

// Get plan type options list
function hb2_get_type_list() {
    $types = carbon_get_theme_option( 'plan_types_options' );

    $out = [];

    if ( is_array( $types ) ) {
        foreach ( $types as $type ) {
            $out[ intval( $type['type_key'] ) ] = $type['type_label'];
        }
    }

    return $out;
}

// Get locations options for select fields
function hb2_get_locations_options() {
    $locations = hb2_get_locations_list();

    $options = [ -1 => '-Select-' ];
    foreach ( $locations as $key => $loc ) {
        $options[ $key ] = $loc['location_name'];
    }
    return $options;
}

// Get manufacturers options for select fields
function hb2_get_manufacturers_options() {
    $manufacturers = hb2_get_manufacturers_list();

    $options = [ -1 => '-Select-' ];
    foreach ( $manufacturers as $key => $manuf ) {
        $options[ $key ] = $manuf;
    }
    
    return $options;
}

// Get series options for select fields
function hb2_get_series_options() {
    $series = hb2_get_series_list();

    $options = [ -1 => '-Select-' ];

    foreach ( $series as $key => $ser ) {
        $options[ $key ] = $ser;
    }
    return $options;
}

// Get width options for select fields
function hb2_get_width_options() {
    $widths = hb2_get_width_list();

    $options = [ -1 => '-Select-' ];

    foreach ( $widths as $key => $width ) {
        $options[ $key ] = $width;
    }
    return $options;
}

// Get type options for select fields
function hb2_get_type_options() {
    $types = hb2_get_type_list();
    $options = [ 0 => 'None' ];
    
    foreach ( $types as $key => $type ) {
        $options[ $key ] = $type;
    }
    return $options;
}  