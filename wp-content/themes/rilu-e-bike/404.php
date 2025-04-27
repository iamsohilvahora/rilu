<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package rilu-e-bike
 */
get_header();
?>
<main id="primary" class="site-main">
	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( '404', 'rilu-e-bike' ); ?></h1>
			<p class="page-subtitle"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'rilu-e-bike' ); ?></p>
		</header><!-- .page-header -->
		<div class="page-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links or go back to home.', 'rilu-e-bike' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="theme-button">Back to Home</a>
		</div><!-- .page-content -->
	</section><!-- .error-404 -->
</main><!-- #main -->
<?php
get_footer();