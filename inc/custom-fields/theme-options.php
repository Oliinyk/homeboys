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

    $manufacturers_labels = [
        'plural_name'   => __( 'Manufacturers', 'home-boys-2' ),
        'singular_name' => __( 'Manufacturer', 'home-boys-2' ),
    ];

    $series_labels = [
        'plural_name'   => __( 'Series', 'home-boys-2' ),
        'singular_name' => __( 'Series', 'home-boys-2' ),
    ];

    $width_labels = [
        'plural_name'   => __( 'Plan Width', 'home-boys-2' ),
        'singular_name' => __( 'Plan Width', 'home-boys-2' ),
    ];

    $type_labels = [
        'plural_name'   => __( 'Plan Types', 'home-boys-2' ),
        'singular_name' => __( 'Plan Type', 'home-boys-2' ),
    ];

    $partners_labels = [
        'plural_name'   => __( 'Partners', 'home-boys-2' ),
        'singular_name' => __( 'Partner', 'home-boys-2' ),
    ];

    $documents_labels = [
        'plural_name'   => __( 'Documents', 'home-boys-2' ),
        'singular_name' => __( 'Document', 'home-boys-2' ),
    ];

    Container::make( 'theme_options', __( 'General Settings', 'home-boys-2' ) )
        ->add_fields( array(
            // Social networks list
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

            // Locations list
            Field::make( 'separator', 'locatons_list_options_sep', __( 'Locations', 'home-boys-2' ) ),
            Field::make( 'complex', 'locations_list', __( 'Locations List', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $locations_labels )
                ->add_fields( array(
                    Field::make( 'text', 'location_key', __( 'Location Key (for filtering)', 'home-boys-2' ) )
                        ->set_width( 20 )
                        ->set_attribute( 'type', 'number' )
                        ->set_required( true ),
                    Field::make( 'text', 'location_name', __( 'Location Name', 'home-boys-2' ) )
                        ->set_width( 40 )
                        ->set_required( true ),
                    Field::make( 'text', 'location_bage_name', __( 'Location Bage', 'home-boys-2' ) )
                        ->set_width( 40 ),    
                    Field::make( 'text', 'location_address', __( 'Location Address', 'home-boys-2' ) ),
                    Field::make( 'textarea', 'location_map', __( 'Locaton MAP embed', 'home-boys-2' ) ),
                    Field::make( 'text', 'location_link_href', __( 'Map link Location' ) ),
                    Field::make( 'text', 'location_phone', __( 'Location Phone', 'home-boys-2'  ) ),
                ))
                ->set_header_template( '
                    <% if (location_name) { %>
                         <%- location_name %>
                    <% } %>
                     ' ),

            // Manufacturers list  
            Field::make( 'separator', 'manufacturers_options_sep', __( 'Manufacturers', 'home-boys-2' ) ),
            Field::make( 'complex', 'manufacturers_list', __( 'Manufacturers List', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $manufacturers_labels )
                ->add_fields( array(
                    Field::make( 'text', 'manufacturer_name', __( 'Manufacturer Name', 'home-boys-2' ) )
                        ->set_width( 80 )
                        ->set_required( true ),
                    Field::make( 'text', 'manufacturer_key', __( 'Manufacturer Key (for filtering)', 'home-boys-2' ) )
                        ->set_width( 20 )
                        ->set_attribute( 'type', 'number' )
                        ->set_required( true ),    
                ))
                ->set_header_template( '
                    <% if (manufacturer_name) { %>
                         <%- manufacturer_name %>
                    <% } %>
                     ' ),

            // Series list         
            Field::make( 'separator', 'series_options_sep', __( 'Series', 'home-boys-2' ) ),
            Field::make( 'complex', 'series_list', __( 'Series List', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $series_labels )
                ->add_fields( array(
                    Field::make( 'text', 'series_name', __( 'Series Name', 'home-boys-2' ) )
                        ->set_width( 85 )
                        ->set_required( true ),
                    Field::make( 'text', 'series_key', __( 'Series Key (for filtering)', 'home-boys-2' ) )
                        ->set_attribute( 'type', 'number' )
                        ->set_width( 15 )
                        ->set_required( true ),
                ))
                ->set_header_template( '
                    <% if (series_name) { %>
                         <%- series_name %>
                    <% } %>
                     ' ),

            // Plan width options
            Field::make( 'separator', 'width_options_sep', __( 'Plan Width', 'home-boys-2' ) ),
            Field::make( 'complex', 'plan_width_options', __( 'Plan Width Options', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $width_labels )
                ->add_fields( array(
                    Field::make( 'text', 'width_label', __( 'Width Label', 'home-boys-2' ) )
                        ->set_width( 80 )
                        ->set_required( true ),
                    Field::make( 'text', 'width_key', __( 'Width Key', 'home-boys-2' ) )
                        ->set_attribute( 'type', 'number' )
                        ->set_width( 20 )
                        ->set_required( true ),    
                ))
                ->set_header_template( '
                    <% if (width_label) { %>
                         <%- width_label %>
                    <% } %>
                     ' ),

            // Plan types options         
            Field::make( 'separator', 'plan_types_options_sep', __( 'Plan Types', 'home-boys-2' ) ),
            Field::make( 'complex', 'plan_types_options', __( 'Plan Types Options', 'home-boys-2' ) )
                ->setup_labels( $type_labels )
                ->set_collapsed( true )
                ->add_fields( array(
                    Field::make( 'text', 'type_label', __( 'Type Label', 'home-boys-2' ) )
                        ->set_width( 80 )
                        ->set_required( true ),
                    Field::make( 'text', 'type_key', __( 'Type Key', 'home-boys-2' ) )
                        ->set_attribute( 'type', 'number' )
                        ->set_width( 20 )
                        ->set_required( true ),      
                ))
                ->set_header_template( '
                    <% if (type_label) { %>
                         <%- type_label %>
                    <% } %>
                     ' ),

            // Contact form
            Field::make( 'separator', 'contact_form_sep', __( 'Contact Form', 'home-boys-2' ) ),
            Field::make( 'text', 'form_title', __( 'Form title', 'home-boys-2' ) )
                ->set_default_value( 'Contact <span class="primary">Us</span> For A Personalized Consultation' ),
            Field::make( 'textarea', 'form_code', __( 'Form shortcode', 'home-boys-2' ) )
                ->set_default_value( '[contact-form-7 id="19e4962" title="Call form"]' ),
            Field::make( 'image', 'form_r_img', __( 'Right side image', 'home-boys-2' ) )
                ->set_value_type( 'url' )
                ->set_width( 30 ),
            Field::make( 'text', 'form_r_title', __( 'Right side title', 'home-boys-2' ) )
                ->set_default_value( 'Steve Randock Jr' )
                ->set_width( 35 ),
            Field::make( 'text', 'form_r_subtitle', __( 'Right side subtitle', 'home-boys-2' ) )
                ->set_default_value( 'General Manager' )
                ->set_width( 35 ),
                
            // Partners
            Field::make( 'separator', 'partners_sep', __( 'Partners', 'home-boys-2' ) ),
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
                ' ),

            // Default labels and texts
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
            Field::make( 'textarea', 'not_found_posts_message', __( 'Posts not fount message', 'home-boys-2' ) )
                ->set_rows( 2 )
                ->set_default_value( "Sorry, we didn't find anything for you this time." ),    
            Field::make( 'textarea', 'sold_marker_placeholder', __( 'Sold marker placeholder', 'home-boys-2' ) )
                ->set_rows( 2 )
                ->set_default_value( '<span class="label-top">Home Was</span><span>Sold</span>' ),
            // FOOTER 
            Field::make( 'separator', 'footer_separator', __( 'FOOTER', 'home-boys-2' ) ),
            Field::make( 'image', 'footer_site_logo', __( 'Footer logo', 'home-boys-2' ) )
                ->set_value_type( 'url' ),
            Field::make( 'text', 'footer_mail_block_title', __( 'Contact block title', 'home-boys-2' ) )
                ->set_default_value( 'Contact us' )
                ->set_width( 50 ),
            Field::make( 'text', 'footer_mail_contact', __( 'Footer contact mail', 'home-boys-2' ) )
                ->set_width( 50 ),
            Field::make( 'text', 'footer_networks_title', __( 'Footer Networks Title', 'home-boys-2' ) )
                ->set_default_value( 'Follow us' )
                ->set_width( 50 ),
            Field::make( 'complex', 'footer_documents', __( 'Footer documents', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $documents_labels )
                ->add_fields( array(
                    Field::make( 'text', 'document_label', __( 'Title', 'home-boys-2' ) )
                        ->set_required( true )
                        ->set_width( 75 ),
                    Field::make( 'file', 'document_file', __( 'File', 'home-boys-2' ) )
                        ->set_required( true )
                        ->set_value_type( 'url' )
                        ->set_width( 25 ),
                ) )
                ->set_header_template( '
                    <% if (document_label) { %>
                        <%- document_label %>
                    <% } %>
                ' ),
            Field::make( 'text', 'footer_form_title', __( 'Footer Form title', 'home-boys-2' ) )
                ->set_default_value('Newsletters'),
            Field::make( 'text', 'footer_form_shortcode', __( 'Footer Form code', 'home-boys-2' ) ), 
            Field::make( 'textarea', 'footer_description_text', __( 'Footer Description Text', 'home-boys-2' ) ),
        ) );
};