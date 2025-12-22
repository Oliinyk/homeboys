<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'hb2_meta_fields' );

function hb2_meta_fields() {
    $hero_labels = [
        'plural_name'   => __( 'Hero', 'home-boys-2' ),
        'singular_name' => __( 'Herois', 'home-boys-2' ),
    ];

    $slider_labels = [
        'plural_name'   => __( 'Slider item', 'home-boys-2' ),
        'singular_name' => __( 'Slider items', 'home-boys-2' ),
    ];

    $states_labels = [
        'plural_name'   => __( 'State', 'home-boys-2' ),
        'singular_name' => __( 'States', 'home-boys-2' ),
    ];

    // Hero variable section
    Container::make( 'post_meta', __( 'Hero', 'home-boys-2' ) )
        ->add_fields( array(
            Field::make( 'complex', 'hero_section', __( 'Change variable', 'home-boys-2' )  )
                ->set_max( 1 )
                ->setup_labels( $hero_labels )
                ->add_fields( 'home', __( 'Home style', 'home-boys-2' ), array(
                    Field::make( 'complex', 'home_hero_slider', __( 'Slider', 'home-boys-2' ) )
                        ->setup_labels( $slider_labels )
                        ->set_collapsed( true )
                        ->add_fields( array(
                            Field::make( 'image', 'slide', __( 'Slide', 'home-boys-2' ) )
                        ) ),
                    Field::make( 'checkbox', 'include_filter', __( 'Include filter', 'home-boys-2' ) )
                        ->set_width( 25 )
                        ->set_default_value( 'yes' ),
                    Field::make( 'text', 'hero_filter_title', __( 'Filter title', 'home-boys-2' ) )
                        ->set_width( 75 )
                        ->set_default_value( 'Find Your Manufactured Home' )
                        ->set_conditional_logic( array(
                            array(
                                'field'   => 'include_filter',
                                'value'   => true,
                            )
                        ) )
                ) )
        ) );

    // Welcome Section
    Container::make( 'post_meta', __( 'Welcome section', 'home-boys-2' ) )
        ->where( 'post_id', '=', get_option( 'page_on_front' ) )
        ->add_fields( array(
            Field::make( 'separator', 'welcome_heading_block_separate', __( 'Heading', 'home-boys-2' ) ),
            Field::make( 'text', 'welcome_small_title', __( 'Small title', 'home-boys-2' ) )
                ->set_default_value( 'Welcome to' ),
            Field::make( 'text', 'welcome_main_title', __( 'Main title', 'home-boys-2' ) )
                ->set_default_value( 'The Home Boys' ),
            Field::make( 'textarea', 'welcome_description_top', __( 'Top description text', 'home-boys-2' ) ),
            Field::make( 'separator', 'welcome_delivering_block_separate', __( 'Delivering block', 'home-boys-2' ) ),
            Field::make( 'text', 'welcome_delivering_title', __( 'Block title', 'home-boys-2' ) )
                ->set_default_value( 'Delivering to' ),
            Field::make( 'complex', 'welcome_states', __( 'Delivering', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->set_max( 5 )
                ->setup_labels( $states_labels )
                ->add_fields( array(
                    Field::make( 'text', 'st_name', __( 'Name', 'home-boys-2' ) )
                        ->set_width( 70 )
                        ->set_required( true ),
                    Field::make( 'image', 'st_image', __( 'Image', 'home-boys-2' ) )
                        ->set_width( 30 )
                        ->set_value_type( 'url' )
                        ->set_required( true )
                ) )
                ->set_header_template( '
                    <% if (st_name) { %>
                        <%- st_name %>
                    <% } %>
                ' ),
            Field::make( 'separator', 'welcome_video_block_separate', __( 'Video block', 'home-boys-2' ) ),
            Field::make( 'text', 'welcome_video_embed_url', __( 'Embed source url', 'home-boys-2' ) )
                ->set_default_value( 'https://www.youtube.com/embed/GNLO3jhL02w' ),
            Field::make( 'text', 'welcome_video_iframe_title', __( 'Iframe title', 'home-boys-2' ) )
                ->set_default_value( 'YouTube video player' ),
            Field::make( 'textarea', 'welcome_description_bottom', __( 'bottom description text', 'home-boys-2' ) ),
        ) );
};