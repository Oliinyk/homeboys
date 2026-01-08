<?php
$origin_title = get_the_title();
$small_title  = isset( $args['simple_hero_small_title'] ) ? $args['simple_hero_small_title'] : '';
$title        = ( isset( $args['simple_hero_title'] ) && ! empty( $args['simple_hero_title'] ) ) ? $args['simple_hero_title'] : $origin_title;
?>

<section class="hero-section">
    <div class="container">
        <ul class="breadcrumbs">
            <li class="crumb-item">
                <a href="#">Display Homes</a>
            </li>

            <li class="crumb-item">
                <span>
                    <?php echo $origin_title?>
                </span>
            </li>
        </ul>

        <?php
        if ( ! empty( $small_title ) ) :
            ?>
            <h4 class="subtitle-section">
                <?php echo $small_title?>
            </h4>
            <?php
        endif;
        ?>
        <h1 class="title-section">
            <?php echo $title?>
        </h1>
    </div>
</section>