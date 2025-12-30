<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'hb2_options_fields' );

function hb2_options_fields() {
    // labels
    $locations_labels = [
        'plural_name'   => __( 'Locations', 'home-boys-2' ),
        'singular_name' => __( 'Location', 'home-boys-2' ),
    ];

    $networks_list_labels = [
        'plural_name'   => __( 'Social Networks', 'home-boys-2' ),
        'singular_name' => __( 'Social Network', 'home-boys-2' ),
    ];

    Container::make( 'theme_options', __( 'General Settings', 'home-boys-2' ) )
        ->add_fields( array(
            Field::make( 'separator', 'networks_list_ser', __( 'Social Networks Links', 'home-boys-2' ) ),
            Field::make( 'complex', 'social_networks', __( 'Social Networks', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $networks_list_labels )
                ->add_fields( array(
                    Field::make( 'text', 'network_name', __( 'Network Name', 'home-boys-2' ) )
                        ->set_required( true ),
                    Field::make( 'text', 'network_url', __( 'Network URL', 'home-boys-2' ) )
                        ->set_required( true ),
                    Field::make( 'image', 'network_icon', __( 'Network Icon', 'home-boys-2' ) )
                        ->set_value_type( 'url' )
                        ->set_required( true ),    
                ))
                ->set_header_template( '
                    <% if (network_name) { %>
                         <%- network_name %>
                    <% } %>
                     ' ),
            Field::make( 'separator', 'locatons_list_options_sep', __( 'Locations data list', 'home-boys-2' ) ),
            Field::make( 'complex', 'locations_list', __( 'Locations List', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $locations_labels )
                ->add_fields( array(
                    Field::make( 'text', 'location_name', __( 'Location Name', 'home-boys-2' ) )
                        ->set_required( true ),
                    Field::make( 'text', 'location_address', __( 'Location Address', 'home-boys-2'  ) ),
                    Field::make( 'text', 'location_phone', __( 'Location Phone', 'home-boys-2'  ) ),
                ))
                ->set_header_template( '
                    <% if (location_name) { %>
                         <%- location_name %>
                    <% } %>
                     ' ),

            Field::make( 'separator', 'labels_options_sep', __( 'Default labels, titles and texts settings', 'home-boys-2' ) ),
            Field::make( 'text', 'stories_section__subtitle', __( 'Stories Section Subtitle', 'home-boys-2' ) )
                ->set_default_value( 'Stories' )
                ->set_width( 50 ),
            Field::make( 'text', 'stories_section_title', __( 'Stories Section Title', 'home-boys-2' ) )
                ->set_default_value( 'From Our People' )
                ->set_width( 50 ),
            Field::make( 'text', 'blog_section__subtitle', __( 'Blog Section Subtitle', 'home-boys-2' ) )
                ->set_default_value( 'Latest from' )
                ->set_width( 50 ),
            Field::make( 'text', 'blog_section_title', __( 'Blog Section Title', 'home-boys-2' ) )
                ->set_default_value( 'Blog' )
                ->set_width( 50 ),
            Field::make( 'text', 'find_home_subtitle', __( 'Find Home Subtitle', 'home-boys-2' ) )
                ->set_default_value( 'Find' )
                ->set_width( 50 ),
            Field::make( 'text', 'find_home_title', __( 'Find Home Title', 'home-boys-2' ) )
                ->set_default_value( 'Your Home' )
                ->set_width( 50 ),
            Field::make( 'text', 'footer_networks_title', __( 'Footer Networks Title', 'home-boys-2' ) )
                ->set_default_value( 'Follow us' )
                ->set_width( 50 ),
            Field::make( 'textarea', 'footer_description_text', __( 'Footer Description Text', 'home-boys-2' ) ) ,
        ) );    
};