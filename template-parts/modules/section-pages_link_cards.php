<?php
if ( ! isset( $args['id'] ) ) {
    return;
}

$id = $args['id'];

$button_txt         = carbon_get_post_meta( $id, 'pages_link_cards_button_txt' );
$pages_link_cards   = carbon_get_post_meta( $id, 'pages_link_cards' );

if ( empty( $pages_link_cards ) ) {
    return;
};
?>
<section class="process-section">
    <div class="container">
        <div class="card-list sm-col-2">
        <?php
        foreach ( $pages_link_cards as $item ) :
            $small_title     = $item['plc_small_title'];
            $title           = $item['plc_title'];
            $post_to_link_id = $item['plc_post'][0]['id'];
            $post_link       = get_the_permalink( $post_to_link_id );
            $card_image      = $item['plc_image'];
            ?>
            <div class="card-item">
                <img src="<?php echo $card_image?>" alt="#">

                <div class="item-info">
                    <?php
                    if ( ! empty( $small_title ) ) :
                        ?>
                        <h4 class="subtitle-section">
                            <?php echo $small_title?>
                        </h4>
                        <?php
                    endif;
                    ?>
                    <h2 class="title-section">
                        <?php echo $title?>
                    </h2>

                    <div class="btn-wrap">
                        <a href="<?php echo esc_url( $post_link )?>" class="btn submit-btn">
                            <?php echo $button_txt?>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        endforeach;
        ?>
        </div>
    </div>
</section>