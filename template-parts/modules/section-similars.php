<?php
$current             = get_the_ID();
$use_display_homes   = (bool) carbon_get_theme_option( 'similar_homes_use_display_lots' );
$origin_id           = isset( $args['id'] ) ? intval( $args['id'] ) : $current;
$origin_price        = carbon_get_post_meta( $origin_id, 'plan_price' );

$q_params = [
    'post_status'       => 'publish',
    'post_type'         => 'plans',
    'posts_per_page'    => 2,
    'post__not_in'      => [$current],
    'meta_query'     => [
        'relation' => 'AND',
        'price_column' => [
            'key'      => '_plan_price',
            'compare'  => 'EXISTS',
            'type'     => 'DECIMAL',
        ],
        [
            'relation' => 'OR',
            [
                'key'     => '_is_sold',
                'value'   => 'yes',
                'compare' => '!=',
            ],
            [
                'key'     => '_is_sold',
                'compare' => 'NOT EXISTS',
            ],
        ],
    ],
    'order'   => 'DESC',
    'orderby' => 'price_column',
];

if ( ! empty( $origin_price ) ) {
    $price_param = [
        'key'     => '_plan_price',
        'compare' => 'BETWEEN',
        'value'   => [ intval( $origin_price ) - 50000, intval( $origin_price ) + 50000 ],
        'type'    => 'SIGNED',
    ];

    array_push( $q_params['meta_query'], $price_param );
}

if ( $use_display_homes ) {
    $display_homes_param = [
        'key'     => '_plan_location',
        'value'   => '-1',
        'compare' => 'NOT LIKE',
    ];

    array_push( $q_params['meta_query'], $display_homes_param );
}

$posts = new WP_Query( $q_params );

if ( ! $posts->have_posts() ) {
    return;
};

$manufacturer_arr = apply_filters( 'hb2_get_manufacturers_list', true ) ;
$series           = apply_filters( 'hb2_get_series_list', true ) ;
?>
<section class="find-home-section">
    <div class="container">
        <h4 class="subtitle-section">View</h4>

        <h2 class="title-section">Similar Homes</h2>

        <div class="card-list sm-col-2">
            <?php
            while ( $posts->have_posts() ) :
                $posts->the_post();

                $plan_id        = get_the_ID();
                $title          = carbon_get_post_meta( $plan_id, 'plan_name' );
                $permalink      = get_the_permalink($plan_id);
                $thumbnail      = get_the_post_thumbnail_url();
                $plan_photos    = carbon_get_post_meta( $plan_id, 'plan_photos' );
                $plan_size      = carbon_get_post_meta( $plan_id, 'plan_size' );
                $plan_beds      = carbon_get_post_meta( $plan_id, 'plan_beds' );
                $plan_baths     = carbon_get_post_meta( $plan_id, 'plan_baths' );
                $plan_price     = carbon_get_post_meta( $plan_id, 'plan_price' );
                $plan_location  = carbon_get_post_meta( $plan_id, 'plan_location' );
                $plan_number    = carbon_get_post_meta( $plan_id, 'plan_number' );
                $plan_series    = carbon_get_post_meta( $plan_id, 'plan_series' );
                $manufacturer   = carbon_get_post_meta( $plan_id, 'plan_manufacturer' );

                if ( empty( $thumbnail ) &&  ! empty( $plan_photos ) ) {
                    $gallery = maybe_unserialize( $plan_photos );

                    $thumbmail_id = $gallery[0];

                    $thumbnail = wp_get_attachment_image_url( $thumbmail_id, 'large' );
                }

                $floor_data = [
                    'title'         => $title,
                    'img_src'       => esc_url( $thumbnail ),
                    'permalink'     => esc_url( $permalink ),
                    'price'         => number_format( floatval($plan_price), 0, ',', ',' ),
                    'size'          => $plan_size,
                    'beds'          => $plan_beds,
                    'baths'         => $plan_baths,
                    'location'      => apply_filters( 'hb2_on_display_arr', $plan_location ),
                    'manufacturer'  => $manufacturer_arr[$manufacturer],
                    'series'        => $series[$plan_series],
                ];
                
                get_template_part( 'template-parts/modules/__floor_home_card', null, [ 'data-floor' => $floor_data ] );
            endwhile;    
            ?>
        </div>

    </div>
</section>
<?php
wp_reset_postdata();
