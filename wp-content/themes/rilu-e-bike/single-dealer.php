<?php
/**
 * The template for displaying all single posts (Dealer's detail)
*/
get_header();
$dealer_post_id = get_the_id(); // get single post id
$delaer = get_fields(); // get all fields of single dealer-detail-page inside one array
// Banner section
$banner_image = $delaer['banner_image'];
$mob_banner_image = $delaer['mobile_banner_image'];
$mob_banner_image_url = (!empty($mob_banner_image)) ? $mob_banner_image['url'] : $banner_image['url'];
// Map section
$latitude = $delaer['latitude'];
$longitude = $delaer['longitude'];
// Dealer section
$dealer_postcode = $delaer['dealer_postcode'];
$dealer_title = $delaer['dealer_title'];
$dealer_sub_title = $delaer['dealer_sub_title'];
$dealer_address = $delaer['dealer_address'];
$dealer_phone = $delaer['dealer_phone'];
$dealer_email = $delaer['dealer_email'];
$dealer_site_link = $delaer['dealer_site_link'];
$dealer_description = $delaer['dealer_description']; ?>
<main class="site-main">
    <!-- banner -->
    <?php if(!empty($banner_image)): ?>
    <div class="product-banner dealer-detail-banner desktop-image" style="background-image: url(<?php echo $banner_image['url']; ?>)">
        <div class="container">
            <?php if(!empty($dealer_title)): ?>
				<h1><?php echo $dealer_title; ?></h1>
			<?php endif;
			if(!empty($dealer_sub_title)): ?>
				<p><?php echo $dealer_sub_title; ?></p>
			<?php endif; ?>
        </div>
    </div>
    <div class="product-banner dealer-detail-banner mob-image" style="background-image: url(<?php echo $mob_banner_image_url; ?>)">
        <div class="container">
            <?php if(!empty($dealer_title)): ?>
                <h1><?php echo $dealer_title; ?></h1>
            <?php endif;
            if(!empty($dealer_sub_title)): ?>
                <p><?php echo $dealer_sub_title; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <!-- address info -->
    <section class="address-info">
        <div class="container">
            <div class="two-row-section">
                <div class="col-section">
                    <div class="map-area">
						<?php if(!empty($latitude) && !empty($longitude)): ?>
                    		<input type="hidden" class="dealer_lat" value="<?php echo $latitude; ?>" data-addr="<?php echo $dealer_address; ?>" />
                    		<input type="hidden" class="dealer_long" value="<?php echo $longitude; ?>" />
                        	<div id="dealer_map_canvas"></div>
                    	<?php else: ?>
                    		<div>Please enter latitude and longitude to see location.</div>	
						<?php endif; ?>
                    </div>
                </div>
                <div class="col-section">
                    <div class="contact-area">
                        <div class="contact-info">
                        	<?php if(!empty($dealer_title)): ?>
                            <h2><?php echo $dealer_title; ?></h2>
                            <?php endif;
                            if(!empty($dealer_address)): ?>
                            <div class="contact-line">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/location.svg" alt="">
                                <span><?php echo $dealer_address; ?></span>
                            </div>
                            <?php endif;
                            if(!empty($dealer_phone)): ?>
                            <div class="contact-line">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/phone.svg" alt="">
                                <span><a href="tel:<?php echo $dealer_phone; ?>"><?php echo $dealer_phone; ?></a></span>
                            </div>
                            <?php endif;
                            if(!empty($dealer_email)): ?>
                            <div class="contact-line">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/email.svg" alt="">
                                <span><a href="mailto:<?php echo $dealer_email; ?>"><?php echo $dealer_email; ?></a></span>
                            </div>
                            <?php endif;
                            if(!empty($dealer_site_link)): ?>
                            <div class="contact-line">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/website.svg" alt="">
                                <span><a href="<?php echo $dealer_site_link; ?>" target="_blank"><?php echo $dealer_site_link; ?></a></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- description section -->
	<?php if(!empty($dealer_description)): ?>
    <section class="dealer-description">
        <div class="container">
            <h3>Description</h3>
            <?php echo $dealer_description; ?>
        </div>
    </section>
	<?php endif; ?>
</main>
<?php get_footer(); ?>