<?php
/**
 * Template name: ADU
 */

get_header();

$p_ID = get_the_ID();

$query_params = [
    'post_status'       => 'publish',
    'post_type'         => 'plans',
    'posts_per_page'    => 8,
    'paged'             => get_query_var( 'paged', 1 ),
    'meta_query'        => [
        'relation' => 'AND',
        'price_column' => [
            'key'      => '_plan_price',
            'compare'  => 'EXISTS',
            'type'     => 'DECIMAL',
        ],
        [
            'key'     => 'is_adu',
            'compare' => 'EXISTS',
        ],
    ],
    'order'   => $order,
    'orderby' => 'price_column',
];

$query              = new WP_Query( $query_params );
$content            = get_the_content();
$not_found_message  = carbon_get_theme_option( 'not_found_posts_message' );
$locations_list     = apply_filters( 'hb2_locations_list', true );
$manufacturer_arr   = apply_filters( 'hb2_get_manufacturers_list', true );
$series_arr         = apply_filters( 'hb2_get_series_list', true );

get_template_part( "template-parts/modules/section", "hero", ['id' => $p_ID ] ); // Баннер или в этом файле или просто ниже, перед контентом

?>
    <section class="info-section">
        <div class="container">
            <?php
            echo $content;
            ?>
        </div>
    </section>

    <section class="home-gallery-section">
        <div class="container">
            <?php
            if ( $query->have_posts() ) :
                ?>
                <div class="controls-sort">
                    <span>Sort by:</span>
                    <span class="sort-switcher sort-down">
                        $
                        <svg class="sort-ico" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.17219 11.306L4.11258 4.27272e-07L5.02649 3.47375e-07L5.04636 11.1157L8.28477 8.01318L9 8.69839L4.50993 13L4.49007 13L3.7947 12.3148L7.65525e-07 8.67936L0.715232 7.99414L4.17219 11.306Z" />
                        </svg>
                    </span>
                    <span class="sort-switcher sort-up active">
                        $
                        <svg class="sort-ico" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.17219 1.694L4.11258 13L5.02649 13L5.04636 1.88433L8.28477 4.98682L9 4.30161L4.50993 5.6114e-07L4.49007 5.59403e-07L3.7947 0.685213L7.65525e-07 4.32064L0.715232 5.00586L4.17219 1.694Z" />
                        </svg>
                    </span>
                </div>

                <div class="card-list sm-col-2">
                    <?php
                    while( $query->have_posts() ) :
                        $query->the_post();

                        $plan_id        = get_the_ID();
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
                        $plan_locations = carbon_get_post_meta( $plan_id, 'plan_location' );

                        // var_dump( maybe_unserialize($plan_photos) );

                        if ( empty( $thumbmail_id ) &&  ! empty( $plan_photos ) ) {
                            $gallery = maybe_unserialize( $plan_photos );

                            if ( is_string( $gallery ) ) {
                                $gallery = unserialize( $gallery );
                            }

                            $thumbmail_id = $gallery[0];
                        }

                        $plan_thumbnail = wp_get_attachment_image_url( $thumbmail_id, 'large' );

                        if ( empty( $plan_thumbnail ) ) {
                            $plan_thumbnail = apply_filters( 'hb2_get_random_image', true );
                        }

                        $floor_data = [
                            'title'         => $plan_title,
                            'img_src'       => esc_url( $plan_thumbnail ),
                            'permalink'     => esc_url( $plan_permalink ),
                            'price'         => number_format( floatval($plan_price), 0, ',', ',' ),
                            'size'          => $plan_sqft,
                            'beds'          => $plan_beds,
                            'baths'         => $plan_baths,
                            'location'      => $locations_list[$plan_locations]['location_name'],
                            'manufacturer'  => $manufacturer_arr[$plan_manuf],
                            'series'        => $series_arr[$plan_series],
                        ];
                        
                        get_template_part( 'template-parts/modules/__floor_home_card', null, [ 'data-floor' => $floor_data ] );
        
                    endwhile;

                    wp_reset_postdata();
                    ?>
                </div>

                <a href="#" class="btn primary-btn">
                    Show All
                    <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.90066 9.7689L5.97351 0L4.85651 0L4.83223 9.52L0.874172 5.4629L-4.94673e-09 6.35895L5.48786 11.9841H5.51214L6.36203 11.0881L11 6.33406L10.1258 5.43801L5.90066 9.7689Z"></path>
                    </svg>
                </a>
                <?php
            else :
                echo $not_found_message;
            endif;
            ?>
        </div>
    </section>
<?php
get_template_part( 'template-parts/modules/section', 'contact' );
get_template_part( 'template-parts/modules/section', 'find_home' );

get_footer();