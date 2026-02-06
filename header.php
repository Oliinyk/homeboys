<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Home_Boys_2
 */

$menu_content = apply_filters( 'hb2_get_menu_items', 'menu-1' );

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header class="site-header">
        <div class="container header-inner">
            <?php
            if ( ! is_front_page() ) :
                ?>
                <a href="/">
                <?php
            endif;
            ?>   
                <img class="logo" src="<?php echo get_stylesheet_directory_uri() . '/assets/img/hb-logo.svg'?>" alt="Home Boys logo">
            <?php
            if ( ! is_front_page() ) :
                ?>    
                </a>
                <?php
            endif;
            ?>

            <?php
            if ( ! empty( $menu_content ) ) :
            ?>
            <nav class="navbar-header main-nav" id="mainNav">
                <ul class="nav-list">
                    <?php
                    foreach ( $menu_content as $item ):
                        $has_children  = ! empty( $item['children'] );
                        $is_current    = $item['object_id'] == get_queried_object_id();

                        if ( $is_current ) {
                            $item['classes'] .= ' current-menu-item';
                        }

                        if ( $has_children ) :
                        ?>
                        <li class="<?php echo esc_attr( $item['classes'] ); ?>" data-id="<?php echo esc_attr( $item['object_id'] ); ?>">
                            <button class="nav-link">
                                <?php echo esc_html( $item['title'] ); ?>
                                <span class="arrow"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ( $item['children'] as $sub_item ):
                                    $is_current_sub = $sub_item['object_id'] == get_queried_object_id();
                                    if ( $is_current_sub ) {
                                        $sub_item['classes'] .= ' current-menu-item';
                                    }
                                ?>
                                <li class="<?php echo esc_attr( $sub_item['classes'] ); ?>" data-id="<?php echo esc_attr( $sub_item['object_id'] ); ?>">
                                    <a href="<?php echo esc_url( $sub_item['url'] ); ?>">
                                        <?php echo esc_html( $sub_item['title'] ); ?>
                                    </a>
                                </li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                        </li>
                        <?php
                        else :
                        ?>
                        <li class="<?php echo esc_attr( $item['classes'] ); ?>" data-id="<?php echo esc_attr( $item['object_id'] ); ?>">
                            <a href="<?php echo esc_url( $item['url'] ); ?>" class="nav-link"><?php echo esc_html( $item['title'] ); ?></a>
                        </li>
                        <?php
                        endif;
                    endforeach;    
                        ?>
                </ul>
            </nav>
            <?php
            endif;
            ?>

            <button class="burger burgerBtn">
                <span class="burger-label">MENU</span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </button>
        </div>
        <div class="dropdown-bg" id="dropdownBg"></div>
    </header>
