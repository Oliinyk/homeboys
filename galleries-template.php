<?php
/**
 * Template name: Gallery Template
 */
get_header();

$p_id = get_the_ID();
$hero_params = ['id' => $p_id];

$q_params = [
    'post_status'    => 'publish',
    'post_type'      => 'galleries',
    'posts_per_page' => 6,
    'meta_query'     => [
        'relation' => 'AND',
        [
            'key'     => '_gallery_photos',
            'compare' => 'EXISTS'
        ],
    ],
];

$includes_type = carbon_get_post_meta( $p_id, 'display_gelleries_type' );

switch ( $includes_type ) {
    case '1' :
        $a = [
            'key'     => '_is_sold',
            'compare' => 'NOT EXISTS',
        ];
        array_push( $q_params['meta_query'], $a );
        break;
    case '2' :
        $b = [
            'relation' => 'AND',
            [
               'key'     => '_is_sold',
               'compare' => 'EXISTS', 
            ],
            [
                'key' => '_is_sold',
                'value' => 'yes',
                'compare' => '=',
            ]
        ];
        array_push( $q_params['meta_query'], $b );
        break;    
}

$query = new WP_Query( $q_params );

$manuf_list  = apply_filters( 'hb2_get_manufacturers_list', [] );
$series_list = apply_filters( 'hb2_get_series_list', [] );

$sold_marker_placeholder = carbon_get_theme_option( 'sold_marker_placeholder' );
$not_found_message       = carbon_get_theme_option( 'not_found_posts_message' );
?>
<div class="nav-overlay" id="navOverlay"></div>

<?php
    get_template_part( 'template-parts/modules/section', 'hero', $hero_params );
?>

<section class="gallery-section">
    <div class="container">
        <div class="galleries-grid">
            <?php
            if ( $query->have_posts() ) :
                while( $query->have_posts() ) :
                    $query->the_post();

                    $g_ID           = get_the_ID();
                    $permalink      = get_the_permalink();
                    $gallery_phts   = carbon_get_post_meta( $g_ID, 'gallery_photos' );
                    $first_pht_id   = $gallery_phts[0];
                    $thumbnail_url  = wp_get_attachment_image_url( $first_pht_id, 'full' );
                    $title          = carbon_get_post_meta( $g_ID, 'gallery_name' );
                    $video_embeds   = carbon_get_post_meta( $g_ID, 'gallery_video_embeds' );
                    $tour_embeds    = carbon_get_post_meta( $g_ID, 'gallery_tours' );
                    $manufacturer   = carbon_get_post_meta( $g_ID, 'gallery_manufacturer' );
                    $series         = carbon_get_post_meta( $g_ID, 'gallery_series' );
                    $is_sold        = 'yes' == carbon_get_post_meta( $g_ID, 'is_sold' );
                    $photos_count   = count( $gallery_phts );
                    $videos_count   = ! empty( $video_embeds ) ? count( $video_embeds ) : 0 ; 
                    $tours_count    = ! empty( $tour_embeds ) ? count( $tour_embeds ) : 0 ;
                    ?>
                    <a href="<?php echo esc_url( $permalink )?>" class="grid-item card-item">
                        <img src="<?php echo esc_url( $thumbnail_url )?>" alt="<?php echo $title?>">

                        <ul class="card-top-info">
                            <li>
                                <?php
                                include( get_template_directory() . '/assets/img/icons/images-svg.html' );
                                echo $photos_count;
                                ?>
                            </li>

                            <li>
                                <?php
                                include( get_template_directory() . '/assets/img/icons/video-svg.html' );
                                echo $videos_count;
                                ?>
                            </li>

                            <li>
                                <?php
                                include( get_template_directory() . '/assets/img/icons/three-d-svg.html' );
                                echo $tours_count;
                                ?>
                            </li>
                        </ul>

                        <?php
                        if ( $is_sold ) :
                            ?>
                            <div class="card-labels">
                                <div class="label sold">
                                    <?php echo $sold_marker_placeholder?>
                                </div>
                            </div>
                            <?php
                        endif;
                        ?>
                        <div class="item-info">
                            <h4 class="item-title"><?php echo $title?></h4>

                            <p class="item-subtitle">
                                <?php
                                isset( $manuf_list[$manufacturer] ) ? $manuf_list[$manufacturer] : '';
                                isset( $series_list[$series] ) ? ' | ' . $series_list[$series] : '';
                                ?>
                            </p>
                        </div>
                    </a>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo $not_found_message;
            endif;
            ?>
        </div>
    </div>
</section>

<?php
    get_template_part( 'template-parts/modules/section', 'contact' );
    get_template_part( 'template-parts/modules/section', 'find_home' );
get_footer();