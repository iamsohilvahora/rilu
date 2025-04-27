<?php
/*
 * Template Name: Customer Photos & Reviews Page
*/
get_header();
$customer_photos_review = get_fields(); // get all fields of customer photos & reviews page inside one array
// Banner section
$banner_image = $customer_photos_review['banner_image'];
$mob_banner_image = $customer_photos_review['mobile_banner_image'];
$mob_banner_image_url = (!empty($mob_banner_image)) ? $mob_banner_image['url'] : $banner_image['url'];
$banner_heading = $customer_photos_review['banner_heading'];
$banner_subheading = $customer_photos_review['banner_subheading'];
$banner_button = $customer_photos_review['banner_button'];
$banner_button_label = $banner_button['button_label'];
$banner_button_link = button_group($banner_button);
//google review section
$review_shortcode = $customer_photos_review['review_shortcode'];
$placeId = "ChIJJz65xtFd1moRuPXlzJsoPuo";
// customer slider section
$customer_sliders = $customer_photos_review['customer_slider'];
// rilu section
$rilu_description = $customer_photos_review['rilu_description']; ?>
<main class="site-main">
	<?php
	if(!empty($banner_image)): ?>
	<div class="product-banner customer-review-banner desktop-image" style="background-image: url(<?php echo $banner_image['url']; ?>)"> 	
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
	<div class="product-banner customer-review-banner mob-image" style="background-image: url(<?php echo $mob_banner_image_url; ?>)"> 
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
	<?php endif;
	if(!empty($review_shortcode)): ?>
	<section class="customer-review-section">
		<div class="container">
			<?php echo do_shortcode($review_shortcode); ?>
			<div class="review-us-btn">
				<a href="https://search.google.com/local/writereview?placeid=<?php echo $placeId; ?>" target="_blank" class="theme-button">Review Us</a>
			</div>
		</div>
	</section>
	<?php endif;
	if(!empty($customer_sliders)): ?>
	<section class="review-slider-section">
		<div class="container">
			<div class="review-slider">
			<?php 
			foreach($customer_sliders as $customer_slider): 
				$customer_image = $customer_slider['customer_image'];
				$customer_details = $customer_slider['customer_details'];
				if(!empty($customer_image) && !empty($customer_details)): ?>
				<div class="slide-content">
					<div class="two-row-section">
						<div class="col-section">
							<img src="<?php echo $customer_image['url']; ?>" alt="<?php echo $customer_image['alt']; ?>">
						</div>
						<div class="col-section">
							<p><?php echo $customer_details; ?></p>
						</div>
					</div>
				</div>
			<?php endif;
			endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif;
	if(!empty($rilu_description)): ?>
	<section class="review-bottom-line">
		<div class="container">
			<p><?php echo $rilu_description; ?></p>
		</div>
	</section>
	<?php endif; ?>
</main>
<?php get_footer(); ?>