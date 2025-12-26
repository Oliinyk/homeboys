<?php
add_action( 'init'  , 'hb2_register_post_types', 10 );

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
}
