<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Home_Boys_2
 */
$id = get_the_ID();

$custom_title = carbon_get_post_meta( $$id, 'post_title' );
$title        = ! empty( $custom_title ) ? $custom_title : get_the_title();
$content      = get_the_content();

get_header();

// Overlay
get_template_part( 'template-parts/modules/nav_overlay', null );
?>
<section class="content-section">
    <div class="container">
        <h1 class="title-section">
            <?php $title ?>
        </h1>

        <?php
        if ( ! empty( $content ) ) :
            ?>
            <div class="content-wrap">
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

