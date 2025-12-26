<?php
$id = $args['id'];

$form_title     = carbon_get_post_meta( $id, 'form_title' );
$form_code      = carbon_get_post_meta( $id, 'form_code' );
$right_img      = carbon_get_post_meta( $id, 'form_r_img' );
$right_title    = carbon_get_post_meta( $id, 'form_r_title' );
$right_subtitle = carbon_get_post_meta( $id, 'form_r_subtitle' );

if ( empty( $form_code ) ) {
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
                            <p class="">General Manager</p>
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