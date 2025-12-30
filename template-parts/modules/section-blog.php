<?php
// $id = $args['id'];
$section_small_title = carbon_get_theme_option( 'blog_section__subtitle' );
$section_title       = carbon_get_theme_option( 'blog_section_title' );
$blog_posts_query_args = [
    'post_type'   => 'post',
    'post_status' => 'publish',
    'orderby'     => 'date',
    'order'       => 'DESC',
];

$blog_posts = new WP_Query( $blog_posts_query_args );

if ( ! $blog_posts->have_posts() ) {
    return;
}
?>
<section class="blog-section">
    <div class="container">
        <h4 class="subtitle-section">
            <?php echo esc_html( $section_small_title ); ?>
        </h4>
        <h2 class="title-section">
            <?php echo esc_html( $section_title ); ?>
        </h2>
        <div class="slider-wrap">
            <!-- Swiper -->
            <div class="swiper-outer">
                <div class="swiper mySwiper3">
                    <div class="swiper-wrapper">
                        <?php
                        while ( $blog_posts->have_posts() ) :
                            $blog_posts->the_post();

                            $blog_post_id = get_the_ID();
                            $title        = get_the_title( $blog_post_id );
                            $thumbnail    = get_the_post_thumbnail_url();
                            $date         = get_the_date();  
                        ?>
                        <div class="swiper-slide">
                            <img src="<?php echo esc_url( $thumbnail )?>" alt="<?php echo esc_attr( $title )?>">

                            <div class="item-description">
                                <h4 class="item-title">
                                    <?php echo $title?>
                                </h4>

                                <p><?php echo $date?></p>
                            </div>
                        </div>
                        <?php
                        endwhile;
                        ?>
                    </div>
                </div>
                <div class="swiper-blog-button-prev custom-prev">
                    <svg class="arrow-ico" width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.8047 23.125L7.92969 14.7656L25.2031 14.7656L25.2031 8.55469L7.83203 8.55469L11.8047 0L5.76953 0L0 11.5625L5.76953 23.125H11.8047Z" />
                    </svg>
                </div>
                <div class="swiper-blog-button-next custom-next">
                    <svg class="arrow-ico" width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.3984 23.125L17.2734 14.7656L0 14.7656L0 8.55469L17.3711 8.55469L13.3984 0L19.4336 0L25.2031 11.5625L19.4336 23.125H13.3984Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
wp_reset_postdata();