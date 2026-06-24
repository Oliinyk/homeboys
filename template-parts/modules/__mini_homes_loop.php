<?php
$current = get_the_ID();
$use_display_homes = (bool) carbon_get_theme_option( 'similar_homes_use_display_lots' );
$origin_price = carbon_get_post_meta( $current, 'plan_price' );
$limit        = 4;
$posts_ids    = [];

$base_meta_query = [
    'relation' => 'AND',
    'price_column' => [
        'key'      => '_plan_price',
        'compare'  => 'EXISTS',
        'type'     => 'DECIMAL',
    ],
    'sold_column' => [
        'key'     => '_is_sold',
        'value'   => 'yes',
        'compare' => '!=',
    ],
];

if ( ! empty( $origin_price ) ) {
    $base_meta_query[] = [
        'key'     => '_plan_price',
        'compare' => 'BETWEEN',
        'value'   => [ intval( $origin_price ) - 50000, intval( $origin_price ) + 50000 ],
        'type'    => 'SIGNED',
    ];
}

$build_args = function( $meta_query, $exclude_ids, $posts_per_page ) {
    return [
        'post_type'      => 'plans',
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
        'post__not_in'   => $exclude_ids,
        'meta_query'     => $meta_query,
        'orderby'        => 'rand',
    ];
};

if ( $use_display_homes ) {
    $display_meta_query = $base_meta_query;
    $display_meta_query[] = [
        'key'     => '_plan_location',
        'value'   => '-1',
        'compare' => 'NOT LIKE',
    ];

    $display_posts = new WP_Query( $build_args( $display_meta_query, [ $current ], $limit ) );
    if ( $display_posts->have_posts() ) {
        $posts_ids = wp_list_pluck( $display_posts->posts, 'ID' );
    }

    $remain = $limit - count( $posts_ids );
    if ( $remain > 0 ) {
        $fallback_posts = new WP_Query( $build_args( $base_meta_query, array_merge( [ $current ], $posts_ids ), $remain ) );
        if ( $fallback_posts->have_posts() ) {
            $posts_ids = array_merge( $posts_ids, wp_list_pluck( $fallback_posts->posts, 'ID' ) );
        }
    }
} else {
    $default_posts = new WP_Query( $build_args( $base_meta_query, [ $current ], $limit ) );
    if ( $default_posts->have_posts() ) {
        $posts_ids = wp_list_pluck( $default_posts->posts, 'ID' );
    }
}

if ( empty( $posts_ids ) ) {
    return;
}

$plans_posts = new WP_Query( [
    'post_type'      => 'plans',
    'post_status'    => 'publish',
    'post__in'       => $posts_ids,
    'posts_per_page' => count( $posts_ids ),
    'orderby'        => 'post__in',
] );

$manufacturer_arr = apply_filters( 'hb2_get_manufacturers_list', true ) ;
$series           = apply_filters( 'hb2_get_series_list', true ) ;
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
            'manufacturer'  => array_key_exists( $manufacturer, $manufacturer_arr ) ?  $manufacturer_arr[$manufacturer] : null,
            'series'        => array_key_exists( $plan_series, $series ) ? $series[$plan_series] : null,
        ];
        
        get_template_part( 'template-parts/modules/__floor_home_card', null, [ 'data-floor' => $floor_data ] );

    endwhile;
    ?>
</div>
<?php
wp_reset_postdata();
