<?php

$query_params = [
    'post_type'      => 'employees',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => [
        'relation' => 'AND',
        'order_column' => [
            'key'      => '_employee_order',
            'compare'  => 'EXISTS',
            'type'     => 'DECIMAL',
        ],
    ],
    'order'   => 'ASC',
    'orderby' => 'order_column',
];

$employees = new WP_Query( $query_params );

if ( ! $employees->have_posts() ) {
    return;
}
?>
<div class="employees">
    <h4 class="subtitle-section">Our</h4>

    <h2 class="title-section">Team</h2>

    <div>
        <?php
        $compare_type    = null;
        $container_start = "<div class='content-wrap items grid sm-col-2 md-col-3'>";
        $container_end   = "</div>";
        while ( $employees->have_posts() ) :
            $employees->the_post();
            $eID = get_the_ID();

            $is_group       = carbon_get_post_meta( $eID, 'is_group' );
            $type           = $is_group ? 'group' : 'single';
            $photo_id       = carbon_get_post_meta( $eID, 'employee_photo' );
            $title          = carbon_get_post_meta( $eID, 'employee_name' );
            $subtitle       = carbon_get_post_meta( $eID, 'employee_title' );
            $mail           = carbon_get_post_meta( $eID, 'employee_email' );
            $phone          = carbon_get_post_meta( $eID, 'employee_phone' );
            $after_phone    = carbon_get_post_meta( $eID, 'employee_phone_after' );
            $desc           = carbon_get_post_meta( $eID, 'employee_bio' );
            $is_group_class = ! empty( $is_group ) ? ' is_group' : '';

            if ( empty( $photo_id ) ) {
                continue;
            }

            $photo_url = wp_get_attachment_image_url( $photo_id, 'large' );

            // If the type is different from the previous one and it's not the first item, close the previous container
            if ( $compare_type !== null && $compare_type !== $type ) {
                echo $container_end;
            }

            // If the type is different from the previous one, open a new container
            if ( $compare_type === null || $compare_type !== $type ) {
                echo $container_start;
            }
            
            if ( empty( $is_group ) ) :
                include get_template_directory() . '/template-parts/modules/__employee-single-item.php';
            else :
                include get_template_directory() . '/template-parts/modules/__employee-group-item.php';
            endif;
            
            $compare_type = $type;
        endwhile;

        if ( $compare_type !== null ) {
            echo $container_end;
        }
        ?>
    </div>
</div>
<?php
wp_reset_postdata();