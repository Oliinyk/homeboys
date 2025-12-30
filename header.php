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
            <a href="/" class="logo">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/hb-logo.svg'?>" alt="Home Boys logo">
            </a>

            <nav class="navbar-header main-nav" id="mainNav">
                <button class="nav-close" id="closeNav">
                    CLOSE
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <ul class="nav-list">
                    <li class="dropdown has-dropdown">
                        <button class="nav-link">
                            Display Homes
                            <span class="arrow"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Spokane Valley</a></li>
                            <li><a href="#">Tri-Cities</a></li>
                            <li><a href="#">Montana</a></li>
                            <li><a href="#">Sold Homes Galleries</a></li>
                        </ul>
                    </li>

                    <li><a href="#" class="nav-link">Find Your Home</a></li>
                    <li><a href="#" class="nav-link">ADU's</a></li>

                    <li class="dropdown has-dropdown">
                        <button class="nav-link">
                            Process
                            <span class="arrow"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Customer Guidelines</a></li>
                            <li><a href="#">Financing</a></li>
                            <li><a href="#">Understanding Manufactured Home Loans</a></li>
                        </ul>
                    </li>

                    <li class="dropdown has-dropdown">
                        <button class="nav-link">
                            About us
                            <span class="arrow"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Our Team</a></li>
                            <li><a href="#">Blog</a></li>
                        </ul>
                    </li>

                    <li><a href="#" class="nav-link">Contacts</a></li>
                </ul>
            </nav>

            <button class="burger" id="burgerBtn">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>
