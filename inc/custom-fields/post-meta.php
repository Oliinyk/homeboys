<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'hb2_meta_fields' );

function hb2_meta_fields() {
    // Labels
    $hero_labels = [
        'plural_name'   => __( 'Hero', 'home-boys-2' ),
        'singular_name' => __( 'Herois', 'home-boys-2' ),
    ];

    $slider_labels = [
        'plural_name'   => __( 'Slider item', 'home-boys-2' ),
        'singular_name' => __( 'Slider items', 'home-boys-2' ),
    ];

    $states_labels = [
        'plural_name'   => __( 'States', 'home-boys-2' ),
        'singular_name' => __( 'State', 'home-boys-2' ),
    ];

    $partners_labels = [
        'plural_name'   => __( 'Partners', 'home-boys-2' ),
        'singular_name' => __( 'Partner', 'home-boys-2' ),
    ];

    // Options
    $plan_series_opt = [
        -1 => '-Select-',
        16 => '400 Series',
        32 => '5000 Series',
        17 => 'American Dream',
        0  => 'Broadmore',
        28 => 'Canyon View',
        24 => 'Columbia River',
        7  => 'Dream Silver',
        34 => 'Imagine',
        35 => 'Inspiration (Cavco)',
        8  => 'Inspiration Gold',
        26 => 'Independence Series',
        27 => 'Majestic Series',
        25 => 'Marlette Special',
        13 => 'McKenzie',
        18 => 'Olympic Range',
        10 => 'Patriot',
        9  => 'Platinum Series',
        31 => 'Pure Series',
        33 => 'Rhythm Series',
        23 => 'Schult Series',
        15 => 'Siskyou Series',
        11 => 'Special Series',
        29 => 'Summit View',
        30 => 'Tempo',
        36 => 'Vista (Cavco)',
        5  => 'Waverly Crest Prestige',
        37 => 'Alpha',
    ];

    $plan_manufacturer_opt = [
       -1 => '-Select-',
        6 => 'Clayton Homes',
        3 => 'Cavco Nampa (Fleetwood)',
        1 => 'Cavco Millersburg (Palm Harbor)',
        7 => 'Cavco Montevideo (Friendship)',
        0 => 'Golden West',
        2 => 'Karsten Homes',
        5 => 'Marlette Homes',
        4 => 'Schult Homes',
    ];

    $plan_width_opt = [
       -1 => '-Select-',
        0 => 'Single Wide',
        1 => 'Double Wide',
        2 => 'Triple Wide',
    ];

    $plan_type_opt = [
        0 => 'None',
        1 => 'Manufactured Home',
        2 => '1 Story',
        3 => '1.5 Story',
        4 => '2 Story',
        5 => 'Bi-Level',
        6 => 'Duplex',
        7 => 'Multi-Family',
        8 => 'Multi-Level',
        9 => 'Split-Level',
        10 => 'Townhouse',
    ];

    $plan_location_opt = [
        0 => 'Spokane Only',
        1 => 'Tri Cities Only',
        2 => 'Spokane and Tri Cities',
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

    // Welcome Section ( front page )
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

    // Partners Section ( front page ) 
    Container::make( 'post_meta', __( 'Partners', 'home-boys-2' ) )
        ->where( 'post_id', '=', get_option( 'page_on_front' ) )
        ->add_fields( array(
            Field::make( 'text', 'partners_section_title', __( 'Title section', 'home-boys-2' ) ),
            Field::make( 'complex', 'partners', __( 'Partners list', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $partners_labels )
                ->add_fields( array(
                    Field::make( 'text', 'patner_name', __( 'Partner name', 'home-boys-2' ) )
                        ->set_required( true )
                        ->set_width( 75 ),
                    Field::make( 'image', 'partner_image', __( 'Partner image', 'home-boys-2' ) )
                        ->set_required( true )
                        ->set_width( 25 )
                        ->set_value_type( 'url' )  
                ) )
                ->set_header_template( '
                    <% if (patner_name) { %>
                        <%- patner_name %>
                    <% } %>
                ' )
        ) );

    // Plains posts meta
    Container::make( 'post_meta', __( 'Home plain data', 'home-boys-2' ) )
        ->where( 'post_type', '=', 'plans' )
        ->add_fields( array(
            Field::make( 'text', 'plan_order', __( 'Display Order', 'home-boys-2' ) )
                ->set_width(33)
                ->set_required( true )
                ->set_attribute( 'type', 'number' ),
            Field::make( 'text', 'plan_beds', __( 'Bedrooms', 'home-boys-2' ) )
                ->set_width(33)
                ->set_required( true )
                ->set_attribute( 'type', 'number' ),
            Field::make( 'text', 'plan_baths', __( 'Bathrooms', 'home-boys-2' ) )
                ->set_width(33)
                ->set_required( true )
                ->set_attribute( 'type', 'number' ),
            Field::make( 'text', 'plan_size', __( 'Size', 'home-boys-2' ) )
                ->set_width(33)
                ->set_required( true )
                ->help_text( 'ft<sup>2</sup>' )
                ->set_attribute( 'type', 'number' ),
            Field::make( 'text', 'plan_price', __( 'Price Range', 'home-boys-2' ) )
                ->set_width(33),
            Field::make( 'select', 'plan_series', __( 'Series', 'home-boys-2' ) )
                ->add_options( $plan_series_opt )
                ->set_width(33),
            Field::make( 'select', 'plan_manufacturer', __( 'Manufacturer', 'home-boys-2' ) )
                ->add_options( $plan_manufacturer_opt )
                ->set_width(33),
            Field::make( 'text', 'plan_number', __( 'Manufacturer Number', 'home-boys-2' ) )
                ->set_width(33)
                ->help_text( 'This field is required for the search box. Searched content needs to match exactly as it is input here.' ),    
            Field::make( 'select', 'plan_width', __( 'Width', 'home-boys-2' ) )
                ->add_options( $plan_width_opt )
                ->set_width(33),
            Field::make( 'select', 'plan_type', __( 'Plan Type', 'home-boys-2' ) )
                ->add_options( $plan_type_opt )
                ->set_width(33),
            Field::make( 'text', 'plan_tour', __( 'Virtual Tour', 'home-boys-2' ) )
                ->set_width(33)
                ->set_attribute( 'type', 'url' ),
            Field::make( 'select', 'plan_location', __( 'Location', 'home-boys-2' ) )
                ->add_options( $plan_location_opt )
                ->set_required( true )
                ->set_width(33),
            Field::make( 'file', 'plan_brochure', __( 'View Plan', 'home-boys-2' ) )
                ->set_width(25),
            Field::make( 'file', 'plan_brochure2', __( 'Standard Features', 'home-boys-2' ) )
                ->set_width(25),
            Field::make( 'file', 'plan_brochure3', __( 'List of Options', 'home-boys-2' ) )
                ->set_width(25),
            Field::make( 'file', 'plan_brochure4', __( 'Misc', 'home-boys-2' ) )
                ->set_width(25),
            Field::make( 'textarea', 'matterport_embed', __( 'Matterport Embed Code', 'home-boys-2' ) )
                ->set_width(50),
            Field::make( 'textarea', 'youtube_embed', __( 'YouTube Embed Code', 'home-boys-2' ) )
                ->set_width(50),
            Field::make( 'textarea', 'plan_description', __( 'Description', 'home-boys-2' ) ), 
            Field::make( 'media_gallery', 'plan_photos', __( 'Photos', 'home-boys-2' ) )     
        ) );
    // Contact form
    Container::make( 'post_meta', __( 'Contact Form' ) )
        ->add_fields( array(
            Field::make( 'text', 'form_title', __( 'Form title', 'home-boys-2' ) ),
            Field::make( 'textarea', 'form_code', __( 'Form shortcode', 'home-boys-2' ) ),
            Field::make( 'image', 'form_r_img', __( 'Right side image', 'home-boys-2' ) )
                ->set_value_type( 'url' )
                ->set_width( 30 ),
            Field::make( 'text', 'form_r_title', __( 'Right side title', 'home-boys-2' ) )
                ->set_width( 35 ),
            Field::make( 'text', 'form_r_subtitle', __( 'Right side subtitle', 'home-boys-2' ) )
                ->set_width( 35 ),
        ) );
};