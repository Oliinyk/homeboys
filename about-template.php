<?php
/**
 * Template name: About Us Template
 */
$p_id = get_the_ID();

$small_title = carbon_get_post_meta( $p_id, 'page_small_title' );
$title       = carbon_get_post_meta( $p_id, 'page_title' );
$p_title     = ! empty( $title ) ? $title : get_the_title();
$content     = get_the_content();

$blog__params = [
    'classes' => ' dark-section',
];

get_header();

// Overlay
get_template_part( 'template-parts/modules/nav_overlay', null );

// Hero section
get_template_part( 'template-parts/modules/section', 'hero', ['id' => $p_id] );
?>

<section class="content-section">
    <div class="container">
        <?php
        if ( ! empty( $small_title ) ) :
            ?>
            <h4 class="subtitle-section">
                <?php echo $small_title?>
            </h4>
            <?php
        endif;
        ?>

        <h1 class="title-section">
            <?php echo $p_title?>
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

        <?php
        get_template_part( 'template-parts/modules/_employees', null );
        ?>
    </div>
</section>

<?php
// Video review section
get_template_part( 'template-parts/modules/section', 'our_people' );

// Find Home section
get_template_part( 'template-parts/modules/section', 'blog', $blog__params );

get_footer();