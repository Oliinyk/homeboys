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

$nav_menu_items = wp_get_nav_menu_items( 'menu-1' );
$menu_content = [];

if ( ! empty( $nav_menu_items ) ) {
    foreach ( $nav_menu_items as $item ) {
        $item_id = $item->ID;
        $parent_id = $item->menu_item_parent;

        if ( $parent_id == 0 ) {
            // This is a top-level item
            $menu_content[ $item_id ] = [
                'classes' => 'dropdown has-dropdown',
                'title' => $item->title,
                'url'   => $item->url,
                'children' => [],
            ];
        } else {
            // This is a child item
            if ( isset( $menu_content[ $parent_id ] ) ) {
                $menu_content[ $parent_id ]['children'][] = [
                    'title' => $item->title,
                    'url'   => $item->url,
                ];
            }
        }
        
    }
};

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
            if ( ! empty( $nav_menu_items ) ) :
            ?>
            <nav class="navbar-header main-nav" id="mainNav">
                <ul class="nav-list">
                    <?php
                    foreach ( $menu_content as $item ):
                        $has_children  = ! empty( $item['children'] );

                        if ( $has_children ) :
                        ?>
                        <li class="<?php echo esc_attr( $item['classes'] ); ?>">
                            <button class="nav-link">
                                <?php echo esc_html( $item['title'] ); ?>
                                <span class="arrow"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ( $item['children'] as $sub_item ):
                                ?>
                                <li><a href="<?php echo esc_url( $sub_item['url'] ); ?>"><?php echo esc_html( $sub_item['title'] ); ?></a></li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                        </li>
                        <?php
                        else :
                        ?>
                        <li><a href="<?php echo esc_url( $item['url'] ); ?>" class="nav-link"><?php echo esc_html( $item['title'] ); ?></a></li>
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
