<a href="<?php echo $permalink?>" class="blog-post-preview">
    <img src="<?php echo esc_url( $thumbnail )?>" alt="<?php echo esc_attr( $title )?>">

    <div class="item-description">
        <h4 class="item-title">
            <?php echo $title?>
        </h4>

        <p><?php echo $date?></p>
    </div>
</a>