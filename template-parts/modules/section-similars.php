<?php
$q_params = [
    'post_status'    => 'publish',
    'post_type'      => 'plans',
    'posts_per_page' => 2, //get_option( 'posts_per_page' )
    'meta_query'     => [
        'relation' => 'AND',
        'price_column' => [
            'key'      => '_plan_price',
            'compare'  => 'EXISTS',
            'type'     => 'DECIMAL',
        ],
    ],
    'order'   => 'DESC',
    'orderby' => 'price_column',
];

if ( isset( $args['id'] ) ) {
    $orient_price = carbon_get_post_meta( $args['id'], 'plan_price' );

    $price_param = [
        'key'     => '_plan_price',
        'compare' => 'BETWEEN',
        'value'   => [ $orient_price-1000, $orient_price+1000 ],
        'type'    => 'SIGNED',
    ];

    array_push( $q_params['meta_query'], $price_param );
}

$posts = new WP_Query( $q_params );

if ( ! $posts->have_posts() ) {
    return;
};

$manufacturer_arr = apply_filters( 'hb2_get_manufacturers_list', true ) ;
$series           = apply_filters( 'hb2_get_series_list', true ) ;
$on_display       = apply_filters( 'hb2_on_display_arr', [] );
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
                $plan_size      = carbon_get_post_meta( $plan_id, 'plan_size' );
                $plan_beds      = carbon_get_post_meta( $plan_id, 'plan_beds' );
                $plan_baths     = carbon_get_post_meta( $plan_id, 'plan_baths' );
                $plan_price     = carbon_get_post_meta( $plan_id, 'plan_price' );
                $plan_location  = carbon_get_post_meta( $plan_id, 'plan_location' );
                $plan_number    = carbon_get_post_meta( $plan_id, 'plan_number' );
                $plan_series    = carbon_get_post_meta( $plan_id, 'plan_series' );
                $manufacturer   = carbon_get_post_meta( $plan_id, 'plan_manufacturer' );

                if ( empty( $thumbnail ) ) {
                    $thumbnail = apply_filters( 'hb2_get_random_image', true );
                };

                $floor_data = [
                    'title'         => $title,
                    'img_src'       => esc_url( $thumbnail ),
                    'permalink'     => esc_url( $permalink ),
                    'price'         => number_format( floatval($plan_price), 0, ',', ',' ),
                    'size'          => $plan_size,
                    'beds'          => $plan_beds,
                    'baths'         => $plan_baths,
                    'location'      => $on_display[$plan_location],
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