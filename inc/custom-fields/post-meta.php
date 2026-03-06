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

    $partners_labels = [
        'plural_name'   => __( 'Partners', 'home-boys-2' ),
        'singular_name' => __( 'Partner', 'home-boys-2' ),
    ];

    $embeds_labels = [
        'plural_name'   => __( 'Embeds', 'home-boys-2' ),
        'singular_name' => __( 'Embed', 'home-boys-2' ),
    ];

    $guidelines_labels = [
        'plural_name'   => __( 'Guidelines', 'home-boys-2' ),
        'singular_name' => __( 'Guideline', 'home-boys-2' ),
    ];

    $cards_labels = [
        'plural_name'   => __( 'Cards', 'home-boys-2' ),
        'singular_name' => __( 'Card', 'home-boys-2' ),
    ];

    $files_labels = [
        'plural_name'   => __( 'Files', 'home-boys-2' ),
        'singular_name' => __( 'File', 'home-boys-2' ),
    ];

    $contacts_labels = [
        'plural_name'   => __( 'Contacs', 'home-boys-2' ),
        'singular_name' => __( 'Conract', 'home-boys-2' ),
    ];

    $phones_labels = [
        'plural_name'   => __( 'Phone numbers', 'home-boys-2' ),
        'singular_name' => __( 'Phone number', 'home-boys-2' ),
    ];

    $emails_labels = [
        'plural_name'   => __( 'Emails', 'home-boys-2' ),
        'singular_name' => __( 'Email', 'home-boys-2' ),
    ];

    $shedule_labels = [
        'plural_name'   => __( 'Shedule items', 'home-boys-2' ),
        'singular_name' => __( 'Shedule', 'home-boys-2' ),
    ];

    // Options
    $plan_series_opt = hb2_get_series_options();

    $plan_manufacturer_opt = hb2_get_manufacturers_options();

    $plan_width_opt = hb2_get_width_options();

    $plan_type_opt = hb2_get_type_options();

    $plan_location_opt = hb2_get_locations_options();

    $galleries_types_opt = [
        0 => __( 'All', 'home-boys-2' ),
        1 => __( 'Not SOLD mark', 'home-boys-2' ),
        2 => __( 'SOLD mark', 'home-boys-2' ),
    ];

    $locations_opt = hb2_get_locations_options();

    // Hero variable section
    Container::make( 'post_meta', __( 'Hero', 'home-boys-2' ) )
        ->where( 'post_type', '=', 'page' )
        ->add_fields( array(
            Field::make( 'complex', 'hero_section', __( 'Change variable', 'home-boys-2' )  )
                ->set_max( 1 )
                ->setup_labels( $hero_labels )
                ->add_fields( 'simple', __( 'Simple', 'home-boys-2' ), array(
                    Field::make( 'text', 'simple_hero_small_title', __( 'Small title', 'home-boys-2' ) ),
                    Field::make( 'text', 'simple_hero_title', __( 'Title', 'home-boys-2' ) ),
                ) )
                ->add_fields( 'video', __( 'Video', 'home-boys-2' ), array(
                    Field::make( 'textarea', 'video_code', __( 'Video embed code', 'home-boys-2' ) ),
                ) )
                ->add_fields( 'single_banner', __( 'Single banner', 'home-boys-2' ), array(
                    Field::make( 'text', 'sb_hero_title', __( 'Title', 'home-boys-2' ) )
                        ->set_width(50),
                    Field::make( 'image', 'sb_hero_image', __( 'Banner image', 'home-boys-2' ) )
                        ->set_width(25)
                        ->set_value_type('url'),
                    Field::make( 'text', 'sb_hero_image_height', __( 'Height banner (px)', 'home-boys-2' ) )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'min', '236' )
                        ->set_attribute( 'max', '540' )
                        ->set_attribute( 'step', '50' )
                        ->set_default_value(236)
                        ->set_width(25)   
                ) )
        )
    );

    // Plains posts meta
    Container::make( 'post_meta', __( 'Home plain data', 'home-boys-2' ) )
        ->where( 'post_type', '=', 'plans' )
        ->add_fields( array(
            Field::make( 'text', 'plan_name', __( 'Display Name', 'home-boys-2' ) ),
            Field::make( 'text', 'plan_order', __( 'Display Order', 'home-boys-2' ) )
                ->set_default_value( '5' )
                ->set_width(25)
                ->set_required( true )
                ->set_attribute( 'type', 'number' ),
            Field::make( 'text', 'plan_beds', __( 'Bedrooms', 'home-boys-2' ) )
                ->set_width(25)
                ->set_required( true )
                ->set_attribute( 'type', 'number' ),
            Field::make( 'text', 'plan_baths', __( 'Bathrooms', 'home-boys-2' ) )
                ->set_width(25)
                ->set_required( true )
                ->set_attribute( 'type', 'number' ),
            Field::make( 'text', 'plan_size', __( 'Size', 'home-boys-2' ) )
                ->set_width(25)
                ->set_required( true )
                ->help_text( 'ft<sup>2</sup>' )
                ->set_attribute( 'type', 'number' ),
            Field::make( 'text', 'plan_price', __( 'Basic Price', 'home-boys-2' ) )
                ->set_required( true )
                ->set_attribute( 'type', 'number' )
                ->set_width(25),
            Field::make( 'text', 'plan_set_price', __( 'Price of the set' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width(25),
            Field::make( 'text', 'plan_set_price_desc', __( 'Set price description' ) )
                ->set_default_value( 'Includes standard delivery & set within 100 miles' )
                ->set_width(50),
            Field::make( 'select', 'plan_series', __( 'Series', 'home-boys-2' ) )
                ->add_options( $plan_series_opt )
                ->set_width(33),
            Field::make( 'select', 'plan_manufacturer', __( 'Manufacturer', 'home-boys-2' ) )
                ->add_options( $plan_manufacturer_opt )
                ->set_width(33),
            Field::make( 'text', 'plan_number', __( 'Manufacturer Number', 'home-boys-2' ) )
                ->set_width(33)
                ->help_text( 'This field is required for the search box. Searched content needs to match exactly as it is input here.' ),
            Field::make( 'set', 'plan_location', __( 'Location', 'home-boys-2' ) )
                ->add_options( $plan_location_opt )
                ->set_width(20),       
            Field::make( 'select', 'plan_width', __( 'Width', 'home-boys-2' ) )
                ->add_options( $plan_width_opt )
                ->set_width(20),
            Field::make( 'select', 'plan_type', __( 'Plan Type', 'home-boys-2' ) )
                ->add_options( $plan_type_opt )
                ->set_width(20),
            Field::make( 'text', 'plan_tour', __( 'Virtual Tour', 'home-boys-2' ) )
                ->set_width(40)
                ->set_attribute( 'type', 'url' ),
            Field::make( 'textarea', 'matterport_embed', __( 'Matterport Embed Code', 'home-boys-2' ) )
                ->set_width(50),
            Field::make( 'textarea', 'youtube_embed', __( 'YouTube Embed Code', 'home-boys-2' ) )
                ->set_width(50),    
            Field::make( 'file', 'plan_brochure', __( 'View Plan', 'home-boys-2' ) )
                ->set_width(25),
            Field::make( 'file', 'plan_brochure2', __( 'Standard Features', 'home-boys-2' ) )
                ->set_width(25),
            Field::make( 'file', 'plan_brochure3', __( 'List of Options', 'home-boys-2' ) )
                ->set_width(25),
            Field::make( 'file', 'plan_brochure4', __( 'Misc', 'home-boys-2' ) )
                ->set_width(25),
            Field::make( 'rich_text', 'plan_description', __( 'Description', 'home-boys-2' ) ), 
            Field::make( 'media_gallery', 'plan_photos', __( 'Photos', 'home-boys-2' ) )     
        )
    );

    // Stories post type meta
    Container::make( 'post_meta', __( 'Story content', 'home-boys-2' ) )
        ->where( 'post_type', '=', 'stories' )
        ->add_fields( array(
            Field::make( 'text', 'story_author', __( 'Author', 'home-boys-2' ) ),
            Field::make( 'textarea', 'story_review', __( 'Video review code', 'home-boys-2' ) ),
        )
    );

    // Display Homes location select
    Container::make( 'post_meta', __( 'Display Homes location', 'home-boys-2' ) )
        ->where( 'post_template', '=', 'display-homes-template.php' )
        ->set_context( 'side')
        ->add_fields( array(
            Field::make( 'select', 'display_homes_location', __( 'Select location', 'home-boys-2' ) )
                ->add_options( $locations_opt )
        )
    );

    // Galeries posts type    
    Container::make( 'post_meta', __( 'Gallery data', 'home-boys-2' ) )
        ->where( 'post_type', '=', 'galleries' )
        ->add_fields( array(
            Field::make( 'text', 'gallery_name', __( 'Gallery Name', 'home-boys-2' ) )
                ->set_width( 75 ),
            Field::make( 'text', 'gallery_order', __( 'Display Order', 'home-boys-2' ) )
                ->set_default_value( '3' )
                ->set_attribute( 'type', 'number' )
                ->set_width( 25 )
                ->set_required( true ),
            Field::make( 'text', 'gallery_beds', __( 'Bedrooms', 'home-boys-2' ) )
                ->set_width(50)
                ->set_attribute( 'type', 'number' ),
            Field::make( 'text', 'gallery_baths', __( 'Bathrooms', 'home-boys-2' ) )
                ->set_width(50)
                ->set_attribute( 'type', 'number' ),
            Field::make( 'text', 'gallery_size', __( 'Size', 'home-boys-2' ) )
                ->set_width(50)
                ->help_text( 'ft<sup>2</sup>' )
                ->set_attribute( 'type', 'number' ),
            Field::make( 'text', 'gallery_price', __( 'Price', 'home-boys-2' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width(50),    
            Field::make( 'select', 'gallery_series', __( 'Series', 'home-boys-2' ) )
                ->add_options( $plan_series_opt )
                ->set_width(50),
            Field::make( 'select', 'gallery_manufacturer', __( 'Manufacturer', 'home-boys-2' ) )
                ->add_options( $plan_manufacturer_opt )
                ->set_width(50),
            Field::make( 'textarea', 'gallery_matterport_embed', __( 'Matterport Embed Code', 'home-boys-2' ) ),
            Field::make( 'textarea', 'gallery_youtube_embed', __( 'YouTube Embed Code', 'home-boys-2' ) ),
            Field::make( 'textarea', 'gallery_description', __( 'Gallery Description', 'home-boys-2' ) ),
            Field::make( 'media_gallery', 'gallery_photos', __( 'Gallery Photos', 'home-boys-2' ) )
                ->help_text( __( 'First photo will be featured', 'home-boys-2' ) ),
        )
    );

    // Gallery page
    // Container::make( 'post_meta', __( 'Display Galleries', 'home-boys-2' ) )
    //     ->where( 'post_template', '=', 'galleries-template.php' )
    //     ->set_context( 'side')
    //     ->add_fields( array(
    //         Field::make( 'select', 'display_gelleries_type', __( 'Select type', 'home-boys-2' ) )
    //             ->add_options( $galleries_types_opt ),
    //     )
    // );

    // Page Titles
    Container::make( 'post_meta', __( 'Page Titles', 'home-boys-2' ) )
        ->where( 'post_template', 'IN', ['process-template.php', 'about-template.php', 'contacts-template.php'] )
        ->add_fields( array(
            Field::make( 'text', 'page_small_title', __( 'Page small title', 'home-boys-2' ) ),
            Field::make( 'text', 'page_title', __( 'Page title', 'home-boys-2' ) ),
        )
    );

    // Process Template
    // Container::make( 'post_meta', __( 'Process items block', 'home-boys-2' ) )
    //     ->where( 'post_template', '=', 'process-template.php' )
    //     ->add_fields( array(
    //         Field::make( 'checkbox', 'include_process_posts', __( 'Include Process Items', 'home-boys-2' ) )
    //             ->set_width( 25 ),
    //         Field::make( 'text', 'process_block_title', __( 'Process Items Block title', 'home-boys-2' ) )
    //             ->set_width( 75 )
    //             ->set_conditional_logic( array(
    //                 array(
    //                     'field' => 'include_process_posts',
    //                     'value' => true,
    //                 )
    //             ) ),
    //         Field::make( 'textarea', 'process_block_desc', __( 'Process Items Block description', 'home-boys-2' ) )
    //             ->set_conditional_logic( array(
    //                 array(
    //                     'field' => 'include_process_posts',
    //                     'value' => true,
    //                 )
    //             ) ),
    //     )
    // );
    
    // Guidelines Template
    Container::make( 'post_meta', __( 'Page meta', 'home-boys-2' ) )
        ->where( 'post_template', '=', 'guidelines-template.php' )
        ->add_fields( array(
            Field::make( 'separator', 'guidelines_block_sep', __( 'Guidelines Block', 'home-boys-2' ) ),
            Field::make( 'text', 'guidelines_block_small_title', __( 'Small title', 'home-boys-2' ) )
                ->set_width(50)
                ->set_default_value('Customer'),
            Field::make( 'text', 'guidelines_block_title', __( 'Title', 'home-boys-2' ) )
                ->set_width(50)
                ->set_default_value('Guidelines'),
            Field::make( 'complex', 'guidelines_list', __( 'Guidelines list', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $guidelines_labels )
                ->add_fields( array(
                    Field::make( 'text', 'guide_title', __( 'Guide title', 'home-boys-2' ) )
                        ->set_required( true )
                        ->set_width( 75 ),
                    Field::make( 'image', 'guide_image', __( 'Guide image', 'home-boys-2' ) )
                        ->set_required( true )
                        ->set_value_type( 'url' )
                        ->set_width( 25 ),
                    Field::make( 'textarea', 'guide_description', __( 'Guide description', 'home-boys-2' ) )
                        ->set_required( true ),
                ))
                ->set_header_template( '
                    <% if (guide_title) { %>
                        <%- guide_title %>
                    <% } %>
                ' )
        ) 
    );

    Container::make( 'post_meta', __( 'Pages link cards', 'home-boys-2' ) )
        ->where( 'post_template', 'IN', ['guidelines-template.php'] )
        ->add_fields( array(
            Field::make( 'text', 'pages_link_cards_button_txt', __( 'Buttons text' ) )
                ->set_default_value( 'View More' ),
            Field::make( 'complex', 'pages_link_cards', __( 'Cards', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $cards_labels )
                ->add_fields( array(
                    Field::make( 'text', 'plc_small_title', __( 'Small title', 'home-boys-2' ) )
                        ->set_width( 50 ),
                    Field::make( 'text', 'plc_title', __( 'Title', 'home-boys-2' ) )
                        ->set_width( 50 ),
                    Field::make( 'association', 'plc_post', __( 'Page', 'home-boys-2' ) )
                        ->set_max( 1 )
                        ->set_width( 50 )
                        ->set_types( [
                            [
                                'type'      => 'post',
                                'post_type' => 'page',
                            ]
                        ] ),
                    Field::make( 'image', 'plc_image', __( 'Image', 'home-boys-2' ) )
                        ->set_value_type( 'url' )
                        ->set_width( 50 )
                ) )
                ->set_header_template( '
                    <% if (plc_title) { %>
                        <%- plc_title %>
                    <% } %>
                ' )
        )
    );

    Container::make( 'post_meta', __( 'Double text-image', 'home-boys-2' ) )
        ->where( 'post_template', 'IN', ['guidelines-template.php', 'process-template.php'] )
        ->add_fields( array(
            Field::make( 'text', 'dti_small_title', __( 'Small title', 'home-boys-2' ) )
                ->set_width( 50 ),
            Field::make( 'text', 'dti_title', __( 'Title', 'home-boys-2' ) )
                // ->set_required( true )
                ->set_width( 50 ),
            Field::make( 'textarea', 'dti_description', __( 'Desription text', 'home-boys-2' ) )
                // ->set_required( true )
                ->set_width( 75 ),
            Field::make( 'image', 'dti_image', __( 'Block image', 'home-boys-2' ) )
                // ->set_required( true )
                ->set_value_type( 'url' )
                ->set_width( 25 ),
        )
    );

    Container::make( 'post_meta', __( 'Partners section', 'home-boys-2' ) )
        ->where( 'post_template', 'IN', ['process-template.php'] )
        ->add_fields( array(
            Field::make( 'checkbox', 'include_partners', __( 'Include Partners section?', 'home-boys-2' ) )
                ->set_width( 25 ),
        ) 
    );

    Container::make( 'post_meta', __( 'Files for upload', 'home-boys-2' ) )
        ->where( 'post_template', 'IN', ['guidelines-template.php'] )
        ->add_fields( array(
            Field::make( 'complex', 'files_for_upload', __( 'Files', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $files_labels )
                ->add_fields( array(
                    Field::make( 'text', 'file_fu_title', __( 'File title', 'home-boys-2' ) )
                        ->set_required( true )
                        ->set_width( 75 ),
                    Field::make( 'file', 'file_fu', __( 'File', 'home-boys-2' ) )
                        ->set_required( true )
                        ->set_width( 25 )
                        ->set_value_type( 'url' ),
                ) )
                ->set_header_template( '
                    <% if (file_fu_title) { %>
                        <%- file_fu_title %>
                    <% } %>
                ' )
            )
    );

    // Process post type meta
    Container::make( 'post_meta', __( 'Finannsing data', 'home-boys-2' ) )
        ->where( 'post_type', '=', 'process' )
        ->add_fields( array(
            Field::make( 'text', 'process_order', __( 'Display Order', 'home-boys-2' ) )
                ->set_default_value( '2' )
                ->set_attribute( 'type', 'number' )
                ->set_required( true ),
            Field::make( 'complex', 'process_contacts', __( 'Contacts', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $contacts_labels )
                ->add_fields( array(
                    Field::make( 'text', 'p_contact_name', __( 'Contact name', 'home-boys-2' ) ),
                    Field::make( 'complex', 'p_contact_phones', __( 'Phone numbers', 'home-boys-2' ) )
                        ->set_collapsed( true )
                        ->setup_labels( $phones_labels )   
                        ->add_fields( array(
                            Field::make( 'text', 'pcp_number', __( 'Phone number', 'home-boys-2' ) )
                                ->set_width( 50 )
                                ->set_required( true ),
                            Field::make( 'text', 'pcp_number_postfix', __( 'Postfix', 'home-boys-2' ) )
                                ->set_width( 50 ),
                        ) )
                        ->set_header_template( '
                            <% if (pcp_number) { %>
                                <%- pcp_number %>
                            <% } %>
                        ' ),
                    Field::make( 'complex', 'p_contact_emails', __( 'Emails ( or websites )', 'home-boys-2' ) )
                        ->set_collapsed( true )
                        ->setup_labels( $emails_labels )
                        ->add_fields( array(
                            Field::make( 'checkbox', 'pcp_is_site', __( 'Is site', 'home-boys-2' ) )
                                ->set_width( 20 ),
                            Field::make( 'text', 'pcp_email', __( 'Email', 'home-boys-2' ) )
                                ->set_width( 40 )
                                ->set_required( true ),
                            Field::make( 'text', 'pcp_email_postfix', __( 'Postfix', 'home-boys-2' ) )
                                ->set_width( 40 ),
                        ) )
                        ->set_header_template( '
                            <% if (pcp_email) { %>
                                <%- pcp_email %>
                            <% } %>
                        ' ),
                ) )
                ->set_header_template( '
                            <% if (p_contact_name) { %>
                                <%- p_contact_name %>
                            <% } %>
                        ' ),
            Field::make( 'textarea', 'process_description', __( 'Description' ) ),         
        )
    );

    // Employees post type meta
    Container::make( 'post_meta', __( 'Employee data', 'home-boys-2' ) )
        ->where( 'post_type', '=', 'employees' )
        ->add_fields( array(
            Field::make( 'text', 'employee_order', __( 'Display Order', 'home-boys-2' ) )
                ->set_default_value( '5' )
                ->set_attribute( 'type', 'number' )
                ->set_width( 10 )
                ->set_required( true ),
            Field::make( 'checkbox', 'is_group', __( 'Is group', 'home-boys-2' ) )
                ->set_width( 10 ),
            Field::make( 'text', 'employee_name', __( 'Employee Name', 'home-boys-2' ) )
                ->set_required( true )
                ->set_width( 40 ),
            Field::make( 'text', 'employee_title', __( 'Employee Title', 'home-boys-2' ) ) 
                ->set_required( true )
                ->set_width( 40 ),
            Field::make( 'textarea', 'employee_bio', __( 'Employee Bio', 'home-boys-2' ) )
                ->set_required( true )
                ->set_width( 75 ),
            Field::make( 'image', 'employee_photo', __( 'Employee Photo', 'home-boys-2' ) )
                ->set_width( 25 ),
            Field::make( 'text', 'employee_email', __( 'Employee Email', 'home-boys-2' ) )
                ->set_width( 40 ),
            Field::make( 'text', 'employee_phone', __( 'Employee Phone', 'home-boys-2' ) )
                ->set_width( 40 ),
            Field::make( 'text', 'employee_phone_after', __( 'After Phone Text', 'home-boys-2' ) )
                ->set_width( 20 ),    
        )
    );

    // Blogposts
    Container::make( 'post_meta', __( 'Post data', 'home-boys-2' ) )
        ->where( 'post_type', '=', 'blogposts' )
        ->add_fields( array(
            Field::make( 'text', 'post_title', __( 'Post Title', 'home-boys-2' ) ),
            Field::make( 'media_gallery', 'post_photo', __( 'Featured Photo(s)', 'home-boys-2' ) ),
        ) 
    );
};