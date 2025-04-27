<?php
$home = get_fields(); // get all fields of home page inside one array
// Slider section
$sliders = $home['slider'];
$total_slider = count($sliders);
// Product section
$product_top_title = $home['product_top_title'];
$product_main_title = $home['product_main_title'];
$product_lists = $home['product_list'];
// About section
$about_title = $home['about_title'];
$about_content = $home['about_content'];
$about_button = $home['about_button'];
$about_button_label = $about_button['button_label'];
$about_button_link = button_group($about_button);
// Client review section
$review_title = $home['review_title'];
$review_description = $home['review_description'];
$review_shortcode = $home['review_shortcode'];
// find dealer section
$dealer_title = $home['dealer_title'];
$dealer_button_text = $home['dealer_button_text'];
// Video section
$video = $home['home_video'];
$video_image = $video['upload_video_image'];
$selected_video = $video['select_video_link'];
// test drive section
$drive_title = $home['title'];
$drive_description = $home['description'];
$drop_message_button = $home['drop_message_button'];
$drop_message_button_label = $drop_message_button['button_label'];
$drop_message_button_link = button_group($drop_message_button);
$drive_image = $home['upload_image'];
// blog section
$blog_title = $home['blog_title'];
$blog_description = $home['blog_description'];
$blog_lists = $home['select_blog'];
// get in touch section
$get_in_touch_title = $home['get_in_touch_title'];
$get_in_touch_content = $home['get_in_touch_content'];
$get_in_touch_button = $home['get_in_touch_button'];
$get_in_touch_button_label = $get_in_touch_button['button_label'];
$get_in_touch_button_link = button_group($get_in_touch_button);
get_header();
?>
<!-- slider start -->
<?php if(!empty($sliders)): ?>
<div class="banner">
    <div class="slider">
        <?php 
            foreach($sliders as $slider): 
                $slider_image = $slider['slider_image'];
                $mob_banner_image = $slider['mobile_banner_image'];
                $mob_banner_image_url = (!empty($mob_banner_image)) ? $mob_banner_image['url'] : $slider_image['url'];
                $slider_title = $slider['slider_title'];
                $slider_button = $slider['slider_button'];
                $slider_button_label = $slider_button['button_label'];
                $slider_button_link = button_group($slider_button); ?>
            <div class="slider__item">
                <?php if(!empty($slider_image)): ?>
                    <img src="<?php echo $slider_image['url']; ?>" alt="" class="desktop-image">
                    <img src="<?php echo $mob_banner_image_url; ?>" alt="" class="mob-image"> 
                <?php endif;?>
                <div class="banner-content">
                    <?php if(!empty($slider_title)): ?>
                        <h3><?php echo $slider_title; ?></h3>
                    <?php endif;
                    if(!empty($slider_button_label) && !empty($slider_button_link)): ?>
                        <a class="theme-button" <?php echo $slider_button_link; ?>> <?php echo $slider_button_label; ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
    </div>
    <?php if($total_slider > 1): ?> 
    <span class="pagingInfo"></span>
    <?php endif; ?>
</div>
<?php endif; ?>
<!-- slider end -->
<!-- product section start -->
<section class="product-section">
    <div class="container">
        <?php if(!empty($product_top_title)): ?>
        <div class="top-title">
            <h3><?php echo $product_top_title; ?></h3>
        </div>
        <?php endif;
        if(!empty($product_main_title)): ?>
        <div class="main-title">
            <h3><?php echo $product_main_title; ?></h3>
        </div>
        <?php endif;
        if(!empty($product_lists)): ?>
        <div class="three-row-section">
            <?php 
                foreach($product_lists as $product): ?>
                <div class="col-section">
                    <?php
                        if(has_post_thumbnail($product->ID)):
                            /* display featured image */
                            echo '<a href="'.get_the_permalink($product->ID).'">'; 
                                echo get_the_post_thumbnail($product->ID, 'product-imgs');
                            echo '</a>';
                        else: 
                            echo wp_get_attachment_image(484, 'product-imgs');                                
                        endif; ?>
                    <div class="product-name"><?php echo $product->post_title; ?></div>
                    <?php if(!empty(get_field('price_from', $product->ID))): ?>
                    <!-- <div class="price"><?php /*From: $<?php echo get_field('price_from', $product->ID); */ ?></div>  -->
                    <?php endif; ?>
                    <a href="<?php echo get_the_permalink($product->ID); ?>" class="theme-button">Discover More</a>
                </div>
                <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<!-- product section end -->
<!-- about section start -->
<?php if((!empty($about_title)) && (!empty($about_content))): ?>
<section class="about-section">
    <div class="container">
        <div class="theme-title">
            <h1><?php echo $about_title; ?></h1>
            <p><?php echo $about_content; ?></p>
           <?php if(!empty($about_button_label) && !empty($about_button_link)): ?>
               <a class="theme-button" <?php echo $about_button_link; ?>> <?php echo $about_button_label; ?></a>
           <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- about section end -->
<!-- client section start -->
<section class="client-section">
    <?php if(!empty($review_title)): ?>
    <div class="common-title">
        <span><?php echo $review_title; ?></span>
    </div>
    <?php endif; 
    if(!empty($review_description)): ?>
        <p><?php echo $review_description; ?></p>
    <?php endif;
    if(!empty($review_shortcode)):
        echo do_shortcode($review_shortcode); 
    endif;?>
</section>
<!-- client section end -->
<!-- map section start -->
<section class="map-section">
    <div class="content-area">
        <div class="map-area">
            <div id="map_canvas"></div>
        </div>
        <!-- dealer search form using postcode -->
        <div class="container">
            <div class="search-area">
                <?php if(!empty($dealer_title)): ?>
                <h4><?php echo $dealer_title; ?></h4>
                <?php endif; ?>
                <?php if(!empty($dealer_button_text)): ?>
                <form method="get" action="<?php echo get_site_url(); ?>/dealer/" class="dealer_postcode_form">
                    <div class="pincode-dropdown dealer_form"><button type="button" class="btn1">Search Postcode</button>
                        <ul class="search-wrapper">
                            <li class="searchInput">
                                <input type="text" name="addressInput" class="postcode" placeholder="Search Postcode" autocomplete="off" required>
                            </li>
                            <div class="show_dealer_location"></div>
                        </ul>
                    </div>
                    <button type="submit" class="theme-button search-btn" id="search-btn"><?php echo $dealer_button_text; ?></button>
                </form>
                <div id="show_dealer_price"><?php echo get_woocommerce_currency_symbol(); ?><span></span></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- map section end -->
<!-- video section start -->
<?php if(!empty($video)): ?>
<section class="video-section">
    <?php if(!empty($video_image)): ?>
        <img id="video-cover" src="<?php echo $video_image['url']; ?>" alt="<?php echo $video_image['alt']; ?>" />
    <?php endif;
    if($selected_video == "internal_video" && !empty($video[$selected_video])): ?>
        <iframe id="player" width="100%" src="<?php echo $video['internal_video']['url']; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    <?php elseif($selected_video == "external_video" && !empty($video[$selected_video])):
        $video_url = $video['external_video']; ?>
        <iframe id="player" width="100%" src="<?php echo $video_url; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    <?php endif;
    if(!empty($video[$selected_video])): ?>
    <button id="play" class="play-btn">
       <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M40 0C17.9427 0 0 17.9444 0 40C0 62.0556 17.9427 80 40 80C62.0573 80 80 62.0556 80 40C80 17.9444 62.0573 0 40 0ZM55.9017 41.4014L32.5684 56.4014C32.295 56.5788 31.9792 56.6667 31.6667 56.6667C31.3933 56.6667 31.1166 56.5983 30.8692 56.4633C30.332 56.1703 30 55.6103 30 55V25C30 24.3897 30.332 23.8297 30.8692 23.5367C31.3966 23.247 32.0573 23.2648 32.5684 23.5986L55.9017 38.5986C56.377 38.9045 56.6667 39.4336 56.6667 40C56.6667 40.5664 56.377 41.0953 55.9017 41.4014Z" fill="white"/>
       </svg>
    </button>
    <?php endif; ?>
</section>
<?php endif; ?>
<!-- video section end -->
<!-- test drive section start -->
<section class="test-drive-section">
    <div class="container">
        <div class="two-row-section">
            <div class="col-section">
                <?php if(!empty($drive_title)): ?>
                    <h4><?php echo $drive_title; ?></h4>
                <?php endif;
                if(!empty($drive_description)): ?>
                <p><?php echo $drive_description; ?></p>
                <?php endif;
                if(!empty($drop_message_button_label) && !empty($drop_message_button_link)): ?>
                    <a class="theme-button drop-message" <?php echo $drop_message_button_link; ?>> <?php echo $drop_message_button_label; ?></a>
                <?php endif; ?>
            </div>
            <?php if(!empty($drive_image)): ?>
            <div class="col-section">
                <img src="<?php echo $drive_image['url']; ?>" alt="">
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- test drive section end -->
<!-- blog section start -->
<section class="blog-section">
    <div class="container">
        <?php if(!empty($blog_title)): ?>
        <div class="common-title">
            <span><?php echo $blog_title; ?></span>
        </div>
        <?php endif; 
        if(!empty($blog_description)): ?>
        <p><?php echo $blog_description; ?></p>
        <?php endif; ?>
        <?php if(!empty($blog_lists)): ?>
        <div class="three-row-section">
            <?php 
                foreach($blog_lists as $blog): ?>
                <div class="col-section">
                    <div class="img-container">
                        <?php
                            if(has_post_thumbnail($blog->ID)):
                            /* display featured image */                                
                            echo '<a href='.get_the_permalink($blog->ID).'>'; 
                                echo get_the_post_thumbnail($blog->ID, 'blog-imgs');
                            echo '</a>';
                            else:
                                echo wp_get_attachment_image(998, 'blog-imgs');
                            endif; ?>
                        <div class="blog-date"><?php echo date("j M Y", strtotime($blog->post_date)); ?></div>
                    </div>
                    <div class="blog-title"><?php echo substr($blog->post_title, 0, 85); ?></div>
                    <div class="blog-content"><?php echo substr($blog->post_excerpt, 0, 110); ?></div>
                    <a href="<?php echo get_the_permalink($blog->ID); ?>" class="theme-button read-post">read post</a>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<!-- blog section end -->
<!-- get in touch section start -->
<section class="gey-in-touch-section">
    <div class="container">
        <div class="get-in-touch-box">
            <?php if(!empty($get_in_touch_title)): ?>
            <div class="box-left">
                <h4><?php echo $get_in_touch_title; ?></h4>
            </div>
            <?php endif; ?>
            <div class="box-right">
                <?php if(!empty($get_in_touch_content)): ?>
                <p><?php echo $get_in_touch_content; ?></p>
                <?php endif;
                if(!empty($get_in_touch_button_label) && !empty($get_in_touch_button_link)): ?>
                    <a class="theme-button" <?php echo $get_in_touch_button_link; ?>> <?php echo $get_in_touch_button_label; ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section> 
<!-- get in touch section end -->
<?php get_footer(); ?>