<?php
/*
 * Template Name: State Dealer Page
*/
get_header(); 
global $post;
$dealer = get_fields(); // get all fields of dealer page inside one array
// get state dealer pages
$options = get_fields('options');
$dealer_state_pages = $options['dealer_state_pages'];
// Banner section
$banner_image = $dealer['banner_image'];
$mob_banner_image = $dealer['mobile_banner_image'];
$mob_banner_image_url = (!empty($mob_banner_image)) ? $mob_banner_image['url'] : $banner_image['url'];
$banner_heading = $dealer['banner_heading'];
// Dealer section
$dealer_title = $dealer['dealer_title'];
// $dealer_details = $dealer['dealer_details'];
$dealer_state_id = $dealer['select_dealer_state'];
$args = array(
    'post_type' => 'dealer',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order'   => 'ASC',
    'tax_query' => array(
        array(
            'taxonomy' => 'state',
            'field'    => 'term_id',
            'terms'    => $dealer_state_id,
        ),
    ),
);
$the_query = new WP_Query($args); // The query
$total_dealer_post = $the_query->found_posts; // get total post

// dealer information
$dealer_information = $dealer['dealer_information'];
$rilu_information = $dealer['rilu_information'];
// get nearest dealer info using entered address
if(isset($_GET['addressInput'])){
    $addressInput = $_GET['addressInput'];
    $places_postcode_arr = wp_get_nearest_dealer_info($addressInput);
}
if(empty($addressInput)){
    unset($_COOKIE['set_select_postcode']);
} 
?>
<main class="site-main">
    <!-- banner -->
    <div class="product-banner dealer-banner desktop-image" style="background-image: url(<?php echo $banner_image['url']; ?>)">
        <div class="container">
            <?php if(!empty($banner_heading)): ?>
                <h2><?php echo $banner_heading; ?></h2>
            <?php endif; ?>
            <div class="search-area">
                <form method="get" class="dealer_postcode_form" action="<?php echo get_site_url().'/dealer/'; ?>">
                    <div class="pincode-dropdown dealer_form"><button type="button" class="btn1"><?php if(isset($_COOKIE['set_select_postcode'])){ echo $_COOKIE['set_select_postcode']; }else{ echo "Search Postcode"; } ?></button>
                        <div class="close-wrapper" <?php if(!isset($_COOKIE['set_select_postcode'])){ ?>style="display: none;"<?php } ?>><a class="close-search" href="javascript:void(0)">×</a></div>
                        <ul class="search-wrapper">
                            <li class="searchInput">
                                <input type="text" name="addressInput" class="postcode" value="<?php if(isset($_COOKIE['set_select_postcode'])): echo $_COOKIE['set_select_postcode']; endif; ?>" placeholder="Search Postcode" autocomplete="off">
                            </li>
                            <div class="show_dealer_location"></div>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Mobile banner -->
    <div class="product-banner dealer-banner mob-image" style="background-image: url(<?php echo $mob_banner_image_url; ?>)">
        <div class="container">
            <?php if(!empty($banner_heading)): ?>
                <h2><?php echo $banner_heading; ?></h2>
            <?php endif; ?>
            <div class="search-area">
                <form method="get" class="mobile_dealer_postcode_form" action="<?php echo get_site_url().'/dealer/'; ?>">
                    <div class="pincode-dropdown mobile_dealer_form"><button type="button" class="btn1"><?php if(isset($_COOKIE['set_select_postcode'])){ echo $_COOKIE['set_select_postcode']; }else{ echo "Search Postcode"; } ?></button>
                        <div class="close-wrapper" <?php if(!isset($_COOKIE['set_select_postcode'])){ ?>style="display: none;"<?php } ?>><a class="close-search" href="javascript:void(0)">×</a></div>
                        <ul class="search-wrapper">
                            <li class="searchInput">
                                <input type="text" name="addressInput" class="mobile_postcode" value="<?php if(isset($_COOKIE['set_select_postcode'])): echo $_COOKIE['set_select_postcode']; endif; ?>" placeholder="Search Postcode" autocomplete="off">
                            </li>
                            <div class="show_dealer_location"></div>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Default links section-->
    <section class="dealer-section">
        <?php if(!empty($dealer_state_pages)): ?>
        <div class="container border-bottom">
            <ul class="links-section">
                <?php
                    foreach($dealer_state_pages as $page):
                        $dealer_state_page = $page['dealer_state_page']; ?>
                    <li class="<?php echo ($post->post_name == $dealer_state_page->post_name) ? 'active' : ''; ?>"><a href="<?php echo get_the_permalink($dealer_state_page->ID); ?>"><?php echo $page['dealer_state_page_name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <!-- VIC -->
        <div class="selected-view">
            <?php if(!empty($dealer_title)): ?>
            <div class="container">
                <div class="dealer-title">
                    <h1><?php echo $dealer_title; ?></h1>
                </div>
            </div>
            <?php endif;
            if($total_dealer_post > 0): ?>
            <div class="show-dealer-section">
                <?php if(!isset($_GET['addressInput']) && empty($_GET['addressInput'])): ?>
                <div class="result-count">Showing <?php echo $total_dealer_post; ?> dealerships for <?php echo $post->post_title; ?></div>
                <?php endif; ?>
                <div class="show-dealer-result">
                    <div class="container">
                        <div class="result-section">
                            <?php
                                $placesZipcode = false;
                                if(isset($_GET['addressInput']) && !empty($_GET['addressInput'])){
                                    if(!empty($places_postcode_arr)){
                                        while($the_query->have_posts()):
                                            $the_query->the_post();
                                            $dealer->ID = get_the_id();
                                            $postcode = get_field('dealer_postcode', $dealer->ID);
                                            $title = get_field('dealer_title', $dealer->ID);
                                            $sub_title = get_field('dealer_sub_title', $dealer->ID);
                                            $address = get_field('dealer_address', $dealer->ID);
                                            $phone = get_field('dealer_phone', $dealer->ID);
                                            $email = get_field('dealer_email', $dealer->ID);
                                            $site_link = get_field('dealer_site_link', $dealer->ID);
                                            $location = get_field('location_link', $dealer->ID); 
                                            if(in_array($postcode, $places_postcode_arr)): ?>
                                            <div class="result">
                                                <div class="result-items">
                                                    <?php if(!empty($title)): ?>
                                                        <a class="title" href="<?php echo get_the_permalink($dealer->ID); ?>"><?php echo $title; ?></a>
                                                    <?php endif; 
                                                    if(!empty($sub_title)): ?>
                                                        <span><?php echo $sub_title; ?></span>
                                                    <?php endif; ?> 
                                                    <div class="contact-detail">
                                                        <?php if(!empty($address)): ?>
                                                            <p><?php echo $address; ?></p>
                                                        <?php endif; 
                                                        if(!empty($address)): ?>
                                                            <p>Phone: <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></p>
                                                        <?php endif;
                                                        if(!empty($email)): ?>
                                                            <p><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if(!empty($site_link)): ?>
                                                    <div class="visit-website">
                                                        <a href="<?php echo $site_link; ?>" target="_blank">visit website <img src="<?php echo get_template_directory_uri(); ?>/assets/images/right-arrow.svg" alt="right_arrow"></a>
                                                    </div>
                                                    <?php endif;
                                                    if(!empty($location)): ?>
                                                    <div class="directions">
                                                        <a href="<?php echo $location; ?>" target="_blank">directions <img src="<?php echo get_template_directory_uri(); ?>/assets/images/right-arrow.svg" alt="right_arrow"></a>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                <?php   $placesZipcode = true; endif; endwhile; 
                                        wp_reset_postdata();
                                        } }
                                // elseif(isset($_GET['addressInput']) && empty($_GET['addressInput'])){ }
                                else{ ?>
                                    <?php 
                                        while($the_query->have_posts()):
                                            $the_query->the_post();
                                            $dealer->ID = get_the_id();
                                            $postcode = get_field('dealer_postcode', $dealer->ID);
                                            $title = get_field('dealer_title', $dealer->ID);
                                            $sub_title = get_field('dealer_sub_title', $dealer->ID);
                                            $address = get_field('dealer_address', $dealer->ID);
                                            $phone = get_field('dealer_phone', $dealer->ID);
                                            $email = get_field('dealer_email', $dealer->ID);
                                            $site_link = get_field('dealer_site_link', $dealer->ID);
                                            $location = get_field('location_link', $dealer->ID); ?>
                                            <div class="result">
                                                <div class="result-items">
                                                    <?php if(!empty($title)): ?>
                                                        <a class="title" href="<?php echo get_the_permalink($dealer->ID); ?>"><?php echo $title; ?></a>
                                                    <?php endif; 
                                                    if(!empty($sub_title)): ?>
                                                        <span><?php echo $sub_title; ?></span>
                                                    <?php endif; ?> 
                                                    <div class="contact-detail">
                                                        <?php if(!empty($address)): ?>
                                                            <p><?php echo $address; ?></p>
                                                        <?php endif; 
                                                        if(!empty($address)): ?>
                                                            <p>Phone: <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></p>
                                                        <?php endif;
                                                        if(!empty($email)): ?>
                                                            <p><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if(!empty($site_link)): ?>
                                                    <div class="visit-website">
                                                        <a href="<?php echo $site_link; ?>" target="_blank">visit website <img src="<?php echo get_template_directory_uri(); ?>/assets/images/right-arrow.svg" alt="right_arrow"></a>
                                                    </div>
                                                    <?php endif;
                                                    if(!empty($location)): ?>
                                                    <div class="directions">
                                                        <a href="<?php echo $location; ?>" target="_blank">directions <img src="<?php echo get_template_directory_uri(); ?>/assets/images/right-arrow.svg" alt="right_arrow"></a>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                    <?php   $placesZipcode = true; endwhile; 
                                            wp_reset_postdata();
                                            } ?>
                                    <?php if($placesZipcode == false){ ?>
                                        <div class="default-view dealer-not-found">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/information.svg" alt="Dealer not found">
                                            <div class="no-data-content">Searched postcode's dealer not found.</div>
                                        </div>        
                                    <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <div class="default-view dealer-not-found">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/information.svg" alt="Dealer not found">
                    <div class="no-data-content">Searched postcode's dealer not found.</div>
                </div> 
            <?php endif;
            if(!empty($dealer_information)): ?>
            <div class="dealer-important-info">
                <div class="container">
                    <div class="common-title">
                        <span>IMPORTANT INFORMATION</span>
                    </div>
                    <?php echo $dealer_information; ?>
                </div>
            </div>
            <?php endif;
            if(!empty($rilu_information)): ?>
            <div class="container">
                <div class="dealer-bottom">
                    <?php echo $rilu_information; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>