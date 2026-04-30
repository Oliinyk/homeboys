<?php
/**
 * Template Name: Find Home Template
 *
 * @package Home_Boys_2
 */


get_header();

$pId = get_the_ID();
$not_found_message = carbon_get_theme_option( 'not_found_posts_message' );
$order = 'desc';

if ( isset( $_GET['sort'] ) ) {
    $order = $_GET['sort'];
}

$per_page = isset( $_GET['per_page'] ) ? -1 : 12;

$query_params = [
    'post_status'       => 'publish',
    'post_type'         => 'plans',
    'posts_per_page'    => $per_page,
    'paged'             => get_query_var( 'paged', 1 ),
    'meta_query'        => [
        'relation' => 'AND',
        'order_column' => [
            'key'     => '_plan_order',
            'type'    => 'NUMERIC',
            'compare' => 'EXISTS',
        ],
        'price_column' => [
            'key'      => '_plan_price',
            'compare'  => 'EXISTS',
            'type'     => 'DECIMAL',
        ],
        // 'sold_column' => [
        //     'key'     => '_is_sold',
        //     'value'   => 'yes',
        //     'compare' => '!=',
        // ],
    ],
    'orderby' => [
        'order_column' => 'ASC',
        'price_column' => strtoupper($order),
    ]
];

// Filter by prices
if ( isset( $_GET['price_min'] ) && isset( $_GET['price_max'] ) ) {
    $price_q = [
        'key'     => '_plan_price',
        'compare' => 'BETWEEN',
        'value'   => [ intval( $_GET['price_min'] ), intval( $_GET['price_max'] ) ],
        'type'    => 'SIGNED',
    ];

    array_push( $query_params['meta_query'], $price_q );
}

// Filter by size
if ( isset( $_GET['size_min'] ) && isset( $_GET['size_max'] ) ) {
    $size_q = [
        'key'     => '_plan_size',
        'compare' => 'BETWEEN',
        'value'   => [ intval( $_GET['size_min'] ), intval( $_GET['size_max'] ) ],
        'type'    => 'SIGNED',
    ];

    array_push( $query_params['meta_query'], $size_q );
}

// Filter by beds
if ( isset( $_GET['beds'] ) ) {
    $beds_q = [
        'key'     => '_plan_beds',
        'compare' => '<=',
        'value'   => intval( $_GET['beds'] ),
        'type'    => 'SIGNED',
    ];

    array_push( $query_params['meta_query'], $beds_q );
}

// Filter by baths
if ( isset( $_GET['baths'] ) ) {
    $baths_q = [
        'key'     => '_plan_baths',
        'compare' => '<=',
        'value'   => intval( $_GET['baths'] ),
        'type'    => 'SIGNED',
    ];

    array_push( $query_params['meta_query'], $baths_q );
}

// Filter by width
if ( isset( $_GET['width'] ) ) {
    $width_q = [
        'key'     => '_plan_width',
        'compare' => '=',
        'value'   => $_GET['width'],
    ];

    array_push( $query_params['meta_query'], $width_q );
}

// Filter by manufacturer
if ( isset( $_GET['manufacturer'] ) ) {
    $manufacturer_q = [
        'key'     => '_plan_manufacturer',
        'compare' => '=',
        'value'   => $_GET['manufacturer'],
    ];

    array_push( $query_params['meta_query'], $manufacturer_q );
}

// Filter by series
if ( isset( $_GET['series'] ) ) {
    $series_q = [
        'key'     => '_plan_series',
        'compare' => '=',
        'value'   => $_GET['series'],
    ];

    array_push( $query_params['meta_query'], $series_q );
}

if ( isset( $_GET['search'] ) ) {
    $query_params['s'] = sanitize_text_field($_GET['search']);
    
     $search_q = [
        [
            'key'     => '_plan_name',
            'compare' => 'LIKE',
            'value'   => $_GET['search'],
        ],
    ];

    array_push( $query_params['meta_query'], $search_q );
}

$locations_list   = apply_filters( 'hb2_locations_list', true );
$manufacturer_arr = apply_filters( 'hb2_get_manufacturers_list', true );
$series_arr       = apply_filters( 'hb2_get_series_list', true );

$homes = new WP_Query( $query_params );

// Overlay
get_template_part( 'template-parts/modules/nav_overlay', null );
?>
<section class="find-home-section">
    <div class="container">
        <h4 class="subtitle-section">Find</h4>
        <h2 class="title-section">Your Home</h2>

        <!-- filter -->
        <?php get_template_part( 'template-parts/modules/_filter', null ); ?>

    </div>
</section>

<section class="home-gallery-section">
    <div class="container">
        <div class="controls-sort">
            <span>Sort by:</span>
            <span class="sort-switcher sort-down<?php echo 'desc' == $order ? ' active' : ''?>" data-sort="desc">
                $
                <svg class="sort-ico" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.17219 11.306L4.11258 4.27272e-07L5.02649 3.47375e-07L5.04636 11.1157L8.28477 8.01318L9 8.69839L4.50993 13L4.49007 13L3.7947 12.3148L7.65525e-07 8.67936L0.715232 7.99414L4.17219 11.306Z" />
                </svg>
            </span>

            <span class="sort-switcher sort-up <?php echo 'asc' == $order ? ' active' : ''?>" data-sort="asc">
                $
                <svg class="sort-ico" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.17219 1.694L4.11258 13L5.02649 13L5.04636 1.88433L8.28477 4.98682L9 4.30161L4.50993 5.6114e-07L4.49007 5.59403e-07L3.7947 0.685213L7.65525e-07 4.32064L0.715232 5.00586L4.17219 1.694Z" />
                </svg>
            </span>
        </div>

        <div class="card-list sm-col-2">
            <?php
            if ( $homes->have_posts() ) :
                while( $homes->have_posts() ) :
                    $homes->the_post();

                    $plan_id        = get_the_ID();
                    $is_sold        = carbon_get_post_meta( $plan_id, 'is_sold' );
                    if ( "yes" == $is_sold ) {
                        continue;
                    }
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

                    if ( empty( $thumbmail_id ) &&  ! empty( $plan_photos ) ) {
                        $gallery = maybe_unserialize( $plan_photos );

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
                        'location'      => apply_filters( 'hb2_on_display_arr', $plan_locations ),
                        'manufacturer'  => $manufacturer_arr[$plan_manuf],
                        'series'        => array_key_exists( $plan_series, $series_arr ) ? $series_arr[$plan_series] : '',
                    ];
                    
                    get_template_part( 'template-parts/modules/__floor_home_card', null, [ 'data-floor' => $floor_data ] );
    
                endwhile;

            else :
                echo $not_found_message;
            endif;
            ?>
        </div>

        <?php
            get_template_part( 'template-parts/modules/__show-all-button', null );

            wp_reset_postdata();
        ?>
    </div>
</section>

<?php
// Contact section
get_template_part( 'template-parts/modules/section', 'contact' );

// Find Home section
get_template_part( 'template-parts/modules/section', 'find_home' );

get_footer();