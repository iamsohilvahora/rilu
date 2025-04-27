<?php
// WooCommerce support in theme
function rilu_wc_setup(){
	add_theme_support('woocommerce');
	remove_theme_support('wc-product-gallery-lightbox');
	remove_theme_support("wc-product-gallery-slider");
	remove_theme_support("wc-product-gallery-zoom");
}
add_action('after_setup_theme', 'rilu_wc_setup', 100);
// Display zipcode form in product detail page
function wc_show_zipcode_form_func(){
	echo do_shortcode('[zipcode]');
}
// Remove default content from single product detail page
function wc_remove_product_page_content(){
	if(is_single()){
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    	remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    	remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
    	remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
    	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
    	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
    	remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
    	remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10); // remove price
    }

    if(is_product_category()){
    	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    	remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    	add_filter( 'woocommerce_show_page_title', '__return_false' );
    	remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
    	remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
    	remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
    	remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    	remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    	remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    	add_action('woocommerce_before_shop_loop', 'wc_show_banner_section', 8);
    	add_action('woocommerce_before_shop_loop', 'wc_show_category_data', 9);
    	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10); // remove price
    	add_action('woocommerce_no_products_found', 'wc_category_product_not_found', 9);
    	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
    	add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
    	add_action('woocommerce_before_shop_loop', 'wc_show_product_category_title', 31);
    }
}
add_action('template_redirect', 'wc_remove_product_page_content');
// Product category section
function wc_show_category_data(){
	$term = get_queried_object();
	$term_id = $term->term_id;
	$product_category = get_fields('product_cat_'.$term_id);
	// about section
	$about_title = $product_category['about_title'];
	$about_content = $product_category['about_content'];
	// description section
	$left_description = $product_category['left_description'];
	$right_image = $product_category['right_image'];
	if(!empty($about_title) && !empty($about_content)): ?>
	<section class="tag-line">
	    <div class="container">
	        <h2><?php echo $about_title; ?></h2>
	        <div class="content"><?php echo $about_content; ?></div>
	    </div>
	</section>
	<?php endif;
	if(!empty($left_description) && !empty($right_image)): ?>
	<section class="ebike-info">
	    <div class="container">
	        <div class="two-row-section">
	            <div class="col-section">
	                <div class="left-content">
	                   <?php echo $left_description; ?>
	                </div>
	            </div>
	            <div class="col-section">
	                <div class="right-content">
	                    <img src="<?php echo $right_image['url']; ?>" alt="<?php echo $right_image['alt']; ?>">
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
	<?php endif; 
}
// Change default placeholder image if featured image is not set in product category
if(!function_exists( 'woocommerce_template_loop_product_thumbnail')){
    function woocommerce_template_loop_product_thumbnail(){
        echo woocommerce_get_product_thumbnail();
    } 
}
if(!function_exists( 'woocommerce_get_product_thumbnail')){   
    function woocommerce_get_product_thumbnail($size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0 ){
        global $post, $woocommerce;
        $output = "";
        if(has_post_thumbnail()){               
            $output .= get_the_post_thumbnail($post->ID, $size);
        }
        else{
            $output .= wp_get_attachment_image(484, $size);
        }                       
        return $output;
    }
}
// products were not found message
function wc_category_product_not_found(){
	wc_show_banner_section();
	wc_show_category_data();
	add_action('woocommerce_no_products_found', 'wc_no_products_found', 10);
}
function wc_show_product_category_title(){
	$term = get_queried_object();
	$term_id = $term->term_id;
	$term = get_term($term_id, 'product_cat');
	if($term->count > 0){
		echo "<p class='product_category_result'>Showing all ".$term->count." results</p>";
	}
}
// Product banner section
function wc_show_banner_section(){
	if(is_product_category()){
		$term = get_queried_object();
		$term_id = $term->term_id;
		$product = get_fields('product_cat_'.$term_id);
	}
	else{
		$product = get_fields(); // get all fields of product detail page inside one array
	}
	// Banner section
	$banner_image = $product['banner_image'];
	$mob_banner_image = $product['mobile_banner_image'];
	$mob_banner_image_url = (!empty($mob_banner_image)) ? $mob_banner_image['url'] : $banner_image['url'];
	$banner_heading = $product['banner_heading'];
	$banner_subheading = $product['banner_subheading'];
	$banner_button = $product['banner_button'];
	$banner_button_label = $banner_button['button_label'];
	$banner_button_link = button_group($banner_button); ?>
	<?php if(!empty($banner_image)): ?>
	<div class="product-banner desktop-image" style="background-image: url(<?php echo $banner_image['url']; ?>)"> 
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
	<div class="product-banner mob-image" style="background-image: url(<?php echo $mob_banner_image_url; ?>);"> 
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
<?php }
add_action('woocommerce_before_single_product_summary', 'wc_show_banner_section');
// Display main content area wrapper above data tab wrapper
function wc_show_product_tab_content(){
	// start acf section 
	$product = get_fields(); // get all fields of product detail page inside one array
	// Description section
	$product_left_description = $product['product_left_description']; // product left and right description
	$product_right_description = $product['product_right_description']; // product left and right description
	// 360 image section
	$left_360_image_content = $product['left_360_image_content'];
	$shortcode_360_image = $product['shortcode_360_image'];
	// product feature section
	$product_feature_heading = $product['product_feature_heading']; 
	$product_feature_description = $product['product_feature_description'];
	$product_feature_contents = $product['product_feature_content'];
	$product_image_gallery = $product['product_image_gallery']; // product image gallery
	// specification section
	$specification_title = $product['specification_title']; // product specification
	$product_specification_image = $product['product_specification_image']; 
	$product_specification_lists = $product['product_specification_list']; 
	// Highlight section
	$product_system_contents = $product['product_system_content'];
	// Manual section
	$product_download_title = $product['product_download_title'];
	$download_button_title = $product['download_button_title'];
	$download_button_link = $product['download_button_link'];
	// Warranty section
	$warranty_details = $product['warranty_details']; 
	// Tab Title
	$tab_one_title = $product['tab_one_title']; 
	$tab_two_title = $product['tab_two_title']; 
	$tab_three_title = $product['tab_three_title']; 
	$tab_four_title = $product['tab_four_title']; 
	$tab_five_title = $product['tab_five_title']; 
	
	
	?>
	<!-- get current user's location -->
	<input type="hidden" class="find-current-location" value="<?php echo get_the_id(); ?>" />
	<div class="main-content-area">
		<div class="tab-line">
			<div class="container">
				<div class="tabs-container">
					<nav class="tabs">
						<ul class="product-detail-tab">
							<?php 
								$tab_one_title_id = str_replace(' ', '', $tab_one_title);
								$tab_one_title_id = preg_replace("/[^A-Za-z0-9 ]/", '', $tab_one_title_id);
								$tab_one_title_id = strtolower($tab_one_title_id);
							?>
							<li class="active" data-tab="<?php echo $tab_one_title_id; ?>"><a href="<?php echo get_the_permalink()."#".$tab_one_title_id; ?>"><?php echo $tab_one_title; ?></a></li>
							<?php if(!empty($specification_title) && !empty($product_specification_image) && !empty($product_specification_lists)): 
								$tab_two_title_id = str_replace(' ', '', $tab_two_title);
								$tab_two_title_id = preg_replace("/[^A-Za-z0-9 ]/", '', $tab_two_title_id);
								$tab_two_title_id = strtolower($tab_two_title_id);	
							?>
								<li data-tab="<?php echo $tab_two_title_id; ?>"><a href="<?php echo get_the_permalink()."#".$tab_two_title_id; ?>"><?php echo $tab_two_title; ?></a></li>
							<?php endif; ?>
							<?php if(!empty($product_system_contents)): 
								$tab_three_title_id = str_replace(' ', '', $tab_three_title);
								$tab_three_title_id = preg_replace("/[^A-Za-z0-9 ]/", '', $tab_three_title_id);
								$tab_three_title_id = strtolower($tab_three_title_id);
							?>	
								<li data-tab="<?php echo $tab_three_title_id; ?>"><a href="<?php echo get_the_permalink()."#".$tab_three_title_id; ?>"><?php echo $tab_three_title; ?></a></li>
							<?php endif; ?>
							<?php if(!empty($product_download_title) && !empty($download_button_title) && !empty($download_button_link)): 
								$tab_four_title_id = str_replace(' ', '', $tab_four_title);
								$tab_four_title_id = preg_replace("/[^A-Za-z0-9 ]/", '', $tab_four_title_id);
								$tab_four_title_id = strtolower($tab_four_title_id);
							
							?>	
								<li data-tab="<?php echo $tab_four_title_id; ?>"><a href="<?php echo get_the_permalink()."#".$tab_four_title_id; ?>"><?php echo $tab_four_title; ?></a></li>
							<?php endif; ?>
							<?php if(!empty($warranty_details)): 
								$tab_five_title_id = str_replace(' ', '', $tab_five_title);
								$tab_five_title_id = preg_replace("/[^A-Za-z0-9 ]/", '', $tab_five_title_id);
								$tab_five_title_id = strtolower($tab_five_title_id);
							?>	
								<li data-tab="<?php echo $tab_five_title_id; ?>"><a href="<?php echo get_the_permalink()."#".$tab_five_title_id; ?>"><?php echo $tab_five_title ?></a></li>
							<?php endif; ?>
						</ul>
					</nav>
					<div class="location-pin"><a href="#" class="popup-toggle"><?php if(isset($_COOKIE['set_dealer_postcode'])){ echo $_COOKIE['set_dealer_postcode']; }else{ echo "Set your location"; } ?></a></div>
				</div>
			</div>
		</div>
		<div id="change-location" class="change-location-modal">
			<div class="overlay popup-toggle"></div>
			<div class="popup popup-transition">
				<div class="title">Location</div>
				<a class="close popup-toggle" href="#">&times;</a>
				<div class="content">
					<img class="red-location" src="<?php echo get_template_directory_uri(); ?>/assets/images/red-location.svg" alt="">
					<div class="heading">Set your location to get dealer detail</div>
					<div class="search-area">
						<div class="pincode-dropdown dealer_form"><button type="button" class="btn1"><span><?php if(isset($_COOKIE['dealer_postcode_location'])){ echo $_COOKIE['dealer_postcode_location']; }else{ echo "Search Postcode"; } ?></span></button>
							<div class="close-wrapper" <?php if(!isset($_COOKIE['dealer_postcode_location'])){ ?>style="display: none;"<?php }else{ ?> style="display: block;" <?php } ?>><a class="close-search" href="javascript:void(0)">&times;</a></div>
							<ul class="search-wrapper">
								<li class="searchInput">
									<input type="text" name="addressInput" class="postcode" autocomplete="off" value="<?php if(isset($_COOKIE['dealer_postcode_location'])){ echo $_COOKIE['dealer_postcode_location']; } ?>" placeholder="Search Postcode">
								</li>
								<div class="show_dealer_location"></div>
							</ul>
						</div>
					</div>
					<!-- <div class="use-current-location">
						<div class="location-link">
							<img src="<?php // echo get_template_directory_uri(); ?>/assets/images/Alt_Location.svg" alt="">
							<a href="javascript:void(0)">Or use current location</a>
						</div>
					</div> -->
					<div class="select-dealership">
						<div class="top-line-content">
							<span>Select a Dealership</span>
							<a href="#" class="close skip popup-toggle">skip</a>
						</div>
						<div class="dealer-content-list">
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- dialog box -->
		<dialog id="window">  
	    	<h3>Please enter an Australian postcode/suburb.</h3>  
	    	<button id="exit">X</button>
	   </dialog>  
		<!-- description tab -->
		<div id="<?php echo $tab_one_title_id; ?>" class="tab-content description-tab current">
			<div class="container">
				<div class="two-row-section first-row">
				    <div class="col-section">
				    <?php if(!empty($product_left_description)):
				        echo $product_left_description;
					endif; ?>
				    </div>
				    <div class="col-section">
					<?php if(!empty($product_right_description)): ?>
				    	<h3><?php echo $product_right_description; ?></h3>
				    <?php endif; ?>	
				    </div>
				</div>
				<div class="two-row-section second-row">
				    <div class="col-section">
				        <?php if(!empty($left_360_image_content)):
				        	 echo $left_360_image_content;
				    	endif; ?>
				        <!-- dealer search form using postcode -->
				        <div class="container">
				        	<div class="search-area">
				        		<!-- <div class="pincode-dropdown zipcode_form"> -->
				        		<div class="pincode-dropdown" id="product_dealer_form">
				        			<button type="button" class="btn1">Search Postcode</button>
				        			<ul class="search-wrapper">
				        				<li class="searchInput">
				        					<input type="text" name="addressInput" class="product_postcode" placeholder="Search Postcode" autocomplete="off">
				        					<input type="hidden" name="product_id" class="search_product_id" value="<?php echo get_the_id(); ?>" />
				        				</li>
				        				<div class="show_dealer_location"></div>
				        			</ul>
				        		</div>
				        		<div id="show_dealer_price" style="display: none;">From: $<span></span></div>
				        		<div id="location-indicator" style="display: none;">Prices based on <span></span></div>
				        		<div id="show_dealer_detail" style="border: 1px solid #ededed;padding: 10px;margin-top: 15px;line-height: 1.5;display: none;"></div>

				        		<!-- 7-10-22 -->

				        		<div id="show_prdct_lst" style="display: none;">
				        			<?php echo $product['product_service']; ?>
				        		</div>
				        		<!-- 7-10-22 -->


				        	</div>
				        </div>
				    </div>
				    <div class="col-section rotate_view">
				        <?php if(!empty($shortcode_360_image)):
				        	echo do_shortcode($shortcode_360_image); 
				    	endif; ?>
				    </div>
				</div>
			</div>
			<div class="own-style">
				<?php if(!empty($product_feature_heading)): ?>	
				<div class="common-title">
					<span><?php echo $product_feature_heading; ?></span>
				</div>
				<?php endif;
				if(!empty($product_feature_description)): ?>	
				<p class="sub-heading"><?php echo $product_feature_description; ?></p>
				<?php endif;
				if(!empty($product_feature_contents)): ?>	
				<div class="container">
					<div class="five-row-section">
						<?php
						foreach($product_feature_contents as $content): 
							$product_feature_image = $content['product_feature_image'];
							$product_feature_title = $content['product_feature_title']; 
							$product_feature = $content['product_feature']; ?>
							<div class="col-section">
								<div class="style-content">
									<?php if(!empty($product_feature_image)): ?>
									<div class="image">
										<img src="<?php echo $product_feature_image['url']; ?>" alt="<?php echo $product_feature_image['alt']; ?>">
									</div>
									<?php endif;
									if(!empty($product_feature_title) && !empty($product_feature)): ?>
									<div class="content">
										<h4><?php echo $product_feature_title; ?></h4>
										<span><?php echo $product_feature; ?></span>
									</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<?php if(!empty($product_image_gallery)): ?>
			<div class="images-section">
				<?php 
				$img_no = 1;
				$row = 1;
				$big_col_no = 1;
				foreach($product_image_gallery as $gallery_image): ?>
					<!-- start row -->
					<?php if($img_no == 1): ?>	
						<div class="random-row-section">	
					<?php elseif(($row + 3) == $img_no): ?>
						<div class="random-row-section">
						<?php $row = $row + 3; ?>
					<?php endif; ?>
					<!-- big column class -->
					<?php if($img_no == 1): 
							$class = "col-big-section";
					    elseif(($big_col_no + 6) == $img_no): 
							$class = "col-big-section";
							$big_col_no = $big_col_no + 6; 
						elseif($img_no % 6 == 0):
							$class = "col-big-section";
						else:
							$class = "col-small-section";
						endif; ?>
					<!-- display column -->
					<div class="<?php echo $class; ?>">
					 	<div class="product-images">
					 		<img src="<?php echo $gallery_image['url']; ?>" alt="<?php echo $gallery_image['alt']; ?>">
					 	</div>
					</div>
					<!-- close row -->
					<?php if(($img_no % 3 == 0) || ($img_no == count($product_image_gallery))): ?>
						</div>
					<?php endif;
				$img_no++;
				endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		<!-- specification tab -->
		<?php if(!empty($specification_title) && !empty($product_specification_image) && !empty($product_specification_lists)): ?>
		<div id="<?php echo $tab_two_title_id; ?>" class="tab-content specification-tab">
			<div class="container specification">
				<?php if(!empty($specification_title)): ?>
				<div class="common-title specification-common-title">
					<span><?php echo $specification_title; ?></span>
				</div>
				<?php endif; ?>
				<?php if(!empty($product_specification_lists)): ?>
				<div class="three-row-section">
					<?php
					$spec_list = 1;
					$col = 1;
					$show_image = 6;
					foreach($product_specification_lists as $specification): 
						$specification_title = $specification['product_specification_title'];
						$specification_description = $specification['product_specification_description']; ?>
						<!-- start column -->
						<?php if($spec_list == 1): ?>
							<div class="col-section">
						<?php elseif(($col + 6) == $spec_list): 
							$col = $col + 6; ?>
							<div class="col-section">	
						<?php endif; ?>
						<!-- specification list -->
						<ul>
							<li class="title"><?php echo $specification_title; ?></li>
							<li class="content"><?php echo $specification_description; ?></li>
						</ul>
						<!-- close column  -->
						<?php if($spec_list % 6 == 0): ?>
							</div>
						<?php endif; ?>
						<!-- Display image -->
						<?php if($show_image == $spec_list): 
							$show_image = $show_image + 12;
							if(!empty($product_specification_image)): ?>	
							<div class="col-section">
								<div class="image">
									<img src="<?php echo $product_specification_image['url'] ?>" alt="<?php echo $product_specification_image['alt'] ?>">
								</div>
							</div>
						<?php endif;
						endif;
						$spec_list++;
					endforeach; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<!-- highlight tab -->		
		<?php if(!empty($product_system_contents)): ?>	
		<div id="<?php echo $tab_three_title_id; ?>" class="tab-content highlight-tab">
			 <div class="container">
				<?php 
					$i = 1;
					foreach($product_system_contents as $content): 
						$product_system_image = $content['product_system_image'];
						$product_system_title = $content['product_system_title'];
						$product_system_description = $content['product_system_description'];
						if($i % 2 !== 0): ?>
						<div class="two-row-section">
							<?php if(!empty($product_system_image)): ?>
							<div class="col-section">
								<div class="image-sec">
									<img src="<?php echo $product_system_image['url']; ?>" alt="<?php echo $product_system_image['alt']; ?>">
								</div>
							</div>
							<?php endif; ?>

							<?php if(!empty($product_system_title) && !empty($product_system_description)): ?>
							<div class="col-section">
								<div class="content-sec content-right">
									<div class="common-title">
										<span><?php echo $product_system_title; ?></span>
									</div>
									<?php echo $product_system_description; ?>
								</div>
							</div>
							<?php endif; ?>
						</div>
						<?php else: ?>
						<div class="two-row-section">
							<?php if(!empty($product_system_title) && !empty($product_system_description)): ?>
							<div class="col-section">
								<div class="content-sec content-left">
									<div class="common-title">
										<span><?php echo $product_system_title; ?></span>
									</div>
									<?php echo $product_system_description; ?>
								</div>
							</div>
							<?php endif; ?>
							<?php if(!empty($product_system_image)): ?>
							<div class="col-section">
								<div class="image-sec">
									<img src="<?php echo $product_system_image['url']; ?>" alt="<?php echo $product_system_image['alt']; ?>">
								</div>
							</div>
							<?php endif; ?>
						</div>
						<?php endif;
						$i++; 
					endforeach; ?>
			 </div>
		</div>
		<?php endif; ?>
		<!-- Manual -->
		<?php if(!empty($product_download_title) && !empty($download_button_title) && !empty($download_button_link)): ?>
		<div id="<?php echo $tab_four_title_id; ?>" class="tab-content manual-tab">
			<div class="container">
				<div class="common-title">
					<span><?php echo $product_download_title; ?></span>
				</div>
				<div class="download-button">
					<a href="<?php echo $download_button_link['url']; ?>" class="theme-button"><?php echo $download_button_title; ?></a>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<!-- Warranty tab  -->
		<?php if(!empty($warranty_details)): ?>	
		<div id="<?php echo $tab_five_title_id; ?>" class="tab-content warranty-tab">
			<div class="container">
				<div class="slick-carousel">
					<?php 
					foreach($warranty_details as $warranty_detail): 
						$warranty_image = $warranty_detail['warranty_image'];
						$warranty_content = $warranty_detail['warranty_content']; ?>
					<div class="slide-content">
						<div class="two-row-section">
							<div class="col-section">
								<?php if(!empty($warranty_image)): ?>
									<img src="<?php echo $warranty_image['url']; ?>" alt="<?php echo $warranty_image['alt']; ?>">
								<?php endif; ?>
							</div>
							<div class="col-section">
								<?php if(!empty($warranty_content)):
									echo $warranty_content;
								endif; ?>	
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		</div>
	</div>
	</div>
<?php }
add_action('woocommerce_after_single_product_summary', 'wc_show_product_tab_content', 9);
// Product video section
function wc_show_product_video(){
	$product = get_fields(); // get all fields of product detail page inside one array
	// Video section
	$video = $product['product_video'];
	$video_image = $video['upload_video_image'];
	$selected_video = $video['select_video_link'];
	if(!empty($video)): ?>
	<section class="video-section">
	    <?php if(!empty($video_image)): ?>
	        <img id="video-cover" src="<?php echo $video_image['url']; ?>" alt="<?php echo $video_image['alt']; ?>" />
	    <?php endif;
	    if($selected_video == "internal_video" && !empty($video[$selected_video])): ?>
	        <iframe id="player" width="100%" src="<?php echo $video['internal_video']['url']; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
	    <?php elseif($selected_video == "external_video" && !empty($video[$selected_video])):
	        $video_url = $video['external_video'];  ?>
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
	<?php endif;
}
add_action('woocommerce_after_single_product_summary', 'wc_show_product_video', 14);
// Change button text on WooCommerce Shop pages
function woocustomizer_edit_shop_button_text(){
    global $product;
    $product_type = $product->get_type(); // Get the Product Type
    // Change text depending on Product type
    switch($product_type){
        case "variable":
            return __('Discover More', 'woocommerce');
            break;
        default:
            return __('Buy Now', 'woocommerce');
    }
}
add_filter('woocommerce_product_add_to_cart_text', 'woocustomizer_edit_shop_button_text');