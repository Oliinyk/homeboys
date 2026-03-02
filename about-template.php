<?php
/**
 * Template name: About Us Template
 */
$small_title     = carbon_get_theme_option( 'about_page_small_title' );
$title           = carbon_get_theme_option( 'about_page_title' );
$p_title         = ! empty( $title ) ? $title : get_the_title();
$content         = carbon_get_theme_option( 'about_page_content' );

$team_block_small_tile = carbon_get_theme_option( 'about_page_team_small_title' );
$team_block_title      = carbon_get_theme_option( 'about_page_team_title' );

$hero_data = [
    'sb_hero_image'        => carbon_get_theme_option( 'about_page_hero' ),
    'sb_hero_image_height' => carbon_get_theme_option( 'about_page_hero_image_height' ),
];

$blog__params = [
    'classes' => ' dark-section',
];

get_header();

// Overlay
get_template_part( 'template-parts/modules/nav_overlay', null );

// Hero section
get_template_part( "template-parts/modules/section", "single_banner__hero", $hero_data );
?>

<section class="team-section">
    <div class="container">
        <div class="content-section">
            <div class="container">
                <ul class="breadcrumbs">
                    <li class="crumb-item">
                        <a href="#">ABOUT US</a>
                    </li>

                    <li class="crumb-item">
                        <span>
                            <?php echo esc_html( get_the_title() ); ?>
                        </span>
                    </li>
                </ul>
                <div class="content-wrap">
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
                        <p class="has-text-align-center"></p>
                            <?php
                            echo $content;
                            ?>
                        </p>
                        <?php
                    endif
                    ?>
                </div>
            </div>
        </div>

        <?php
        get_template_part( 'template-parts/modules/_employees', [
            'small_title' => $team_block_small_tile,
            'title'       => $team_block_title,
        ] );
        ?>
    </div>
</section>

<?php
// Video review section
get_template_part( 'template-parts/modules/section', 'our_people' );

// Find Home section
get_template_part( 'template-parts/modules/section', 'blog', $blog__params );

get_footer();