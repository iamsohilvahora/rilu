<?php
/*
 * Template Name: Contact
*/
get_header();
$contact = get_fields(); // get all fields of contact page inside one array
// Get in touch section
$rilu_description = $contact['rilu_description'];
// form section
$form_title = $contact['form_title'];
$form_sub_title = $contact['form_sub_title'];
$form_shortcode = $contact['form_shortcode'];
// contact section
$telephone = $contact['telephone'];
$email_address = $contact['email_address'];
$phone_and_toll_info = $contact['phone_and_toll_info'];
$address = $contact['address']; ?>
<main class="site-main">
    <!-- map-section -->
    <div class="map-area">
        <div id="map_canvas"></div>
    </div>
    <!-- top-content -->
    <?php if(!empty($rilu_description)): ?>
    <section class="contact-top-lines">
        <div class="container">
            <p><?php echo $rilu_description; ?></p>
        </div>
    </section>
    <?php endif; ?>
    <!-- contact form -->
    <section class="contact-detail-section">
        <div class="container">
            <div class="two-row-section">
                <div class="col-section">
                    <?php if(!empty($form_shortcode)): ?>
                    <div class="form-title">
                        <?php if(!empty($form_title)): ?>
                            <h2><?php echo $form_title; ?></h2>
                        <?php endif;
                        if(!empty($form_sub_title)): ?>
                            <span><?php echo $form_sub_title; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="contact-form">
                        <?php echo do_shortcode($form_shortcode); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-section">
                    <div class="contact-info">
                        <?php if(!empty($telephone)): ?>
                        <div class="contact-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/phone.svg" alt="Telephone">
                            <div class="info">
                                <p><a href="tel:<?php echo $telephone; ?>"><?php echo $telephone; ?></a></p>
                            </div>
                        </div>
                        <?php endif;
                        if(!empty($email_address)): ?>
                        <div class="contact-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/email.svg" alt="Eamil Address">
                            <div class="info">
                                <p><a href="mailto:<?php echo $email_address; ?>"><?php echo $email_address; ?></a></p>
                            </div>
                        </div>
                        <?php endif;
                        if(!empty($phone_and_toll_info)): ?>
                        <div class="contact-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/phone.svg" alt="Toll Free Number">
                            <div class="info">
                                <?php echo $phone_and_toll_info; ?>
                            </div>
                        </div>
                        <?php endif;
                        if(!empty($address)): ?>
                        <div class="contact-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/location.svg" alt="Location Address">
                            <div class="info">
                                <?php echo $address; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>