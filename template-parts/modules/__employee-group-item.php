<div class="employee-item group-item">
    <div class="item-wrap">
        <img src="<?php echo esc_url( $photo_url )?>" alt="<?php echo esc_attr( $title )?>">

        <h3>
            <?php echo $title?>
        </h3>

        <?php
        if ( ! empty( $subtitle ) ) :
        ?>
        <span class="subtitle">
            <?php echo $subtitle?>
        </span>
        <?php
        endif;

        if ( ! empty( $desc ) ) :
            ?>
            <p class="description">
                <?php echo $desc?>
            </p>
            <?php
        endif;
        ?>
    </div>
</div>