<?php
/*
 * Template Name: New Dealer Registration
*/
get_header(); 
$new_dealer_application = get_fields(); // get all fields of new dealer application page inside one array
// Banner section
$banner_image = $new_dealer_application['banner_image'];
$mob_banner_image = $new_dealer_application['mobile_banner_image'];
$mob_banner_image_url = (!empty($mob_banner_image)) ? $mob_banner_image['url'] : $banner_image['url'];
$banner_heading = $new_dealer_application['banner_heading'];
// form section
$form_title = $new_dealer_application['form_title'];
$form_sub_title = $new_dealer_application['form_sub_title'];
$form_shortcode = $new_dealer_application['form_shortcode'];
// about section
$about_title = $new_dealer_application['about_title'];
$about_content = $new_dealer_application['about_content'];
// description section
$retailer_image = $new_dealer_application['left_image'];
$retailer_title = $new_dealer_application['retailer_title'];
$retailer_features = $new_dealer_application['retailer_feature'];
$retailer_description = $new_dealer_application['retailer_description'];
// contact section
$contact_title = $new_dealer_application['contact_title'];
$contact_description = $new_dealer_application['contact_description'];
// rilu section
$rilu_description = $new_dealer_application['rilu_description']; ?>
<main class="site-main">
    <!-- banner -->
    <?php if(!empty($banner_image)): ?>
    <div class="product-banner dealer-registration-banner desktop-image" style="background-image: url(<?php echo $banner_image['url']; ?>)">
        <?php if(!empty($banner_heading)): ?> 
		<div class="container">
            <h1><?php echo $banner_heading; ?></h1>
        </div>
        <?php endif; ?>
	</div>
    <div class="product-banner dealer-registration-banner mob-image" style="background-image: url(<?php echo $mob_banner_image_url; ?>)">
        <?php if(!empty($banner_heading)): ?> 
        <div class="container">
            <h1><?php echo $banner_heading; ?></h1>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <!-- dealer form -->
    <?php if(!empty($form_shortcode)): ?>
    <section class="dealer-form">
        <div class="container">
            <div class="form-title">
                <?php if(!empty($form_title)): ?>
                    <h2><?php echo $form_title; ?></h2>
                <?php endif;
                if(!empty($form_sub_title)): ?>
                    <span><?php echo $form_sub_title; ?></span>
                <?php endif; ?>
            </div>
            <!-- start form -->
            <div class="form-section"><?php echo do_shortcode($form_shortcode); ?></div>
            <!-- end form -->
        </div>
    </section>
    <?php endif; ?>
    <!-- looking for more retailer -->
    <?php if(!empty($about_title) && !empty($about_content)): ?>  
    <section class="more-retailer">
        <div class="container">
            <div class="title">
                <h2><?php echo $about_title; ?></h2>
                <span><?php echo $about_content; ?></span>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- supported for -->
    <section class="support-registration">
        <div class="container">
            <div class="two-row-section">
                <div class="col-section">
                    <?php if(!empty($retailer_image)): ?>
                    <div class="left-content">
                        <img src="<?php echo $retailer_image['url']; ?>" alt="<?php echo $retailer_image['alt']; ?>">
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-section">                    
                    <div class="right-content">
                        <?php if(!empty($retailer_title)): ?>
                        <div class="common-title">
                            <span><?php echo $retailer_title; ?></span>
                        </div>
                        <?php endif;                        
                        if(!empty($retailer_features)): ?>
                        <ul class="list">
                        <?php
                            foreach($retailer_features as $retailer_feature_list): ?>
                            <li><?php echo $retailer_feature_list['retailer_feature_list']; ?></li>
                        <?php endforeach; ?>
                        </ul>
                        <?php endif;
                        if(!empty($retailer_description)): ?>
                        <p><?php echo $retailer_description; ?></p>
                        <?php endif;
                        if(!empty($contact_title) && !empty($contact_description)): ?>
                        <div class="common-title">
                            <span><?php echo $contact_title; ?></span>
                        </div>
                        <?php echo $contact_description;
                        endif; ?>
                    </div>
                </div>
            </div>
            <?php if(!empty($rilu_description)): ?>
            <div class="bottom-lines">
                <p><?php echo $rilu_description; ?></p>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>