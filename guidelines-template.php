<?php
/**
 * Template name: Guidelines Template
 */
$p_ID = get_the_ID();

$guidelines_block_small_title = carbon_get_post_meta( $p_ID, 'guidelines_block_small_title' );
$guidelines_block_title       = carbon_get_post_meta( $p_ID, 'guidelines_block_title' );
$guidelines_list              = carbon_get_post_meta( $p_ID, 'guidelines_list' );

$pages_link_cards_button_txt  = carbon_get_post_meta( $p_ID, 'pages_link_cards_button_txt' );
$pages_link_cards             = carbon_get_post_meta( $p_ID, 'pages_link_cards' );

$dti_small_title = carbon_get_post_meta( $p_ID, 'dti_small_title' );
$dti_title       = carbon_get_post_meta( $p_ID, 'dti_title' );
$dti_description = carbon_get_post_meta( $p_ID, 'dti_description' );
$dti_image       = carbon_get_post_meta( $p_ID, 'dti_image' );

$content = get_the_content();

$files_for_upload = carbon_get_post_meta( $p_ID, 'files_for_upload' );

get_header();
?>
<div class="nav-overlay" id="navOverlay"></div>


    <!-- Start HERO -->
    <section class="hero-section">
        <!-- video -->
        <div class="fullscreen-video">
            <div class="video-wrap">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/GNLO3jhL02w?si=MTLh_ULyJxsX8XRI&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </section>
    <!-- End HERO -->

    <!-- Start Customer Guidelines  -->
    <section class="customer-guidelines-section">
        <div class="container">

            <ul class="breadcrumbs">
                <li class="crumb-item"><a href="#">Process</a></li>
                <li class="crumb-item"><span>Customer Guidelines</span></li>
            </ul>
            <h4 class="subtitle-section">Customer</h4>
            <h2 class="title-section">Guidelines</h2>

            <div class="swiper guidelines-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slide-content">
                            <div class="slide-text">
                                <div class="step-label">Step 1</div>
                                <h2 class="slide-title">Exploring Homes</h2>
                                <p class="slide-description">
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans.
                                </p>
                            </div>
                            <div class="slide-image">
                                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=800&h=600&fit=crop" alt="Woman working on laptop">
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slide-content">
                            <div class="slide-text">
                                <div class="step-label">Step 2</div>
                                <h2 class="slide-title">Pre-Qualification</h2>
                                <p class="slide-description">
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans.
                                </p>
                            </div>
                            <div class="slide-image">
                                <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=800&h=600&fit=crop" alt="Financial consultation">
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slide-content">
                            <div class="slide-text">
                                <div class="step-label">Step 3</div>
                                <h2 class="slide-title">Home Selection</h2>
                                <p class="slide-description">
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans.
                                </p>
                            </div>
                            <div class="slide-image">
                                <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&h=600&fit=crop" alt="Home selection">
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slide-content">
                            <div class="slide-text">
                                <div class="step-label">Step 4</div>
                                <h2 class="slide-title">Paperwork & Land Review</h2>
                                <p class="slide-description">
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans.
                                </p>
                            </div>
                            <div class="slide-image">
                                <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=800&h=600&fit=crop" alt="Paperwork">
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slide-content">
                            <div class="slide-text">
                                <div class="step-label">Step 5</div>
                                <h2 class="slide-title">Site Prep & Delivery</h2>
                                <p class="slide-description">
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans.
                                </p>
                            </div>
                            <div class="slide-image">
                                <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800&h=600&fit=crop" alt="Construction site">
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slide-content">
                            <div class="slide-text">
                                <div class="step-label">Step 6</div>
                                <h2 class="slide-title">Home Setup</h2>
                                <p class="slide-description">
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans.
                                </p>
                            </div>
                            <div class="slide-image">
                                <img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=800&h=600&fit=crop" alt="Home setup">
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slide-content">
                            <div class="slide-text">
                                <div class="step-label">Step 7</div>
                                <h2 class="slide-title">Key Handover</h2>
                                <p class="slide-description">
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans. 
                                    We have a list of lenders that specialize in manufactured loans.
                                </p>
                            </div>
                            <div class="slide-image">
                                <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&h=600&fit=crop" alt="Key handover">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-button-prev custom-prev">
                    <svg class="arrow-ico" width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.8047 23.125L7.92969 14.7656L25.2031 14.7656L25.2031 8.55469L7.83203 8.55469L11.8047 0L5.76953 0L0 11.5625L5.76953 23.125H11.8047Z" />
                    </svg>
                </div>
                <div class="swiper-button-next custom-next">
                    <svg class="arrow-ico" width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.3984 23.125L17.2734 14.7656L0 14.7656L0 8.55469L17.3711 8.55469L13.3984 0L19.4336 0L25.2031 11.5625L19.4336 23.125H13.3984Z" />
                    </svg>
                </div>
            </div>

            <div class="progress-section  guidelines-progress-section">
                <div class="steps-list guidelines-steps-list">
                    <div class="step-item" data-step="0">
                        <div class="step-number">Step 1</div>
                        <div class="step-name">Exploring Homes</div>
                    </div>
                    <div class="step-item" data-step="1">
                        <div class="step-number">Step 2</div>
                        <div class="step-name">Pre-Qualification</div>
                    </div>
                    <div class="step-item" data-step="2">
                        <div class="step-number">Step 3</div>
                        <div class="step-name">Home Selection</div>
                    </div>
                    <div class="step-item" data-step="3">
                        <div class="step-number">Step 4</div>
                        <div class="step-name">Paperwork & Land Review</div>
                    </div>
                    <div class="step-item" data-step="4">
                        <div class="step-number">Step 5</div>
                        <div class="step-name">Site Prep & Delivery</div>
                    </div>
                    <div class="step-item" data-step="5">
                        <div class="step-number">Step 6</div>
                        <div class="step-name">Home Setup</div>
                    </div>
                    <div class="step-item" data-step="6">
                        <div class="step-number">Step 7</div>
                        <div class="step-name">Key Handover</div>
                    </div>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-segments">
                        <div class="progress-segment active"></div>
                        <div class="progress-segment"></div>
                        <div class="progress-segment"></div>
                        <div class="progress-segment"></div>
                        <div class="progress-segment"></div>
                        <div class="progress-segment"></div>
                        <div class="progress-segment"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Customer Guidelines section -->

    <!-- Start Financing-Manufactured section -->
    <section class="process-section">
        <div class="container">
            <div class="card-list sm-col-2">
                <div class="card-item">
                    <img src="assets/img/Clover-30603F.png" alt="#">
                    <div class="item-info">
                        <h2 class="title-section">Financing</h2>
                        <div class="btn-wrap">
                            <a href="#" class="btn submit-btn">
                                View More
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-item">
                    <img src="/assets/img/Giant-Sequoia-ING762G.png" alt="#">
                    <div class="item-info">
                        <h4 class="subtitle-section">Understanding</h4>
                        <h2 class="title-section">Manufactured Home Loans</h2>
                        <div class="btn-wrap">
                            <a href="#" class="btn submit-btn">
                                View More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Financing Manufactured section -->


<?php
    // Steps section
    if ( ! empty( $guidelines_list ) ) :
        foreach ( $guidelines_list as $key => $item ) :
            $item_label = "Step {$key}";
            $item_title = $item['guide_title'];
            $item_image = $item['guide_image'];
            $item_desc  = $item['guide_description'];
        endforeach;    
    endif;
    // Steps section end

    // Pages cards section
    if ( ! empty( $pages_link_cards ) ) :
        foreach ( $pages_link_cards as $item ) :
            $small_title     = $item['plc_small_title'];
            $title           = $item['plc_title'];
            $post_to_link_id = $item['plc_post'][0]['id'];
            $post_link       = get_the_permalink( $post_to_link_id );
            $card_image      = $item['plc_image'];
        endforeach;
    endif;
    // Pages cards section end
?>
    <!-- // START Text-banner section -->
    <section class="text-banner-section">
        <div class="container">
            <div class="text-banner-wrap">
                <div class="text-wrap">
                    <h4 class="subtitle-section">Our</h4>
                    <h2 class="title-section">Manufactured Homes</h2>
                    <p class="section-description">
                    The Home Boys have partnered with some of the largest home builders, Clayton Manufacturing, as 1 of their largest volume retailers on the west coast we get their very best pricing and past those saving on to our clients. We sell Golden West Homes, Karsten Homes, Marlette Homes, Schult Homes, Tempo Homes, all Clayton Built products plus we sell Cavco Millersburg (Palm Harbor Homes) and Cavco Nampa (Fleetwood Homes of Idaho).
                    </p>
                </div>

                <div class="banner-wrap">
                    <img src="assets/img/Giant-Sequoia-ING762G.png" alt="#">
                </div>
            </div>
        </div>
    </section>
    <!-- // END Text-banner section -->

    <!-- START partner-section (logo) -->
    <section class="partner-section">
        <div class="container">
            <!-- <h3 class="subtitle-section">Our partner manufactures:</h3> -->
            <div class="partner-wrap">
                <img src="assets/img/clayton-homes-logo.png" alt="clayton-homes">
                <img src="assets/img/golden-west-logo.png" alt="golden-west">
                <img src="assets/img/cavco-millersburg-logo.png" alt="cavco-millersburg">
                <img src="assets/img/marlette-logo.png" alt="marlette">
                <img src="assets/img/cavco-nampa-logo.png" alt="cavco-nampa">
            </div>
        </div>
    </section>
    <!-- END partner-section (logo) -->

    <!-- START text section (Manufactured Home Loans) -->
    <section class="blog-section">
        <div class="container">
            <h4 class="subtitle-section">Understanding</h4>
            <h2 class="title-section">Manufactured Home Loans</h2>

            <h6 class="title-description text-center georgia italic bold">Manufactured Home Financing Options</h6>
            <p class="section-description text-center">Obtaining a mortgage on a manufactured home or mobile home is the first step toward buying your new home, however, options for the manufactured homes can be confusing. The Home Boys team is experienced with options and resources for manufactured home financing. We can help guide you in the right direction, based off of your specific needs. We’ll help you find a loan that’s right for you and your family. Our lenders are extremely knowledgeable in the different types of loans available. Here are some of the different types of loans available to help your purchase your dream home.</p>

            <h5 class="subtitle-description">HOME ONLY FINANCING</h5>
            <p class="section-description">Manufactured homes can be financed in much the same way as a car or personal loan. This loan is designed for customers moving into manufactured home communities or onto land that they don’t own where they will lease their lot instead of purchasing land, family land, or where there is already another home on the property i.e. ADU, dependent care relative exemption or 2nd home on property. On this type of loan, the home is the only collateral however, you can sometime still finance your exterior improvements such as stairs, garage, decks, etc. can be combined into this loan. This loan is on personal property not on real estate, interest rates may be a little higher than a typical real estate loan. Typically, there are little or no closing costs and no prepayment penalty for early pay-off of loan. This also makes an excellent loan for customers who need only short-term financing. We have several lenders who fund these types of loans.</p>
        
            <a href="#" class="btn primary-btn">
                Show All
                <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.90066 9.7689L5.97351 0L4.85651 0L4.83223 9.52L0.874172 5.4629L-4.94673e-09 6.35895L5.48786 11.9841H5.51214L6.36203 11.0881L11 6.33406L10.1258 5.43801L5.90066 9.7689Z"></path>
                </svg>
            </a>

            <!-- PDF download -->
            <div class="plan-download">
                <a href="./directory/yourfile.pdf" download="">
                    <svg width="49" height="64" viewBox="0 0 49 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M48.6597 17.5002C48.8866 18.1669 49 18.7224 49 19.1669L49 62.7689C49 63.4487 48.4515 63.9997 47.775 63.9997C46.6112 63.9996 45.7718 63.9996 45.257 63.9996L1.22525 64C0.548565 64 2.67099e-06 63.4489 1.12616e-08 62.769C9.25971e-05 61.4938 0.000138893 60.5706 0.000138893 59.9996V4.0004C0.000138893 3.42941 9.25966e-05 2.50621 3.33125e-09 1.23081C-4.9343e-05 0.551102 0.548388 4.95787e-05 1.22491 0L31.1355 0.000454049C31.816 0.000454049 32.3264 0.111563 32.6667 0.333783C33.1204 0.556003 33.5174 0.833774 33.8577 1.1671L48.1493 16.5002L48.6597 17.5002ZM32.1903 19.0002H43.0452L30.9653 6.00037V17.7694C30.9653 18.4492 31.5138 19.0002 32.1903 19.0002ZM7.35 44.6515H10.0137V40.8561H12.0375C14.7531 40.8561 16.9326 39.3379 16.9326 36.41V36.3738C16.9326 33.7893 15.1856 32 12.2969 32H7.35V44.6515ZM10.0137 38.38V34.5122H12.0721C13.404 34.5122 14.2342 35.181 14.2342 36.428V36.4642C14.2342 37.5486 13.4558 38.38 12.124 38.38H10.0137ZM18.9044 44.6515H23.6265C27.4318 44.6515 30.061 41.8863 30.061 38.3258V38.2896C30.061 34.7291 27.4318 32 23.6265 32H18.9044V44.6515ZM23.6265 34.5122C25.8059 34.5122 27.2762 36.0846 27.2762 38.3258V38.3619C27.2762 40.6031 25.8059 42.1393 23.6265 42.1393H21.5682V34.5122H23.6265ZM32.4307 44.6515H35.0944V39.7536H40.8716V37.2233H35.0944V34.5303H41.65V32H32.4307V44.6515Z" fill="#D43031"></path>
                    </svg>
                    Fleetwood Option PhotoBook
                </a>
                <a href="./directory/yourfile.pdf" download="">
                    <svg width="49" height="64" viewBox="0 0 49 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M48.6597 17.5002C48.8866 18.1669 49 18.7224 49 19.1669L49 62.7689C49 63.4487 48.4515 63.9997 47.775 63.9997C46.6112 63.9996 45.7718 63.9996 45.257 63.9996L1.22525 64C0.548565 64 2.67099e-06 63.4489 1.12616e-08 62.769C9.25971e-05 61.4938 0.000138893 60.5706 0.000138893 59.9996V4.0004C0.000138893 3.42941 9.25966e-05 2.50621 3.33125e-09 1.23081C-4.9343e-05 0.551102 0.548388 4.95787e-05 1.22491 0L31.1355 0.000454049C31.816 0.000454049 32.3264 0.111563 32.6667 0.333783C33.1204 0.556003 33.5174 0.833774 33.8577 1.1671L48.1493 16.5002L48.6597 17.5002ZM32.1903 19.0002H43.0452L30.9653 6.00037V17.7694C30.9653 18.4492 31.5138 19.0002 32.1903 19.0002ZM7.35 44.6515H10.0137V40.8561H12.0375C14.7531 40.8561 16.9326 39.3379 16.9326 36.41V36.3738C16.9326 33.7893 15.1856 32 12.2969 32H7.35V44.6515ZM10.0137 38.38V34.5122H12.0721C13.404 34.5122 14.2342 35.181 14.2342 36.428V36.4642C14.2342 37.5486 13.4558 38.38 12.124 38.38H10.0137ZM18.9044 44.6515H23.6265C27.4318 44.6515 30.061 41.8863 30.061 38.3258V38.2896C30.061 34.7291 27.4318 32 23.6265 32H18.9044V44.6515ZM23.6265 34.5122C25.8059 34.5122 27.2762 36.0846 27.2762 38.3258V38.3619C27.2762 40.6031 25.8059 42.1393 23.6265 42.1393H21.5682V34.5122H23.6265ZM32.4307 44.6515H35.0944V39.7536H40.8716V37.2233H35.0944V34.5303H41.65V32H32.4307V44.6515Z" fill="#D43031"></path>
                    </svg>
                    Construction Planning Guide
                </a>
            </div>
        </div>
    </section>
    <!-- END text section -->

<?php
    get_template_part( 'template-parts/modules/section', 'partner' );

    if ( ! empty( $content ) ) :
        ?>
        <section>
            <div class="container">
                <div class="content-wrap">
                    <?php echo $content ?>
                </div>
            </div>
        </section>
        <?php
    endif;

    get_template_part( 'template-parts/modules/section', 'contact' );
    get_template_part( 'template-parts/modules/section', 'find_home' );

get_footer();