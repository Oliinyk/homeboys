<?php
/**
 * Template name: Blog Template
 */

$p_id         = get_the_ID();
$id_param     = ['id' => $p_id];
$content      = get_the_content();
$per_page     = isset( $_GET['per_page'] ) ? intval( $_GET['per_page'] ) : get_option( 'posts_per_page' );
$query_params = [
    'post_type'      => 'blogposts',
    'posts_per_page' => $per_page,
    'orderby'        => 'date',
    'order'          => 'DESC',
];

$blog_posts = new WP_Query( $query_params );

$find_home__params = [
    'classes' => 'dark-section',
    'filter'  => false,
];

get_header();

// Overlay
get_template_part( 'template-parts/modules/nav_overlay', null );

// Hero section
get_template_part( 'template-parts/modules/section', 'hero', $id_param );
?>
<section class="blog-section">
    <div class="container">
        <ul class="breadcrumbs">
            <li class="crumb-item">
                <a href="#">About us</a>
            </li>

            <li class="crumb-item">
                <span>
                    <?php the_title()?>
                </span>
            </li>
        </ul>

        <h1 class="title-section">
            <?php the_title()?>
        </h1>

        <?php
        if ( $blog_posts->have_posts() ) :
            ?>
            <div class="card-list sm-col-3">
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
                    $thumbnail = wp_get_attachment_image_url( $th_id, 'large' );
                }

                include get_template_directory() . "/template-parts/modules/__blog-item-preview.php";
            endwhile;
            
            wp_reset_postdata();
            ?>
            </div>
            <?php

            get_template_part( 'template-parts/modules/__show-all-button', null );
        endif;
        ?>
    </div>
</section>
<?php
// Video review section
get_template_part( 'template-parts/modules/section', 'our_people' );

// Find Home section
get_template_part( 'template-parts/modules/section', 'find_home', $find_home__params );

get_footer();