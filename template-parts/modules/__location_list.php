<?php
$locations        = isset( $args['locations'] ) ? $args['locations'] : apply_filters( 'hb2_locations_list', true );
$additional_class = isset( $args['settings']['additional_class'] ) ? $args['settings']['additional_class'] : '';
$active_index     = isset( $args['settings']['active_index'] ) ? (int) $args['settings']['active_index'] : 0;

if ( empty( $locations ) ) {
    return;
}
?>
<div class="location-list <?php echo esc_attr( $additional_class ); ?>">
    <?php
    foreach ( $locations as $key => $location ) :
        $aclive_class = ( $key === $active_index ) ? ' active' : '';
        ?>
        <div class="location-list-item<?php echo esc_attr( $aclive_class ); ?>">
            <?php
            if ( ! empty( $location['location_name'] ) ) :
                ?>
                    <h4 class="location-title">
                        <?php echo esc_html( $location['location_name'] ); ?>
                    </h4>

                    <p class="location-subtitle">Display Lot</p>
                <?php
            endif;
            ?>

            <div class="location-bottom-content">
                <?php
                if ( ! empty( $location['location_phone'] ) ) :
                    ?>
                    <a href="tel:<?php echo esc_attr( preg_replace( '/\D+/', '', $location['location_phone'] ) ); ?>" class="phone-link">
                        <?php echo esc_html( $location['location_phone'] ); ?>
                    </a>
                    <?php
                endif;
                ?>

                <?php
                if ( ! empty( $location['location_address'] ) ) :
                    ?>
                    <p class="address-link"><?php echo esc_html( $location['location_address'] ); ?></p>
                    <?php
                endif;
                ?>
            </div>
        </div>
        <?php
    endforeach;
    ?>
</div>