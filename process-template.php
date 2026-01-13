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

$content = get_the_content();

get_header();
?>
    <!-- Finansing dark section -->
    <?php
    if ( ! empty( $inlude_processes ) ) :
        get_template_part( 'template-parts/modules/section', 'processes_posts', $processes_section_args );
    endif;    
    ?>
    <!-- Finansing dark section end -->

    <!-- Content -->
    <?php
    if ( ! empty( $content ) ) :
        ?>
        <section>
            <div class="container">
                <div class="content-wrap">
                    <?php echo $content ?>
                </div>
            </div>
        </section>
        <?php
    endif;
    ?>
    <!-- Content end -->

    <?php
        get_template_part( 'template-parts/modules/section', 'contact' );
        get_template_part( 'template-parts/modules/section', 'find_home' );
    ?>
<?php
get_footer();