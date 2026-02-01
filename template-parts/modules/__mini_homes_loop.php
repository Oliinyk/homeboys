<?php
$current = get_the_ID();

$plans_query_args = [
    'post_type'      => 'plans',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
    'post__not_in'   => [$current],
    'meta_query'        => [
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

$plans_posts = new WP_Query( $plans_query_args );

if ( ! $plans_posts->have_posts() ) {
    return;
}

$manufacturer_arr = apply_filters( 'hb2_get_manufacturers_list', true ) ;
$series           = apply_filters( 'hb2_get_series_list', true ) ;
$on_display       = apply_filters( 'hb2_on_display_arr', [] );
?>
<div class="card-list sm-col-2 md-col-4">
    <?php
    while( $plans_posts->have_posts() ) :
        $plans_posts->the_post();

        $plan_id        = get_the_ID();
        $meta_title     = carbon_get_post_meta( $plan_id, 'plan_name' );
        $title          = ! empty( $meta_title ) ? $meta_title : get_the_title();
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
            'manufacturer'  => array_key_exists( $manufacturer, $manufacturer_arr ) ?  $manufacturer_arr[$manufacturer] : null,
            'series'        => array_key_exists( $plan_series, $series ) ? $series[$plan_series] : null,
        ];
        
        get_template_part( 'template-parts/modules/__floor_home_card', null, [ 'data-floor' => $floor_data ] );

    endwhile;
    ?>
</div>
<?php
wp_reset_postdata();