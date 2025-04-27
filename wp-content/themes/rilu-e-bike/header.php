<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rilu-e-bike
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="icon" type="image/x-icon" href="<?php echo get_field('favicon', 'options'); ?>"/>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open();
$options = get_fields('options');
$header_logo = $options['header_logo']; // get header logo
$toll_free_title = $options['toll_free_title']; // get toll free title
$toll_free_number = $options['toll_free_number']; // get toll free number
$email_address = $options['e-mail']; // get email address
$find_dealer_title = $options['find_dealer_title']; // get dealer title
$find_dealer_link = $options['find_dealer_link']; // get dealer link ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'rilu-e-bike' ); ?></a>
	<div class="top-line">
		<div class="container">
			<ul class="line-contant">
				<?php if(!empty($toll_free_title) && !empty($toll_free_number)): ?>	
				<li><a href="tel:<?php echo $toll_free_number; ?>"><?php echo $toll_free_title; ?></a></li>
				<?php endif;
				if(!empty($email_address)): ?>
				<li><a href="mailto:<?php echo $email_address; ?>"><?php echo $email_address; ?></a></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
	<header id="masthead" class="site-header"><!-- .site-branding -->
		<nav id="site-navigation" class="main-navigation">
			<div class="menu-left">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'rilu-e-bike' ); ?><span class="navbar-toggler-icon"></span></button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'Left Primary',
					)
				);
				?>
			</div>
			<div class="site-branding">
					<p class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php if(!empty($header_logo)): ?>
							<img src="<?php echo $header_logo['url']; ?>" alt="<?php echo $header_logo['alt']; ?>">
						<?php else:	
							bloginfo('name'); ?>
						<?php endif; ?>
						</a>
					</p>	
			</div>
			<div class="menu-right">
				<button class="menu-toggle" aria-controls="secondary-menu" aria-expanded="false"><?php esc_html_e( 'Secondary Menu', 'rilu-e-bike' ); ?></button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-2',
						'menu_id'        => 'Right Primary',
					)
				);
				?>
				<?php if(!empty($find_dealer_title) && !empty($find_dealer_link)): ?>	
				<span class="button-area">
					<a href="<?php echo $find_dealer_link; ?>" class="theme-button header-button"><?php echo $find_dealer_title; ?></a>
				</span>
				<?php endif; ?>
			</div>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
