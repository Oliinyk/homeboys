<?php
if ( ! $args['id'] || empty( $args['id'] ) ) {
    return;
}

$id   = $args['id'];
$hero = carbon_get_post_meta( $id, 'hero_section' );

if ( empty( $hero ) ) {
    return;
}
$hero_data  = isset( $args['params'] ) ? array_merge( $args['params'], $hero[0] ) : $hero[0];
$type       = $hero_data['_type'];

get_template_part( "template-parts/modules/section", "{$type}__hero", $hero_data );