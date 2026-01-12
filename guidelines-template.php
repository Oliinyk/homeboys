<?php
/**
 * Template name: Guidelines Template
 */
$p_ID = get_the_ID();

$guidelines_block_small_title = carbon_get_post_meta( $p_ID, 'guidelines_block_small_title' );
$guidelines_block_title       = carbon_get_post_meta( $p_ID, 'guidelines_block_title' );
$guidelines_list              = carbon_get_post_meta( $p_ID, 'guidelines_list' );

$pages_link_cards_button_txt  = carbon_get_post_meta( $p_ID, 'pages_link_cards_button_txt' );
$pages_link_cards             = carbon_get_post_meta( $p_ID, 'pages_link_cards' );

$dti_small_title = carbon_get_post_meta( $p_ID, 'dti_small_title' );
$dti_title       = carbon_get_post_meta( $p_ID, 'dti_title' );
$dti_description = carbon_get_post_meta( $p_ID, 'dti_description' );
$dti_image       = carbon_get_post_meta( $p_ID, 'dti_image' );

$content = get_the_content();

$files_for_upload = carbon_get_post_meta( $p_ID, 'files_for_upload' );

get_header();
?>
<div class="nav-overlay" id="navOverlay"></div>
<?php

    // Hero section

    // Hero section end

    // Steps section
    if ( ! empty( $guidelines_list ) ) :
        foreach ( $guidelines_list as $key => $item ) :
            $item_label = "Step {$key}";
            $item_title = $item['guide_title'];
            $item_image = $item['guide_image'];
            $item_desc  = $item['guide_description'];
        endforeach;    
    endif;
    // Steps section end

    // Pages cards section
    if ( ! empty( $pages_link_cards ) ) :
        foreach ( $pages_link_cards as $item ) :
            $small_title     = $item['plc_small_title'];
            $title           = $item['plc_title'];
            $post_to_link_id = $item['plc_post'][0]['id'];
            $post_link       = get_the_permalink( $post_to_link_id );
            $card_image      = $item['plc_image'];
        endforeach;
    endif;
    // Pages cards section end

    // Text-banner section
    // Text-banner section end

    get_template_part( 'template-parts/modules/section', 'partner' );

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

    get_template_part( 'template-parts/modules/section', 'contact' );
    get_template_part( 'template-parts/modules/section', 'find_home' );

get_footer();