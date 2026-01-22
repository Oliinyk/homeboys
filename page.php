<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Home_Boys_2
 */
$content = get_the_content();

get_header();

// Overlay
get_template_part( 'template-parts/modules/nav_overlay', null );
?>
<section class="content-section">
    <div class="container">
        <h1 class="title-section">
            <?php the_title()?>
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
get_template_part( 'template-parts/modules/section', 'contact' );

// Find Home section
get_template_part( 'template-parts/modules/section', 'find_home' );

get_footer();
