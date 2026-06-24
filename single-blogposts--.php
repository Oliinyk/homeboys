<?php
$id = get_the_ID();

$custom_title = carbon_get_post_meta( $id, 'post_title' );
$title        = ! empty( $custom_title ) ? $custom_title : get_the_title();
$content      = get_the_content();

get_header();

// Overlay
get_template_part( 'template-parts/modules/nav_overlay', null );
?>
<section class="content-section">
    <div class="container">

        <ul class="breadcrumbs">
            <li class="crumb-item">
                <a href="#">Display Homes</a>
            </li>

            <li class="crumb-item">
                <span>
                    <?php the_title()?>
                </span>
            </li>
        </ul>

        <h1 class="title-section">
            <?php echo $title ?>
        </h1>

        <p class="date-wrap">
            <?php echo get_the_date(); ?>
        </p>

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

