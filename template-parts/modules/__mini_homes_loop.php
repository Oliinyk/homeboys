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
?>
<div class="card-list">
    <?php
    while( $plans_posts->have_posts() ) :
        $plans_posts->the_post();

        $plan_id    = get_the_ID();
        $title      = get_the_title( $plan_id );
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

        $on_display = [
            0 => "Spokane",
            1 => "Tri-Cities",
            2 => "Spokane <br/>
                Tri-Cities",
            3 => "Montana",
        ];

        $series = [
            16 => '400 Series',
            32 => '5000 Series',
            17 => 'American Dream',
            0  => 'Broadmore',
            28 => 'Canyon View',
            24 => 'Columbia River',
            7  => 'Dream Silver',
            34 => 'Imagine',
            35 => 'Inspiration (Cavco)',
            8  => 'Inspiration Gold',
            26 => 'Independence Series',
            27 => 'Majestic Series',
            25 => 'Marlette Special',
            13 => 'McKenzie',
            18 => 'Olympic Range',
            10 => 'Patriot',
            9  => 'Platinum Series',
            31 => 'Pure Series',
            33 => 'Rhythm Series',
            23 => 'Schult Series',
            15 => 'Siskyou Series',
            11 => 'Special Series',
            29 => 'Summit View',
            30 => 'Tempo',
            36 => 'Vista (Cavco)',
            5  => 'Waverly Crest Prestige',
            37 => 'Alpha',
        ];

        $manufacturer_arr = [
            6 => 'Clayton Homes',
            3 => 'Cavco Nampa (Fleetwood)',
            1 => 'Cavco Millersburg (Palm Harbor)',
            7 => 'Cavco Montevideo (Friendship)',
            0 => 'Golden West',
            2 => 'Karsten Homes',
            5 => 'Marlette Homes',
            4 => 'Schult Homes',
        ];

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
                    <?php echo $plan_price?>
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
                <?php
                // if ( ! empty( $plan_number ) ) :
                ?>
                <h4 class="item-title">
                    <?php echo $title?>
                </h4>
                <?php
                // endif;

                ?>
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