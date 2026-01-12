<?php
$block_title       = isset( $args['title'] ) ? $args['title'] : '';
$block_description = isset( $args['description'] ) ? $args['description'] : '';

$query_args = [
    'post_type'      => 'process',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => [
        [
            'key' => '_process_contacts',
            'compare' => 'EXISTS',
        ],
    ],
];

$processes = new WP_Query( $query_args );


while( $processes->have_posts() ) :
    $processes->the_post();

    $process_Id   = get_the_ID();
    $contacts     = carbon_get_post_meta( $process_Id, 'process_contacts' );
    $process_desc = carbon_get_post_meta( $process_Id, 'process_description' );

    foreach ( $contacts as $contact ) :
        $name   = $contact['p_contact_name'];
        $phones = $contact['p_contact_phones'];
        $emails = $contact['p_contact_emails'];

    endforeach;
endwhile;

wp_reset_postdata();

