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
    'order'   => 'DESC',
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

    <div class="content-wrap items">
        <?php
        while ( $employees->have_posts() ) :
            $employees->the_post();
            $eID = get_the_ID();

            $is_group  = carbon_get_post_meta( $eID, 'is_group' );
            $photo_id  = carbon_get_post_meta( $eID, 'employee_photo' );
            $title     = carbon_get_post_meta( $eID, 'employee_name' );
            $subtitle  = carbon_get_post_meta( $eID, 'employee_title' );
            $mail      = carbon_get_post_meta( $eID, 'employee_email' );
            $phone     = carbon_get_post_meta( $eID, 'employee_phone' );
            $desc      = carbon_get_post_meta( $eID, 'employee_bio' );
            $is_group_class = ! empty( $is_group ) ? ' is_group' : '';

            if ( empty( $photo_id ) ) {
                continue;
            }

            $photo_url = wp_get_attachment_image_url( $photo_id );
            
            echo $title;

            if ( empty( $is_group ) ) :
                include get_template_directory() . '/template-parts/modules/__employee-single-item.php';
            else :
                include get_template_directory() . '/template-parts/modules/__employee-group-item.php';
            endif;    
        endwhile;
        ?>
    </div>
</div>
<?php
wp_reset_postdata();