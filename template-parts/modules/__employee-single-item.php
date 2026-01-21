<div class="employee-item single-item">
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
            </p >
            <?php
            endif;
            ?>

            <div class="info">
                <?php
                if ( ! empty( $mail ) ) :
                    ?>
                    <a href="mailto:<?php echo $mail?>">
                        <?php echo $mail?>
                    </a>
                    <?php
                endif;

                if ( ! empty( $phone ) ) :
                    ?>
                    <a href="tel:<?php echo $phone?>">
                        <?php
                            echo $phone . ( isset( $after_phone ) ? " {$after_phone}" : "" );
                        ?>
                    </a>
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
</div>