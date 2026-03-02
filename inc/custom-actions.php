<?php
add_action( 'init'                      , 'hb2_register_post_types', 10 );
add_filter( 'hb2_get_menu_items'        , 'hb2_get_menu_items' );
add_filter( 'hb2_get_random_image'      , 'get_random_image' );
// add_action( 'after_setup_theme'         , 'hb2_register_custom_menus' );
add_filter( 'hb2_locations_list'        , 'hb2_get_locations_list' );
add_filter( 'hb2_on_display_arr'        , 'hb2_on_display_arr' );
add_filter( 'hb2_get_manufacturers_list', 'hb2_get_manufacturers_list' );
add_filter( 'hb2_get_series_list'       , 'hb2_get_series_list' );
add_filter( 'hb2_get_width_list'        , 'hb2_get_width_list' );
add_filter( 'hb2_get_type_list'         , 'hb2_get_type_list' );

// Register custom menus
function hb2_register_custom_menus() {
    register_nav_menus( [
        'main_menu' => __( 'Main Menu', 'home-boys-2' ),
    ] );
};

// Register custom post types
function hb2_register_post_types() {
    register_post_type( 'plans', [
        'label' => null,
        'labels' => [
            'name'                  => __( 'Floor Plans', 'home-boys-2' ),
            'singular_name'         => __( 'Floor Plan', 'home-boys-2' ),
            'add_new'               => __( 'Add New Floor Plan', 'home-boys-2' ),
            'add_new_item'          => __( 'Add Floor Plan', 'home-boys-2' ),
            'edit_item'             => __( 'Edit Floor Plan', 'home-boys-2' ),
            'new_item'              => __( 'New Floor Plan', 'home-boys-2' ),
            'view_item'             => __( 'View Floor Plan', 'home-boys-2' ),
            'search_items'          => __( 'Search', 'home-boys-2' ),
            'not_found'             => __( 'Not Found', 'home-boys-2' ),
            'not_found_in_trash'    => __( 'Not Found in Trash', 'home-boys-2' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Floor Plans', 'home-boys-2' ),
        ],
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'rest_base'           => null,
        'show_in_nav_menus'   => true,
        'menu_icon'           => 'dashicons-admin-multisite',
        'menu_position'       => 5,
        'hierarchical'        => false,
        'supports'            => ['title', 'shedule-settings', 'thumbnail', 'page-attributes', 'editor'],
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );

    register_post_type( 'stories', [
        'label' => null,
        'labels' => [
            'name'                  => __( 'Testimonials', 'home-boys-2' ),
            'singular_name'         => __( 'Testimonial', 'home-boys-2' ),
            'add_new'               => __( 'Add New Testimonial', 'home-boys-2' ),
            'add_new_item'          => __( 'Add Testimonial', 'home-boys-2' ),
            'edit_item'             => __( 'Edit Testimonial', 'home-boys-2' ),
            'new_item'              => __( 'New Testimonial', 'home-boys-2' ),
            'view_item'             => __( 'View Testimonial', 'home-boys-2' ),
            'search_items'          => __( 'Search', 'home-boys-2' ),
            'not_found'             => __( 'Not Found', 'home-boys-2' ),
            'not_found_in_trash'    => __( 'Not Found in Trash', 'home-boys-2' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Testimonials', 'home-boys-2' ),
        ],
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'rest_base'           => null,
        'show_in_nav_menus'   => true,
        'menu_icon'           => 'dashicons-format-video',
        'menu_position'       => 5,
        'hierarchical'        => false,
        'supports'            => ['title', 'editor', 'shedule-settings', 'thumbnail'],
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );

    // register_post_type( 'galleries', [
    //     'label' => null,
    //     'labels' => [
    //         'name'                  => __( 'Galleries', 'home-boys-2' ),
    //         'singular_name'         => __( 'Gallery', 'home-boys-2' ),
    //         'add_new'               => __( 'Add New Gallery', 'home-boys-2' ),
    //         'add_new_item'          => __( 'Add Gallery', 'home-boys-2' ),
    //         'edit_item'             => __( 'Edit Gallery', 'home-boys-2' ),
    //         'new_item'              => __( 'New Gallery', 'home-boys-2' ),
    //         'view_item'             => __( 'View Gallery', 'home-boys-2' ),
    //         'search_items'          => __( 'Search', 'home-boys-2' ),
    //         'not_found'             => __( 'Not Found', 'home-boys-2' ),
    //         'not_found_in_trash'    => __( 'Not Found in Trash', 'home-boys-2' ),
    //         'parent_item_colon'     => '',
    //         'menu_name'             => __( 'Galleries', 'home-boys-2' ),
    //     ],
    //     'description'         => '',
    //     'public'              => true,
    //     'publicly_queryable'  => true,
    //     'show_in_menu'        => true,
    //     'show_in_rest'        => true,
    //     'rest_base'           => null,
    //     'show_in_nav_menus'   => true,
    //     'menu_icon'           => 'dashicons-images-alt2',
    //     'menu_position'       => 5,
    //     'hierarchical'        => false,
    //     'supports'            => ['title', 'editor', 'thumbnail', 'page-attributes'],
    //     'taxonomies'          => [],
    //     'has_archive'         => false,
    //     'rewrite'             => true,
    //     'query_var'           => true,
    // ] );

    register_post_type( 'process', [
        'label' => null,
        'labels' => [
            'name'                  => __( 'Financing', 'home-boys-2' ),
            'singular_name'         => __( 'Financing', 'home-boys-2' ),
            'add_new'               => __( 'Add New Financing', 'home-boys-2' ),
            'add_new_item'          => __( 'Add Financing', 'home-boys-2' ),
            'edit_item'             => __( 'Edit Financing', 'home-boys-2' ),
            'new_item'              => __( 'New Financing', 'home-boys-2' ),
            'view_item'             => __( 'View Financing', 'home-boys-2' ),
            'search_items'          => __( 'Search', 'home-boys-2' ),
            'not_found'             => __( 'Not Found', 'home-boys-2' ),
            'not_found_in_trash'    => __( 'Not Found in Trash', 'home-boys-2' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Financing', 'home-boys-2' ),
        ],
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'rest_base'           => null,
        'show_in_nav_menus'   => true,
        'menu_icon'           => 'dashicons-money-alt',
        'menu_position'       => 5,
        'hierarchical'        => false,
        'supports'            => ['title', 'thumbnail', 'editor'],
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );

    register_post_type( 'employees', [
        'label' => null,
        'labels' => [
            'name'                  => __( 'Employees', 'home-boys-2' ),
            'singular_name'         => __( 'Employee', 'home-boys-2' ),
            'add_new'               => __( 'Add New Employee', 'home-boys-2' ),
            'add_new_item'          => __( 'Add Employee', 'home-boys-2' ),
            'edit_item'             => __( 'Edit Employee', 'home-boys-2' ),
            'new_item'              => __( 'New Employee', 'home-boys-2' ),
            'view_item'             => __( 'View Employee', 'home-boys-2' ),
            'search_items'          => __( 'Search', 'home-boys-2' ),
            'not_found'             => __( 'Not Found', 'home-boys-2' ),
            'not_found_in_trash'    => __( 'Not Found in Trash', 'home-boys-2' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Employees', 'home-boys-2' ),
        ],
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'rest_base'           => null,
        'show_in_nav_menus'   => true,
        'menu_icon'           => 'dashicons-groups',
        'menu_position'       => 5,
        'hierarchical'        => false,
        'supports'            => ['title', 'editor'],
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );

    register_post_type( 'blogposts', [
        'label' => null,
        'labels' => [
            'name'                  => __( 'Blogposts', 'home-boys-2' ),
            'singular_name'         => __( 'Blogpost', 'home-boys-2' ),
            'add_new'               => __( 'Add New Blogpost', 'home-boys-2' ),
            'add_new_item'          => __( 'Add Blogpost', 'home-boys-2' ),
            'edit_item'             => __( 'Edit Blogpost', 'home-boys-2' ),
            'new_item'              => __( 'New Blogpost', 'home-boys-2' ),
            'view_item'             => __( 'View Blogpost', 'home-boys-2' ),
            'search_items'          => __( 'Search', 'home-boys-2' ),
            'not_found'             => __( 'Not Found', 'home-boys-2' ),
            'not_found_in_trash'    => __( 'Not Found in Trash', 'home-boys-2' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Blog', 'home-boys-2' ),
        ],
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'rest_base'           => null,
        'show_in_nav_menus'   => true,
        'menu_icon'           => 'dashicons-welcome-write-blog',
        'menu_position'       => 5,
        'hierarchical'        => false,
        'supports'            => ['title', 'thumbnail', 'shedule-settings', 'page-attributes', 'editor'],
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );
};

// Menu items parse
function hb2_get_menu_items( $menu ) {
    $nav_menu_items = wp_get_nav_menu_items( $menu );
    $menu_arr = [];

    global $post;
    $current_id = $post->ID;

    if ( ! empty( $nav_menu_items ) ) {
        foreach ( $nav_menu_items as $item ) {
            $item_id   = $item->ID;
            $parent_id = $item->menu_item_parent;

            $classes   = implode( ' ', $item->classes );

            if ( $parent_id == 0 ) {
                // This is a top-level item
                $menu_arr[ $item_id ] = [
                    'classes'   => "dropdown has-dropdown {$classes}",
                    'object_id' => intval( $item->object_id ),
                    'title'     => $item->title,
                    'url'       => $item->url,
                    'children'  => [],
                ];
            } else {
                // This is a child item
                if ( isset( $menu_arr[ $parent_id ] ) ) {
                    $menu_arr[ $parent_id ]['children'][] = [
                        'classes'   => $classes,
                        'object_id' => intval( $item->object_id ),
                        'title'     => $item->title,
                        'url'       => $item->url,
                    ];
                }
            }
        }
    };

    return $menu_arr;
}

function get_random_image() {
    $imgs = [
        'Clover-30603F.png',
        'cottonwood-by-golden-west.png',
        'Giant-Sequoia-ING762G.png',
        'golden-west-dream.png',
        'ING762G.png',
        'ING764G.png',
        'Sweet-Dream.png',
        'The-Brook-Haven.png',
    ];

    $key = rand( 0, ( count( $imgs ) - 1 ) );

    return get_stylesheet_directory_uri() . "/assets/img/" . $imgs[$key];
}

// Get locations list
function hb2_get_locations_list() {
    $locations = carbon_get_theme_option('locations_list');

    if ( ! is_array( $locations ) ) {
        return [];
    }

    return array_column($locations, null, 'location_key');
}

function hb2_on_display_arr( $locations ) {
    if ( empty( $locations ) ) {
        return '';
    }

    if ( ! is_array( $locations ) ) {
        $locations = [ $locations ];
    }

    $list = hb2_get_locations_list();
    $names = [];

    foreach ( $locations as $loc ) {
        if ( -1 == $loc ) {
            continue;
        };

        $loc_data = array_filter( $list, function( $item ) use ( $loc ) {
            return intval( $item['location_key'] ) === intval( $loc );
        } );

        if ( ! empty( $loc_data ) ) {
            $loc_data = array_values( $loc_data )[0];
            $names[] = $loc_data['location_bage_name'] ?: $loc_data['location_name'];
        }
    }

    return implode( '<br/>', $names );
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
    foreach ( $locations as $loc ) {
        $options[ $loc['location_key'] ] = $loc['location_name'];
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

// Get min and max prices of all homes
function hb2_get_all_homes_prices_range() {
    global $wpdb;

    $results = $wpdb->get_row( "
        SELECT 
            MIN( CAST( REPLACE( meta_value, ',', '' ) AS SIGNED ) ) as min_price, 
            MAX( CAST( REPLACE( meta_value, ',', '' ) AS SIGNED ) ) as max_price 
        FROM {$wpdb->postmeta} 
        WHERE meta_key = '_plan_price' 
          AND meta_value != ''
    " );

    if ( is_null( $results->min_price ) ) {
        return null;
    }

    return [
        'min' => floatval( $results->min_price ),
        'max' => floatval( $results->max_price ),
    ];
}

// Get min and max sizes of all homes
function hb2_get_all_homes_sizes_range() {
    global $wpdb;
 
    $results = $wpdb->get_row( "
        SELECT 
            MIN( CAST( meta_value AS SIGNED ) ) as min_size, 
            MAX( CAST( meta_value AS SIGNED ) ) as max_size 
        FROM {$wpdb->postmeta} 
        WHERE meta_key = '_plan_size' 
          AND meta_value != ''
    " );

    if ( is_null( $results->min_size ) ) {
        return null;
    }

    return [
        'min' => floatval( $results->min_size ),
        'max' => floatval( $results->max_size ),
    ];
}

// Get min and max beds of all homes
function hb2_get_all_homes_beds_range() {
    global $wpdb;
 
    $results = $wpdb->get_row( "
        SELECT 
            MIN( CAST( meta_value AS SIGNED ) ) as min_beds, 
            MAX( CAST( meta_value AS SIGNED ) ) as max_beds 
        FROM {$wpdb->postmeta} 
        WHERE meta_key = '_plan_beds' 
          AND meta_value != ''
    " );

    if ( is_null( $results->min_beds ) ) {
        return null;
    }

    return [
        'min' => floatval( $results->min_beds ),
        'max' => floatval( $results->max_beds ),
    ];
}

// Get min and max baths of all homes
function hb2_get_all_homes_baths_range() {
    global $wpdb;
 
    $results = $wpdb->get_row( "
        SELECT 
            MIN( CAST( meta_value AS SIGNED ) ) as min_baths, 
            MAX( CAST( meta_value AS SIGNED ) ) as max_baths 
        FROM {$wpdb->postmeta} 
        WHERE meta_key = '_plan_baths' 
          AND meta_value != ''
    " );

    if ( is_null( $results->min_baths ) ) {
        return null;
    }

    return [
        'min' => floatval( $results->min_baths ),
        'max' => floatval( $results->max_baths ),
    ];
}