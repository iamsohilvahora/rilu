<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package rilu-e-bike
 */
get_header(); //get header
$blog_id = get_the_id(); // get single blog id
$blog = get_fields(); // get all fields of single blog page inside one array
// Banner section
$banner_image = $blog['banner_image'];
$mob_banner_image = $blog['mobile_banner_image'];
$mob_banner_image_url = (!empty($mob_banner_image)) ? $mob_banner_image['url'] : $banner_image['url'];
$banner_heading = $blog['banner_heading'];
$banner_subheading = $blog['banner_subheading'];
$banner_button = $blog['banner_button'];
$banner_button_label = $banner_button['button_label'];
$banner_button_link = button_group($banner_button);
// get blog content
$blog_content = $blog['blog_content'];
// Service section
$rilu_services = $blog['rilu_services']; ?>
<main id="primary" class="site-main">
	<?php if(!empty($banner_image)): ?>
	<div class="product-banner blog-banner desktop-image" style="background-image: url(<?php echo $banner_image['url']; ?>)"> 
		<div class="container">
			<?php if(!empty($banner_heading)): ?>
				<h1><?php echo $banner_heading; ?></h1>
			<?php endif;
			if(!empty($banner_subheading)): ?>
				<p><?php echo $banner_subheading; ?></p>
			<?php endif;
			if(!empty($banner_button_label) && !empty($banner_button_link)): ?>
			<a class="theme-button" <?php echo $banner_button_link; ?>><?php  echo $banner_button_label; ?></a>
			<?php endif; ?>
		</div>
	</div>
	<div class="product-banner blog-banner mob-image" style="background-image: url(<?php echo $mob_banner_image_url; ?>)"> 
		<div class="container">
			<?php if(!empty($banner_heading)): ?>
				<h1><?php echo $banner_heading; ?></h1>
			<?php endif;
			if(!empty($banner_subheading)): ?>
				<p><?php echo $banner_subheading; ?></p>
			<?php endif;
			if(!empty($banner_button_label) && !empty($banner_button_link)): ?>
			<a class="theme-button" <?php echo $banner_button_link; ?>><?php  echo $banner_button_label; ?></a>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
	<section class="full-blog-section">
		<div class="container">
			<div class="common-title">
				<h1><?php echo get_the_title(); ?></h1>
			</div>
			<div class="full-row">
				<div class="left-section">
					<div class="blog-image">
						<?php 
							if(has_post_thumbnail($blog_id)):
							/* display featured image */                                
							echo '<a href='.get_the_permalink($blog_id).'>'; 
							    echo get_the_post_thumbnail($blog_id, 'blog-first-img');
							echo '</a>';
							else:
							    echo wp_get_attachment_image(998, 'blog-first-img');
							endif; ?>					
					</div>
				</div>
				<div class="right-section">
					<?php get_sidebar(); ?>
				</div>
			</div>
			<div class="blog-detail">
				<?php 
				if(!empty($blog_content)):
					echo $blog_content; 
				endif;
				if(!empty($rilu_services)): 
					foreach($rilu_services as $service):
						$service_title = $service['service_title'];
						$service_content = $service['service_content'];
						if(!empty($service_title) && !empty($service_content)): ?>
						<div class="content-with-title">
							<h2><?php echo $service_title; ?></h2>
							<?php echo $service_content; ?>
						</div>
				<?php endif; 
					endforeach; 
				endif; ?>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>