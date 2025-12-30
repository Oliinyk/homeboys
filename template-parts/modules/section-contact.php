<?php
$id = isset( $args['id'] ) ? $args['id'] : NULL;

$form_enabled   = ! is_null( $id ) ? carbon_get_post_meta( $id, 'form_enabled' ) : true;
$form_title     = ! is_null( $id ) ? carbon_get_post_meta( $id, 'form_title' ) : 'Contact <span class="primary">Us</span> For A Personalized Consultation' ;
$form_code      = ! is_null( $id ) ? carbon_get_post_meta( $id, 'form_code' ) : '[contact-form-7 id="19e4962" title="Call form"]';
$right_img      = ! is_null( $id ) ? carbon_get_post_meta( $id, 'form_r_img' ) : get_stylesheet_directory_uri() . '/assets/img/steve-randock-jr.png';
$right_title    = ! is_null( $id ) ? carbon_get_post_meta( $id, 'form_r_title' ) : 'Steve Randock Jr';
$right_subtitle = ! is_null( $id ) ? carbon_get_post_meta( $id, 'form_r_subtitle' ) : 'General Manager';

if ( empty( $form_code ) || ! $form_enabled ) {
    return;
}
?>
<section class="contact-section">
    <div class="container">
        <div class="contact-wrap">
            <?php
            if ( ! empty( $form_title ) ) :
                ?>
                <h2 class="title-section">
                    <?php echo $form_title?>
                </h2>
                <?php
            endif;

            echo do_shortcode( $form_code );
            ?>

            <?php
            if ( ! empty( $right_img ) ) :
                ?>
                <div class="author">
                    <img src="<?php echo esc_url( $right_img ) ?>" alt="steve-randock-jr">
                    <div class="author-info">
                        <?php
                        if ( ! empty( $right_title ) ) :
                            ?>
                            <p class="author-title"><?php echo $right_title?></p>
                            <?php
                        endif;

                        if ( ! empty( $right_subtitle ) ):
                            ?>
                            <p class=""><?php echo $right_subtitle?></p>
                            <?php
                        endif;
                        ?>
                    </div>
                </div>
                <?php
            endif;
            ?>
        </div>
    </div>
</section>