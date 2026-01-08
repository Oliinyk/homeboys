<?php
get_header();

$p_ID               = get_the_ID();
$thumbnail          = get_the_post_thumbnail_url();
$title              = get_the_title();
$photos             = carbon_get_post_meta( $p_ID, 'plan_photos' );
$manufacturer       = carbon_get_post_meta( $p_ID, 'plan_manufacturer' );
$series             = carbon_get_post_meta( $p_ID, 'plan_series' );
$youtube_embed      = carbon_get_post_meta( $p_ID, 'youtube_embed' );
$plan_tour          = carbon_get_post_meta( $p_ID, 'plan_tour' );
$base_price         = carbon_get_post_meta( $p_ID, 'plan_price' );
$location           = carbon_get_post_meta( $p_ID, 'plan_location' );
$size               = carbon_get_post_meta( $p_ID, 'plan_size' );
$beds               = carbon_get_post_meta( $p_ID, 'plan_beds' );
$baths              = carbon_get_post_meta( $p_ID, 'plan_baths' );
$view_plan_doc      = carbon_get_post_meta( $p_ID, 'plan_brochure' );
$standart_features  = carbon_get_post_meta( $p_ID, 'plan_brochure2' );
$list_options_doc   = carbon_get_post_meta( $p_ID, 'plan_brochure3' );
$content            = get_the_content();

$uns_photos    = [];
$gallery       = [];
$on_display    = apply_filters( 'hb2_on_display_arr', [] );

$manuf_list  = apply_filters( 'hb2_get_manufacturers_list', [] );
$series_list = apply_filters( 'hb2_get_series_list', [] );

if ( ! $thumbnail ) {
    $thumbnail = apply_filters( 'hb2_get_random_image', false );
}

array_push( $gallery, $thumbnail );

if ( ! empty( $photos ) ) {
    if ( is_array( $photos ) ) {
        foreach ( $photos as $item_f ) {
            if ( ! is_array( $item_f ) ) {
                $anf = unserialize( $item_f );
                if ( ! is_array( $anf ) ) {
                    $ans = unserialize( $anf );
                    $url = wp_get_attachment_image_url( $ans );

                    if ( $url ) {
                        array_push( $gallery, $url );
                    } else {
                        array_push( $gallery, apply_filters( 'hb2_get_random_image', true ) );
                    }
                }
            }
        }
    }
}

?>
<div class="nav-overlay" id="navOverlay"></div>

<?php
if ( ! empty( $gallery ) ) :
    ?>
    <section class="gallery-thumbs-section">
        <div class="container">

            <!-- Thumbs gallery slider -->
            <div class="gallery-thumbs-slider">
                <!-- Main slider -->
                <div class="gallery-main swiper">
                    <div class="swiper-wrapper">
                        <?php
                        foreach( $gallery as $key => $item ) :
                            ?>
                            <div class="swiper-slide">
                                <a href="<?php echo esc_url( $item ); ?>" class="js-fancybox-item" data-index="<?php echo $key; ?>">
                                    <img src="<?php echo esc_url( $item )?>" alt="Photo <?php echo $key?>">
                                </a>
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
                                ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo esc_url( $item )?>" alt="Thumb <?php echo $key?>">
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
        </div>
    </section>
    <?php
endif;
?>

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
                        <?php echo $youtube_embed?>
                    </div>
                    <?php
                endif;

                if ( ! empty( $plan_tour ) ) :
                ?>
                <div class="video-wrap">
                    <iframe width="1034" height="582" 
                        src="<?php echo esc_url( $plan_tour )?>" 
                        title="YouTube video player" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen>
                    </iframe>
                </div>
                <?php
                endif;
            

                if ( ! empty( $content ) ) :
                    echo $content;
                endif;    
                ?>
            </div>

            <div class="sidebar-area">
                <div class="price-wrap">
                    <p class="price-subtitle">Base Price:</p>

                    <div class="price-row">
                        <h4 class="price-title">
                            $<?php echo number_format( floatval($base_price), 0, '.', ',' )?>
                        </h4>

                        <?php
                        if ( array_key_exists( $location, $on_display ) ) :
                        ?>
                        <div class="label danger">
                            <span class="label-top">On Display</span>

                            <span><?php echo $on_display[$location]?></span>
                        </div>
                        <?php
                        endif;
                        ?>
                    </div>

                    <!-- What is this data? -->
                    <p>Model Price: $223,040 Includes standard delivery & set within 100 miles</p>
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
                        <a href="<?php echo esc_url( $view_doc_src )?>" download>
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
                        <a href="<?php echo esc_url( $standart_features_src )?>" download>
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
                        <a href="<?php echo esc_url( $list_options_doc_src )?>" download>
                            <?php
                                include( get_template_directory() . '/assets/img/icons/pdf-svg.html' );
                            ?>

                            List Of Options
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
