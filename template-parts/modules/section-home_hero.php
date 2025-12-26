<?php
$id     = $args['id'];
$hero   = carbon_get_post_meta( $id, 'hero_section' );

if ( empty( $hero ) || 
    'home' !== $hero[0]['_type'] || 
    ! isset( $hero[0]['home_hero_slider'] ) || 
    empty( $hero[0]['home_hero_slider'] )
    )
{
    return;
}

$hero_slider    = $hero[0]['home_hero_slider'];
$include_filter = $hero[0]["include_filter"];

?>
<section class="hero-section">
    <!-- Swiper -->
    <div class="swiper hero-slider mySwiper">
        <div class="swiper-wrapper">
            <?php
            foreach( $hero_slider as $item ) :
                $img_id     = $item['slide'];
                $alt_text   = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
                $img_url    = wp_get_attachment_image_url( $img_id, 'full' );
            ?>
            <div class="swiper-slide">
                <img src="<?php echo esc_url( $img_url )?>" alt="<?php echo esc_attr( $alt_text )?>">
            </div>
            <?php
            endforeach;
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <?php
    if ( $include_filter ) :
        ?>
        <div class="filter-wrap">
            <h1 class="title-section">
                <?php echo __( $hero[0]["hero_filter_title"], 'home-boys-2' )?>
            </h1>
            <!-- filter -->
            <div class="filter-container">
                <div class="filter-grid">
                    <div class="filter-group">
                        <div class="filter-label">Price</div>
                        <div class="value-display">
                            <div class="value-box" id="priceMin">$ 76,391</div>
                            <div class="value-box" id="priceMax">$ 235,867</div>
                        </div>
                        <div class="slider-container">
                            <div class="slider-track"></div>
                            <div class="slider-range" id="priceRange"></div>
                            <div class="filter-slider">
                                <input type="range" id="priceMinSlider" min="0" max="500000" value="76391" step="1000">
                                <input type="range" id="priceMaxSlider" min="0" max="500000" value="235867" step="1000">
                            </div>
                        </div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-label">Size</div>
                        <div class="value-display">
                            <div class="value-box" id="sizeMin">800 ft²</div>
                            <div class="value-box" id="sizeMax">2 999 ft²</div>
                        </div>
                        <div class="slider-container">
                            <div class="slider-track"></div>
                            <div class="slider-range" id="sizeRange"></div>
                            <div class="filter-slider">
                                <input type="range" id="sizeMinSlider" min="0" max="5000" value="800" step="50">
                                <input type="range" id="sizeMaxSlider" min="0" max="5000" value="2999" step="50">
                            </div>
                        </div>
                    </div>

                    <div class="counter-group">
                        <div class="filter-label">Beds</div>
                        <div class="counter-container">
                            <button class="counter-btn arrow-left" id="bedsDown"></button>
                            <div class="counter-value" id="bedsValue">2</div>
                            <button class="counter-btn arrow-right" id="bedsUp"></button>
                        </div>
                    </div>

                    <div class="counter-group">
                        <div class="filter-label">Baths</div>
                        <div class="counter-container">
                            <button class="counter-btn arrow-left" id="bathsDown"></button>
                            <div class="counter-value" id="bathsValue">2</div>
                            <button class="counter-btn arrow-right" id="bathsUp"></button>
                        </div>
                    </div>

                    <div class="btn-wrap">
                        <button class="btn submit-btn" id="submitBtn">
                            Find Your Home
                            <svg width="17" height="11" viewBox="0 0 17 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7848 5.09934L6.89478e-08 5.02649L5.60551e-08 6.14349L14.5359 6.16777L10.4788 10.1258L11.3748 11L17 5.51214L17 5.48786L16.104 4.63797L11.3499 -2.71811e-07L10.4539 0.874172L14.7848 5.09934Z" fill="white"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endif;
    ?>
</section>