<?php
// action and function for load zipcode result
add_action('wp_ajax_load_zipcode_result', 'wc_load_zipcode_result'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_load_zipcode_result', 'wc_load_zipcode_result'); // wp_ajax_nopriv_{action}
// action and function for insert zipcode result into the database
add_action('wp_ajax_insert_zipcode_result', 'wc_insert_zipcode_result'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_insert_zipcode_result', 'wc_insert_zipcode_result'); // wp_ajax_nopriv_{action}
// action for get current user location 
add_action('wp_ajax_get_current_user_location', 'wc_get_current_user_location'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_get_current_user_location', 'wc_get_current_user_location'); // wp_ajax_nopriv_{action}
// action for get load delaer location
add_action('wp_ajax_load_dealer_location_result', 'wc_load_dealer_location_result'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_load_dealer_location_result', 'wc_load_dealer_location_result'); // wp_ajax_nopriv_{action}
// action for get load delaer location on product detail page
add_action('wp_ajax_load_dealer_location_result_on_product_detail', 'wc_load_dealer_location_result_on_product_detail'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_load_dealer_location_result_on_product_detail', 'wc_load_dealer_location_result_on_product_detail'); // wp_ajax_nopriv_{action}
// action for get delaer details on product detail page
add_action('wp_ajax_wc_display_dealer_data_result', 'wc_display_dealer_data_result_func'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_wc_display_dealer_data_result', 'wc_display_dealer_data_result_func'); // wp_ajax_nopriv_{action}
// action for get delaer location in text field
add_action('wp_ajax_wc_load_postcode_select_result', 'wc_load_postcode_select_result'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_wc_load_postcode_select_result', 'wc_load_postcode_select_result'); // wp_ajax_nopriv_{action}
// action for get delaer location in text field
add_action('wp_ajax_wc_load_dealer_result', 'wc_load_dealer_result'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_wc_load_dealer_result', 'wc_load_dealer_result'); // wp_ajax_nopriv_{action}
function wc_load_zipcode_result(){
	if(isset($_POST['action']) == "load_zipcode_result"){
		if(isset($_POST['zipcode'])){
			if(!empty($_POST['zipcode'])){
				$zipcode = $_POST['zipcode'];
			}
		}
		if(isset($_POST['product_id'])){
			if(!empty($_POST['product_id'])){
				$product_id = $_POST['product_id'];
			}
		}
		$product = wc_get_product($product_id); // get product details
		$product_name = $product->get_name(); // get product name
		$zipcode_length = strlen($zipcode);
		$locationZipcode = true;
		// $distance_km = 10;
		$output = "";
		if($zipcode !== ""){
			// if zipcode is available in variable product list 
			if($product->is_type('variable')){
				if($product->is_in_stock()){
					$variations = $product->get_available_variations(); // get all variation of products
			    	foreach($variations as $variation){
						$variation_zipcode = $variation['attributes']['attribute_pa_postcode'];
						$variation_zipcode_length = strlen($variation_zipcode);
						if($zipcode_length <= $variation_zipcode_length && $zipcode_length > 2){
							if(stristr($zipcode, substr($variation_zipcode, 0, $zipcode_length))){
								$variation_id = $variation['variation_id'];
				                $variation_obj = new WC_Product_variation($variation_id);
				                $stock = $variation_obj->get_stock_quantity();
				                $variation_attr = $variation_obj->get_variation_attributes();
				                if((is_int($stock) || ctype_digit($stock)) && (int)$stock > 0){
				                    $regular_price = $variation['display_price'];
				                    $address =  $variation_attr['attribute_pa_suburb'];	

				                    $dealer_name =  $variation_attr['attribute_pa_dealer'];	
				                    $output .= '<li class="variation_info" data-product_name="'.$product_name.'" data-product_id="'.$product_id.'" data-variation_id="'.$variation_id.'" data-searched_zipcode="'.$zipcode.'" data-selected_zipcode="'.$variation_zipcode.'" data-dealer="'.$dealer_name.'" data-price="'.$regular_price.'" data-suburb="'.$address.'" data-exact="Yes">'.$address.'</li>';
				                }
					            $locationZipcode = false;
			            	}
			            } 
					}
				}
			}
			// if zipcode is not available in variable product list
			if($locationZipcode == true){
				$output = "";
            	global $wpdb;
				$table_name = $wpdb->prefix.'postcodes_geo';
				$places_zipcode_arr = [];
				// query for getting lat and long
				$lat_long_query = $wpdb->get_results("SELECT * FROM $table_name WHERE postcode = '".$zipcode."' LIMIT 1");
				if(!empty($lat_long_query)):
					foreach($lat_long_query as $result):
					    $latitude = $result->latitude; 
					    $longitude = $result->longitude;
					 	// Calculate distance and filter records by radius 
					 	$sql_distance = $having = ''; 
					 	if(!empty($distance_km) && !empty($latitude) && !empty($longitude)){ 
					 	    $radius_km = $distance_km; 
					 	    $sql_distance = " ,(((acos(sin((".$latitude."*pi()/180)) * sin((`p`.`latitude`*pi()/180))+cos((".$latitude."*pi()/180)) * cos((`p`.`latitude`*pi()/180)) * cos(((".$longitude."-`p`.`longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance ";     
					 	    $having = " HAVING (distance <= $radius_km) ";
					 	    $order_by = ' distance ASC '; 
					 	}
					 	else{
					 	    $order_by = ' p.postcode DESC '; 
					 	}
					 	// Fetch places from the database 
					 	$places_query = $wpdb->get_results("SELECT p.*".$sql_distance." FROM $table_name p $having ORDER BY $order_by");
					 	if(!empty($places_query)):
							$placesZipcode = false;
							foreach($places_query as $places):
								$places_zip = $places->postcode;
								$distance = $places->distance;
								if(in_array($places_zip, $places_zipcode_arr)){ continue; } // check if previously display zipcode also available in database one or more time then skip it

					 			// if zipcode is available in variable product list 
					 			if($product->is_type('variable')){
					 				if($product->is_in_stock()){
					 					$variations = $product->get_available_variations(); // get all variation of products
					 			    	foreach($variations as $variation){
					 						$variation_zipcode = $variation['attributes']['attribute_pa_postcode'];
					 						if($places_zip === $variation_zipcode){
					 							// Store match zipcode to array
					 							$places_zipcode_arr[] = $places_zip;
					 							// product variation data
				 								$variation_id = $variation['variation_id'];
				 				                $variation_obj = new WC_Product_variation($variation_id);
				 				                $stock = $variation_obj->get_stock_quantity();
				 				                $variation_attr = $variation_obj->get_variation_attributes();
				 				                if((is_int($stock) || ctype_digit($stock)) && (int)$stock > 0){
				 				                    $regular_price = $variation['display_price'];
				 				                    $address =  $variation_attr['attribute_pa_suburb'];	
				 				                    $dealer_name =  $variation_attr['attribute_pa_dealer'];	
				 				                    $output .= '<li class="variation_info" data-product_name="'.$product_name.'" data-product_id="'.$product_id.'" data-variation_id="'.$variation_id.'" data-searched_zipcode="'.$zipcode.'" data-selected_zipcode="'.$variation_zipcode.'" data-dealer="'.$dealer_name.'" data-price="'.$regular_price.'" data-suburb="'.$address.'" data-exact="No" data-distance="'.$distance.'">'.$address.'</li>';
				 				                }
				 					            $placesZipcode = true;
					 				        }
					 					}
					 				}
					 			}
							endforeach;
						endif;
					endforeach;
				else:
					$output = "<li class='location_not_found'>Search postcode's product price not found</li>";		
				endif; 
				// If places zipcode not find any zipcode in variable product list
				if($placesZipcode == false){
					$output = "<li class='location_not_found'>Search postcode's product price not found</li>";		
				}
			}
		}
		echo json_encode(array(
			'output' => $output
		));
		exit;
	}
}
function wc_insert_zipcode_result(){
	global $wpdb;
	$table_name = $wpdb->prefix . "product_hit_zipcode";
	$charset_collate = $wpdb->get_charset_collate();
	// Create rilu_product_hit_zipcode table
	$sql = "CREATE TABLE IF NOT EXISTS $table_name(
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`product_id` int(11) NOT NULL,
				`variation_id` int(11) NOT NULL,
	            `product_name` varchar(255) NOT NULL,
	            `searched_zipcode` varchar(30) NOT NULL,
	            `selected_zipcode` varchar(30) NOT NULL,
	            `suburb` varchar(255) NOT NULL,
	            `selected_suburb` varchar(255) NOT NULL,
	            `dealer_name` varchar(255) NOT NULL,
	            `dealer_price` decimal(10,2) NOT NULL,
	            `is_exact` enum('Yes','No') DEFAULT NULL,
	            `dealer_postcode` varchar(30) NOT NULL,
	            `zipcode_distance` varchar(255) DEFAULT NULL,
	            `current_date_hit` date,
	            PRIMARY KEY (id)
	            ) $charset_collate";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);	
	if(isset($_POST['action']) == "insert_zipcode_result"){
		if(isset($_POST['product_name'])){
			if(!empty($_POST['product_name'])){
				$product_name = $_POST['product_name'];
			}
			else{
				$product_name = "";	
			}
		}
		if(isset($_POST['product_id'])){
			if(!empty($_POST['product_id'])){
				$product_id = $_POST['product_id'];
			}
			else{
				$product_id = "";	
			}
		}
		if(isset($_POST['variation_id'])){
			if(!empty($_POST['variation_id'])){
				$variation_id = $_POST['variation_id'];
			}
			else{
				$variation_id = "";	
			}
		}
		if(isset($_POST['searched_zipcode'])){
			if(!empty($_POST['searched_zipcode'])){
				$searched_zipcode = $_POST['searched_zipcode'];
			}
			else{
				$searched_zipcode = "";	
			}
		}
		if(isset($_POST['selected_zipcode'])){
			if(!empty($_POST['selected_zipcode'])){
				$selected_zipcode = $_POST['selected_zipcode'];
			}
			else{
				$selected_zipcode = "";	
			}
		}
		if(isset($_POST['suburb'])){
			if(!empty($_POST['suburb'])){
				$suburb = $_POST['suburb'];
			}
			else{
				$suburb = "";	
			}
		}
		if(isset($_POST['selected_suburb'])){
			if(!empty($_POST['selected_suburb'])){
				$selected_suburb = $_POST['selected_suburb'];
			}
			else{
				$selected_suburb = "";	
			}
		}		
		if(isset($_POST['dealer_name'])){
			if(!empty($_POST['dealer_name'])){
				$dealer = $_POST['dealer_name'];
			}
			else{
				$dealer = "";	
			}
		}
		if(isset($_POST['dealer_price'])){
			if(!empty($_POST['dealer_price'])){
				$price = $_POST['dealer_price'];
			}
			else{
				$price = "";	
			}
		}
		if(isset($_POST['exact'])){
			if(!empty($_POST['exact'])){
				$exact = $_POST['exact'];
			}
			else{
				$exact = "";	
			}
		}
		if(isset($_POST['zipcode_distance'])){
			if(!empty($_POST['zipcode_distance'])){
				$zipcode_distance = $_POST['zipcode_distance'];
			}
			else{
				$zipcode_distance = "";	
			}
		}
		// Insert zipcode data into the database
		if($product_name !== "" && $searched_zipcode !== "" && $selected_zipcode !== "" && $suburb !== "" && $dealer !== "" && $price !== ""){
			$sql = $wpdb->prepare("INSERT INTO `$table_name` (`product_name`, `product_id`, `variation_id`, `searched_zipcode`, `selected_zipcode`, `suburb`, `selected_suburb`, `dealer_name`, `dealer_price`, `is_exact`, `dealer_postcode`, `zipcode_distance`, `current_date_hit` ) values (%s, %d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $product_name, $product_id, $variation_id, $searched_zipcode, $selected_zipcode, $suburb, $selected_suburb, $dealer, $price, $exact, $selected_zipcode, $zipcode_distance, date('Y-m-d'));
			$wpdb->query($sql);
		}
		exit;
	}
}
// get nearest dealer info using entered address
function wp_get_nearest_dealer_info(){
	if(isset($_GET['addressInput']) && !empty($_GET['addressInput'])){
	    global $wpdb;
	    $postcode_or_suburb = $_GET['addressInput'];
	    // $distance_km = 50;
	    $table_name = $wpdb->prefix.'postcodes_geo';
	    $places_postcode_arr = [];
	    // query for getting lat and long
	    $lat_long_query = $wpdb->get_results("SELECT * FROM $table_name WHERE postcode = '".$postcode_or_suburb."' OR suburb = '".strtolower($postcode_or_suburb)."'  LIMIT 1");
	    if(!empty($lat_long_query)):
	        foreach($lat_long_query as $result):
	            $latitude = $result->latitude; 
	            $longitude = $result->longitude;
	            // Calculate distance and filter records by radius 
	            $sql_distance = $having = ''; 
	            // if(!empty($distance_km) && !empty($latitude) && !empty($longitude)){ 
	            if(!empty($latitude) && !empty($longitude)){ 
	                // $radius_km = $distance_km; 
	                $sql_distance = " ,(((acos(sin((".$latitude."*pi()/180)) * sin((`p`.`latitude`*pi()/180))+cos((".$latitude."*pi()/180)) * cos((`p`.`latitude`*pi()/180)) * cos(((".$longitude."-`p`.`longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance ";     
	                // $having = " HAVING (distance <= $radius_km) ";
	                $order_by = ' distance ASC '; 
	            }
	            else{
	                $order_by = ' p.postcode DESC '; 
	            }
	            // Fetch places from the database 
	            // $places_query = $wpdb->get_results("SELECT p.*".$sql_distance." FROM $table_name p $having ORDER BY $order_by");
	            $places_query = $wpdb->get_results("SELECT p.*".$sql_distance." FROM $table_name p ORDER BY $order_by");
	            if(!empty($places_query)):
	                // $placesZipcode = false;
	                foreach($places_query as $places):
	                    $places_zip = $places->postcode;
	                    if(in_array($places_zip, $places_postcode_arr)){ continue; } // check if postcode previously stored in array or not
	                    $places_postcode_arr[] = $places_zip;
	                endforeach;
	            endif;
	        endforeach;                    
	    endif;
	    return $places_postcode_arr;
	}
}
/********************************************************************************************/
/************************** Custom phone number validation in cf7 ***************************/ 
function custom_filter_wpcf7_is_tel($result, $tel){
	$result = preg_match('/^\(?\+?([0-9]{1,5})?\)?[-\. ]?(\d{10})$/', $tel);
	return $result;
}
add_filter('wpcf7_is_tel', 'custom_filter_wpcf7_is_tel', 10, 2);
add_filter('wpcf7_is_tel*', 'custom_filter_wpcf7_is_tel', 10, 2);
/********************************************************************************************/
/************************** Custom name validation in cf7 ***********************************/ 
function custom_name_validation_filter($result, $tag){
	if("contact_name" == $tag->name || "your-name" == $tag->name){
		$name = isset($_POST[$tag->name]) ? $_POST[$tag->name]  : '';
		if($name != "" && !preg_match("/^[a-zA-Z ]*$/", $name)){
			$result->invalidate($tag, "Please Enter Your valid name.");
		}
	}  
	return $result;
}
add_filter('wpcf7_validate_text', 'custom_name_validation_filter', 20, 2);
add_filter('wpcf7_validate_text*', 'custom_name_validation_filter', 20, 2);
// Get current user location
function wc_get_current_user_location(){
	if(isset($_POST['latitude']) && isset($_POST['longitude'])){
		$product_id = $_POST['product_id']; // get product id
		$product = wc_get_product($product_id); // get product details
		$lat = $_POST['latitude']; // get latitude
		$lng = $_POST['longitude']; // get longitude
		$api_key = "AIzaSyDQREPH4gI-KbtFY40PfTU0s1J9PT51Lv0";
		function getPostcode($lat,$lng){
			$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&key=AIzaSyDQREPH4gI-KbtFY40PfTU0s1J9PT51Lv0';

			$json = file_get_contents($url);
			$data = json_decode($json);
			if(!empty($data)){
	            $addressComponents = $data->results[0]->address_components;
	         
	            $currentPostcodeSuburb = array();
	            foreach($addressComponents as $addrComp){
	                if($addrComp->types[0] == 'locality'){
	                	$currentPostcodeSuburb['suburb'] = $addrComp->long_name;
	                }
	                if($addrComp->types[0] == 'postal_code'){
	                    //Return the postcode
	                    $currentPostcodeSuburb['postcode'] = $addrComp->long_name;
	                    return $currentPostcodeSuburb;
	                }
	            }
	            return false;
	        }
	        else{
	            return false;
	        }
		}
		$currentUserPostcode = getPostcode($lat,$lng);
		if(!empty($currentUserPostcode)){
			// get dealer list
		    global $wpdb;
		    
		    if(isset($_COOKIE['dealer_postcode'])){
		    	$postcode = $_COOKIE['dealer_postcode'];
		    }
		    else{
		    	$postcode = $currentUserPostcode['postcode'];
		    }
		    /**********************************/ 
		    /**********************************/ 
			$zipcode = $postcode;
    		$product = wc_get_product($product_id); // get product details
    		$product_name = $product->get_name(); // get product name
    		$zipcode_length = strlen($zipcode);
    		$output = "";
    		if($zipcode !== ""){
				$output = "";
	        	global $wpdb;
				$table_name = $wpdb->prefix.'postcodes_geo';
				// query for getting lat and long of selected zipcode
				$lat_long_query = $wpdb->get_results("SELECT * FROM $table_name WHERE postcode = '".$zipcode."' LIMIT 1");
				if(!empty($lat_long_query)):
				    $latitude = $lat_long_query[0]->latitude; 
					$longitude = $lat_long_query[0]->longitude;
		 			if($product->is_type('variable')):
		 				if($product->is_in_stock()){
		 					$variations = $product->get_available_variations(); // get all variation of products
		 			    	foreach($variations as $variation){
		 						$variation_zipcode = $variation['attributes']['attribute_pa_postcode'];
	 							// product variation data
									$variation_id = $variation['variation_id'];
					                $variation_obj = new WC_Product_variation($variation_id);
					                $stock = $variation_obj->get_stock_quantity();
					                $variation_attr = $variation_obj->get_variation_attributes();
					                if((is_int($stock) || ctype_digit($stock)) && (int)$stock > 0){
					                    // $regular_price = $variation['display_price'];
					                    $address =  $variation_attr['attribute_pa_suburb'];
					                    $term = get_term_by('slug', $address, 'pa_suburb');
										$addres_name = $term->name;   
					                    $suburb_state_addr = explode(",",$addres_name);
					                    $suburb_addr = $suburb_state_addr[0];
					                    $state_addr = $suburb_state_addr[1];
					                    // get latitude and longitude of variable product
					                    $variation_lat_long_query = $wpdb->get_results("SELECT * FROM $table_name WHERE postcode = '".$variation_zipcode."' AND suburb LIKE '%".trim($suburb_addr)."%' AND state LIKE '%".trim($state_addr)."%' LIMIT 1");
					                    if(!empty($variation_lat_long_query)){
					                    	$variation_latitude = $variation_lat_long_query[0]->latitude;
					                    	$variation_longitude = $variation_lat_long_query[0]->longitude;
					                    	// get distance from selected zipcode
					                    	$variation_postcode_distance = distance($latitude, $longitude, $variation_latitude, $variation_longitude, "K");

					                    	$variation_postcode_dist_arr[$variation_id] = $variation_postcode_distance;
					                    	// if($variation_postcode_distance < 51){
					                    	// 	$variation_postcode_dist_arr[$variation_id] = $variation_postcode_distance;
					                    	// }
					                    }
					                }
		 					}

		 					// 29-9-22
		 					foreach($variation_postcode_dist_arr as $variation_id => $distance){
		 						$variation_obj = new WC_Product_variation($variation_id);
								$variation_attr = $variation_obj->get_variation_attributes();
			                    $variation_postcode =  $variation_attr['attribute_pa_postcode'];    

               					$dealer_postcode_args = array(
               						'post_type' => 'dealer',
               						'posts_per_page' => -1,
               						'post_status' => 'publish',
               						'meta_key' => 'dealer_postcode',
               						'meta_value' => $variation_postcode 
               					);
               					$dealer_postcode_query = new WP_Query($dealer_postcode_args);
               	                while($dealer_postcode_query->have_posts()):
               	                    $dealer_postcode_query->the_post();
               	                    
               	                    $dealer_module_postcode = get_field('dealer_postcode', $dealerID);
               	                    $postcode_latitude = get_field('latitude', $dealerID);
               	                    $postcode_longitude = get_field('longitude', $dealerID);

               	                    // get distance from selected postcode
               	                    $postcode_distance = distance($latitude, $longitude, $postcode_latitude, $postcode_longitude, "K");

               	                    $postcode_dist_arr[$variation_id] = $postcode_distance;
               	        		endwhile;
		 					}
		 					// $min_dist = min($postcode_dist_arr);
		 					// $min_dist_variation_id = array_search($min_dist, $postcode_dist_arr);
				 			// 29-9-22

		 					asort($postcode_dist_arr); // Sorted variation postcode array
		 					// display dealer list
		 					$dealer_args = array(
		 						'post_type' => 'dealer',
		 						'posts_per_page' => -1,
		 						'post_status' => 'publish' 
		 					);
		 					$dealer_query = new WP_Query($dealer_args);
		 					$dealer_count = 1;
		 					foreach($postcode_dist_arr as $min_dist_variation_id => $variation_min_dist):
	 							// product variation data
					            $min_dist_variation_obj = new WC_Product_variation($min_dist_variation_id);
					            $min_dist_variation_stock = $min_dist_variation_obj->get_stock_quantity();
					            $min_dist_variation_attr = $min_dist_variation_obj->get_variation_attributes();
			                    $variation_zipcode =  $min_dist_variation_attr['attribute_pa_postcode'];    
								$output_postcode = $variation_zipcode;
			                	$placesZipcode = true;
		                        while($dealer_query->have_posts()):
		                            $dealer_query->the_post();
		                            $dealerID = $dealer_query->ID; 
		                            $dealer_postcode = get_field('dealer_postcode', $dealerID);
		                            $dealer_title = get_field('dealer_title', $dealerID);
		                            $address = get_field('dealer_address', $dealerID);
		                            if($dealer_postcode == $output_postcode && $dealer_count <= 5):
		                            $output .= '<a href="'.get_the_permalink($dealerID).'" target="_blank"><div class="dealership-content">
		                            	<div class="content-info">
		                            		<h4>'.$dealer_title.'</h4>
		                            		<p>'.$address.'</p>
		                            	</div>
		                            </div></a>';
		                            $dealer_count++;
		                    		endif; 
		                		endwhile;
	                		endforeach;
		 				}
		 			endif;		
				else:
					$output = "<li class='location_not_found'>Result Not Found.</li>";	
				endif; 
				// If places postcode not found in variable product list
				if($placesZipcode == false){
					$output = "<li class='location_not_found'>Result Not Found.</li>";	
				}
			}
	    	/*******************************/
	    	/*******************************/
 			// if postcode is available in variable product list 
 			if($product->is_type('variable')){
 				if($product->is_in_stock()){
 					$variations = $product->get_available_variations(); // get all variation of products
 			    	foreach($variations as $variation){
 						$variation_zipcode = $variation['attributes']['attribute_pa_postcode'];
 						if($postcode === $variation_zipcode){
 							// product variation data
							$variation_id = $variation['variation_id'];
			                $variation_obj = new WC_Product_variation($variation_id);
			                $stock = $variation_obj->get_stock_quantity();
			                $variation_attr = $variation_obj->get_variation_attributes();
			                if((is_int($stock) || ctype_digit($stock)) && (int)$stock > 0){
			                    $regular_price = $variation['display_price'];
			                    $address = $variation_attr['attribute_pa_suburb'];
			                    $term = get_term_by('slug', $address, 'pa_suburb');
								$addres_name = $term->name;

								// set cookie for location
								if(isset($_COOKIE['set_dealer_postcode'])){}
								else{
									$suburb = $addres_name;
									setcookie("set_dealer_postcode", $suburb, '', '/');
								}

								if(isset($_COOKIE['dealer_postcode_location'])){}
								else{
									$dealer_postcode_location = $suburb.', '.$postcode;
									setcookie("dealer_postcode_location", $dealer_postcode_location, '', '/');
								}

								if(isset($_COOKIE['dealer_postcode'])){}
								else{
									setcookie("dealer_postcode", $postcode, '', '/');
								}

		 						// return response
		 						if(isset($_COOKIE['dealer_postcode_location'])){
				 						echo json_encode(array(
				 							'message' => "Postcode is found",
											'price' => $regular_price,
											'suburb' => $addres_name,
											'postcode' => $postcode,
				 							'current' => true,
				 							'output' => $output
				 						));
				 						exit;
				 				}
				 				else{
				 					echo json_encode(array(
				 							'message' => "Postcode is found",
											'price' => $regular_price,
											'suburb' => $addres_name,
											'postcode' => $postcode,
											'dealer_postcode_location' => $dealer_postcode_location,
				 							'current' => false,
				 							'output' => $output
				 						));
				 					exit;
				 				}
			                }
 				        }
 					}
 					// Code for find australian postcode in database.
 					global $wpdb;
 					$table_name = $wpdb->prefix.'postcodes_geo';
 					$latitude = round($lat, 1);
 					$longitude = round($lng, 1);
 					// query for check postcode exist in database or not
 					// for current user location	
 					$postcode_query = $wpdb->get_results("SELECT * FROM $table_name WHERE postcode = '".$postcode."' AND latitude LIKE '".$latitude."%' AND longitude LIKE '".$longitude."%' AND suburb = '". $currentUserPostcode['suburb']."' LIMIT 1");

 					// for saved postcode in cookie
 					if(empty($postcode_query)){
 						$postcode_query = $wpdb->get_results("SELECT * FROM $table_name WHERE postcode = '".$postcode."' LIMIT 1");
 					}

 					// Check if postcode found in database
 					if(!empty($postcode_query)){
 						// set cookie for location
 						if(isset($_COOKIE['set_dealer_postcode'])){}
 						else{
 							$suburb = $postcode_query[0]->suburb;
 							setcookie("set_dealer_postcode", $suburb, '', '/');
 						}

 						if(isset($_COOKIE['dealer_postcode_location'])){}
 						else{
 							$dealer_postcode_location = $suburb.', '.$postcode_query[0]->postcode;
 							setcookie("dealer_postcode_location", $dealer_postcode_location, '', '/');
 						}
 						// return response
 						if(isset($_COOKIE['dealer_postcode_location'])){
		 						echo json_encode(array(
		 							'message' => "Australian Postcode found",
		 							'suburb' => $postcode_query[0]->suburb,
		 							'postcode' => $postcode_query[0]->postcode,
		 							'current' => true,
		 							'output' => $output
		 						));
		 						exit;
		 				}
		 				else{
		 					echo json_encode(array(
		 							'message' => "Australian Postcode found",
		 							'suburb' => $postcode_query[0]->suburb,
		 							'postcode' => $postcode_query[0]->postcode,
		 							'dealer_postcode_location' => $dealer_postcode_location,
		 							'current' => false,
		 							'output' => $output
		 						));
		 					exit;
		 				}
 					}
 					else{
 						echo json_encode(array(
 							'message' => "Postcode not found",
 						));
 						exit;
 					}
 				}
 			}
		}
		else{
			echo json_encode(array(
				'message' => "Postcode not found",
			));
			exit;
		}
	}
}
function wc_load_dealer_location_result(){
	if(isset($_POST['action']) == "load_dealer_location_result"){
		if(isset($_POST['postcode'])){
			if(!empty($_POST['postcode'])){
				$postcode = $_POST['postcode'];
			}
		}
		if($postcode && strlen($postcode) > 2 && strlen($postcode) < 5){
			global $wpdb;
			$table_name = $wpdb->prefix.'postcodes_geo';
			// query for check postcode exist in database or not
			$postcode_query = $wpdb->get_results("SELECT suburb, postcode, state FROM $table_name WHERE postcode LIKE '".$postcode."%'");
			// Check if postcode found in database
			$output = "";
			if(!empty($postcode_query)){
				foreach($postcode_query as $dealer_data){
					$suburb = $dealer_data->suburb;
					$postcode = $dealer_data->postcode;
					$state = $dealer_data->state;
					$output .= '<li class="dealer_location_info" data-suburb="'.$suburb.'" data-postcode="'.$postcode.'" data-state="'.$state.'">'.$suburb.", ".$postcode." ".$state.'</li>';
				}
			}
			else{
				$output = "<li class='dealer_location_not_found'>No results found.</li>";
			}
		}
		else{
			$output = "<li class='dealer_location_not_found'>No results found.</li>";
		}
	}
	echo json_encode(array(
		'output' => $output
	));
	exit;
}
function wc_load_dealer_location_result_on_product_detail(){
	if(isset($_POST['action']) == "load_dealer_location_result"){
		if(isset($_POST['postcode'])){
			if(!empty($_POST['postcode'])){
				$postcode = $_POST['postcode'];
			}
		}
		if($postcode && strlen($postcode) > 2 && strlen($postcode) < 5){
			global $wpdb;
			$table_name = $wpdb->prefix.'postcodes_geo';
			// query for check postcode exist in database or not
			$postcode_query = $wpdb->get_results("SELECT suburb, postcode, state FROM $table_name WHERE postcode LIKE '".$postcode."%'");
			// Check if postcode found in database
			$output = "";
			if(!empty($postcode_query)){
				foreach($postcode_query as $dealer_data){
					$suburb = $dealer_data->suburb;
					$postcode = $dealer_data->postcode;
					$state = $dealer_data->state;
					$output .= '<li class="dealer_location_product_detail" data-suburb="'.$suburb.'" data-postcode="'.$postcode.'" data-state="'.$state.'">'.$suburb.", ".$postcode." ".$state.'</li>';
				}
			}
			else{
				$output = "<li class='location_not_found'>No results found.</li>";
			}
		}
		else{
			$output = "<li class='location_not_found'>No results found.</li>";
		}
	}
	echo json_encode(array(
		'output' => $output
	));
	exit;
}
function wc_display_dealer_data_result_func(){
		if(isset($_POST['action']) == "wc_display_dealer_data_result"){
			if(isset($_POST['postcode'])){
				if(!empty($_POST['postcode'])){
					$zipcode = $_POST['postcode'];
				}
			}
			if(isset($_POST['product_id'])){
				if(!empty($_POST['product_id'])){
					$product_id = $_POST['product_id'];
				}
			}
			if(isset($_POST['suburb'])){
				if(!empty($_POST['suburb'])){
					$suburb = $_POST['suburb'];
				}
			}
			$product = wc_get_product($product_id); // get product details
			$product_name = $product->get_name(); // get product name
			$zipcode_length = strlen($zipcode);
			$locationZipcode = true;
			$distance_km = 10;
			$output = "";
			if($zipcode !== ""){
				// if zipcode is available in variable product list 
				if($product->is_type('variable')){
					if($product->is_in_stock()){
						$variations = $product->get_available_variations(); // get all variation of products
				    	foreach($variations as $variation){
							$variation_zipcode = $variation['attributes']['attribute_pa_postcode'];
							$variation_zipcode_length = strlen($variation_zipcode);

							if($zipcode_length <= $variation_zipcode_length && $zipcode_length > 2){
								if(stristr($zipcode, substr($variation_zipcode, 0, $zipcode_length))){
									$variation_id = $variation['variation_id'];
					                $variation_obj = new WC_Product_variation($variation_id);
					                $stock = $variation_obj->get_stock_quantity();
					                $variation_attr = $variation_obj->get_variation_attributes();
					                if((is_int($stock) || ctype_digit($stock)) && (int)$stock > 0){
					                    $regular_price = $variation['display_price'];
					                    $address =  $variation_attr['attribute_pa_suburb'];
					                    $address_term = get_term_by('slug', $address, 'pa_suburb');
										$addres_name = $address_term->name;
					                    $dealer =  $variation_attr['attribute_pa_dealer'];  
					                    $dealer_term = get_term_by('slug', $dealer, 'pa_dealer');
										$dealer_name = $dealer_term->name; 
					                    $exact = "Yes";
					                    $output_postcode = $variation_zipcode;
					                    $output_price = $regular_price;
					                    $output_suburb = ucfirst($address);
					                    $locationZipcode = false;
					                    break;
					                }
				            	}
				            }
						}
					}
				}
				// if zipcode is not match then find nearest postcode from variable product list
				if($locationZipcode == true){
					$output = "";
	            	global $wpdb;
					$table_name = $wpdb->prefix.'postcodes_geo';
					// query for getting lat and long of selected zipcode
					$lat_long_query = $wpdb->get_results("SELECT * FROM $table_name WHERE postcode = '".$zipcode."' LIMIT 1");
					if(!empty($lat_long_query)):
					    $latitude = $lat_long_query[0]->latitude; 
						$longitude = $lat_long_query[0]->longitude;
			 			if($product->is_type('variable')):
			 				if($product->is_in_stock()){
			 					$variations = $product->get_available_variations(); // get all variation of products
			 			    	foreach($variations as $variation){
			 						$variation_zipcode = $variation['attributes']['attribute_pa_postcode'];
		 							// product variation data
	 								$variation_id = $variation['variation_id'];
	 				                $variation_obj = new WC_Product_variation($variation_id);
	 				                $stock = $variation_obj->get_stock_quantity();
	 				                $variation_attr = $variation_obj->get_variation_attributes();
	 				                if((is_int($stock) || ctype_digit($stock)) && (int)$stock > 0){
	 				                    // $regular_price = $variation['display_price'];
	 				                    $address =  $variation_attr['attribute_pa_suburb'];
					                    $address_term = get_term_by('slug', $address, 'pa_suburb');
										$addres_name = $address_term->name;
					                    $dealer =  $variation_attr['attribute_pa_dealer'];  
					                    $dealer_term = get_term_by('slug', $dealer, 'pa_dealer');
										$dealer_name = $dealer_term->name; 
	 				                    
	 				                    $suburb_state_addr = explode(",",$addres_name);
	 				                    $suburb_addr = $suburb_state_addr[0];
	 				                    $state_addr = $suburb_state_addr[1];

	 				                    // get latitude and longitude of variable product
	 				                    $variation_lat_long_query = $wpdb->get_results("SELECT * FROM $table_name WHERE postcode = '".$variation_zipcode."' AND suburb LIKE '%".trim($suburb_addr)."%' AND state LIKE '%".trim($state_addr)."%' LIMIT 1");
	 				                    if(!empty($variation_lat_long_query)){
	 				                    	$variation_latitude = $variation_lat_long_query[0]->latitude;
	 				                    	$variation_longitude = $variation_lat_long_query[0]->longitude;
	 				                    	// get distance from selected zipcode
	 				                    	$variation_postcode_distance = distance($latitude, $longitude, $variation_latitude, $variation_longitude, "K");
	 				                    	$variation_postcode_dist_arr[$variation_id] = $variation_postcode_distance;
	 				                    }
	 				                }
			 					}

				 				// 29-9-22
			 					foreach($variation_postcode_dist_arr as $variation_id => $distance){
			 						$variation_obj = new WC_Product_variation($variation_id);
									$variation_attr = $variation_obj->get_variation_attributes();
				                    $variation_postcode =  $variation_attr['attribute_pa_postcode'];    

                   					$dealer_postcode_args = array(
                   						'post_type' => 'dealer',
                   						'posts_per_page' => -1,
                   						'post_status' => 'publish',
                   						'meta_key' => 'dealer_postcode',
                   						'meta_value' => $variation_postcode 
                   					);
                   					$dealer_postcode_query = new WP_Query($dealer_postcode_args);
                   	                while($dealer_postcode_query->have_posts()):
                   	                    $dealer_postcode_query->the_post();
                   	                    
                   	                    $dealer_module_postcode = get_field('dealer_postcode', $dealerID);
                   	                    $postcode_latitude = get_field('latitude', $dealerID);
                   	                    $postcode_longitude = get_field('longitude', $dealerID);

                   	                    // get distance from selected postcode
                   	                    $postcode_distance = distance($latitude, $longitude, $postcode_latitude, $postcode_longitude, "K");

                   	                    $postcode_dist_arr[$variation_id] = $postcode_distance;
                   	        		endwhile;
			 					}
			 					$min_dist = min($postcode_dist_arr);
			 					$min_dist_variation_id = array_search($min_dist, $postcode_dist_arr);
				 				// 29-9-22
			 					// $variation_min_dist = min($variation_postcode_dist_arr);
			 					// $min_dist_variation_id = array_search($variation_min_dist, $variation_postcode_dist_arr);

	 							// product variation data
 				                $min_dist_variation_obj = new WC_Product_variation($min_dist_variation_id);
 				                $min_dist_variation_stock = $min_dist_variation_obj->get_stock_quantity();
 				                $min_dist_variation_attr = $min_dist_variation_obj->get_variation_attributes();

 				                $regular_price = $min_dist_variation_obj->get_regular_price();
 				                $address =  $variation_attr['attribute_pa_suburb'];
								$address_term = get_term_by('slug', $address, 'pa_suburb');
								$addres_name = $address_term->name;

			                    $dealer =  $min_dist_variation_attr['attribute_pa_dealer'];  
			                    $dealer_term = get_term_by('slug', $dealer, 'pa_dealer');
								$dealer_name = $dealer_term->name; 
    
			                    $variation_zipcode =  $min_dist_variation_attr['attribute_pa_postcode'];    
			                    $exact = "No";
								$output_postcode = $variation_zipcode;
			                    $output_price = $regular_price;
			                    $output_suburb = ucfirst($address);
			                    $variation_id = $min_dist_variation_id;
			                    $place_distance = $variation_min_dist;
			                	$placesZipcode = true;
			 				}
			 			endif;		
					else:
						$output = "<li class='location_not_found'>Search postcode's product price not found</li>";	
					endif; 
					// If places zipcode not find any zipcode in variable product list
					if($placesZipcode == false){
						$output = "<li class='location_not_found'>Search postcode's product price not found</li>";	
					}
				}
			}

			// display dealer details
			if(!empty($output_postcode)){
				$dealer_detail = "";
				$dealer_args = array(
					'post_type' => 'dealer',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'meta_key' => 'dealer_postcode',
					'meta_value' => $output_postcode 
				);
				$dealer_query = new WP_Query($dealer_args);
                while($dealer_query->have_posts()):
                    $dealer_query->the_post();
                    $dealerID = $dealer_query->ID; 
                    $dealer_title = get_the_title();
                    $dealer_title = html_entity_decode($dealer_title);
                    $dealer_name = html_entity_decode($dealer_name);
                    $dealer_title_html = !empty($dealer_title) ? "<h4 style='color: #000000;text-transform: uppercase;margin-bottom: 5px;'>$dealer_title</h4>" : "";

                    $address = get_field('dealer_address', $dealerID);
                    $address = !empty($address) ? "<div>$address</div>" : "";

                    $phone = get_field('dealer_phone', $dealerID);
                    $phone = !empty($phone) ? "<div><a href='tel:+$phone'>$phone</a></div>" : "";

                    $email = get_field('dealer_email', $dealerID);
                    $email = !empty($email) ? "<div><a href='mailto:$email'>$email</a></div>" : "";

                    $site_link = get_field('dealer_site_link', $dealerID);
                    $site_link = !empty($site_link) ? "<div><a href='$site_link' target='_blank'>$site_link</a></div>" : "";
                    $dealer_postcode = get_field('dealer_postcode', $dealerID);

                    $dealer_output = $dealer_title_html.$address.$phone.$email.$site_link;
                    if(($dealer_postcode == $output_postcode) && (trim($dealer_name) == trim ($dealer_title))):
                    	$dealer_detail .= $dealer_output;
            		endif; 
        		endwhile;
			}

			echo json_encode(array(
				'output' => $output,
				'output_postcode' => $output_postcode,
				'output_price' => $output_price,
				'output_suburb' => $addres_name,
				'product_name' => $product_name,
				'product_id' => $product_id,
				'variation_id' => $variation_id,
				'searched_zipcode' => $zipcode,
				'selected_zipcode' => $output_postcode,
				'suburb' => $address,
				'dealer_name' => $dealer_name,
				'dealer_price' => $regular_price,
				'dealer_detail' => $dealer_detail,
				'exact' => $exact,
				'zipcode_distance' => $place_distance,
			));
			exit;
		}
}
// Find distance between two postcode
function distance($lat1, $lon1, $lat2, $lon2, $unit){
	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	if($unit == "K"){
		if(trim($miles) == 'NAN'){
			$miles = 0;
		}
		return ($miles * 1.609344);
	}
	else{
		if(trim($miles) == 'NAN'){
			$miles = 0;
		}
		return $miles;
	}
}

function wc_load_postcode_select_result(){
	if(isset($_COOKIE['set_select_postcode'])){
		unset($_COOKIE['set_select_postcode']);
	}
	$select_postcode = $_REQUEST['select_postcode'];
	setcookie("set_select_postcode", $select_postcode, '', '/');	
	echo json_encode(array('status' => 'true', 'selected_postcode' => $select_postcode));
	die();
}
function wc_load_dealer_result(){
	if(isset($_COOKIE['set_dealer_postcode'])){
		unset($_COOKIE['set_dealer_postcode']);
	}
	$suburb = $_REQUEST['suburb'];
	setcookie("set_dealer_postcode", $suburb, '', '/');

	if(isset($_COOKIE['dealer_postcode_location'])){
		unset($_COOKIE['dealer_postcode_location']);
	}
	$dealer_postcode_location = $_REQUEST['dealer_postcode_location'];
	setcookie("dealer_postcode_location", $dealer_postcode_location, '', '/');
	
	if(isset($_POST['postcode']) && !empty($_POST['postcode'])){
		// set cookie for get dealer list on popup form
		if(isset($_COOKIE['dealer_postcode'])){
			unset($_COOKIE['dealer_postcode']);
		}
		setcookie("dealer_postcode", $_POST['postcode'], '', '/');

	    /**********************************/ 
	    /**********************************/ 
		if(isset($_POST['postcode'])){
			if(!empty($_POST['postcode'])){
				$zipcode = $_POST['postcode'];
			}
		}
		if(isset($_POST['product_id'])){
			if(!empty($_POST['product_id'])){
				$product_id = $_POST['product_id'];
			}
		}
		if(isset($_POST['suburb'])){
			if(!empty($_POST['suburb'])){
				$suburb = $_POST['suburb'];
			}
		}
		$product = wc_get_product($product_id); // get product details
		$product_name = $product->get_name(); // get product name
		$zipcode_length = strlen($zipcode);
		$output = "";
		if($zipcode !== ""){
			$output = "";
        	global $wpdb;
			$table_name = $wpdb->prefix.'postcodes_geo';
			// query for getting lat and long of selected zipcode
			$lat_long_query = $wpdb->get_results("SELECT * FROM $table_name WHERE postcode = '".$zipcode."' LIMIT 1");
			if(!empty($lat_long_query)):
			    $latitude = $lat_long_query[0]->latitude; 
				$longitude = $lat_long_query[0]->longitude;
	 			if($product->is_type('variable')):
	 				if($product->is_in_stock()){
	 					$variations = $product->get_available_variations(); // get all variation of products
	 			    	foreach($variations as $variation){
	 						$variation_zipcode = $variation['attributes']['attribute_pa_postcode'];
 							// product variation data
								$variation_id = $variation['variation_id'];
				                $variation_obj = new WC_Product_variation($variation_id);
				                $stock = $variation_obj->get_stock_quantity();
				                $variation_attr = $variation_obj->get_variation_attributes();
				                if((is_int($stock) || ctype_digit($stock)) && (int)$stock > 0){
				                    // $regular_price = $variation['display_price'];
				                    $address =  $variation_attr['attribute_pa_suburb'];
				                    $term = get_term_by('slug', $address, 'pa_suburb');
									$addres_name = $term->name;   
				                    $suburb_state_addr = explode(",",$addres_name);
				                    $suburb_addr = $suburb_state_addr[0];
				                    $state_addr = $suburb_state_addr[1];
				                    // get latitude and longitude of variable product
				                    $variation_lat_long_query = $wpdb->get_results("SELECT * FROM $table_name WHERE postcode = '".$variation_zipcode."' AND suburb LIKE '%".trim($suburb_addr)."%' AND state LIKE '%".trim($state_addr)."%' LIMIT 1");

				                    if(!empty($variation_lat_long_query)){
				                    	$variation_latitude = $variation_lat_long_query[0]->latitude;
				                    	$variation_longitude = $variation_lat_long_query[0]->longitude;
				                    	// get distance from selected zipcode
				                    	$variation_postcode_distance = distance($latitude, $longitude, $variation_latitude, $variation_longitude, "K");

				                    	$variation_postcode_dist_arr[$variation_id] = $variation_postcode_distance;
				                    	// if($variation_postcode_distance < 51){
				                    	// 	$variation_postcode_dist_arr[$variation_id] = $variation_postcode_distance;
				                    	// }
				                    }
				                }
	 					}
	 					// 29-9-22
	 					foreach($variation_postcode_dist_arr as $variation_id => $distance){
	 						$variation_obj = new WC_Product_variation($variation_id);
							$variation_attr = $variation_obj->get_variation_attributes();
		                    $variation_postcode =  $variation_attr['attribute_pa_postcode'];    

           					$dealer_postcode_args = array(
           						'post_type' => 'dealer',
           						'posts_per_page' => -1,
           						'post_status' => 'publish',
           						'meta_key' => 'dealer_postcode',
           						'meta_value' => $variation_postcode 
           					);
           					$dealer_postcode_query = new WP_Query($dealer_postcode_args);
           	                while($dealer_postcode_query->have_posts()):
           	                    $dealer_postcode_query->the_post();
           	                    
           	                    $dealer_module_postcode = get_field('dealer_postcode', $dealerID);
           	                    $postcode_latitude = get_field('latitude', $dealerID);
           	                    $postcode_longitude = get_field('longitude', $dealerID);

           	                    // get distance from selected postcode
           	                    $postcode_distance = distance($latitude, $longitude, $postcode_latitude, $postcode_longitude, "K");

           	                    $postcode_dist_arr[$variation_id] = $postcode_distance;
           	        		endwhile;
	 					}
	 					// $min_dist = min($postcode_dist_arr);
	 					// $min_dist_variation_id = array_search($min_dist, $postcode_dist_arr);
			 			// 29-9-22

	 					asort($postcode_dist_arr); // Sorted variation postcode array

	 					// display dealer list
	 					$dealer_args = array(
	 						'post_type' => 'dealer',
	 						'posts_per_page' => -1,
	 						'post_status' => 'publish' 
	 					);
	 					$dealer_query = new WP_Query($dealer_args);
	 					$dealer_count = 1;
	 					foreach($postcode_dist_arr as $min_dist_variation_id => $variation_min_dist):
 							// product variation data
				            $min_dist_variation_obj = new WC_Product_variation($min_dist_variation_id);
				            $min_dist_variation_stock = $min_dist_variation_obj->get_stock_quantity();
				            $min_dist_variation_attr = $min_dist_variation_obj->get_variation_attributes();
		                    $variation_zipcode =  $min_dist_variation_attr['attribute_pa_postcode'];    
							$output_postcode = $variation_zipcode;
		                	$placesZipcode = true;
	                        while($dealer_query->have_posts()):
	                            $dealer_query->the_post();
	                            $dealerID = $dealer_query->ID; 
	                            $dealer_postcode = get_field('dealer_postcode', $dealerID);
	                            $dealer_title = get_field('dealer_title', $dealerID);
	                            $address = get_field('dealer_address', $dealerID);
	                            if($dealer_postcode == $output_postcode && $dealer_count <= 5):
	                            $output .= '<a href="'.get_the_permalink($dealerID).'" target="_blank"><div class="dealership-content">
	                            	<div class="content-info">
	                            		<h4>'.$dealer_title.'</h4>
	                            		<p>'.$address.'</p>
	                            	</div>
	                            </div></a>';
	                            $dealer_count++;
	                    		endif; 
	                		endwhile;
                		endforeach;
	 				}
	 			endif;		
			else:
				$output = "<li class='location_not_found'>Result Not Found.</li>";	
			endif; 
			// If places postcode not found in variable product list
			if($placesZipcode == false){
				$output = "<li class='location_not_found'>Result Not Found.</li>";	
			}
		}
	    /**********************************/ 
	    /**********************************/
    	echo json_encode(array(
			'output' => $output
		));
        exit;
	}
}
// set image size
add_image_size('blog-first-img', 770, 660, true); 
add_image_size('blog-imgs', 410, 320, true); 
add_image_size('blog-sidebar-img', 80, 80, true); 
add_image_size('product-imgs', 370, 320, true); 
// Remove the WordPress version
add_filter('the_generator', '__return_false');
// Disable HTML in WordPress comments
add_filter('pre_comment_content', 'esc_html');
// Disable WordPress Login Hints
function no_wordpress_errors(){
	return 'Please try the right user/pass combination';
}
add_filter('login_errors', 'no_wordpress_errors');
// Remove Query String from Static Resources
// function remove_cssjs_ver($src){
// if(strpos($src, '?ver='))
// 	$src = remove_query_arg( 'ver', $src );
// 	return $src;
// }
// add_filter('style_loader_src', 'remove_cssjs_ver', 10, 2);
// add_filter('script_loader_src', 'remove_cssjs_ver', 10, 2);
// Remove Shortlink
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
// Disable Embed
function disable_embed(){
	wp_dequeue_script('wp-embed');
}
add_action('wp_footer', 'disable_embed');
// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');
// Remove RSD Link
remove_action('wp_head', 'rsd_link');
// Hide Version
remove_action('wp_head', 'wp_generator') ;
// Remove WLManifest Link
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links', 2); 
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
// Disable Self Pingback
function disable_pingback(&$links){
  foreach($links as $l => $link)
        if(0 === strpos($link, get_option('home')))
            unset($links[$l]);
}
add_action('pre_ping', 'disable_pingback');
// Disable Heartbeat
function stop_heartbeat(){
	wp_deregister_script('heartbeat');
}
add_action('init', 'stop_heartbeat', 1);
// Disable Dashicons in Front-end
function wpdocs_dequeue_dashicon(){
	if(current_user_can('update_core')){
	    return;
	}
	wp_deregister_style('dashicons');
}
add_action('wp_enqueue_scripts', 'wpdocs_dequeue_dashicon');
// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
  $post_types = get_post_types();
  foreach ($post_types as $post_type) {
    if(post_type_supports($post_type, 'comments')) {
      remove_post_type_support($post_type, 'comments');
      remove_post_type_support($post_type, 'trackbacks');
    }
  }
}
add_action('admin_init', 'df_disable_comments_post_types_support');
// Close comments on the front-end
function df_disable_comments_status() {
	return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);
// Hide existing comments
function df_disable_comments_hide_existing_comments($comments){
	$comments = array();
 	return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);
// Remove comments page in menu
function df_disable_comments_admin_menu(){	
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');

// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect(){
	global $pagenow;
  	if ($pagenow === 'edit-comments.php'){
    	wp_redirect(admin_url());
    	exit;
  	}
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');
// Remove comments metabox from dashboard
function df_disable_comments_dashboard(){
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');
// Remove comments links from admin bar
function df_disable_comments_admin_bar(){
  if (is_admin_bar_showing()) {
    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
  }
}
add_action('init', 'df_disable_comments_admin_bar');
// disable embed in wordpress
function disable_embeds_code_init(){
	// Remove the REST API endpoint.
	remove_action('rest_api_init', 'wp_oembed_register_route');
	// Turn off oEmbed auto discovery.
	add_filter('embed_oembed_discover', '__return_false');
	// Don't filter oEmbed results.
	remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
	// Remove oEmbed discovery links.
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	// Remove oEmbed-specific JavaScript from the front-end and back-end.
	remove_action('wp_head', 'wp_oembed_add_host_js');
	add_filter('tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin');
	// Remove all embeds rewrite rules.
	add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
	// Remove filter of the oEmbed result before any HTTP requests are made.
	remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
}
add_action('init', 'disable_embeds_code_init', 9999);
function disable_embeds_tiny_mce_plugin($plugins){
    return array_diff($plugins, array('wpembed'));
}
function disable_embeds_rewrites($rules){
    foreach($rules as $rule => $rewrite){
        if(false !== strpos($rewrite, 'embed=true')){
            unset($rules[$rule]);
        }
    }
    return $rules;
}
// Disable the emoji's
function disable_emojis(){
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles'); 
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji'); 
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
	add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');
// Filter function used to remove the tinymce emoji plugin
function disable_emojis_tinymce($plugins){
	if(is_array($plugins)){
		return array_diff($plugins, array('wpemoji'));
	}
	else{
		return array();
	}
}
// Remove emoji CDN hostname from DNS prefetching hints.
function disable_emojis_remove_dns_prefetch($urls, $relation_type){
	if('dns-prefetch' == $relation_type){
 		/** This filter is documented in wp-includes/formatting.php */
 		$emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
		$urls = array_diff($urls, array($emoji_svg_url));
 	}
	return $urls;
}
// disable RSS feed
function itsme_disable_feed(){
	wp_die(__('No feed available, please visit the <a href="'. esc_url(home_url('/')) .'">homepage</a>!'));
}
add_action('do_feed', 'itsme_disable_feed', 1);
add_action('do_feed_rdf', 'itsme_disable_feed', 1);
add_action('do_feed_rss', 'itsme_disable_feed', 1);
add_action('do_feed_rss2', 'itsme_disable_feed', 1);
add_action('do_feed_atom', 'itsme_disable_feed', 1);
add_action('do_feed_rss2_comments', 'itsme_disable_feed', 1);
add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);
// DNS Prefetch
function wp_dns_prefetch(){
    echo '<meta http-equiv="x-dns-prefetch-control" content="on">
	<link rel="dns-prefetch" href="//www.youtube.com/" />'; // last step has '; make sure it should be therein last 
}
add_action('wp_head', 'wp_dns_prefetch', 0);

// Add acf option page
if(function_exists('acf_add_options_page')){
	acf_add_options_page(array(
		'page_title' 	=> 'Options',
		'menu_title'	=> 'Options',
		'menu_slug' 	=> 'acf-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

/**
 * Removes the shop from sitemap
 */
function wp_remove_shop_page_link_from_index($link, $post_type){
	// Disable product/post archives in the sitemaps
	if($post_type === 'product')
		return false;	
	return $link;
}
add_filter('wpseo_sitemap_post_type_archive_link', 'wp_remove_shop_page_link_from_index', 10, 2);
?>
