<?php
$prefix         = $args['is_home'] ? 'front_' : '';
$partners       = carbon_get_theme_option( "{$prefix}partners" );
$section_title  = carbon_get_theme_option( "{$prefix}partners_section_title" );

if ( empty( $partners ) ) {
    return;
}
?>
<section class="partner-section">
    <div class="container">
        <?php
        if ( isset( $args['title'] ) && ! empty( $section_title ) ) :
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
            <img src="<?php echo esc_url( $item["{$prefix}partner_image"] )?>" alt="<?php echo esc_attr( $item["{$prefix}partner_name"] )?>">
            <?php
            endforeach;
            ?>
        </div>
    </div>
</section>