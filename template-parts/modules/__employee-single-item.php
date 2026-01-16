<div class="employee-item single-item">
    <div class="item-wrap">
        <div class="side">
            <img src="<?php echo esc_url( $photo_url )?>" alt="<?php echo esc_attr( $title )?>">
        </div>

        <div class="side">
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
            ?>

            <div class="info">
                <?php
                if ( ! empty( $mail ) ) :
                    ?>
                    <p>
                        <a href="mailto:<?php echo $mail?>">
                            <?php echo $mail?>
                        </a>
                    </p>
                    <?php
                endif;

                if ( ! empty( $phone ) ) :
                    ?>
                    <p>
                        <a href="tel:<?php echo $phone?>">
                            <?php echo $phone?>
                        </a>
                    </p>
                    <?php
                endif;

                if ( ! empty( $desc ) ) :
                    ?>
                    <p>
                        <?php echo $desc?>
                    </p>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</div>