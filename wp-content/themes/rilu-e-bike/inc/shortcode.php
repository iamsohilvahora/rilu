<?php
/***************************************** Year Shortcode ***********************************/
function wp_year_shortcode_func(){
	$year = date('Y');
	return $year;
}
add_shortcode('year', 'wp_year_shortcode_func');
/***************************************** Zipcode Form Shortcode ***************************/
function wc_zipcode_shortcode_func(){ ?>
	<form method="post" class="zipcode_form">
		<input type="text" name="zipcode" class="zipcode" placeholder="Search by zipcode" autocomplete="off" />
		<input type="hidden" name="product_id" class="search_product_id" value="<?php echo get_the_id(); ?>" />
		<div id="answer"></div>
    </form>
<?php }
add_shortcode('zipcode', 'wc_zipcode_shortcode_func');
/***************************************** Recent blog Shortcode ***************************/
function wp_show_recent_blog_list(){
	// recent blog query  
	$latest_blog_args = array(
		'post_type' => 'post',
		'posts_per_page' => 5,
		'post_status' => 'publish',
		'post__not_in' => array(get_the_ID()),
		'orderby'=> 'post_date', 
		'order' => 'DESC',
	);
	$latest_blog_query = new WP_Query($latest_blog_args); 
	if($latest_blog_query->have_posts()): ?>
		<div class="more-blog">
			<?php 
			while ($latest_blog_query->have_posts()): 
				$latest_blog_query->the_post(); 
				$blog_id = get_the_id(); ?>
				<div class="blog-list">
					<div class="image">
					<?php
                        if(has_post_thumbnail($blog_id)):
                        /* display featured image */                                
                        echo '<a href='.get_the_permalink($blog_id).'>'; 
                            echo get_the_post_thumbnail($blog_id, 'blog-sidebar-img');
                        echo '</a>';
                        else:
                            echo wp_get_attachment_image(998, 'blog-sidebar-img');
                        endif; ?>
					</div>
					<div class="content">
						<a href="<?php echo get_the_permalink($blog_id); ?>"><?php echo get_the_title(); ?></a>
						<p><?php echo substr(get_the_excerpt(), 0, 50); ?></p>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
<?php
	else:
		echo "<p>Recent blog list not found.</p>";
	endif;
	wp_reset_postdata(); // Restore original Post Data
}
add_shortcode('recent_blog_list', 'wp_show_recent_blog_list');
?>