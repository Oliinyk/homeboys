<?php
if ( ! isset( $args['data-floor'] ) ) {
    return;
}

$data = $args['data-floor'];

?>
<a href="<?php echo isset( $data['permalink'] ) ? $data['permalink'] : '#' ?>" class="card-item">
    <?php
    if ( isset( $data['img_src'] ) ) :
        ?>
        <img src="<?php echo esc_url( $data['img_src'] )?>" alt="#">
        <?php
    endif;
    ?>
    <ul class="card-top-info">
        <?php
        if ( isset( $data['size'] ) && ! empty( $data['size'] ) ) :
            ?>
            <li>
                <?php echo sprintf( "%s ft2", $data['size'] )?>
            </li>
            <?php
        endif;

        if ( isset( $data['beds'] ) && ! empty( $data['beds'] ) ) :
            ?>
            <li>
                <?php echo sprintf( "%d Beds", $data['beds'] )?>
            </li>
            <?php
        endif;

        if ( isset( $data['baths'] ) && ! empty( $data['baths'] ) ) :
            ?>
            <li>
                <?php echo sprintf( "%d Baths", $data['baths'] )?>
            </li>
            <?php
        endif;
        ?>
    </ul>

    <div class="card-labels">
        <?php
        if ( isset( $data['price'] ) && ! empty ( $data['price'] ) ) :
            ?>
            <div class="label">
                $<?php echo $data['price']?>
            </div>
            <?php
        endif;

        if ( isset( $data['location'] ) && ! empty( $data['location'] ) )
        ?>
        <div class="label danger">
            <span class="label-top">On Display</span>
            <span>
                <?php echo $data['location']?>
            </span>
        </div>
    </div>

    <div class="item-info">
        <?php
        if ( isset( $data['title'] ) && ! empty( $data['title'] ) ) :
            ?>
            <h4 class="item-title">
                <?php echo $data['title']?>
            </h4>
            <?php
        endif;
        ?>
        <p class="item-subtitle">
            <?php 
                echo isset( $data['manufacturer'] ) ? $data['manufacturer'] : '';
                echo isset( $data['series'] ) ? '|' . $data['series'] : '';
            ?>
        </p>
    </div>
</a>