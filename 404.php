<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#404-not-found
 *
 * @package Home_Boys_2
 */

get_header();
?>

<section class="error-section">
    <div class="container">
        <p class="error-oops"><?php esc_html_e( 'Oops!', 'home-boys-2' ); ?></p>
        <h1 class="error-title"><?php esc_html_e( "That page can't be found.", 'home-boys-2' ); ?></h1>
        <p class="error-desc"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'home-boys-2' ); ?></p>
    </div>
</section>

<?php
get_template_part( 'template-parts/modules/section-find_home', null );
get_footer();
