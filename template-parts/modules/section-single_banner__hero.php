<?php

$title       = ! empty( $args['sb_hero_title'] ) ? $args['sb_hero_title'] : '';
$hero_height = ! empty( $args['sb_hero_image_height'] ) ? intval( $args['sb_hero_image_height'] ) : 236;
$banner_src  = $args['sb_hero_image'];
?>
<section class="hero-section hero-img" style="--hero-bg: url(<?php echo $banner_src?>); --desctop-hero-height: <?php echo $hero_height ?>px;">
    <div class="container">
        <h1 class="title-section">
            <?php echo $title?>
        </h1>
    </div>
</section>

