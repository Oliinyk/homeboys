<?php
/**
 * Template name: Finansing Template
 */
$p_ID = get_the_ID();

$processes_section_title = carbon_get_theme_option( 'financing_posts_block_title' );
$processes_section_desc  = carbon_get_theme_option( 'financing_posts_block_desc' );
$processes_section_args  = [
    'title'       => $processes_section_title,
    'description' => $processes_section_desc,
];

$small_title = carbon_get_theme_option( 'financing_page_small_title' );
$title       = carbon_get_theme_option( 'financing_page_title' );
$p_title     = ! empty( $title ) ? $title : get_the_title();

$content = carbon_get_theme_option( 'financing_page_content' );

get_header();

get_template_part( 'template-parts/modules/section', 'processes_posts', $processes_section_args );

// Content
if ( ! empty( $content ) ) :
    ?>
    <section class="content-section">
        <div class="container">
            <ul class="breadcrumbs">
                <li class="crumb-item">
                    <a href="#">PROCESS</a>
                </li>

                <li class="crumb-item">
                    <span>
                        <?php echo esc_html( get_the_title() ); ?>
                    </span>
                </li>
            </ul>
            
            <?php
            if ( ! empty( $small_title ) ) :
            ?>
            <h4 class="subtitle-section">
                <?php echo $small_title?>
            </h4>
            <?php
            endif;
            ?>
            <h2 class="title-section">
                <?php echo $p_title?>
            </h2>
            <?php
            if ( ! empty( $content ) ) :
            ?>
            <div class="content-wrap">
                <?php echo apply_filters( 'the_content', $content ) ?>
            </div>
            <?php
            endif
            ?>
        </div>
    </section>
    <?php
endif;

// Contact form
get_template_part( 'template-parts/modules/section', 'contact' );

// Find home section
get_template_part( 'template-parts/modules/section', 'find_home' );

get_footer();