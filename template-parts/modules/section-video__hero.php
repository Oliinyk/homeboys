<?php
$code = $args['video_code'];

if ( empty( $code ) ) {
    return;
}
?>

<section class="hero-section">
    <div class="fullscreen-video">
        <div class="video-wrap">
            <?php echo $code?>
        </div>
    </div>
</section>