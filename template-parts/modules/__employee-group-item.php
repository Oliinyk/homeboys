<div class="employee-item group-item">
    <div class="item-wrap">
        <div class="side">
            <img src="<?php echo esc_url( $photo_url )?>" alt="<?php echo esc_attr( $title )?>">
        </div>

        <div class="side">
            <h3 class="employee-title">
                <?php echo $title?>
            </h3>

            <?php
            if ( ! empty( $subtitle ) ) :
            ?>
            <p class="employee-subtitle">
                <?php echo $subtitle?>
            </p>
            <?php
            endif;

            if ( ! empty( $desc ) ) :
                ?>
                <p class="employee-desc">
                    <?php echo $desc?>
                </p>
                <?php
            endif;
            ?>
        </div>

    </div>
</div>