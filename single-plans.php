<?php
get_header();

$p_ID               = get_the_ID();
$thumbnail          = get_the_post_thumbnail_url();
$title              = carbon_get_post_meta( $p_ID, 'plan_name' );
$title              = ! empty( $title ) ? $title : get_the_title();
$photos             = carbon_get_post_meta( $p_ID, 'plan_photos' );
$manufacturer       = carbon_get_post_meta( $p_ID, 'plan_manufacturer' );
$series             = carbon_get_post_meta( $p_ID, 'plan_series' );
$youtube_embed      = carbon_get_post_meta( $p_ID, 'youtube_embed' );
$plan_tour          = carbon_get_post_meta( $p_ID, 'plan_tour' );
$matterport_embed   = carbon_get_post_meta( $p_ID, 'matterport_embed' );
$base_price         = carbon_get_post_meta( $p_ID, 'plan_price' );
$complect_price     = carbon_get_post_meta( $p_ID, 'plan_set_price' );
$complect_pr_desc   = carbon_get_post_meta( $p_ID, 'plan_set_price_desc' );
$loc                = carbon_get_post_meta( $p_ID, 'plan_location' );
$size               = carbon_get_post_meta( $p_ID, 'plan_size' );
$beds               = carbon_get_post_meta( $p_ID, 'plan_beds' );
$baths              = carbon_get_post_meta( $p_ID, 'plan_baths' );
$view_plan_doc      = carbon_get_post_meta( $p_ID, 'plan_brochure' );
$standart_features  = carbon_get_post_meta( $p_ID, 'plan_brochure2' );
$list_options_doc   = carbon_get_post_meta( $p_ID, 'plan_brochure3' );
$misc_doc           = carbon_get_post_meta( $p_ID, 'plan_brochure4' );
$description        = carbon_get_post_meta( $p_ID, 'plan_description' );
$content            = get_the_content();

$gallery       = array_unique( maybe_unserialize( $photos ) );
$location      = apply_filters( 'hb2_on_display_arr', $loc );

$manuf_list  = apply_filters( 'hb2_get_manufacturers_list', [] );
$series_list = apply_filters( 'hb2_get_series_list', [] );

if ( ! $thumbnail ) {
    $thumbnail = apply_filters( 'hb2_get_random_image', false );
}

$base_price_format     = ! empty( $base_price ) ? number_format( intval( $base_price ), 0, '.', ',' ) : '';
$complect_price_format = ! empty( $complect_price ) ? '$' . number_format( intval( $complect_price ), 0, '.', ',' ) : '$' . $base_price_format;
$price_short_desc      = ! empty( $complect_pr_desc ) ? ' ' . $complect_pr_desc : ' Includes standard delivery & set within 100 miles';

// Overlay
get_template_part( 'template-parts/modules/nav_overlay', null );

?>

    <section class="gallery-thumbs-section">
        <div class="container">

            <?php if ( ! empty( $gallery ) ) : ?>

            <!-- Thumbs gallery slider -->
            <div class="gallery-thumbs-slider <?php echo count( $gallery ) === 1 ? 'one-gallery-image' : ''; ?>">
                <!-- Main slider -->
                <div class="gallery-main <?php echo count( $gallery ) > 1 ? 'swiper' : 'single-gallery-image'; ?>">
                    <div class="swiper-wrapper">
                        <?php
                        foreach( $gallery as $key => $item ) :
                            $img_url = is_numeric($item) ? wp_get_attachment_image_url( intval($item), 'full' ) : $item;
                            if ( empty( $img_url ) ) {
                                    continue;
                                }
                            ?>
                                <div class="swiper-slide">
                                    <?php if ( count( $gallery ) > 1 ) : ?>
                                        <a href="<?php echo esc_url( $img_url ); ?>" class="js-fancybox-item" data-index="<?php echo $key; ?>">
                                            <img src="<?php echo esc_url( $img_url )?>" alt="Photo <?php echo $key?>">
                                        </a>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url( $img_url )?>" alt="Photo <?php echo $key?>">
                                    <?php endif; ?>
                                </div>
                            <?php
                        endforeach;
                        ?>
                    </div>

                    <?php
                    if ( 1 < count( $gallery ) ) :
                        ?>
                        <div class="swiper-button-prev custom-prev">
                            <svg class="arrow-ico" width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.8047 23.125L7.92969 14.7656L25.2031 14.7656L25.2031 8.55469L7.83203 8.55469L11.8047 0L5.76953 0L0 11.5625L5.76953 23.125H11.8047Z" />
                            </svg>
                        </div>

                        <div class="swiper-button-next custom-next">
                            <svg class="arrow-ico" width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.3984 23.125L17.2734 14.7656L0 14.7656L0 8.55469L17.3711 8.55469L13.3984 0L19.4336 0L25.2031 11.5625L19.4336 23.125H13.3984Z" />
                            </svg>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>

                <!-- Thumbnails -->
                <?php
                if ( 1 < count( $gallery ) ) :
                    ?>
                    <div class="gallery-thumbs swiper">
                        <div class="swiper-wrapper">
                            <?php
                            foreach ( $gallery as $key => $item ) :
                                $img_url = wp_get_attachment_image_url( intval($item) );
                                if ( empty( $img_url ) ) {
                                    continue;
                                }
                                ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo esc_url( $img_url )?>" alt="Thumb <?php echo $key?>">
                                </div>
                                <?php
                            endforeach;
                            ?>    
                        </div>
                    </div>
                    <?php
                endif;
                ?>
            </div>

            <?php else : ?>

                <div class="no-gallery">
                    <svg width="52" height="37" viewBox="0 0 52 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1.92188" y="1.9209" width="47.5076" height="32.6615" stroke="black" stroke-width="3.84253" stroke-linejoin="round"/>
                        <circle cx="39.0378" cy="12.3132" r="4.45384" fill="black"/>
                        <path d="M25.6757 15.2822L49.4295 34.5822H1.92188L25.6757 15.2822Z" fill="black"/>
                    </svg>
                </div>

            <?php endif; ?>

        </div>
    </section>

    <section class="plans-section">
        <div class="container">
            <div class="plans-wrap">
                <div class="content-area">
                    <ul class="breadcrumbs">
                        <li class="crumb-item">
                            <a href="#">Display Homes</a>
                        </li>

                        <li class="crumb-item">
                            <?php echo $title?>
                        </li>
                    </ul>

                    <h1 class="title-section"><?php echo $title?></h1>

                    <h4 class="subtitle-section">
                        <?php
                        if ( array_key_exists( $manufacturer, $manuf_list ) ) {
                            echo $manuf_list[$manufacturer];
                        }

                        if ( array_key_exists( $series, $series_list ) ) {
                            echo " | " . $series_list[$series];
                        }
                        ?>
                    </h4>

                    <!-- video -->
                    <?php
                    if ( ! empty( $youtube_embed ) ) :
                        ?>
                        <div class="video-wrap">
                            <?php echo $youtube_embed; ?>
                        </div>
                        <?php
                    endif;

                    if ( ! empty( $plan_tour ) ) :
                        ?>
                        <div class="video-wrap">
                            <iframe width="1034" height="582" 
                                src="<?php echo esc_url( $plan_tour ); ?>" 
                                title="Virtual tour" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen>
                            </iframe>
                        </div>
                        <?php
                    elseif ( ! empty( $matterport_embed ) ) :
                        ?>
                        <div class="video-wrap">
                            <?php echo $matterport_embed; ?>
                        </div>
                        <?php
                    endif;

                    if ( ! empty( $description ) ) :
                        echo '<div class="prose">' . wpautop( $description ) . '</div>';
                    endif;

                    if ( ! empty( $content ) ) :
                        echo '<div class="prose">' . $content . '</div>';
                    endif;
                    ?>
                </div>

                <div class="sidebar-area">
                    <div class="price-wrap">
                        <p class="price-subtitle">Base Price:</p>

                        <div class="price-row">
                            <h4 class="price-title">
                                $<?php echo $base_price_format?>
                            </h4>

                            <?php
                            if ( ! empty( $location ) ) :
                            ?>
                            <div class="label danger">
                                <span class="label-top">On Display</span>

                                <span><?php echo $location?></span>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div class="model-price-wrap">
                            <p class="model-price">
                                Model Price: <?php echo $complect_price_format; ?>
                            </p>
                            <p class="model-desc">
                                <?php echo $price_short_desc; ?>
                            </p>
                        </div>
                    </div>

                    <div class="plan-items">
                        <?php
                        if ( ! empty( $size ) ) :
                            ?>
                            <div class="plan-item">
                                <?php
                                include( get_template_directory() . '/assets/img/icons/size-svg.html' );
                                ?>

                                <p>
                                    <?php echo number_format( $size, 0, ',', ',' )?> ft<sup>2</sup>
                                </p>
                            </div>
                            <?php
                        endif;

                        if ( ! empty( $beds ) ) :
                            ?>
                            <div class="plan-item">
                                <?php
                                include( get_template_directory() . '/assets/img/icons/beds-svg.html' );
                                ?>

                                <p><?php echo $beds?> Beds</p>
                            </div>
                            <?php
                        endif;

                        if ( ! empty( $baths ) ) :
                            ?>
                            <div class="plan-item">
                                <?php
                                include( get_template_directory() . '/assets/img/icons/baths-svg.html' );
                                ?>

                                <p><?php echo $baths?> Baths</p>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>

                    <div class="plan-download">
                        <?php
                        if ( ! empty( $view_plan_doc ) ) :
                            $view_doc_src = wp_get_attachment_url( $view_plan_doc );
                            ?>
                            <a href="<?php echo esc_url( $view_doc_src )?>" target="_blank">
                                <?php
                                    include( get_template_directory() . '/assets/img/icons/pdf-svg.html' );
                                ?>

                                Floor Plan
                            </a>
                            <?php
                        endif;

                        if ( ! empty( $standart_features ) ) :
                            $standart_features_src = wp_get_attachment_url( $standart_features );
                            ?>
                            <a href="<?php echo esc_url( $standart_features_src )?>" target="_blank">
                                <?php
                                    include( get_template_directory() . '/assets/img/icons/pdf-svg.html' );
                                ?>

                                Standart Features
                            </a>
                            <?php
                        endif;

                        if ( ! empty( $list_options_doc ) ) :
                            $list_options_doc_src = wp_get_attachment_url( $list_options_doc );

                            ?>
                            <a href="<?php echo esc_url( $list_options_doc_src )?>" target="_blank">
                                <?php
                                    include( get_template_directory() . '/assets/img/icons/pdf-svg.html' );
                                ?>

                                List Of Options
                            </a>
                            <?php
                        endif;

                        // misc
                        if ( ! empty( $misc_doc ) ) :
                            $misc_doc_src = wp_get_attachment_url( $misc_doc );
                            ?>
                            <a href="<?php echo esc_url( $misc_doc_src )?>" target="_blank">
                                <?php
                                    include( get_template_directory() . '/assets/img/icons/pdf-svg.html' );
                                ?>

                                Misc
                            </a>
                            <?php
                        endif;

                        ?>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?php
get_template_part( 'template-parts/modules/section', 'contact' );

get_template_part( 'template-parts/modules/section', 'similars', ['id' => $p_ID ] );
get_footer();
