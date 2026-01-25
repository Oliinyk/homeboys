<?php
/**
 * Template name: Contact Template
 */

$id = get_the_ID();

$mail_contact   = carbon_get_theme_option( 'footer_mail_contact' );
$shedules       = carbon_get_post_meta( $id, 'shedule_strings' );
$small_title    = carbon_get_post_meta( $id, 'page_small_title' );
$page_title     = carbon_get_post_meta( $id, 'page_title' );
$locations      = apply_filters( 'hb2_locations_list', false );
$title          = ! empty( $page_title ) ? $page_title : get_the_title();

get_header();
?>
<section class="content-section">
    <div class="container">
        <?php
        if ( ! empty( $mail_contact ) ) :
            ?>
            <div class="contact-mail">
                <a href="mailto:<?php echo $mail_contact?>" class="primary">
                    <?php echo $mail_contact?>
                </a>
            </div>
            <?php
        endif;

        if ( ! empty( $shedules ) ) :
            ?>
            <div class="your-shedule">
                <?php
                foreach( $shedules as $item ) :
                ?>
                <p>
                    <?php echo $item['shedule_item']; ?>
                </p>
                <?php
                endforeach;
                ?>
            </div>
            <?php
        endif;
        ?>
    </div>
</section>

<section class="content-section contact-section-main">
    <div class="container">
        <?php
        if ( ! empty( $small_title ) ) :
            ?>
            <h4 class="subtitle-section">
                <?php echo $small_title;?>
            </h4>
            <?php
        endif;
        ?>
        <h1 class="title-section">
            <?php echo $title;?>
        </h1>

        <?php
        if ( ! empty( $locations ) ) :
        ?>
        <div class="map-fraims-wrap location-wrap grid md-col-3">
            <?php
            foreach( $locations as $loc ) :
                ?>
                <div class="address-item">
                    <h5 class="title-address">
                        <svg width="17" height="26" viewBox="0 0 17 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.34334 20.4173C5.3536 20.4278 5.35873 20.4383 5.36387 20.4487L8.49969 26L15.8491 13C17.3836 10.2847 17.3836 7.04516 15.8491 4.33512C14.3145 1.61978 11.5689 0 8.49969 0C5.43573 0 2.68488 1.61975 1.15029 4.33512C-0.3843 7.0505 -0.384267 10.29 1.15542 13L5.34334 20.4173ZM8.49969 3.5069C11.2814 3.5069 13.5551 5.82382 13.5551 8.67033C13.5551 11.5168 11.2866 13.8338 8.49969 13.8338C5.71273 13.8338 3.44429 11.5221 3.44429 8.67033C3.44429 5.82395 5.71789 3.5069 8.49969 3.5069Z" fill="#D43031"/>
                        </svg>
                        <?php
                        echo $loc['location_name'];
                        ?>
                    </h5>

                    <div class="map-address">
                        <?php
                        if ( ! empty( $loc['location_map'] ) ) :
                            echo $loc['location_map'];
                        endif;
                        ?>
                    </div>

                    <div class="footer-address">
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
        ?>
    </div>
</section>
<?php
get_template_part( 'template-parts/modules/section', 'contact' );

get_footer();