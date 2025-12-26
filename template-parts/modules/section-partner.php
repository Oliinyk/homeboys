<?php
$id = $args['id'];

$partners       = carbon_get_post_meta( $id, 'partners' );
$section_title  = carbon_get_post_meta( $id, 'partners_section_title' );
if ( empty( $partners ) ) {
    return;
}
?>
<section class="partner-section">
    <div class="container">
        <?php
        if ( ! empty( $section_title ) ) :
            ?>
            <h3 class="subtitle-section">
                <?php echo __( $section_title, 'home-boys-2' ) ?>
            </h3>
            <?php
        endif;
        ?>

        <div class="partner-wrap">
            <?php
            foreach( $partners as $item ) :
            ?>
            <img src="<?php echo esc_url( $item['partner_image'] )?>" alt="<?php echo esc_attr( $item['partner_image'] )?>">
            <?php
            endforeach;
            ?>
        </div>
    </div>
</section>