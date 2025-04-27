<?php
/*
 * Template Name: About Us
*/
get_header();
$about = get_fields(); // get all fields of about page inside one array
// Banner section
$banner_image = $about['banner_image'];
$mob_banner_image = $about['mobile_banner_image'];
$mob_banner_image_url = (!empty($mob_banner_image)) ? $mob_banner_image['url'] : $banner_image['url'];
$banner_heading = $about['banner_heading'];
$banner_subheading = $about['banner_subheading'];
$banner_button = $about['banner_button'];
$banner_button_label = $banner_button['button_label'];
$banner_button_link = button_group($banner_button);
// about section
$about_title = $about['about_title'];
$about_content = $about['about_content'];
// description section
$left_description = $about['left_description'];
$description_image = $about['description_image'];
// retailer section
$retailer_title = $about['retailer_title'];
$retailer_content = $about['retailer_content'];
// legalisation section
$legal_title = $about['legal_title'];
$legal_contents = $about['legal_content'];
// team section
$team_title = $about['team_title'];
$team_description = $about['team_description'];
// rilu section
$rilu_description = $about['rilu_description']; ?>
<main class="site-main">
	<?php if(!empty($banner_image)): ?>
	<div class="product-banner about-banner desktop-image" style="background-image: url(<?php echo $banner_image['url']; ?>)"> 
		<div class="container">
			<?php if(!empty($banner_heading)): ?>
				<h2><?php echo $banner_heading; ?></h2>
			<?php endif;
			if(!empty($banner_subheading)): ?>
				<p><?php echo $banner_subheading; ?></p>
			<?php endif;
			if(!empty($banner_button_label) && !empty($banner_button_link)): ?>
			<a class="theme-button" <?php echo $banner_button_link; ?>><?php  echo $banner_button_label; ?></a>
			<?php endif; ?>
		</div>
	</div>
	<div class="product-banner about-banner mob-image" style="background-image: url(<?php echo $mob_banner_image_url; ?>)"> 
		<div class="container">
			<?php if(!empty($banner_heading)): ?>
				<h2><?php echo $banner_heading; ?></h2>
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
	if(!empty($about_title) && !empty($about_content)): ?>
	<section class="top-line-about">
		<div class="container">
			<h1><?php echo $about_title; ?></h1>
			<p><?php echo $about_content; ?></p>
		</div>
	</section>
	<?php endif; ?>
	<section class="about-content">
		<div class="container">
			<div class="two-row-section">
				<div class="col-section">
				<?php if(!empty($left_description)):
					echo $left_description;
				endif; ?>
				</div>
				<div class="col-section">
					<?php if(!empty($description_image)): ?>
					<img src="<?php echo $description_image['url']; ?>" alt="<?php echo $description_image['alt']; ?>">
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php if(!empty($retailer_title) && !empty($retailer_content)): ?>
	<section class="middle-lines">
		<div class="container">
			<h2><?php echo $retailer_title; ?></h2>
			<p><?php echo $retailer_content; ?></p>
		</div>
	</section>
	<?php endif;
	if(!empty($legal_contents)): ?>
	<section class="street-legal">
		<div class="container">
			<?php if(!empty($legal_title)): ?>
			<div class="container">
            	<div class="title">
                	<h1><?php echo $legal_title; ?></h1>
            	</div>
        	</div>
			<?php endif; ?>
			<div class="two-row-section">
				<?php foreach($legal_contents as $content): ?>
				<div class="col-section">
					<div class="content-section">
						<div class="image">
							<img src="<?php echo $content['image']['url']; ?>" alt="<?php echo $content['image']['alt']; ?>">
						</div>
						<div class="content">
							<h3><?php echo $content['title']; ?></h3>
							<p><?php echo $content['description']; ?></p>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif;
	if(!empty($team_description)): ?>
	<section class="e-bilke-team">
		<?php if(!empty($team_title)): ?>
		<div class="common-title">
			<span><?php echo $team_title; ?></span>
		</div>
		<?php endif; ?>

		<div class="container">
			<div class="team-slider">
				<?php foreach($team_description as $team_person): ?>
				<div class="content">
					<p><?php echo $team_person['team_person_information']; ?></p>
					<div class="bottom-name">
						<div class="name"><?php echo $team_person['team_person_name']; ?></div>
						<div class="designation"><?php echo $team_person['team_person_designation']; ?></div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif;
	if(!empty($rilu_description)): ?>
	<section class="about-bottom">
		<div class="container">
			<div class="bottom-lines">
				<p><?php echo $rilu_description; ?></p>
			</div>
		</div>
	</section>
	<?php endif; ?>
</main>
<?php get_footer(); ?>