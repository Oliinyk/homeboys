<?php
get_header();

$p_id = get_the_ID();
?>
    <div class="nav-overlay" id="navOverlay"></div>

    <?php
    get_template_part( 'template-parts/modules/section', 'home_hero', ['id' => $p_id] );
    get_template_part( 'template-parts/modules/section', 'welcome', ['id' => $p_id] );
    get_template_part( 'template-parts/modules/section', 'partner' );
    get_template_part( 'template-parts/modules/section', 'contact' );
    get_template_part( 'template-parts/modules/section', 'our_people' );
    get_template_part( 'template-parts/modules/section', 'blog' );
    get_template_part( 'template-parts/modules/section', 'dark_home' );

get_footer();