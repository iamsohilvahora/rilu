<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rilu-e-bike
 */
?>
	<footer id="colophon" class="site-footer">
		<?php
		/**
		 * Displays the footer widget area.
		 *
		 */
		?>
		<div class="container">
			<div class="top-footer">
				<div class="widget-area">
					<?php dynamic_sidebar('footer-1'); ?>
				</div>
			</div>
			<div class="bottom-footer">
				<div class="widget-area rilu-info">
					<?php dynamic_sidebar('footer-2'); ?>
				</div>

				<div class="widget-area">
					<?php dynamic_sidebar('footer-3'); ?>
				</div>

				<div class="widget-area">
					<?php dynamic_sidebar('footer-4'); ?>
				</div>

				<div class="widget-area">
					<?php dynamic_sidebar('footer-5'); ?>
				</div>
			</div>
			<div class="copy-right">
				<div class="widget-area">
					<?php dynamic_sidebar('footer-6'); ?>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
	<div class="clear"></div>
	<a href="#" class="scroll_top"><i class="fa fa-arrow-up"></i></a>
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>