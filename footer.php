<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Home_Boys_2
 */

$locations          = apply_filters( 'hb2_locations_list', false );
$footer_logo        = carbon_get_theme_option( 'footer_site_logo' );
$mail_contact       = carbon_get_theme_option( 'footer_mail_contact' );
$mail_block_title   = carbon_get_theme_option( 'footer_mail_block_title' );
$newtworks          = carbon_get_theme_option( 'social_networks' );
$networks_title     = carbon_get_theme_option( 'footer_networks_title' );
$form_title         = carbon_get_theme_option( 'footer_form_title' );
$form_shortcode     = carbon_get_theme_option( 'footer_form_shortcode' );
$description        = carbon_get_theme_option( 'footer_description_text' );
$menu_items         = apply_filters( 'hb2_get_menu_items', 'menu-1' );
$documents          = carbon_get_theme_option( 'footer_documents' );
?>
	<footer class="footer">
        <div class="container">

            <div class="footer-wrap">
                <?php
                if ( ! empty( $footer_logo ) ) :
                    ?>
                    <div class="footer-col footer-logo">
                        <img src="<?php echo $footer_logo?>" alt="Home Boys logo">
                    </div>
                    <?php
                endif;
                ?>
                <div class="footer-col col-2 col-span-3 md-col-3">
                    <?php
                    if ( ! empty( $menu_items ) ) :
                        ?>
                        <ul class="footer-nav footer-col">
                            <?php
                            foreach ( $menu_items as $item ) :
                                if ( ! empty( $item['children'] ) ) :
                                ?>
                                <li class="<?php echo $item['classes']?>">
                                    <button class="f-nav-link">
                                        <?php echo $item['title']?>
                                    </button>

                                    <ul class="f-dropdown">
                                        <?php
                                        foreach ( $item['children'] as $sub ) :
                                            ?>
                                            <li>
                                                <a href="<?php echo $sub['url']?>">
                                                    <?php echo $sub['title']?>
                                                </a>
                                            </li>
                                            <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                </li>
                                <?php
                            else:
                            ?>
                            <li>
                                <a href="<?php echo $item['url']?>" class="f-nav-link">
                                    <?php echo $item['title']?>
                                </a>
                            </li>
                            <?php
                            endif;
                            endforeach;
                            ?>
                        </ul>
                        <?php
                    endif;
                    ?>
                    <div class="footer-main footer-col col-3 col-span-3 sm-col-2 sm-col-span-2">
                        <div class="footer-row sm-col-2 col-span-3">
                            <?php
                            if ( ! empty( $mail_contact ) ) :
                                ?>
                                <div class="footer-col">
                                    <?php
                                    if ( ! empty( $mail_block_title ) ) :
                                        ?>
                                        <h4 class="title-col"><?php echo $mail_block_title?></h4>
                                        <?php
                                    endif;
                                    ?>
                                    <a href="mailto:<?php echo $mail_contact?>?subject=From website" class="primary">
                                        <?php echo $mail_contact?>
                                    </a>
                                </div>
                                <?php
                            endif;
                            
                            if ( ! empty( $newtworks ) ) :
                                ?>
                                <div class="footer-col">
                                    <h4 class="title-col">
                                        <?php
                                        echo esc_html( $networks_title );
                                        ?>
                                    </h4>
                                    <ul class="footer-social">
                                        <?php
                                        foreach ( $newtworks as $network ) :
                                            ?>
                                            <li>
                                                <a href="<?php echo esc_url( $network['network_url'] ); ?>" target="_blank" rel="noopener noreferrer">
                                                    <img src="<?php echo esc_url( $network['network_icon'] ); ?>" alt="<?php echo esc_attr( $network['network_name'] ); ?>">
                                                </a>
                                            </li>
                                            <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                    
                        <?php
                        if ( ! empty( $locations ) ) :
                            ?>
                            <div class="location-wrap footer-row col-span-3 sm-col-3">
                                <?php
                                foreach ( $locations as $loc ) :
                                    $location_link_href = $loc['location_link_href'];
                                    ?>
                                    <div class="address-item">
                                        <h5 class="title-address">
                                            <svg width="17" height="26" viewBox="0 0 17 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.34334 20.4173C5.3536 20.4278 5.35873 20.4383 5.36387 20.4487L8.49969 26L15.8491 13C17.3836 10.2847 17.3836 7.04516 15.8491 4.33512C14.3145 1.61978 11.5689 0 8.49969 0C5.43573 0 2.68488 1.61975 1.15029 4.33512C-0.3843 7.0505 -0.384267 10.29 1.15542 13L5.34334 20.4173ZM8.49969 3.5069C11.2814 3.5069 13.5551 5.82382 13.5551 8.67033C13.5551 11.5168 11.2866 13.8338 8.49969 13.8338C5.71273 13.8338 3.44429 11.5221 3.44429 8.67033C3.44429 5.82395 5.71789 3.5069 8.49969 3.5069Z" fill="#D43031"/>
                                            </svg>
                                            <span class="location-name">
                                                <?php
                                                echo $loc['location_name'];
                                                ?>
                                            </span>
                                        </h5>
                                        <div class="info-address">
                                            <?php
                                            if ( ! empty( $loc['location_phone'] ) ) :
                                                ?>
                                                <a href="tel:<?php echo esc_attr( $loc['location_phone'] ); ?>" class="primary">
                                                    <?php echo esc_html( $loc['location_phone'] ); ?>
                                                </a>
                                                <?php
                                            endif;

                                            if ( ! empty( $loc['location_address'] ) ) :
                                                
                                                $before = ! empty( $location_link_href ) ? "<a href='{$location_link_href}' target='_blank'>" : "<p>";
                                                $after  = ! empty( $location_link_href ) ? "</a>" : "</p>";

                                                echo $before;
                                                    echo esc_html( $loc['location_address'] );
                                                echo $after;

                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                endforeach;
                                ?>
                            </div>
                            <?php
                        endif;

                        if ( ! empty( $form_shortcode ) ) :
                            ?>
                            <div class="contact-section footer-row col-span-3 sm-col-3">
                                <?php
                                if ( ! empty( $form_title ) ) :
                                ?>
                                <h4 class="title-col">
                                    <?php echo $form_title;?>
                                </h4>
                                <?php
                                endif;
                                ?>
                                <div class="sm-col-span-2">
                                    <?php echo do_shortcode( $form_shortcode )?>
                                </div>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>
                </div>

                <!-- 2 -->
                <?php
                if ( ! empty( $documents ) ) :
                    ?>
                    <div class="footer-col privacy-col text-center col-span-3 sm-col-span-1 sm-text-left">
                        <ul>
                            <?php
                            foreach ( $documents as $item ) :
                                ?>
                                <li>
                                    <a href="<?php echo $item['document_file']?>" target="_blank">
                                        <?php echo $item['document_label']?>
                                    </a>
                                </li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                        <p class="copyright">Copyright © <?php echo date('Y'); ?> by HomeBoys</p>
                    </div>
                    <?php
                endif;

                if ( ! empty( $description ) ) :
                    ?>
                    <div class="footer-col privacy-col col-span-3 sm-col-span-2 md-col-span-3">
                        <p>
                            <?php echo esc_html( $description ); ?>
                        </p>
                    </div>
                    <?php
                endif;
                ?>
            </div>

        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
