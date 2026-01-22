<?php
$current = get_the_ID();

$section_small_title   = carbon_get_theme_option( 'blog_section__subtitle' );
$section_title         = carbon_get_theme_option( 'blog_section_title' );
$classes               = isset( $args['classes'] ) ? $args['classes'] : '';

$blog_posts_query_args = [
    'post_type'    => 'blogposts',
    'post_status'  => 'publish',
    'orderby'      => 'date',
    'order'        => 'DESC',
    'post__not_in' => [$current],
];

$blog_posts = new WP_Query( $blog_posts_query_args );

if ( ! $blog_posts->have_posts() ) {
    return;
}
?>
<section class="blog-section<?php echo $classes?>">
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
                <div class="swiper blog-slider">
                    <div class="swiper-wrapper">
                        <?php
                        while ( $blog_posts->have_posts() ) :
                            $blog_posts->the_post();

                            $blog_post_id = get_the_ID();
                            $custom_title = carbon_get_post_meta( $blog_post_id, 'post_title' );
                            $title        = ! empty( $custom_title ) ? $custom_title : get_the_title( $blog_post_id );
                            $gallery      = carbon_get_post_meta( $blog_post_id, 'post_photo' );
                            $date         = get_the_date(); 
                            $permalink    = get_the_permalink();
                            $thumbnail = get_the_post_thumbnail_url();

                            if ( ! empty( $gallery ) ) {
                                $th_id = $gallery[0];
                                $thumbnail = wp_get_attachment_image_url( $th_id, 'medium' );
                            }
                        ?>
                        <div class="swiper-slide">
                            <?php
                            include get_template_directory() . "/template-parts/modules/__blog-item-preview.php";
                            ?>
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