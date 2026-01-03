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

        $location_page_query = new WP_Query( [
            'post_type'      => 'page',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'meta_query'     => [
                [
                    'key'     => 'display_homes_location',
                    'value'   => $key,
                    'compare' => '=',
                ],
            ],
        ] );

        $location_page_id  = ! empty ( $location_page_query->posts ) ? $location_page_query->posts[0]->ID : null;
        $location_page_url = ! is_null( $location_page_id ) ? get_permalink( $location_page_id ) : '#';
        ?>
        <div class="location-list-item<?php echo esc_attr( $aclive_class ); ?>">
            <?php
            if ( ! is_null( $location_page_id ) ) :
                ?>
                    <a href="<?php echo esc_url( $location_page_url ); ?>">
                <?php
            endif;
                        
            if ( ! empty( $location['location_name'] ) ) :
                ?>
                    <h4 class="location-title">
                        <?php echo $location['location_name']; ?>
                    </h4>

                    <p class="location-subtitle">Display Lot</p>
                <?php
            endif;
            ?>

            <div class="location-bottom-content">
                <?php
                if ( ! empty( $location['location_phone'] ) ) :
                    ?>
                    <span class="phone-link">
                        <?php echo esc_html( $location['location_phone'] ); ?>
                    </span>
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
            <?php
            if ( ! is_null( $location_page_id ) ) :
            ?>
            </a>
            <?php
            endif;
            ?>
        </div>
        <?php
    endforeach;
    ?>
</div>