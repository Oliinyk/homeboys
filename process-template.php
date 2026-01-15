<?php
/**
 * Template name: Process Template
 */
$p_ID = get_the_ID();

$inlude_processes = carbon_get_post_meta( $p_ID, 'include_process_posts' );

$processes_section_title = carbon_get_post_meta( $p_ID, 'process_block_title' );
$processes_section_desc  = carbon_get_post_meta( $p_ID, 'process_block_desc' );
$processes_section_args  = [
    'title'       => $processes_section_title,
    'description' => $processes_section_desc,
];

$small_title = carbon_get_post_meta( $p_ID, 'page_small_title' );
$title       = carbon_get_post_meta( $p_ID, 'page_title' );
$p_title     = ! empty( $title ) ? $title : get_the_title();

$content = get_the_content();

$parners_include = carbon_get_post_meta( $p_ID, 'include_partners' );

get_header();

// Finansing dark section
if ( ! empty( $inlude_processes ) ) :
    get_template_part( 'template-parts/modules/section', 'processes_posts', $processes_section_args );
endif;    

// Content
if ( ! empty( $content ) ) :
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
            <h2 class="title-section">
                <?php echo $p_title?>
            </h2>
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
endif;

// Text-banner section
get_template_part( 'template-parts/modules/section', 'text_banner', [ 'id' => $p_ID ] );

// Partners section
if ( ! empty( $parners_include ) ) :
    get_template_part( 'template-parts/modules/section', 'partner' );
endif;    

// Contact form
get_template_part( 'template-parts/modules/section', 'contact' );

// Find home section
get_template_part( 'template-parts/modules/section', 'find_home' );

get_footer();