<?php
/**
 * Template name: Display homes
 */
$post_id = get_the_ID();

$locations = apply_filters( 'hb2_locations_list', true );

$plans_query_args = [
    'post_type'      => 'plans',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
    'orderby'        => 'date',
];

$plans = new WP_Query( $plans_query_args );

get_header();
?>
<div class="nav-overlay" id="navOverlay"></div>

<section class="hero-section">
    <div class="container">
        <ul class="breadcrumbs">
            <li class="crumb-item"><a href="#">Display Homes</a></li>
            <li class="crumb-item"><a href="#">Spokane Valley</a></li>
        </ul>
        <h4 class="subtitle-section">Our</h4>
        <h1 class="title-section">Display Homes</h1>
        
        <?php
        get_template_part( 'template-parts/modules/__location_list', null, [
            'locations'        => $locations,
            'settings' => [
                'additional_class' => 'location-top',
            ],
        ] );
        ?>
    </div>
</section>

<section class="gallery-section">
    <div class="container">
        <div class="swiper gallery-slider gallerySlider">
            <div class="swiper-wrapper">
                <!-- Slide Group 1 -->
                <div class="swiper-slide">
                    <div class="slides-group">
                        <div class="card-item">
                            <img src="<?php echo get_template_directory_uri() . '/assets/img/ING762G.png'?>" alt="#" class="slide-image">

                            <ul class="card-top-info">
                                <li>2,280 ft²</li>
                                <li>4 BEDS</li>
                                <li>2 BATHS</li>
                            </ul>
                            <div class="card-labels">
                                <div class="label">$186,284</div>
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Giant Sequoia ING762G</h4>
                                <p class="item-subtitle">Golden West | Inspiration Gold Series</p>
                            </div>
                        </div>

                        <div class="card-item">
                            <img src="<?php echo get_template_directory_uri() . '/assets/img/ING762G.png'?>" alt="Mt Anderson" class="slide-image">

                            <ul class="card-top-info">
                                <li>1,609 ft²</li>
                                <li>3 BEDS</li>
                                <li>2 BATHS</li>
                            </ul>
                            <div class="card-labels">
                                <div class="label">$186,284</div>
                            </div>
                            <div class="item-info">
                                <div class="item-title">N4P360F5 Mt Anderson</div>
                                <div class="item-subtitle">Olympic Range | Cavco Millersburg</div>
                            </div>
                        </div>

                        <div class="card-item">
                            <img src="<?php echo get_template_directory_uri() . '/assets/img/ING762G.png'?>" alt="Clover" class="slide-image">

                            <ul class="card-top-info">
                                <li>1,770 ft²</li>
                                <li>3 BEDS</li>
                                <li>2 BATHS</li>
                            </ul>
                            <div class="card-labels">
                                <div class="label">$186,284</div>
                            </div>
                            <div class="item-info">
                                <div class="item-title">Clover 30603F</div>
                                <div class="item-subtitle">Fleetwood | Waverly Crest Prestige</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide Group 2 -->
                <div class="swiper-slide">
                    <div class="slides-group">
                        <div class="card-item">
                            <img src="<?php echo get_template_directory_uri() . '/assets/img/ING762G.png'?>" alt="#" class="slide-image">

                            <ul class="card-top-info">
                                <li>2,280 ft²</li>
                                <li>4 BEDS</li>
                                <li>2 BATHS</li>
                            </ul>
                            <div class="card-labels">
                                <div class="label">$186,284</div>
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Giant Sequoia ING762G</h4>
                                <p class="item-subtitle">Golden West | Inspiration Gold Series</p>
                            </div>
                        </div>

                        <div class="card-item">
                            <img src="<?php echo get_template_directory_uri() . '/assets/img/ING762G.png'?>" alt="Mt Anderson" class="slide-image">
                            <ul class="card-top-info">
                                <li>1,609 ft²</li>
                                <li>3 BEDS</li>
                                <li>2 BATHS</li>
                            </ul>
                            <div class="card-labels">
                                <div class="label">$186,284</div>
                            </div>
                            <div class="item-info">
                                <div class="item-title">N4P360F5 Mt Anderson</div>
                                <div class="item-subtitle">Olympic Range | Cavco Millersburg</div>
                            </div>
                        </div>

                        <div class="card-item">
                            <img src="<?php echo get_template_directory_uri() . '/assets/img/ING762G.png'?>" alt="Clover" class="slide-image">
                            <ul class="card-top-info">
                                <li>1,770 ft²</li>
                                <li>3 BEDS</li>
                                <li>2 BATHS</li>
                            </ul>
                            <div class="card-labels">
                                <div class="label">$186,284</div>
                            </div>
                            <div class="item-info">
                                <div class="item-title">Clover 30603F</div>
                                <div class="item-subtitle">Fleetwood | Waverly Crest Prestige</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide Group 3 -->
                <div class="swiper-slide">
                    <div class="slides-group">
                        <div class="card-item">
                            <img src="<?php echo get_template_directory_uri() . '/assets/img/ING762G.png'?>" alt="#" class="slide-image">

                            <ul class="card-top-info">
                                <li>2,280 ft²</li>
                                <li>4 BEDS</li>
                                <li>2 BATHS</li>
                            </ul>
                            <div class="card-labels">
                                <div class="label">$186,284</div>
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Giant Sequoia ING762G</h4>
                                <p class="item-subtitle">Golden West | Inspiration Gold Series</p>
                            </div>
                        </div>

                        <div class="card-item">
                            <img src="<?php echo get_template_directory_uri() . '/assets/img/ING762G.png'?>" alt="Mt Anderson" class="slide-image">
                            
                            <ul class="card-top-info">
                                <li>1,609 ft²</li>
                                <li>3 BEDS</li>
                                <li>2 BATHS</li>
                            </ul>
                            <div class="card-labels">
                                <div class="label">$186,284</div>
                            </div>
                            <div class="item-info">
                                <div class="item-title">N4P360F5 Mt Anderson</div>
                                <div class="item-subtitle">Olympic Range | Cavco Millersburg</div>
                            </div>
                        </div>

                        <div class="card-item">
                            <img src="<?php echo get_template_directory_uri() . '/assets/img/ING762G.png'?>" alt="Clover" class="slide-image">

                            <ul class="card-top-info">
                                <li>1,770 ft²</li>
                                <li>3 BEDS</li>
                                <li>2 BATHS</li>
                            </ul>
                            <div class="card-labels">
                                <div class="label">$186,284</div>
                            </div>
                            <div class="item-info">
                                <div class="item-title">Clover 30603F</div>
                                <div class="item-subtitle">Fleetwood | Waverly Crest Prestige</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-pagination"></div>
        </div>

        <div class="card-item">
            <img src="<?php echo get_template_directory_uri() . '/assets/img/ING762G.png'?>" alt="#" class="slide-image">

            <ul class="card-top-info">
                <li>2,280 ft²</li>
                <li>4 BEDS</li>
                <li>2 BATHS</li>
            </ul>
            <div class="card-labels">
                <div class="label">$186,284</div>
            </div>
            <div class="item-info">
                <h4 class="item-title">Giant Sequoia ING762G</h4>
                <p class="item-subtitle">Golden West | Inspiration Gold Series</p>
            </div>
        </div>

        <a href="#" class="btn primary-btn">
            Show All
            <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.90066 9.7689L5.97351 0L4.85651 0L4.83223 9.52L0.874172 5.4629L-4.94673e-09 6.35895L5.48786 11.9841H5.51214L6.36203 11.0881L11 6.33406L10.1258 5.43801L5.90066 9.7689Z" />
            </svg>
        </a>

        <?php
            get_template_part( 'template-parts/modules/__location_list', null, [
                'locations' => $locations,
                'settings' => [
                    'additional_class' => 'location-bottom',
                ],
            ] );
        ?>
    </div>
</section>

<?php
    get_template_part( 'template-parts/modules/section', 'contact', ['id' => $post_id] );
    get_template_part( 'template-parts/modules/section', 'find_home' );
get_footer();