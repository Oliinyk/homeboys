<?php
/**
 * Template name: Display homes
 */
$post_id = get_the_ID();

$locations          = apply_filters( 'hb2_locations_list', true );
$selected_location  = carbon_get_post_meta( $post_id, 'display_homes_location' );
$manufacturer_arr   = apply_filters( 'hb2_get_manufacturers_list', true );
$series_arr         = apply_filters( 'hb2_get_series_list', true );

$plans_query_args = [
    'post_type'      => 'plans',
    'posts_per_page' => $_GET['per_page'] ?? 4,
    'post_status'    => 'publish',
    'meta_query'     => [
        'relation' => 'AND',
        'order_column' => [
            'key'     => '_plan_order',
            'compare' => 'EXISTS',
        ],
        'location_column' => [
            [
                'key'     => '_plan_location',
                'value'   => (int) $selected_location,
                'compare' => '=',
            ],
        ],
        'sold_column' => [
            'key'     => '_is_sold',
            'value'   => 'yes',
            'compare' => '!=',
        ],
    ],
    'orderby' => [
        'order_column' => 'ASC',
    ]
];

$plans = new WP_Query( $plans_query_args );

get_header();

// Overlay
get_template_part( 'template-parts/modules/nav_overlay', null );
?>

<section class="hero-section">
    <div class="container">
        <ul class="breadcrumbs">
            <li class="crumb-item">
                <a href="#">Display Homes</a>
            </li>
            
            <?php
            if ( 0 <= $selected_location && isset( $locations[ $selected_location ] ) ) :
                ?>
                <li class="crumb-item">
                    <?php echo esc_html( $locations[ $selected_location ]['location_name'] ); ?>
                </li>
                <?php
            endif;
            ?>
        </ul>
        <h4 class="subtitle-section">Our</h4>
        <h1 class="title-section">Display Homes</h1>
        
        <?php
        get_template_part( 'template-parts/modules/_location_list', null, [
            'locations'        => $locations,
            'settings' => [
                'additional_class' => 'location-top',
                'active_index'     => $selected_location,
            ],
        ] );
        ?>
    </div>
</section>

<section class="gallery-section">
    <div class="container">
        <?php 
        if ( $plans->have_posts() ) :
        
            while ( $plans->have_posts() ) :
                $plans->the_post();
                $plan_id        = get_the_ID();
                $plan_order     = get_post_meta( $plan_id, 'plan_order', true );
                $plan_title     = carbon_get_post_meta( $plan_id, 'plan_name' );
                $plan_permalink = get_permalink( $plan_id );
                $thumbmail_id   = get_post_thumbnail_id( $plan_id );
                $plan_photos    = carbon_get_post_meta( $plan_id, 'plan_photos' );
                $plan_price     = carbon_get_post_meta( $plan_id, 'plan_price' );
                $plan_sqft      = carbon_get_post_meta( $plan_id, 'plan_size' );
                $plan_beds      = carbon_get_post_meta( $plan_id, 'plan_beds' );
                $plan_baths     = carbon_get_post_meta( $plan_id, 'plan_baths' );
                $plan_manuf     = carbon_get_post_meta( $plan_id, 'plan_manufacturer' );
                $plan_series    = carbon_get_post_meta( $plan_id, 'plan_series' );
                

                if ( empty( $thumbmail_id ) &&  ! empty( $plan_photos ) ) {
                    $gallery = maybe_unserialize( $plan_photos );

                    $thumbmail_id = $gallery[0];
                }

                $plan_thumbnail = wp_get_attachment_image_url( $thumbmail_id, 'large' );

                ?>
                <a href="<?php echo esc_url( $plan_permalink )?>" class="card-item">
                    <img src="<?php echo esc_url( $plan_thumbnail ); ?>" alt="#" class="slide-image">

                    <ul class="card-top-info">
                        <?php
                        if ( ! empty( $plan_sqft ) ) :
                            $sqft = number_format( intval( $plan_sqft ), 0, ',', ',' );
                            ?>
                            <li><?php echo esc_html( $sqft ); ?> ft²</li>
                        <?php
                        endif;

                        if ( ! empty( $plan_beds ) ) :
                            ?>
                        <li><?php echo esc_html( $plan_beds ); ?> BEDS</li>
                        <?php
                        endif;
                        if ( ! empty( $plan_baths ) ) :
                            ?>
                        <li><?php echo esc_html( $plan_baths ); ?> BATHS</li>
                        <?php
                        endif;
                        ?>
                    </ul>
                    <?php
                    if ( ! empty( $plan_price ) ) :
                        $price = number_format( intval( $plan_price ), 0, ',', ',' );
                        ?>
                        <div class="card-labels">
                            <div class="label">$ <?php echo esc_html( $price ); ?></div>
                        </div>
                        <?php
                    endif;
                    ?>
                    <div class="item-info">
                        <?php
                        if ( ! empty( $plan_title ) ) :
                            ?>
                            <h4 class="item-title">
                                <?php echo esc_html( $plan_title ); ?>
                            </h4>
                            <?php
                        endif;
                        ?>
                        
                        <p class="item-subtitle">
                            <?php
                                echo isset( $manufacturer_arr[$plan_manuf] ) ? $manufacturer_arr[$plan_manuf] : '';
                                echo isset( $series_arr[$plan_series] ) ? ' | ' . $series_arr[$plan_series] : '';
                            ?>
                        </p>
                    </div>
                </a>
                <?php
            endwhile;

            get_template_part( 'template-parts/modules/__show-all-button', null );
        
            wp_reset_postdata();

        else :
            $not_found_message = carbon_get_theme_option( 'not_found_posts_message' );

            if ( ! empty( $not_found_message ) ) :
                echo "<p class='not-found-message'>{$not_found_message}</p>";
            endif;    

        endif;
        
        get_template_part( 'template-parts/modules/_location_list', null, [
            'locations' => $locations,
            'settings' => [
                'additional_class' => 'location-bottom',
                'active_index'     => $selected_location,
            ],
        ] );
        ?>
    </div>
</section>

<?php
// Contact section
get_template_part( 'template-parts/modules/section', 'contact' );

// Find Home section
get_template_part( 'template-parts/modules/section', 'find_home' );

get_footer();