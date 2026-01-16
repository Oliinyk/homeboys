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

    // Options
    $plan_series_opt = hb2_get_series_options();

    $plan_manufacturer_opt = hb2_get_manufacturers_options();

    $plan_width_opt = hb2_get_width_options();

    $plan_type_opt = hb2_get_type_options();

    $plan_location_opt = [
        -1 => '-Select',
        0  => 'Spokane Only',
        1  => 'Tri Cities Only',
        2  => 'Spokane and Tri Cities',
        3  => 'Montana',
    ];

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
                        ->set_width(75),
                    Field::make( 'image', 'sb_hero_image', __( 'Banner image', 'home-boys-2' ) )
                        ->set_width(25)
                        ->set_value_type('url'),
                ) )
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
        )
    );

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
        )
    );

    // Plains posts meta
    Container::make( 'post_meta', __( 'Home plain data', 'home-boys-2' ) )
        ->where( 'post_type', '=', 'plans' )
        ->add_fields( array(
            Field::make( 'text', 'plan_name', __( 'Display Name', 'home-boys-2' ) ),
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
                ->set_attribute( 'type', 'number' )
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
        )
    );

    Container::make( 'post_meta', __( 'Is ADU' ) )
        ->where( 'post_type', '=', 'plans' )
        ->set_context( 'side' )
        ->add_fields( array(
            Field::make( 'checkbox', 'is_adu', __( 'Mark as ADU', 'home-boys-2' ) ),
        )
    );

    Container::make( 'post_meta', __( 'Is Soild', 'home-boys-2' ) )
        ->where( 'post_type', 'IN', ['plans', 'galleries'] )
        ->set_context( 'side' )
        ->add_fields( array(
            Field::make( 'checkbox', 'is_sold', __( 'Mark as Sold', 'home-boys-2' ) ),
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
                ->set_required( true ),
            Field::make( 'select', 'gallery_series', __( 'Series', 'home-boys-2' ) )
                ->add_options( $plan_series_opt )
                ->set_width(50),
            Field::make( 'select', 'gallery_manufacturer', __( 'Manufacturer', 'home-boys-2' ) )
                ->add_options( $plan_manufacturer_opt )
                ->set_width(50),
            Field::make( 'complex', 'gallery_video_embeds', __( 'Video embeds', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $embeds_labels )
                ->add_fields( array(
                    Field::make( 'text', 'gve_title', __( 'Title', 'home-boys-2' ) ),
                    Field::make( 'textarea', 'gve_code', __( 'Embed code', 'home-boys-2' ) )
                        ->set_required( true ),
                ) )
                ->set_header_template( '
                    <% if (gve_title) { %>
                        <%- gve_title %>
                    <% } %>
                ' ),
            Field::make( 'complex', 'gallery_tours', __( 'Tour embeds', 'home-boys-2' ) )
                ->set_collapsed( true )
                ->setup_labels( $embeds_labels )
                ->add_fields( array(
                    Field::make( 'text', 'gvt_title', __( 'Title', 'home-boys-2' ) ),
                    Field::make( 'text', 'gvt_url', __( 'Tour URL', 'home-boys-2' ) )
                        ->set_required( true ),
                ) )
                ->set_header_template( '
                    <% if (gvt_title) { %>
                        <%- gvt_title %>
                    <% } %>
                ' ),
            Field::make( 'textarea', 'gallery_description', __( 'Gallery Description', 'home-boys-2' ) ),
            Field::make( 'media_gallery', 'gallery_photos', __( 'Gallery Photos', 'home-boys-2' ) )
                ->help_text( __( 'First photo will be featured', 'home-boys-2' ) ),    
        )
    );

    // Gallery page
    Container::make( 'post_meta', __( 'Display Galleries', 'home-boys-2' ) )
        ->where( 'post_template', '=', 'galleries-template.php' )
        ->set_context( 'side')
        ->add_fields( array(
            Field::make( 'select', 'display_gelleries_type', __( 'Select type', 'home-boys-2' ) )
                ->add_options( $galleries_types_opt ),
        )
    );

    // Page Titles
    Container::make( 'post_meta', __( 'Page Titles', 'home-boys-2' ) )
        ->where( 'post_template', 'IN', ['process-template.php', 'about-template.php'] )
        ->add_fields( array(
            Field::make( 'text', 'page_small_title', __( 'Page small title', 'home-boys-2' ) ),
            Field::make( 'text', 'page_title', __( 'Page title', 'home-boys-2' ) ),
        )
    );

    // Process Template
    Container::make( 'post_meta', __( 'Process items block', 'home-boys-2' ) )
        ->where( 'post_template', '=', 'process-template.php' )
        ->add_fields( array(
            Field::make( 'checkbox', 'include_process_posts', __( 'Include Process Items', 'home-boys-2' ) )
                ->set_width( 25 ),
            Field::make( 'text', 'process_block_title', __( 'Process Items Block title', 'home-boys-2' ) )
                ->set_width( 75 )
                ->set_conditional_logic( array(
                    array(
                        'field' => 'include_process_posts',
                        'value' => true,
                    )
                ) ),
            Field::make( 'textarea', 'process_block_desc', __( 'Process Items Block description', 'home-boys-2' ) )
                ->set_conditional_logic( array(
                    array(
                        'field' => 'include_process_posts',
                        'value' => true,
                    )
                ) ),
        )
    );
    
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
    Container::make( 'post_meta', __( 'Process data', 'home-boys-2' ) )
        ->where( 'post_type', '=', 'process' )
        ->add_fields( array(
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
                            Field::make( 'text', 'pcp_email', __( 'Email', 'home-boys-2' ) )
                                ->set_width( 50 )
                                ->set_required( true ),
                            Field::make( 'text', 'pcp_email_postfix', __( 'Postfix', 'home-boys-2' ) )
                                ->set_width( 50 ),
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
            Field::make( 'checkbox', 'is_group', __( 'Is group', 'home-boys-2' ) )
                ->set_width( 20 ),
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
                ->set_width( 50 ),
            Field::make( 'text', 'employee_phone', __( 'Employee Phone', 'home-boys-2' ) )
                ->set_width( 50 ),    
        )
    );
};