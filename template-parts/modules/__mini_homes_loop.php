<?php
$plans_query_args = [
    'post_type'      => 'plans',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
    'orderby'        => 'rand',
];

$plans_posts = new WP_Query( $plans_query_args );

if ( ! $plans_posts->have_posts() ) {
    return;
}

$manufacturer_arr = apply_filters( 'hb2_get_manufacturers_list', true ) ;
$series           = apply_filters( 'hb2_get_series_list', true ) ;

$on_display = [
    0 => "Spokane",
    1 => "Tri-Cities",
    2 => "Spokane <br/>
        Tri-Cities",
    3 => "Montana",
];
?>
<div class="card-list">
    <?php
    while( $plans_posts->have_posts() ) :
        $plans_posts->the_post();

        $plan_id    = get_the_ID();
        $title      = carbon_get_post_meta( $plan_id, 'plan_name' );
        $thumbnail  = get_the_post_thumbnail_url();

        if ( empty( $thumbnail ) ) {
            $thumbnail = get_stylesheet_directory_uri() . '/assets/img/Giant-Sequoia-ING762G.png';
        };

        $plan_size      = carbon_get_post_meta( $plan_id, 'plan_size' );
        $plan_beds      = carbon_get_post_meta( $plan_id, 'plan_beds' );
        $plan_baths     = carbon_get_post_meta( $plan_id, 'plan_baths' );
        $plan_price     = carbon_get_post_meta( $plan_id, 'plan_price' );
        $plan_location  = carbon_get_post_meta( $plan_id, 'plan_location' );
        $plan_number    = carbon_get_post_meta( $plan_id, 'plan_number' );
        $plan_series    = carbon_get_post_meta( $plan_id, 'plan_series' );
        $manufacturer   = carbon_get_post_meta( $plan_id, 'plan_manufacturer' );

        ?>
        <div class="card-item">
            <img src="<?php echo esc_url( $thumbnail ) ?>" alt="#">

            <ul class="card-top-info">
                <?php
                if ( ! empty( $plan_size ) ) :
                    ?>
                    <li>
                        <?php echo sprintf( "%s ft2", $plan_size )?>
                    </li>
                    <?php
                endif;

                if ( ! empty( $plan_beds ) ) :
                    ?>
                    <li>
                        <?php echo sprintf( "%d Beds", $plan_beds )?>
                    </li>
                    <?php
                endif;

                if ( ! empty( $plan_baths ) ) :
                ?>
                <li>
                    <?php echo sprintf( "%d Baths", $plan_baths )?>
                </li>
                <?php
                endif;
                ?>
            </ul>

            <div class="card-labels">
                <?php
                if ( ! empty ( $plan_price ) ) :
                ?>
                <div class="label">
                    $<?php echo $plan_price?>
                </div>
                <?php
                endif;
                ?>
                <div class="label danger">
                    <span class="label-top">On Display</span>
                    <span>
                        <?php echo $on_display[$plan_location]?>
                    </span>
                </div>
            </div>
            <div class="item-info">
                <h4 class="item-title">
                    <?php echo $title?>
                </h4>
                
                <p class="item-subtitle">
                    <?php 
                        echo isset( $manufacturer_arr[$manufacturer] ) ? $manufacturer_arr[$manufacturer] : '';
                        echo isset( $series[$plan_series] ) ? '|' . $series[$plan_series] : '';
                    ?>
                </p>
            </div>
        </div>
        <?php
    endwhile;
    ?>
</div>
<?php
wp_reset_postdata();