<?php
$post_id = $args['id'];

$subtitle           = carbon_get_post_meta( $post_id, 'welcome_small_title' );
$title              = carbon_get_post_meta( $post_id, 'welcome_main_title' );
$description_top    = carbon_get_post_meta( $post_id, 'welcome_description_top' );
$delivering_title   = carbon_get_post_meta( $post_id, 'welcome_delivering_title' );
$states             = carbon_get_post_meta( $post_id, 'welcome_states' );
$video_url          = carbon_get_post_meta( $post_id, 'welcome_video_embed_url' );
$iframe_title       = carbon_get_post_meta( $post_id, 'welcome_video_iframe_title' );
$description_bottom = carbon_get_post_meta( $post_id, 'welcome_description_bottom' );
?>
<section class="welcome-section">
    <div class="container">
        <?php
        if ( ! empty( $subtitle ) ):
            ?>
            <h4 class="subtitle-section">
                <?php echo __( $subtitle, 'home-boys-2' )?>
            </h4>
            <?php
        endif;

        if ( ! empty( $title ) ) :
            ?>
            <h2 class="title-section">
                <?php echo __( $title, 'home-boys-2' )?>
            </h2>
            <?php
        endif;

        if ( ! empty( $description_top ) ) :
            ?>
            <p class="section-description">
                <?php echo __( $description_top, 'home-boys-2' )?>
            </p>
            <?php
        endif;

        if ( ! empty( $states ) ) :
            if ( ! empty( $delivering_title ) ) :
                ?>
                <h4 class="delivering-title">
                    <?php echo __( $delivering_title, 'home-boys-2' )?>:
                </h4>
                <?php
            endif;
            ?>
            <ul class="delivering-wrap">
                <?php
                foreach ( $states as $item ) :
                    ?>
                    <li class="delivering-item">
                        <img src="<?php echo esc_url( $item['st_image'] )?>" alt="<?php echo esc_attr( $item['st_name'] )?>">

                        <h5 class="">
                            <?php echo __( $item['st_name'],  'home-boys-2' )?>
                        </h5>
                    </li>
                    <?php
                endforeach;
                ?>
            </ul>
            <?php
        endif;
        ?>
        <!-- video -->
        <?php
        if ( ! empty( $video_url ) ) :
            ?>
            <div class="video-wrap">
                <iframe width="1034" height="582" 
                    src="<?php echo esc_url( $video_url )?>" 
                    title="<?php echo esc_attr( $iframe_title )?>" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            </div>
            <?php
        endif;

        if ( ! empty( $description_bottom ) ) :
            ?>
            <p class="video-description">
                <?php echo __( $description_bottom,  'home-boys-2' )?>
            </p>
            <?php
        endif;
        ?>
    </div>
</section>