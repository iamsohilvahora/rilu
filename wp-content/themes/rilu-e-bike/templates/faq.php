<?php
/*
 * Template Name: FAQ
*/
get_header();
$faq = get_fields(); // get all fields of faq page inside one array
// Banner section
$banner_image = $faq['banner_image'];
$mob_banner_image = $faq['mobile_banner_image'];
$mob_banner_image_url = (!empty($mob_banner_image)) ? $mob_banner_image['url'] : $banner_image['url'];
$banner_heading = $faq['banner_heading'];
$banner_subheading = $faq['banner_subheading'];
$banner_button = $faq['banner_button'];
$banner_button_label = $banner_button['button_label'];
$banner_button_link = button_group($banner_button);
// Get in touch section
$rilu_description = $faq['rilu_description']; 
// FAQs list section
$faqs_list = $faq['faqs_list']; ?>
<main class="site-main">
    <?php if(!empty($banner_image)): ?>
    <div class="product-banner faq-banner desktop-image" style="background-image: url(<?php echo $banner_image['url']; ?>)"> 
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
    <div class="product-banner faq-banner mob-image" style="background-image: url(<?php echo $mob_banner_image_url; ?>)"> 
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
    <!-- top-content -->
    <?php if(!empty($rilu_description)): ?>
    <section class="faq-top-lines">
        <div class="container">
            <p><?php echo $rilu_description; ?></p>
        </div>
    </section>
    <?php endif; ?>
    <!-- faq section -->
    <?php if(!empty($faqs_list)): ?>
    <section class="faq-section">
        <div class="container">
            <ul class="accordion-list">
                <?php foreach($faqs_list as $faq): 
                    $faq_title = $faq['faq_title'];
                    $faq_answer = $faq['faq_answer'];
                    if(!empty($faq_title) && !empty($faq_answer)): ?>
                    <li>
                        <h3><?php echo $faq_title; ?></h3>
                        <div class="answer">
                            <?php echo $faq_answer; ?>     
                        </div>
                    </li>
                    <?php endif;
                        endforeach; ?>
            </ul>
        </div>
    </section>
    <?php endif; ?>
</main>
<?php get_footer(); ?>