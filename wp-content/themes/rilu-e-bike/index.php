<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package rilu-e-bike
 */
get_header(); // get header
$blog_page_id = get_option('page_for_posts'); // get id of main blog page
$blog_list = get_fields($blog_page_id); // get all fields of blog_list page inside one array
// Banner section
$banner_image = $blog_list['banner_image'];
$mob_banner_image = $blog_list['mobile_banner_image'];
$mob_banner_image_url = (!empty($mob_banner_image)) ? $mob_banner_image['url'] : $banner_image['url'];
$banner_heading = $blog_list['banner_heading'];
$banner_subheading = $blog_list['banner_subheading'];
$banner_button = $blog_list['banner_button'];
$banner_button_label = $banner_button['button_label'];
$banner_button_link = button_group($banner_button);
// rilu section
$rilu_description = $blog_list['rilu_description'];
// display blog list
$blog_args = array(
	'post_type' => 'post',
	'paged' => get_query_var('paged'),
);
$blog_query = new WP_Query($blog_args);
$post_count = $blog_query->post_count; // count posts per page ?>
<main id="primary" class="site-main">
	<?php if(!empty($banner_image)): ?>
	<div class="product-banner blog-banner desktop-image" style="background-image: url(<?php echo $banner_image['url']; ?>)"> 
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
	<div class="product-banner blog-banner mob-image" style="background-image: url(<?php echo $mob_banner_image_url; ?>)"> 
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
	<?php endif;
	if(have_posts()): ?>
		<section class="blog-list-section">
			<div class="container">
				<div class="three-row-section">
				<?php	   
				while(have_posts()):
					the_post();
					$blog_id = get_the_id(); // get blog id
					$author_id = get_post_field('post_author', $blog_id); // get blog author id
					$author_name = get_the_author_meta('display_name', $author_id); // get author name
					$category = get_the_category($blog_id);
					$cat_name = "";
					foreach($category as $cat){
						$cat_name .= $cat->cat_name.', '; // get category name
					}
					// check comment is allowed or not
					$comment = (comments_open()) ? 'Comments On' : 'Comments Off'; ?>
					<div class="col-section">
						<div class="img-container">
							<?php
	                            if(has_post_thumbnail($blog_id)):
	                            /* display featured image */                                
	                            echo '<a href='.get_the_permalink($blog_id).'>'; 
	                                echo get_the_post_thumbnail($blog_id, 'blog-imgs');
	                            echo '</a>';
	                            else:
	                                echo wp_get_attachment_image(998, 'blog-imgs');
	                            endif; ?>
							<div class="blog-date"><?php echo date("j M Y", strtotime(get_the_date())); ?></div>
						</div>
						<div class="blog-title"><?php echo substr(get_the_title(), 0, 85); ?></div>
						<div class="blog-content"><?php echo substr(get_the_excerpt(), 0, 110); ?></div>
						<a href="<?php echo get_the_permalink($blog_id); ?>" class="theme-button read-post">Read Post</a>
					</div>
				<?php endwhile; ?>
				</div>
			</div>
		</section>
		<div class="blog-pagination">
			<?php 
				echo paginate_links(array(
					'prev_text'   => "Prev",
					'next_text'   => "Next",
				)); 
			?>
		</div>
	<?php else:
		echo "<p>No post found</p>";
	endif;
	wp_reset_postdata(); // Restore original Post Data
	if(!empty($rilu_description)): ?>
		<section class="blog-footer-content">
			<div class="container">
				<div class="bottom-lines"><?php echo $rilu_description; ?></div>
			</div>
		</section>
	<?php endif; ?>
</main>
<?php get_footer(); ?>