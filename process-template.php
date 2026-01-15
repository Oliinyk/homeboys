<?php
/**
 * Template name: Process Template
 */
$p_ID = get_the_ID();

$inlude_processes = carbon_get_post_meta( $p_ID, 'include_process_posts' );

$processes_section_title = carbon_get_post_meta( $p_ID, 'process_block_title' );
$processes_section_desc  = carbon_get_post_meta( $p_ID, 'process_block_desc' );
$processes_section_args  = [
    'title'       => $processes_section_title,
    'description' => $processes_section_desc,
];

$content = get_the_content();

get_header();
?>
    <!-- Finansing dark section -->
    <?php
    if ( ! empty( $inlude_processes ) ) :
        get_template_part( 'template-parts/modules/section', 'processes_posts', $processes_section_args );
    endif;    
    ?>

    <section class="financing-section dark-section">
        <div class="container">
            <div class="financing-list card-list sm-col-2 md-col-3">
                <!-- 1 -->
                <div class="financing-item">
                    <h3 class="item-title">21 St Mortgage</h3>
                    <div class="contact-info">
                        <div><a href="tel:800-955-0021">800-955-0021</a></div>
                        <div><a href="http://www.21stmortgage.com">www.21stmortgage.com</a></div>
                        <div><p>our retailer # 1270-2</p></div>
                    </div>
                    <div class="contact-description">
                        Do home only, land home, land in lieu, co-sign program, vacation home, low to no credit (with big down payment), Alternate income, plus more.
                    </div>
                </div>
                <!-- 2 -->
                <div class="financing-item">
                    <h3>Banner Bank</h3>
                    <div class="contact-info">
                        <div><span>Lisa Knight</span><a href="tel:800-955-0021">800-955-0021</a></div>
                        <div><a href="lisa.knight@bannerbank.com">lisa.knight@bannerbank.com</a></div>
                        <div><span>Chad Kubik</span><a href="tel:509-347-6794">509-347-6794</a></div>
                    </div>
                    <div class="contact-description">Land Home 5% down Land/Home Program.</div>
                </div>
                <!-- 3 -->
                <div class="financing-item">
                    <h3>21 St Mortgage</h3>
                    <div class="contact-info">
                        <div><a href="tel:360-709-9191">360-709-9191</a>or<a href="tel:360-556-9915">360-556-9915</a></div>
                        <div><a href="http://www.21stmortgage.com">www.21stmortgage.com</a></div>
                        <div><a href="#">our retailer # 1270-2</a></div>
                    </div>
                    <div class="contact-description">
                        FHA, VA, USDA Rural, & Conventional Construction loans.
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Finansing dark section end -->

    <!-- Content -->
    <?php
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
    ?>
    <!-- Content end -->

    <?php
        get_template_part( 'template-parts/modules/section', 'contact' );
        get_template_part( 'template-parts/modules/section', 'find_home' );
    ?>
<?php
get_footer();