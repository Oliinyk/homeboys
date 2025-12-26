<?php
add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( get_template_directory() . '/vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}

include_once 'post-meta.php';
include_once 'term-meta.php';
include_once 'theme-options.php';