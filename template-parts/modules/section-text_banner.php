<?php
if ( ! isset( $args['id'] ) ) {
    return;
}

$id = $args['id'];

$small_title = carbon_get_post_meta( $id, 'dti_small_title' );
$title       = carbon_get_post_meta( $id, 'dti_title' );
$description = carbon_get_post_meta( $id, 'dti_description' );
$image       = carbon_get_post_meta( $id, 'dti_image' );

if ( empty( $description ) || empty( $image ) ) {
    return;
}
?>
<section class="text-banner-section">
    <div class="container">
        <div class="text-banner-wrap">
            <div class="text-wrap">
                <?php
                if ( ! empty( $small_title ) ) :
                    ?>
                    <h4 class="subtitle-section">
                        <?php echo $small_title?>
                    </h4>
                    <?php
                endif;

                if ( ! empty( $title ) ) :
                    ?>
                    <h2 class="title-section">
                        <?php echo $title?>
                    </h2>
                    <?php
                endif;
                ?>
                <p class="section-description">
                    <?php echo $description?>
                </p>
            </div>

            
            <div class="banner-wrap">
                <img src="<?php echo esc_url( $image )?>" alt="#">
            </div>
        </div>
    </div>
</section>