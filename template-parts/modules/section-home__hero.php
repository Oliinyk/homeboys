<?php
$filter_exclude_fields = $args['filter_exclude_fields'] ?? [];
$hero_slider           = $args['home_hero_slider'];
$include_filter        = $args["include_filter"];
?>
<section class="hero-section">
    <!-- Swiper -->
    <div class="swiper hero-slider mySwiper">
        <div class="swiper-wrapper">
            <?php
            foreach( $hero_slider as $item ) :
                $img_id     = $item['slide'];
                $alt_text   = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
                $img_url    = wp_get_attachment_image_url( $img_id, 'full' );
            ?>
            <div class="swiper-slide">
                <img src="<?php echo esc_url( $img_url )?>" alt="<?php echo esc_attr( $alt_text )?>">
            </div>
            <?php
            endforeach;
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <?php
    if ( $include_filter ) :
        ?>
        <div class="filter-wrap">
            <h1 class="title-section">
                <?php echo __( $args["hero_filter_title"], 'home-boys-2' )?>
            </h1>
            <?php
            get_template_part( 'template-parts/modules/_filter', null, [ 'exclude_fields' => $filter_exclude_fields ] );
            ?>
        </div>
        <?php
    endif;
    ?>
</section>