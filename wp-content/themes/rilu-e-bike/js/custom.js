jQuery(document).ready(function(){
	// Auto scroll on dealer-section when dealer or state dealer page
	if(!(jQuery(".not_scroll_dealer").length > 0)){
		if(jQuery('#dealer-section').length > 0){			
			var offset = jQuery('#dealer-section').offset().top; // offset
			jQuery('html, body').animate({
				scrollTop: offset - 210,
			}, "slow");	
		}
	}

	// call this when fillup the postcode text
	jQuery('.zipcode_form').on('keyup', function(){
		var zipcode = jQuery('.zipcode').val();
		var product_id  = jQuery('.search_product_id').val();
		jQuery("#show_dealer_address").html("<li>Searching location...</li>");
		// call ajax for load postcode result
		if(zipcode.length > 2){
			jQuery.ajax({
			    type: "POST",
			    dataType: "json",
			    url: rilu_ajax_object.ajaxurl,
			    data: {
			    	'action': 'load_zipcode_result',
			    	'zipcode': zipcode,
			    	'product_id': product_id 
			    },
			    success: function(response){
			        jQuery("#show_dealer_address").fadeIn();
			        jQuery("#show_dealer_address").html(response.output);
			    },
			});
		}
		return false;
	});
	// call this when fillup the postcode text in dealer page
	jQuery('.dealer_form').on('keyup', function(){
		var postcode = jQuery('.postcode').val();
		if(postcode.length == ""){
			jQuery('.close-wrapper').hide();
		}
		jQuery(".dealer_form .show_dealer_location").html("<li>Searching location...</li>");
		// call ajax for load dealer's location result using postcode
		if(postcode.length > 2){	
			jQuery.ajax({
			    type: "POST",
			    dataType: "json",
			    url: rilu_ajax_object.ajaxurl,
			    data: {
			    	'action': 'load_dealer_location_result',
			    	'postcode': postcode
			    },
			    success: function(response){
			        jQuery(".dealer_form .show_dealer_location").fadeIn();
			        jQuery(".dealer_form .show_dealer_location").html(response.output);
			    },
			});
		}
		return false;
	});
	// call this when fillup the postcode text in dealer page (mobile)
	jQuery('.mobile_dealer_form').on('keyup', function(){
		var postcode = jQuery('.mobile_postcode').val();
		if(postcode.length == ""){
			jQuery('.close-wrapper').hide();
		}
		jQuery(".mobile_dealer_form .show_dealer_location").html("<li>Searching location...</li>");
		// call ajax for load dealer's location result using postcode
		if(postcode.length > 2){	
			jQuery.ajax({
			    type: "POST",
			    dataType: "json",
			    url: rilu_ajax_object.ajaxurl,
			    data: {
			    	'action': 'load_dealer_location_result',
			    	'postcode': postcode
			    },
			    success: function(response){
			        jQuery(".mobile_dealer_form .show_dealer_location").fadeIn();
			        jQuery(".mobile_dealer_form .show_dealer_location").html(response.output);
			    },
			});
		}
		return false;
	});
	// call this when fillup the postcode text in product detail page
	jQuery('#product_dealer_form').on('keyup', function(){
		var postcode = jQuery('.product_postcode').val();
		jQuery("#product_dealer_form .show_dealer_location").html("<li>Searching location...</li>");
		// call ajax for load dealer's location result using postcode
		if(postcode.length > 2){
			jQuery.ajax({
			    type: "POST",
			    dataType: "json",
			    url: rilu_ajax_object.ajaxurl,
			    data: {
			    	'action': 'load_dealer_location_result_on_product_detail',
			    	'postcode': postcode
			    },
			    success: function(response){
			        jQuery("#product_dealer_form .show_dealer_location").fadeIn();
			        jQuery("#product_dealer_form .show_dealer_location").html(response.output);
			    },
			});
		}
		return false;
	});
	// call this when click on location list field in product detail page
	jQuery(document).on("click", "li.variation_info", function(){
		var regular_price = jQuery(this).attr('data-price');
		var product_name = jQuery(this).attr('data-product_name');
		var product_id = jQuery(this).attr('data-product_id');
		var variation_id = jQuery(this).attr('data-variation_id');
		var searched_zipcode = jQuery(this).attr('data-searched_zipcode');
		var selected_zipcode = jQuery(this).attr('data-selected_zipcode');
		var dealer = jQuery(this).attr('data-dealer');
		var suburb = jQuery(this).attr('data-suburb');
		var exact = jQuery(this).attr('data-exact');
		var zipcode_distance = jQuery(this).attr('data-distance');
		// empty the zipcode text field
		jQuery(".zipcode").val('');
		jQuery('#show_dealer_price').show(); // show currency symbol click on suburb
		jQuery('#show_dealer_price span').text(regular_price); // show dealer price
		jQuery("#show_dealer_address").fadeOut(); 
		jQuery('.zipcode_form input[name="zipcode"]').val(suburb); //  Update price in text field
		// call ajax for insert selected suburb field data into the database
		jQuery.ajax({
		    type: "POST",
		    dataType: "json",
		    url: rilu_ajax_object.ajaxurl,
		    data: {
		    	'action': 'insert_zipcode_result',
		    	'product_name': product_name,
		    	'product_id': product_id,
		    	'variation_id': variation_id,
		    	'searched_zipcode': searched_zipcode,
		    	'selected_zipcode': selected_zipcode,
		    	'suburb': suburb,
		    	'dealer_name': dealer,
		    	'dealer_price': regular_price,
		    	'exact': exact,
		    	'zipcode_distance': zipcode_distance
		    },
		    success: function(response){
		    	console.log('Database Inserted successfully');  
		    },
		});
	});
	// call this when click on location list field in dealer page
	jQuery(document).on("click", "li.dealer_location_info", function(){
		// Get current location
		var dealer_postcode_location = jQuery(this).text();
		var findMeButton = jQuery('.find-current-location');
		var product_id = findMeButton.val();
		var search_postcode = jQuery('.dealer_form input[name="addressInput"]').val();
		var dealer_form_class = ".dealer_postcode_form";
		if(search_postcode == ""){
			search_postcode = jQuery('.mobile_dealer_form input[name="addressInput"]').val();
			dealer_form_class = ".mobile_dealer_postcode_form";
		}
		var suburb = jQuery(this).attr('data-suburb');
		var postcode = jQuery(this).attr('data-postcode');
		var state = jQuery(this).attr('data-state');
		var location = suburb + ', '+ postcode + ' ' + state;
		// Check if it is product detail page or not
		if(product_id && product_id != ""){
			// Set user location
			jQuery('.location-pin a').text(suburb);
			jQuery('.dealer_form input[name="addressInput"]').val(location);
			jQuery(".show_dealer_location").fadeOut();
			// call ajax for select location
			jQuery.ajax({
			    type: "POST",
			    dataType: "json",
			    url: rilu_ajax_object.ajaxurl,
			    data: {
			    	'action': 'wc_load_dealer_result',
			    	'postcode': postcode,
			    	'dealer_postcode_location': dealer_postcode_location,
			    	'suburb': suburb,
			    	'product_id' : product_id
			    },
			    success: function(response){
			    	jQuery('.select-dealership .dealer-content-list').html(response.output);
			    	jQuery('.close-wrapper').show();
			    	jQuery('.close-wrapper a.close-search').show();
			    }
			});
		}
		else{
			// call ajax for select location
			jQuery('.dealer_form input[name="addressInput"]').val(postcode);
			jQuery('.mobile_dealer_form input[name="addressInput"]').val(postcode);
			
			jQuery.ajax({
			    type: "POST",
			    dataType: "json",
			    url: rilu_ajax_object.ajaxurl,
			    data: {
			    	'action': 'wc_load_postcode_select_result',
			    	'select_postcode' : location,
			    	'user_selected_postcode' : postcode
			    },
			    success: function(response){
			    	jQuery(dealer_form_class).submit();
			    }
			});	
		}		
	});
	// call this when click on location list field in product detail page
	jQuery(document).on("click", "li.dealer_location_product_detail", function(){	
		var dealer_postcode_location = jQuery(this).text();
		var product_id  = jQuery('.search_product_id').val();
		var search_postcode = jQuery('#product_dealer_form input[name="addressInput"]').val();
		var suburb = jQuery(this).attr('data-suburb');
		var postcode = jQuery(this).attr('data-postcode');
		var state = jQuery(this).attr('data-state');
		var location = suburb + ', '+ postcode + ' ' + state;

		// 7-10-22
		// get postcode arr
		var postcode_arrs = rilu_ajax_object.postcode_lists;

		for (postcode_data of postcode_arrs) {
			console.log("postcode: "+ postcode_data.postcode);
			console.log("Address: "+ postcode_data.address);
		}

		// check postcode and get new array
		var new_postcode_arrs = postcode_arrs.filter(function(ele) {
		    return ele.postcode === postcode;
		});

		// check address in postcode array
		var data = new_postcode_arrs.find(function(ele) {
		    return ele.address.toLowerCase() === suburb.toLowerCase();
		});

		if(data !== undefined){	
			if(data.address !== undefined && data.address){
				jQuery("#show_prdct_lst").show();
			}
			else{
				jQuery("#show_prdct_lst").hide();
			}
		}
		else{
			jQuery("#show_prdct_lst").hide();
		}
		// 7-10-22

		jQuery(".show_dealer_location").html("<li>Searching product price...</li>");
		// Check if it is product detail page or not
		if(product_id && product_id != ""){
			// jQuery(".show_dealer_location").fadeOut();
			// call ajax for select location
			jQuery.ajax({
			    type: "POST",
			    dataType: "json",
			    url: rilu_ajax_object.ajaxurl,
			    data: {
			    	'action': 'wc_display_dealer_data_result',
			    	'product_id': product_id,
			    	'postcode': postcode,
			    	'dealer_postcode_location': dealer_postcode_location,
			    	'suburb': suburb
			    },
			    success: function(response){
			    	if(response.output_postcode && response.output_postcode != ""){  		
			    		jQuery(".show_dealer_location").fadeOut();
						jQuery('#product_dealer_form input[name="addressInput"]').val(location);
						jQuery('#show_dealer_price').show(); 
						jQuery('#show_dealer_price span').text(response.output_price);
						jQuery('#location-indicator').show(); 
						jQuery('#location-indicator span').text(location);

						if(response.dealer_detail && response.dealer_detail != ""){  
							jQuery('#show_dealer_detail').show(); 
							jQuery('#show_dealer_detail').html(response.dealer_detail);
						}
						else{
							jQuery('#show_dealer_detail').hide(); 
							jQuery('#show_dealer_detail').html(response.dealer_detail);
						}

			    		// call ajax for insert selected suburb field data into the database
			    		jQuery.ajax({
			    		    type: "POST",
			    		    dataType: "json",
			    		    url: rilu_ajax_object.ajaxurl,
			    		    data: {
			    		    	'action': 'insert_zipcode_result',
			    		    	'product_name': response.product_name,
			    		    	'product_id': response.product_id,
			    		    	'variation_id': response.variation_id,
			    		    	'searched_zipcode': response.searched_zipcode,
			    		    	'selected_zipcode': response.selected_zipcode,
			    		    	'suburb': response.suburb,
			    		    	'selected_suburb': suburb,
			    		    	'dealer_name': response.dealer_name,
			    		    	'dealer_price': response.dealer_price,
			    		    	'exact': response.exact,
			    		    	'zipcode_distance': response.zipcode_distance
			    		    },
			    		    success: function(response){
			    		    	console.log('Database Inserted successfully');  
			    		    },
			    		});
			    	}
			    	else{
			    		jQuery(".show_dealer_location").fadeIn();
			    		jQuery(".show_dealer_location").html(response.output);
			    		jQuery('#show_dealer_price').hide();
			    		jQuery('#location-indicator').hide();
			    		jQuery('#show_dealer_detail').hide();
			    	}
			    }
			});
		}		
	});
	// click on close button in location popup form
	jQuery('.close-wrapper a.close-search').on('click', function(){
		var findMeButton = jQuery('.find-current-location');
		var product_id = findMeButton.val();
		jQuery('.dealer_form .postcode').val('');
		jQuery('.mobile_dealer_form .mobile_postcode').val('');
		jQuery('.search-wrapper').css('display', 'block');
		jQuery(this).hide();
		$close = true;
		// Check if it is product detail page or not
		if(product_id && product_id != ""){
			$close = false;
		}
		// destroy location on click of close button
		if($close){
			jQuery.ajax({
			    type: "POST",
			    dataType: "json",
			    url: rilu_ajax_object.ajaxurl,
			    data: {
			    	'action': 'wc_load_postcode_select_result',
			    	'select_postcode' : "",
			    },
			    success: function(response){
			    	let dealer_url = window.location.href;
			    	dealer_url = dealer_url.slice(0, dealer_url.indexOf('?')); // remove query string
			    	window.history.pushState('', '', dealer_url);
			    	window.location.reload();
			    }
			});
		}
	});
	// call this when click on location not found in dealer form
	jQuery(document).on("click", "li.dealer_location_not_found", function(){
		jQuery(".show_dealer_location").fadeOut();
	});
	// call this when click on location not found in product dealer form
	jQuery(document).on("click", "li.location_not_found", function(){
		jQuery(".product_postcode").val('');
		jQuery('#show_dealer_price').hide(); // hide currency symbol
		jQuery('#location-indicator').hide(); // hide suburb
		jQuery('#show_dealer_detail').hide(); // hide dealer detail
		jQuery(".show_dealer_location").fadeOut();
	});
	// if map_canvas id is exist in page
	if(jQuery('#map_canvas').length){
		// load diffrent address marker on gooogle map using js
		var locations = [
		      ['Australia', -25.274399, 133.775131],
		      ['<div><p>Movement Systems</p><p>129 Burswood Rd,<br>Burswood, Western Australia 6100</p><p>Ph: (08) 93621488</p></div>', -31.9661132,115.894359],
		     
		      ['<div><p>Gawler Cycles<br>Unit 4, 1 Theen Avenue<br>Willaston SA 5118</p><p>Phone: (08) 8522 2343<br>Website: www.gawlercycles.com</p><p>&nbsp;</p></div>', -34.5930062,138.7313656],
		      ['<div><p>Electric Bikes Superstore<br>344 Magill Road<br>Kensington Park, SA 5068</p><p>Phone: 08 8166 7571</p><p>Email:magill@ebikess.com.au<br>www.electricbikesuperstore.com.au</p></div>', -34.9143283,138.651443],
		      ['<div><p>Electric Bikes Superstore</p><p>417 Brighton Rd,<br>Brighton, SA5048</p><p>Phone: 08 8166 7571</p><p>Email:brighton@ebikess.com.au<br>www.electricbikesuperstore.com.au</p></div>', -35.0140912,138.5201406],
		      ['<div><p>Bicycles Mt. Barker<br>12a Walker Street,<br>Mount Barker, SA 5251</p><p>Phone: (08) 8391 4777<br>Website: www.bicyclesmountbarker.com</p></div>', -35.0671011,138.855492],
		      ['<div><p>Easy Ride Bikes<br>Moana, SA 5169 / Willunga, SA 5172</p><p>Phone: 0433 669 301<br>https://easyridebikes.com.au<br>info@easyridebikes.com.au</p></div>', -35.2058059,138.4744482],
		      
		      ["<div><p>Pyke's Cycles<br>107 Main Street<br>Stawell, VIC 3380</p><p>Tel: (03) 5307 1488<br>E-Mail: pykescycles@iinet.net.au</p></div>", -37.056019,142.7785535],
		      ["<div><p>Major’s Eaglehawk Sports Centre<br>25 High Street<br>Eaglehawk, VIC 3556</p><p>Phone: (03) 5446 8263<br>Email: majorseaglehawksports@hotmail.com</p></div>", -36.7181897,144.2512769],
		      ["<div><p>Ash Hall Cycles<br>32 Nish Street<br>Echuca, VIC 3564<br>Phone: (03) 5482 4706</p><p>E-Mail: ashhallcycles@bigpond.com<br>Website:&nbsp; www.ashhallcycles.com.au</p></div>", -36.1288427,144.7484669],
		      ["<div><p>Leading Edge Cycles</p><p>15 Edward Street<br>Shepparton, VIC 3630<br>Phone: (03) 5831 2968</p><p>E-Mail: lecycles@bigpond.com<br>Website: https://www.facebook.com/Leadingedgecycles</p></div>", -36.3781427,145.4011463],
		      ["<div><p>Artavilla Emporium<br>5-11 Station Street<br>Cobram, VIC 3644<br>Phone: (03) 5872 1726</p><p>E-Mail: artavilla.emporium@gmail.com<br>Facebook: https://www.facebook.com/pages/Artavillas-Emporium/400859123325449</p></div>", -35.9207818,145.64458],
		      ["<div><p>Bike Locker<br>80-82 Belmore Street, Yarrawonga,<br>VIC 3730</p><p>Tel: 0402 016 339<br>E-Mail: maurice@wingatesports.com.au</p></div>", -36.0119443,146.0026182],

		      ["<div><p><strong>The Pedal Shed</strong></p><p>&nbsp;</p><p>12 Pinnaroo Avenue<br>Clifton Springs, VIC 3222</p><p>Tel:&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;0480 241 442<br>e-Mail:&nbsp; &nbsp; &nbsp;<a href='mailto:fix@pedalshed.net' tabindex='0'>fix@pedalshed.net</a><br>Website:&nbsp; &nbsp;<a href='http://www.pedalshed.net'>www.pedalshed.net</a></p></div>", -38.1608916,144.55309],
		      ["<div><p>RILU Trading Pty Ltd<br>2/2 Caulson,<br>Maribyrnong, VIC 3032</p><p>Phone: (03) 8395 2616<br>Email: info@rilu-e-bike.com.au<br>www.rilu-e-bike.com.au</p></div>", -37.7728435,144.8804315],
		      ["<div><p>Rays Bicycle Centre Brunswick<br>110 Sydney Road,<br>Brunswick, VIC 3056</p><p>Phone: (03) 9380 8689<br>https://www.facebook.com/raysbicyclesbrunswick/</p></div>", -37.7753867,144.9587063],
		      ["<div><p>Electric Bike Superstore<br>1034 Dandenong Rd,<br>Carnegie VIC 3163</p><p>Phone: <a href='https://www.google.com/search?q=electric%20bike%20superstore&amp;oq=electric+bike+superstore&amp;aqs=chrome..69i57j46i175i199i512j0i512j46i175i199i512l2j69i60l3.8025j0j15&amp;sourceid=chrome&amp;ie=UTF-8&amp;tbs=lf:1,lf_ui:4&amp;tbm=lcl&amp;sxsrf=AOaemvK51agaQN7-_DoaLVvyUReplz2_kA:1639549402805&amp;rflfq=1&amp;num=10&amp;rldimm=1308351749096189561&amp;lqi=ChhlbGVjdHJpYyBiaWtlIHN1cGVyc3RvcmUiA4gBAUjj5MH3qqqAgAhaJhAAEAEQAhgAGAEYAiIYZWxlY3RyaWMgYmlrZSBzdXBlcnN0b3JlkgENYmljeWNsZV9zdG9yZaoBIBABKhwiGGVsZWN0cmljIGJpa2Ugc3VwZXJzdG9yZSgA&amp;ved=2ahUKEwiAnfu9leX0AhWxFrkGHaJBB_IQvS56BAgEECg&amp;rlst=f' tabindex='0'>0423 376 680</a><br>Email: sales@electricbikesuperstore.com.au<br>www.electricbikesuperstore.com.au</p></div>", -37.8836216,145.0514781],
		      ["<div><p>Mac's Cycles (Bike Hub)</p><p>&nbsp;</p><p>210 Dorset Road<br>BORONIA&nbsp; &nbsp;VIC 3155<br>(03) 9762 4081<br>frankdomine15@gmail.com</p></div>", -37.8621074,145.2836881],
		      ["<div><p>The Bicycle Company - Mornington</p><p>Peninsula Home Centre<br>Shop 5D, 1128 - 1132 Nepean Hwy<br>(Cnr of Bungower Road &amp; Nepean Highway),<br>Mornington, VIC 3931</p><p>Tel: (03) 5975 2444</p><p>E-Mail: mornington@thebicyclecompany.com.au</p><p>Website: www.sealyscycles.com.au</p></div>", -38.2202064,145.0593636],
		      ["<div><p>Freewheeling Cycles<br>1 Jetty Road<br>Rosebud, VIC 3939</p><p>Phone: (03) 5981 1132<br>Email: bulka@cdi.com.au<br>www.freewheelingcycles.com.au</p></div>", -38.3549234,144.9072],
		      ["<div><p>Great Southern Ride</p><p>70B Bair Street<br>Leongatha, VIC 3953<br>Tel: 0468 477 043<br>E-Mail: ride@greatsouthernride.com.au<br>Website: www.greatsouthernride.com.au</p></div>", -38.4796275,145.944905],

		      ["<div><p>Forster Cycles<br>170 Pine Avenue, Tuncurry<br>NSW 2428</p><p>Tel: (02) 6554 9222<br>Website: https://www.bicycle-centre.com.au/store_locations/Forster-bike-shop<br>E-Mail: pjnixon@westnet.com.au</p></div>", -32.1667223,152.4919642],
		      ["<div><p>Newcastle Electric Bikes</p><p>22 Maitland Road<br>Islington, NSW 2296</p><p>Tel: 0413 193 334<br>E-Mail: stephbrown06@yahoo.com<br>Website: www.newcastlelectricbikes.com.au</p></div>", -32.9192811,151.7486632],
		      ["<div><p>Shop 1, 7-9 The Boulevard, Woy Woy, NSW 2256</p><p>Tel: 0427 949 719<br>E-Mail: scootersforeveryone@gmail.com<br>Website: www.scootersforeveryone.com.au</p></div>", -33.4844649,151.322196],
		      ["<div><p>Energy Electric Bikes</p><p>Shop No. 6<br>674 Pitwater Road<br>Brookvale, NSW 2100<br>Tel: 0418 947 383<br>E-Mail: gowestpictures@bigpond.com</p></div>", -33.7629695,151.2699444],
		      
		      ["<div><p>Gladstone Bicycle Centre<br>151 Auckland Street<br>Gladstone, QLD 4680</p><p>Tel: (07) 4972 1142<br>E-Mail: davegbc@aapt.net.au</p><p>&nbsp;</p></div>", -23.8474638,151.2586744],
		      ["<div><p>Bundy Bikes<br>113 Bargara Road,<br>Bundaberg, QLD 4670</p><p>Tel: (07) 4151 4258,<br>Facebook: https://www.facebook.com/avantiplus.bundaberg/</p></div>", -24.8540871,152.3754403],
		      ["<div><p>Bay Bike Mobility</p><p>Shop 2 / 26-28 Taylor Street<br>Pialba, QLD 4655</p><p>Tel: (07) 4124 1570<br>Mobile: 0428 448 333<br>E-Mail: baymobilityshop@gmail.com<br>Website (1): www.baybikefinders.com.au<br>Website (2): www.baymobilityscooters.com.au</p></div>", -25.2840424,152.8414041],
		      ["<div><p>Noosa Bike Shop</p><p>Shop 7, Home Maker Centre<br>Mary Street, Noosaville, QLD 4566</p><p>Phone: (07) 5449 7300<br>Email: noosabikeshop@bigpond.com<br>Website: www.noosabikeshop.com.au</p><p>&nbsp;</p></div>", -26.4003569,153.060361],
			  ["<div><p><strong>Everybody Ebikes</strong></p><p>&nbsp;</p><p><u>Lutwyche , QLD 4030</u>– please call shop for details on&nbsp;0409 126669<br>Phone: 0409 126669<br>Email: andrea@bfebikes.com.au<br><a href='http://www.everybodyebikes.com.au/'' tabindex='0'>www.everyBodyebikes.com.au</a></p></div>", -27.4232006,153.0282292],
		      ["<div><p>Electro Bikes</p><p>Unit 3/ 61-63 Steel Street,<br>Capalaba Qld 4157<br>Ph: (07) 3245 7615 (Barry Whelan)<br>https://www.electrobikes.com.au/</p></div>", -27.5312462,153.1997975],
		      ["<div><p>Sunrise Cycles</p><p>3 Byron Street<br>Byron Bay, NSW 2481</p><p>Tel: (02) 6680 9590<br>E-Mail: bikes@sunrisecycles.com.au<br>Website: www.sunrisecycles.com.au</p></div>", -28.6318204,153.5809552],
		      ["<div><p>Sunrise Cycles</p><p>3 Hogan Street<br>Ballina, NSW 2478</p><p>Tel: (02) 6686 6322<br>E-Mail: bikes@sunrisecycles.com.au<br>Website: www.sunrisecycles.com.au</p></div>", -28.8569293,153.5603939],
		      
		      ["<div><p>Bike Shop &amp; Rental</p><p>3 Warner Street, Port Douglas,<br>QLD 4877</p><p>Tel: (07) 4099 5799<br>Website: www.bikeshopandhire.com<br>E-Mail: info@portdouglasbikehire.com</p></div>", -16.4821739,145.4597133],
		      ["<div><p>Cairns Bicycle Works<br>504 Mulgrave Road<br>Earlville, QLD 4870</p><p>Tel: (07) 4033 0377<br>E-Mail: sales@cairnsbicycleworks.com<br>Website: www.cairnsbicycleworks.com</p></div>", -16.9424593,145.7366427],
		      ["<div><p>Wobble-In Bicycles<br>5/180 Edith Street<br>Innisfail, QLD 4860</p><p>Phone: 0439 348 582<br>Email: peterandnichole@yahoo.com<br>Website:www.wobblein.com</p></div>", -17.524328,146.0195488],
		    ];
		var map;
		var markers = [];
		function init(){
			map = new google.maps.Map(document.getElementById('map_canvas'), {
				zoom: 4,
				center: new google.maps.LatLng(-25.274399, 133.775131),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			var num_markers = locations.length;
			for(var i = 0; i < num_markers; i++){  
				markers[i] = new google.maps.Marker({
				  position: {lat:locations[i][1], lng:locations[i][2]},
				  map: map,
				  html: locations[i][0],
				  id: i,
				});
				google.maps.event.addListener(markers[i], 'click', function(){
					var infowindow = new google.maps.InfoWindow({
						id: this.id,
						content:this.html,
						position:this.getPosition()
					});
					google.maps.event.addListenerOnce(infowindow, 'closeclick', function(){
						markers[this.id].setVisible(true);
					});
					this.setVisible(false);
					infowindow.open(map);
				});
			}
		}
		init();
	}
	// Scroll to top
	jQuery(window).scroll(function(){
		if(jQuery(this).scrollTop() > 100){
			jQuery('.scroll_top').fadeIn();
		}
		else{
			jQuery('.scroll_top').fadeOut();
		}
	});
	jQuery('.scroll_top').click(function(){
		jQuery("html, body").animate({ scrollTop:0 }, 600); 
		return false; 
	});
	// google review - read more
	jQuery('a.btn-reivew').click(function(){
		var site_url = rilu_ajax_object.siteurl;	
		// redirect
		if(window.location.href == site_url + '/'){
			window.location.href = site_url + '/customer-photos-reviews/';
			return false;
		}
	});
	// Dealer serach form validation error message
	jQuery("#search-btn").on('click', function(){
		jQuery('.dealer_form .btn1').click();
		jQuery('.dealer_form .postcode').focus();
	});
});
jQuery(window).load(function(){
	// Change tab section in product detail page on hit url
	var url_hash = document.location.hash;	
	if(url_hash != ''){
		jQuery('nav.tabs > ul > li').each(function (index, li){
			jQuery(this).removeClass('active');
			var tab_name = jQuery(li).attr('data-tab');
			jQuery('#'+tab_name).removeClass('current');
			if('#' + jQuery(li).attr('data-tab') == url_hash){
				jQuery(this).addClass('active');
				jQuery('#'+tab_name).addClass('current');
				var offset = jQuery(this).offset().top; // offset
				jQuery('html, body').animate({
					scrollTop: offset - 50
				}, 1000);
				return;
			}
		});
	}
	// Get current location
	var findMeButton = jQuery('.find-current-location');
	var product_id = findMeButton.val();
	var dialog = jQuery('#window'); // get id of dialog box
	jQuery('#exit').click(function(){
		dialog.hide();  
	}); 
	if(product_id && product_id != ''){
		// jQuery('.location-pin').text("SET YOUR LOCATION");
		if(navigator.geolocation){
			navigator.geolocation.getCurrentPosition(function(position){
				// Get the coordinates of the current possition.
				var lat = position.coords.latitude;
				var lng = position.coords.longitude;
				jQuery('.latitude').text(lat.toFixed(3));
				jQuery('.longitude').text(lng.toFixed(3));
				jQuery.ajax({
				    type: "POST",
				    dataType: "json",
				    url: rilu_ajax_object.ajaxurl,
				    data: {
				    	'action' : 'get_current_user_location',
				    	'latitude' : lat,
				    	'longitude' : lng,
				    	'product_id' : product_id,
				    },
				    success: function(response){
				    	if(response.price && response.price != '' && response.current == false){
				    		jQuery(".zipcode").val('');
				    		// jQuery('#show_dealer_price').show(); 
				    		// jQuery('#show_dealer_price span').text(response.price);
				    		jQuery('.location-pin a').text(response.suburb);
				    		jQuery('.dealer_form span').text(response.dealer_postcode_location);
				    		jQuery('.dealer_form input[name="addressInput"]').val(response.dealer_postcode_location);
				    		jQuery('.select-dealership .dealer-content-list').html(response.output);
				    		jQuery('.close-wrapper').show();
			    			jQuery('.close-wrapper a.close-search').show();
				    	}
				    	else if(response.price && response.price != '' && response.current == true){
				    		jQuery('.select-dealership .dealer-content-list').html(response.output);
				    		jQuery('.close-wrapper').show();
			    			jQuery('.close-wrapper a.close-search').show();
				    	}
				    	else if(response.postcode && response.postcode != '' && response.current == false){
				    		jQuery('.location-pin a').text(response.suburb);
				    		jQuery('.dealer_form span').text(response.dealer_postcode_location);
				    		jQuery('.dealer_form input[name="addressInput"]').val(response.dealer_postcode_location);
				    		jQuery('.select-dealership .dealer-content-list').html(response.output);
				    		jQuery('.close-wrapper').show();
				    		jQuery('.close-wrapper a.close-search').show();
				    	}
				    	else if(response.postcode && response.postcode != '' && response.current == true){
				    		jQuery('.select-dealership .dealer-content-list').html(response.output);
				    		jQuery('.close-wrapper').show();
				    		jQuery('.close-wrapper a.close-search').show();
				    	}
				    	else{
				    		jQuery('.close-wrapper').hide();
				    		// Show dialog box
							dialog.show();   
							setTimeout(function(){
								dialog.hide();
							}, 5000);
				    	}
				    },
				});
			}, function(error){
				let findMeButton = jQuery('.find-current-location');
				let product_id = findMeButton.val(); // get product id
				let postcode = Cookies.get('dealer_postcode'); // get postcode
				if(postcode != undefined){
					let dealer_postcode_location = getCookie(Cookies.get('dealer_postcode_location')); // get location
					let suburb = getCookie(Cookies.get('set_dealer_postcode')); // get suburb
					// Set user location
					jQuery('.location-pin a').text(suburb);
					jQuery('.dealer_form input[name="addressInput"]').val(dealer_postcode_location);
					jQuery(".show_dealer_location").fadeOut();
					// call ajax for select location
					jQuery.ajax({
					    type: "POST",
					    dataType: "json",
					    url: rilu_ajax_object.ajaxurl,
					    data: {
					    	'action': 'wc_load_dealer_result',
					    	'postcode': postcode,
					    	'dealer_postcode_location': dealer_postcode_location,
					    	'suburb': suburb,
					    	'product_id' : product_id
					    },
					    success: function(response){
					    	jQuery('.select-dealership .dealer-content-list').html(response.output);
					    	jQuery('.close-wrapper').show();
					    	jQuery('.close-wrapper a.close-search').show();
					    }
					});
				}
			});
		}
		else{
			alert("Geolocation is not supported by this browser.");
		}
		function getCookie(c){
			var s = c;
			return s ? decodeURIComponent(s.replace(/\+/g, ' ')) : s;
		}
	}
	// Display map location of dealer
	var dealer_lat = jQuery('.dealer_lat').val();
	var dealer_address = jQuery('.dealer_lat').attr('data-addr');
	var dealer_long = jQuery('.dealer_long').val();
	if(dealer_lat && dealer_long && dealer_lat != "" && dealer_long != ""){
		dealer_lat = parseFloat(dealer_lat);
		dealer_long = parseFloat(dealer_long);
		var locations = [
		    	[dealer_address, dealer_lat, dealer_long],
		    ];
		var map;
		var markers = [];
		function initDealerLocation(){
			map = new google.maps.Map(document.getElementById('dealer_map_canvas'), {
				zoom: 12,
				center: new google.maps.LatLng(dealer_lat, dealer_long),
				mapTypeId: google.maps.MapTypeId.ROADMAP,
			});
			var num_markers = locations.length;
			for(var i = 0; i < num_markers; i++){  
				markers[i] = new google.maps.Marker({
				  position: {lat:locations[i][1], lng:locations[i][2]},
				  map: map,
				  html: locations[i][0],
				  id: i,
				});
				google.maps.event.addListener(markers[i], 'click', function(){
					var infowindow = new google.maps.InfoWindow({
						id: this.id,
						content:this.html,
						position:this.getPosition()
					});
					google.maps.event.addListenerOnce(infowindow, 'closeclick', function(){
						markers[this.id].setVisible(true);
					});
					this.setVisible(false);
					infowindow.open(map);
				});
			}
		}
		initDealerLocation();
	}
});