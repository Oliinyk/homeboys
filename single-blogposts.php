<?php
$id = get_the_ID();

$custom_title = carbon_get_post_meta( $id, 'post_title' );
$title        = ! empty( $custom_title ) ? $custom_title : get_the_title();
$post_gallery = carbon_get_post_meta( $id, 'post_photo' );
$content      = get_the_content();

$post_th_id   = false;
if ( ! empty( $post_gallery ) && is_array( $post_gallery ) ) {
    $post_th_id = $post_gallery[0];
}

get_header();

// Overlay
get_template_part( 'template-parts/modules/nav_overlay', null );
?>
<section class="content-section">
    <div class="container">
        <h1 class="title-section">
            <?php echo $title ?>
        </h1>

        <?php
        if ( ! empty( $content ) ) :
            ?>
            <div class="content-wrap">
                <?php
                if ( $post_th_id ) :
                    $thumb = wp_get_attachment_image_url( $post_th_id, 'full' );
                ?>
                <div class="post-thumb">
                    <img src="<?php echo esc_url( $thumb ) ?>" alt="<?php echo esc_attr( $title ) ?>">
                </div>
                <?php
                endif;
                ?>
                <?php echo $content ?>
            </div>
            <?php
        endif
        ?>
    </div>
</section>
<?php
// Contact section
get_template_part( 'template-parts/modules/section', 'blog' );

get_footer();

