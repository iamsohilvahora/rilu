<?php
/*
 * Template Name: Dealer Page
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
$dealer_image = $dealer['default_dealer_image'];
$dealer_content = $dealer['default_dealer_content'];
$dealer_detail_args = array(
    'post_type' => 'dealer',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'title',
    'order'   => 'ASC',
);
$dealer_details = new WP_Query($dealer_detail_args);
// get nearest dealer info using entered address
if(isset($_GET['addressInput'])){
    $addressInput = $_GET['addressInput'];
    // $places_postcode_arr = wp_get_nearest_dealer_info($addressInput);
    // 15-9-22
    global $wpdb;
    $table_name = $wpdb->prefix.'postcodes_geo';
    // query for getting lat and long of selected zipcode
    $lat_long_query = $wpdb->get_results("SELECT * FROM $table_name WHERE postcode = '".$addressInput."' LIMIT 1");
    if(!empty($lat_long_query)):
        $latitude = $lat_long_query[0]->latitude; 
        $longitude = $lat_long_query[0]->longitude;
        while($dealer_details->have_posts()):
            $dealer_details->the_post();
            $dealerID = $dealer_details->ID; 
            $postcode = get_field('dealer_postcode', $dealerID);
            $postcode_latitude = get_field('latitude', $dealerID);
            $postcode_longitude = get_field('longitude', $dealerID);
            // get distance from selected postcode
            $dealer_postcode_distance = distance($latitude, $longitude, $postcode_latitude, $postcode_longitude, "K");
            // get latitude and longitude of dealer
            // $dealer_lat_long_query = $wpdb->get_results("SELECT * FROM $table_name WHERE postcode = '".$postcode."' LIMIT 1");
            // $dealer_latitude = $dealer_lat_long_query[0]->latitude;
            // $dealer_longitude = $dealer_lat_long_query[0]->longitude;
            // get distance from selected zipcode
            // $dealer_postcode_distance = distance($latitude, $longitude, $dealer_latitude, $dealer_longitude, "K");
            $places_postcode_arr[$postcode] = $dealer_postcode_distance;
        endwhile;
    endif;
    asort($places_postcode_arr); // Sorted variation postcode array
    // 15-9-22
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
                <form method="get" class="dealer_postcode_form">
                    <div class="pincode-dropdown dealer_form"><button type="button" class="btn1"><?php if(isset($_COOKIE['set_select_postcode'])){ echo $_COOKIE['set_select_postcode']; }else{ echo "Search Postcode"; } ?></button>
                        <div class="close-wrapper" <?php if(!isset($_COOKIE['set_select_postcode'])){ ?>style="display: none;"<?php } ?>><a class="close-search" href="javascript:void(0)">×</a></div>
                        <ul class="search-wrapper">
                            <li class="searchInput">
                                <input type="text" name="addressInput" class="postcode" placeholder="Search Postcode" value="<?php if(isset($_COOKIE['set_select_postcode'])): echo $_COOKIE['set_select_postcode']; endif; ?>" autocomplete="off">
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
                <form method="get" class="mobile_dealer_postcode_form">
                    <div class="pincode-dropdown mobile_dealer_form"><button type="button" class="btn1"><?php if(isset($_COOKIE['set_select_postcode'])){ echo $_COOKIE['set_select_postcode']; }else{ echo "Search Postcode"; } ?></button>
                        <div class="close-wrapper" <?php if(!isset($_COOKIE['set_select_postcode'])){ ?>style="display: none;"<?php } ?>><a class="close-search" href="javascript:void(0)">×</a></div>
                        <ul class="search-wrapper">
                            <li class="searchInput">
                                <input type="text" name="addressInput" class="mobile_postcode" placeholder="Search Postcode" value="<?php if(isset($_COOKIE['set_select_postcode'])): echo $_COOKIE['set_select_postcode']; endif; ?>" autocomplete="off">
                            </li>
                            <div class="show_dealer_location"></div>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Default links section-->
    <section class="dealer-section" <?php if(!empty($addressInput)){ ?> id="dealer-section" <?php } ?>>
        <?php if(!empty($dealer_state_pages)): ?>
        <div class="container border-bottom">
            <ul class="links-section">
                <?php
                    foreach($dealer_state_pages as $page):
                        $dealer_state_page = $page['dealer_state_page'];
                        // $class = ""; 
                        // if($post->post_name != 'dealer' && $dealer_state_page->post_name == 'victoria'){
                        //     $class = "active";
                        // } 
                        ?>
                    <li><a href="<?php echo get_the_permalink($dealer_state_page->ID); ?>"><?php echo $page['dealer_state_page_name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <!-- default -->
        <?php if(empty($_GET['addressInput'])): ?>
        <div class="default-view not_scroll_dealer">
            <?php if(!empty($dealer_image)): ?>
                <img src="<?php echo $dealer_image['url']; ?>" alt="<?php echo $dealer_image['alt']; ?>">
            <?php endif;
            if(!empty($dealer_content)): ?>
                <div class="no-data-content"><?php echo $dealer_content; ?></div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <!-- VIC -->
        <?php
        $placesZipcode = false;
        if(isset($_GET['addressInput']) && !empty($_GET['addressInput'])): ?>
        <div class="selected-view">
            <?php if(!empty($dealer_title)): ?>
            <div class="container">
                <div class="dealer-title">
                    <h1><?php echo $dealer_title; ?></h1>
                </div>
            </div>
            <?php endif;
            if($dealer_details->have_posts()): ?>
            <div class="show-dealer-section">
                <?php if(!isset($_GET['addressInput']) && empty($_GET['addressInput'])): ?>
                 <div class="result-count">Showing <?php echo count($dealer_details); ?> dealerships for <?php echo $post->post_title; ?></div>
                <?php endif; ?>
                <div class="show-dealer-result">
                    <div class="container">
                        <div class="result-section">
                            <?php
                                if(isset($_GET['addressInput']) && !empty($_GET['addressInput'])){
                                    if(!empty($places_postcode_arr)){
                                        $dealer_count = 1;
                                        foreach($places_postcode_arr as $key => $value):
                                        while($dealer_details->have_posts()):
                                            $dealer_details->the_post();
                                            $dealerID = $dealer_details->ID; 
                                            $postcode = get_field('dealer_postcode', $dealerID);
                                            $title = get_field('dealer_title', $dealerID);
                                            $sub_title = get_field('dealer_sub_title', $dealerID);
                                            $address = get_field('dealer_address', $dealerID);
                                            $phone = get_field('dealer_phone', $dealerID);
                                            $email = get_field('dealer_email', $dealerID);
                                            $site_link = get_field('dealer_site_link', $dealerID);
                                            $location = get_field('location_link', $dealerID);
                                            // if(in_array($postcode, $places_postcode_arr)):
                                            if($key == $postcode && $dealer_count <= 5): ?>
                                            <div class="result">
                                                <div class="result-items">
                                                    <?php if(!empty($title)): ?>
                                                        <a class="title" href="<?php echo get_the_permalink($dealerID); ?>"><?php echo $title; ?></a>
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
                                <?php $placesZipcode = true; $dealer_count++; endif; endwhile; endforeach; } } ?>
                                <?php if($placesZipcode == false){ ?>
                                    <div class="default-view dealer-not-found not_scroll_dealer">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/information.svg" alt="Dealer not dound">
                                        <div class="no-data-content">Searched postcode's dealer not found.</div>
                                    </div>        
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>    
        <?php endif; ?>
    </section>
</main>
<?php get_footer(); ?>