<?php
if ( ! isset( $args['id'] ) ) {
    return;
}
$id = $args['id'];

$guidelines_list = carbon_get_post_meta( $id, 'guidelines_list' );

if ( empty( $guidelines_list ) ) {
    return;
};

$small_title    = carbon_get_post_meta( $id, 'guidelines_block_small_title' );
$title          = carbon_get_post_meta( $id, 'guidelines_block_title' );
$guides_count   = count( $guidelines_list );

?>
<section class="customer-guidelines-section">
    <div class="container">
        <ul class="breadcrumbs">
            <li class="crumb-item">
                <a href="#">Process</a>
            </li>

            <li class="crumb-item">
                <span>
                    <?php the_title()?>
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

        if ( ! empty( $title ) ) :
            ?>
            <h2 class="title-section">
                <?php echo $title ?>
            </h2>
            <?php
        endif;
            ?>
        <div class="swiper guidelines-swiper">
            <div class="swiper-wrapper">
                <?php
                foreach ( $guidelines_list as $key => $item ) :
                    $key++;
                    $item_label = "Step {$key}";
                    $item_title = $item['guide_title'];
                    $item_image = $item['guide_image'];
                    $item_desc  = $item['guide_description'];
                    ?>
                    <div class="swiper-slide">
                        <div class="slide-content">
                            <div class="slide-text">
                                <div class="step-label">
                                    <?php echo $item_label?>
                                </div>

                                <?php
                                if ( ! empty( $item_title ) ) :
                                    ?>  
                                    <h2 class="slide-title">
                                        <?php echo $item_title ?>
                                    </h2>
                                    <?php
                                endif;

                                if ( ! empty( $item_desc ) ) :
                                    ?>
                                    <p class="slide-description">
                                        <?php echo $item_desc?>
                                    </p>
                                    <?php
                                endif;
                                ?>
                            </div>
                            <div class="slide-image">
                                <img src="<?php echo esc_url( $item_image )?>" alt="<?php echo esc_attr( $item_title )?>">
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>

            <div class="swiper-button-prev custom-prev">
                <svg class="arrow-ico" width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.8047 23.125L7.92969 14.7656L25.2031 14.7656L25.2031 8.55469L7.83203 8.55469L11.8047 0L5.76953 0L0 11.5625L5.76953 23.125H11.8047Z" />
                </svg>
            </div>

            <div class="swiper-button-next custom-next">
                <svg class="arrow-ico" width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.3984 23.125L17.2734 14.7656L0 14.7656L0 8.55469L17.3711 8.55469L13.3984 0L19.4336 0L25.2031 11.5625L19.4336 23.125H13.3984Z" />
                </svg>
            </div>
        </div>

        <div class="progress-section  guidelines-progress-section">
            <div class="steps-list guidelines-steps-list">
                <?php
                foreach ( $guidelines_list as $key => $item ) :
                    $key++;
                    $item_label = "Step {$key}";
                    $item_title = $item['guide_title'];
                    ?>
                    <div class="step-item" data-step="0">
                        <div class="step-number">
                            <?php echo $item_label?>
                        </div>

                        <div class="step-name">
                            <?php echo $item_title?>
                        </div>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
            <div class="progress-bar-container">
                <div class="progress-segments">
                    <?php
                    for ( $i = 0; $i < $guides_count; $i++ ) :
                        $active_class = ( $i == 0 ) ? ' active' : '';
                        ?>
                        <div class="progress-segment<?php echo $active_class?>"></div>
                        <?php
                    endfor;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>