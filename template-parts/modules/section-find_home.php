<?php
    $params = isset( $args ) ? $args : [];

    $classes                = isset( $params['classes'] ) ? $params['classes'] : '';
    $subtitle               = isset( $params['subtitle'] ) ? $params['subtitle'] : carbon_get_theme_option( 'find_home_subtitle' );
    $title                  = isset( $params['title'] ) ? $params['title'] : carbon_get_theme_option( 'find_home_title' );
    $need_filter            = isset( $params['filter'] ) ? $params['filter'] : true;
    $filter_exclude_fields  = isset( $params['filter__exclude_fields'] ) ? $params['filter__exclude_fields'] : [];
?>
<section class="find-home-section <?php echo esc_attr( $classes ); ?>">
    <div class="container">
        <h4 class="subtitle-section"><?php echo esc_html( $subtitle ); ?></h4>
        <h2 class="title-section"><?php echo esc_html( $title ); ?></h2>

        <?php
        if ( $need_filter ) {
            get_template_part( 'template-parts/modules/__filter', null, [ 'exclude_fields' => $filter_exclude_fields ] );
        };

        get_template_part( 'template-parts/modules/__mini_homes_loop', null );
        ?>
    </div>
</section>