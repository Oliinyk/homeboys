<?php
/**
 * Template name: Guidelines Template
 */
$p_ID = get_the_ID();

$content = get_the_content();

$files_for_upload = carbon_get_post_meta( $p_ID, 'files_for_upload' );

get_header();
?>
<div class="nav-overlay" id="navOverlay"></div>
<?php
// Hero
get_template_part( 'template-parts/modules/section', 'hero', ['id' => $p_ID ] );

// Guideline
get_template_part( 'template-parts/modules/section', 'steps', [ 'id' => $p_ID ] );

// Pages cards section
get_template_part( 'template-parts/modules/section', 'pages_link_cards', [ 'id' => $p_ID ] );

// Text-banner section
get_template_part( 'template-parts/modules/section', 'text_banner', [ 'id' => $p_ID ] );

// Partners section
get_template_part( 'template-parts/modules/section', 'partner' );
?>

<!-- START text section (Manufactured Home Loans) -->
<section class="blog-section">
    <div class="container">
        <?php
        if ( ! empty( $content ) ) :
            echo $content;
        endif;
        ?>

        <!-- PDF download -->
        <?php
        if ( ! empty( $files_for_upload ) ) :
        ?>
        <div class="plan-download">
            <?php
            foreach( $files_for_upload as $file ) :
                ?>
                <a href="<?php echo esc_url( $file['file_fu'] )?>" download="">
                    <svg width="49" height="64" viewBox="0 0 49 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M48.6597 17.5002C48.8866 18.1669 49 18.7224 49 19.1669L49 62.7689C49 63.4487 48.4515 63.9997 47.775 63.9997C46.6112 63.9996 45.7718 63.9996 45.257 63.9996L1.22525 64C0.548565 64 2.67099e-06 63.4489 1.12616e-08 62.769C9.25971e-05 61.4938 0.000138893 60.5706 0.000138893 59.9996V4.0004C0.000138893 3.42941 9.25966e-05 2.50621 3.33125e-09 1.23081C-4.9343e-05 0.551102 0.548388 4.95787e-05 1.22491 0L31.1355 0.000454049C31.816 0.000454049 32.3264 0.111563 32.6667 0.333783C33.1204 0.556003 33.5174 0.833774 33.8577 1.1671L48.1493 16.5002L48.6597 17.5002ZM32.1903 19.0002H43.0452L30.9653 6.00037V17.7694C30.9653 18.4492 31.5138 19.0002 32.1903 19.0002ZM7.35 44.6515H10.0137V40.8561H12.0375C14.7531 40.8561 16.9326 39.3379 16.9326 36.41V36.3738C16.9326 33.7893 15.1856 32 12.2969 32H7.35V44.6515ZM10.0137 38.38V34.5122H12.0721C13.404 34.5122 14.2342 35.181 14.2342 36.428V36.4642C14.2342 37.5486 13.4558 38.38 12.124 38.38H10.0137ZM18.9044 44.6515H23.6265C27.4318 44.6515 30.061 41.8863 30.061 38.3258V38.2896C30.061 34.7291 27.4318 32 23.6265 32H18.9044V44.6515ZM23.6265 34.5122C25.8059 34.5122 27.2762 36.0846 27.2762 38.3258V38.3619C27.2762 40.6031 25.8059 42.1393 23.6265 42.1393H21.5682V34.5122H23.6265ZM32.4307 44.6515H35.0944V39.7536H40.8716V37.2233H35.0944V34.5303H41.65V32H32.4307V44.6515Z" fill="#D43031"></path>
                    </svg>
                    <?php echo $file['file_fu_title'] ?>
                </a>
                <?php
            endforeach;
            ?>
        </div>
        <?php
        endif;
        ?>
    </div>
</section>
<!-- END text section -->

<?php
// Contact form
get_template_part( 'template-parts/modules/section', 'contact' );

// Find home section
get_template_part( 'template-parts/modules/section', 'find_home' );

get_footer();