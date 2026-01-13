<?php

$title      = ! empty( $args['sb_hero_title'] ) ? $args['sb_hero_title'] : get_the_title();
$banner_src = $args['sb_hero_image'];
?>
<section class="hero-section hero-img" style="--hero-bg: url(<?php echo $banner_src?>)">
    <div class="container">
        <h1 class="title-section">
            <?php echo $title?>
        </h1>
    </div>
</section>

