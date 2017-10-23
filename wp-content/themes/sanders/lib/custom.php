<?php 

/* -------------------------------- */
/*  Custom Post Types               */
/* -------------------------------- */

add_action('init', 'lms_custom_post_types');
function lms_custom_post_types()
{
	// Testimonials
	/*register_post_type('testimonials',
		array(
			'labels' => array(
				'name' => 'Testimonials',
				'singular_name' => 'Testimonials',
			),
			'public' => true,
			'has_archive' => true,
			'supports' => array(
				//'title',
				'editor', 
				//'thumbnail', 
				//'excerpt', 
				//'comments',
			),
		)
	);*/

	// Attorneys
	register_post_type('attorney-profiles',
		array(
			'labels' => array(
				'name' => 'Attorneys',
				'singular_name' => 'Attorney',
				'add_new_item' => 'Add New Attorney',
			),
			'public' => true,
			'has_archive' => false,
			'supports' => array(
				'title',
				//'editor',
				'thumbnail',
				//'excerpt',
				//'comments',
			),
		)
	);
}

/* -------------------------------- */
/*  Meta Boxes                      */
/* -------------------------------- */

function lms_add_meta_box()
{	
	wp_enqueue_script('meta-js', themedir(false).'/js/admin.js'); 
	wp_enqueue_style('meta-css', themedir(false).'/css/admin.css');
	//add_meta_box('metabox_testimonials', 'Testimonials Options', 'metabox_testimonials_callback', 'testimonials');
	add_meta_box('metabox_structured_data_page', 'Structured Data Settings', 'structured_data_page_metabox_callback', 'page');
	add_meta_box('metabox_structured_data_post', 'Structured Data Settings', 'structured_data_post_metabox_callback', 'post');
	add_meta_box('metabox_post_options', 'Post Options', 'post_options_callback', 'post');
	add_meta_box('metabox_attorneys', 'Attorney Options', 'metabox_attorneys_callback', 'attorney-profiles');
}
add_action('add_meta_boxes', 'lms_add_meta_box');

/* -------------------------------- */
/*  Post Options                    */
/* -------------------------------- */

/* Metaboxes */

function post_options_callback($post)
{
	wp_nonce_field('metabox_post_options', 'post_options_nonce');

	$colors = array('#c6d6d6', '#7b2732', '#374162', '#d19e5d', '#292933');
	$data_post_color = get_post_meta($post->ID, 'meta_post_color', true);
	$data_excerpt_length = get_post_meta($post->ID, 'meta_excerpt_length', true);

	echo '<div>';
	echo '<label for="post-color">Category Color</label><br>';
		echo '<div class="color-choices">';
			foreach($colors as $color)
				echo '<div class="color-choice" style="background:'.$color.'" data-value="'.$color.'"></div>';
			echo '<input type="hidden" name="post-color" value="'.$data_post_color.'" />';
		echo '</div>';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="excerpt-length">Excerpt Length</label><br>';
		echo '<input type="radio" name="excerpt-length" value="1" '.($data_excerpt_length == 1 ? 'checked' : '').' /> Image Only <br>';
		echo '<input type="radio" name="excerpt-length" value="2" '.($data_excerpt_length == 2 || $data_excerpt_length == 0 ? 'checked' : '').' /> Short <br>';
		echo '<input type="radio" name="excerpt-length" value="3" '.($data_excerpt_length == 3 ? 'checked' : '').' /> Medium <br>';
		echo '<input type="radio" name="excerpt-length" value="4" '.($data_excerpt_length == 4 ? 'checked' : '').' /> Long';
	echo '</div>';
}
function post_options_save($post_id)
{
	// Check if our nonce is set.
	if ( ! isset( $_POST['post_options_nonce'] ) ){
		return;
	}
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['post_options_nonce'], 'metabox_post_options' ) ){
		return;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'post' == $_POST['post_type'] ){
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} 
	else {
		if ( ! current_user_can( 'edit_post', $post_id ) ){
			return;
		}
	}		

	// Update the meta field in the database
	$data_post_color = $_POST['post-color'];
	$data_excerpt_length = $_POST['excerpt-length'];
	update_post_meta($post_id, 'meta_post_color', $data_post_color);
	update_post_meta($post_id, 'meta_excerpt_length', $data_excerpt_length);
}
add_action('save_post', 'post_options_save');

/* -------------------------------- */
/*  Attorneys                       */
/* -------------------------------- */

/* Scripts */

function attorney_profiles_scripts()
{
	$screen = get_current_screen();

	// Special scripts for the Luxury Homes custom post type
	if ($screen->post_type == 'attorney-profiles') {
		wp_enqueue_script('admin-jqueryui', 'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js');
		wp_enqueue_script('admin-attorney-scripts', themedir(false).'/js/attorney-profiles-admin.js'); 
	}

	// Pass php variable (the wordpress ajax url) to the javascript file
	wp_localize_script('admin-attorney-scripts', 'php_data', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('admin_enqueue_scripts', 'attorney_profiles_scripts');

/* Ajax Callback - Post Ordering */

function attorney_profiles_post_order()
{
	$order = $_POST['order'];
    global $wpdb;
    $list = join(', ', $order);
    $wpdb->query( 'SELECT @i:=-1' );
    $result = $wpdb->query("UPDATE wp_posts SET menu_order = ( @i:= @i+1 ) WHERE ID IN ( $list ) ORDER BY FIELD( ID, $list );");
    echo $result;
    wp_die();
}
add_action('wp_ajax_attorney_profiles_post_order', 'attorney_profiles_post_order');

/* Custom Order for the Admin View */

function custom_attorney_profiles_post_order($query)
{
	// Sort posts in wp_list_table by menu order
    $post_types = get_post_types(array('_builtin' => false), 'names');
    //$post_type = $query->get('post_type');
    if (in_array('attorney-profiles', $post_types))
    {
        if ($query->get('orderby') == '') {
            $query->set('orderby', 'menu_order');
        }
        if ($query->get('order') == '') {
            $query->set('order', 'ASC');
        }
    }
}
add_action('pre_get_posts', 'custom_attorney_profiles_post_order'); 

/* Hide Metaboxes On This Post Type */

add_filter('default_hidden_meta_boxes', 'hide_wp_seo', 10, 2);
function hide_wp_seo($hidden, $screen)
{
	if ($screen->post_type == 'attorney-profiles')
		array_push($hidden, 'wpseo_meta');
	return $hidden;
}

/* Columns */

add_action('manage_posts_custom_column',  'attorneys_custom_columns');
add_filter('manage_edit-attorney-profiles_columns', 'attorneys_edit_columns');
 
function attorneys_edit_columns($columns)
{
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'thumbnail' => 'Image',
		'title' => 'Attorney',
		'attorney-email' => 'Email',
		'link' => 'Page Link',
	);
  	return $columns;
}
function attorneys_custom_columns($column)
{
	global $post;
	switch ($column)
	{
		case 'thumbnail':
			echo get_the_post_thumbnail($post->ID, array(60,60));
			break;

		case 'link':
			$page_id = get_post_meta($post->ID, 'meta_attorneys_link', true);
			echo get_the_title($page_id).'<br><a target="_blank" href="'.get_permalink($page_id).'">'.get_permalink($page_id).'</a>';
			break;

		case 'attorney-email':
			echo get_post_meta($post->ID, 'meta_attorneys_email', true);
			break;
	}
}

/* Metaboxes */

function metabox_attorneys_callback($post)
{
	wp_nonce_field('metabox_attorneys', 'ma_nonce'); 

	$data_link = get_post_meta( $post->ID, 'meta_attorneys_link', true);
	$data_attorney_email = get_post_meta( $post->ID, 'meta_attorneys_email', true);

	echo '<div>';
	echo '<label for="attorney-email">Email</label><br>';
	echo '<input id="attorney-email" type="text" class="regular-text ltr" name="attorney-email" value="'.$data_attorney_email.'" />';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="link">Link To Page</label><br>';
	wp_dropdown_pages(array(
	    'child_of'     => 0,
	    'sort_order'   => 'ASC',
	    'sort_column'  => 'post_title',
	    'hierarchical' => 1,
	    'post_type' => 'page',
	    'show_option_none' => '-- No link --',
	    'selected' => $data_link,
	    'name' => 'link',
	));
	echo '</div>';
}
function metabox_attorneys_save($post_id)
{
	// Check if our nonce is set.
	if ( ! isset( $_POST['ma_nonce'] ) ){
		return;
	}
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['ma_nonce'], 'metabox_attorneys' ) ){
		return;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'attorney-profiles' == $_POST['post_type'] ){
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} 
	else {
		if ( ! current_user_can( 'edit_post', $post_id ) ){
			return;
		}
	}		

	// Update the meta field in the database
	$data_link = $_POST['link'];
	$data_attorney_email = $_POST['attorney-email'];
	update_post_meta($post_id, 'meta_attorneys_link', $data_link); 
	update_post_meta($post_id, 'meta_attorneys_email', $data_attorney_email); 
}
add_action('save_post', 'metabox_attorneys_save');

/* -------------------------------- */
/*  Testimonials                    */
/* -------------------------------- */

/* Columns */

add_action('manage_posts_custom_column',  'testimonials_custom_columns');
add_filter('manage_edit-testimonials_columns', 'testimonials_edit_columns'); 
function testimonials_edit_columns($columns)
{
	$columns = array(
		'cb' => '<input type="checkbox" />',
		/*'title' => 'Title',*/
		'description' => 'Testimonial',
		'cited' => 'Cited By',
	);
  	return $columns;
}
function testimonials_custom_columns($column)
{
	global $post;
	switch ($column)
	{
		case 'description':
			the_excerpt();
			echo edit_post_link('Edit', '', '', $post->ID);
			break;

		case 'cited':
			echo get_post_meta($post->ID, 'meta_testimonials_cited', true);
			break;
	}
}

/* Metaboxes */

function metabox_testimonials_callback($post)
{
	wp_nonce_field('metabox_testimonials', 'mt_nonce');
	$data_cited = get_post_meta($post->ID, 'meta_testimonials_cited', true);

	echo '<div>';
	echo '<label for="cited">Cited By</label><br>';
	echo '<input type="text" name="cited" value="'.$data_cited.'" />';
	echo '</div>';
}
function metabox_testimonials_save($post_id)
{
	// Check if our nonce is set.
	if ( ! isset( $_POST['mt_nonce'] ) ){
		return;
	}
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['mt_nonce'], 'metabox_testimonials' ) ){
		return;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'testimonials' == $_POST['post_type'] ){
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} 
	else {
		if ( ! current_user_can( 'edit_post', $post_id ) ){
			return;
		}
	}		

	// Update the meta field in the database
	$data_cited = $_POST['cited'];
	update_post_meta($post_id, 'meta_testimonials_cited', $data_cited);

}
add_action('save_post', 'metabox_testimonials_save');

/* -------------------------------- */
/*  Structured Data                 */
/* -------------------------------- */

/* Metaboxes */
//echo "The category is "'$a_sec';
function structured_data_page_metabox_callback($post)
{
	wp_nonce_field('metabox_structured_data_page', 'msd_nonce');

	$data_title = get_post_meta( $post->ID, 'meta_msd_title', true);
	if ($data_title == '' || $data_url !== wpseo_get_value('metadesc')) $data_title = wpseo_get_value('metadesc'); //$metadesc
	//Auto adds in URL into URL field
	if ($data_url == '') $data_url = get_permalink($post->ID);
	$data_url = get_post_meta( $post->ID, 'meta_msd_url', true);
	$data_headline = get_post_meta( $post->ID, 'meta_msd_headline', true);
	$data_description = get_post_meta( $post->ID, 'meta_msd_description', true);
	if ($data_description == '' || $data_description !== wpseo_get_value('metadesc')) $data_description = wpseo_get_value('metadesc');
	$data_keywords = get_post_meta( $post->ID, 'meta_msd_keywords', true);

	echo '<div>';
	//echo '$a_sec = get_the_category('selected');';
	echo '<label for="msd_title">Site Name</label><br>';
	echo '<input type="text" id="msd_title" name="msd_title" value="' . esc_attr( $data_title ) . '" size="60" /><br>';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="msd_url">URL</label><br>';
	echo '<input type="text" id="msd_url" name="msd_url" value="' . esc_attr( $data_url ) . '" size="60" /><br>';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="msd_headline">Headline</label><br>';
	echo '<input type="text" id="msd_headline" name="msd_headline" value="' . esc_attr( $data_headline ) . '" size="60" /><br>';
	echo '</div><br>';

	echo "<script type=text/javascript> $('.large-text metadesc').on('keyup', function() { $('.'+$(this).attr('class')).val($(this).val()) });</script>";

	echo '<div>';
	echo '<label for="msd_description">Description</label><br>';
	echo '<textarea class="large-text metadesc" id="msd_description" name="msd_description" rows="4" cols="60" >' . esc_attr( $data_description ) . '</textarea><br>';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="msd_keywords">Keywords</label><br>';
	echo '<textarea id="msd_keywords" name="msd_keywords" rows="4" cols="60" >' . esc_attr( $data_keywords ) . '</textarea><br>';
	echo '</div><br>';
}

function structured_data_post_metabox_callback($post)
{
	$a_sec = get_the_category("selected");
	wp_nonce_field('metabox_structured_data_post', 'msd_nonce');

	$data_title = get_post_meta( $post->ID, 'meta_msd_title', true);
	$data_url = get_post_meta( $post->ID, 'meta_msd_url', true);
	$data_headline = get_post_meta( $post->ID, 'meta_msd_headline', true);
	$data_description = get_post_meta( $post->ID, 'meta_msd_description', true);
	$data_keywords = get_post_meta( $post->ID, 'meta_msd_keywords', true);
	$data_article_section = get_post_meta( $post->ID, 'meta_msd_article_section', true);
	$data_article_body = get_post_meta( $post->ID, 'meta_msd_article_body', true);
	$data_author = get_post_meta( $post->ID, 'meta_msd_author', true);
	$data_author_link = get_post_meta( $post->ID, 'meta_msd_author_link', true);

	echo '<div>';
	echo '<label for="msd_title">Site Name</label><br>';
	echo "The category is $a_sec";
	echo '<input type="text" id="msd_title" name="msd_title" value="' . esc_attr( $data_title ) . '" size="60" /><br>';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="msd_url">URL</label><br>';
	echo '<input type="text" id="msd_url" name="msd_url" value="' . esc_attr( $data_url ) . '" size="60" /><br>';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="msd_headline">Headline</label><br>';
	echo '<input type="text" id="msd_headline" name="msd_headline" value="' . esc_attr( $data_headline ) . '" size="60" /><br>';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="msd_description">Description</label><br>';
	echo '<textarea id="msd_description" name="msd_description" rows="4" cols="60" >' . esc_attr( $data_description ) . '</textarea><br>';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="msd_keywords">Keywords</label><br>';
	echo '<textarea id="msd_keywords" name="msd_keywords" rows="4" cols="60" >' . esc_attr( $data_keywords ) . '</textarea><br>';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="msd_article_section">Article Section</label><br>';
	//echo '<input type="text" id="msd_article_section" name="msd_article_section" value="' . esc_attr( $a sec ) . '" size="60" /><br>';
	echo '<input type="text" id="msd_article_section" name="msd_article_section" value="' . esc_attr( $data_article_section ) . '" size="60" /><br>';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="msd_article_body">Article Body</label><br>';
	echo '<textarea id="msd_article_body" name="msd_article_body" rows="4" cols="60" >' . esc_attr( $data_article_body ) . '</textarea><br>';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="msd_author">Author Name</label><br>';
	echo '<input type="text" id="msd_author" name="msd_author" value="' . esc_attr( $data_author ) . '" size="60" /><br>';
	echo '</div><br>';

	echo '<div>';
	echo '<label for="msd_author_link">Author\'s Google+ Page</label><br>';
	echo '<input type="text" id="msd_author_link" name="msd_author_link" value="' . esc_attr( $data_author_link ) . '" size="60" /><br>';
	echo '</div><br>';
}

// Save all our data
function structured_data_page_save($post_id)
{
	// Check if our nonce is set.
	if ( ! isset( $_POST['msd_nonce'] ) )
	{
		return;
	}
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['msd_nonce'], 'metabox_structured_data_page' ) )
	{
		return;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	{
		return;
	}
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] )
	{
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} 
	else 
	{
		if ( ! current_user_can( 'edit_post', $post_id ) )
		{
			return;
		}
	}		

	// Make sure that it is set
	if (!isset( $_POST['msd_title'])){ return; }
	if (!isset( $_POST['msd_url'])){ return; }
	if (!isset( $_POST['msd_headline'])){ return; }
	if (!isset( $_POST['msd_description'])){ return; }
	if (!isset( $_POST['msd_keywords'])){ return; }

	// Sanitize user input
	$data_title = sanitize_text_field($_POST['msd_title']);
	$data_url = sanitize_text_field($_POST['msd_url']);
	$data_headline = sanitize_text_field($_POST['msd_headline']);
	$data_description = sanitize_text_field($_POST['msd_description']);
	$data_keywords = sanitize_text_field($_POST['msd_keywords']);

	// Update the meta field in the database
	update_post_meta($post_id, 'meta_msd_title', $data_title);
	update_post_meta($post_id, 'meta_msd_url', $data_url);
	update_post_meta($post_id, 'meta_msd_headline', $data_headline);
	update_post_meta($post_id, 'meta_msd_description', $data_description);
	update_post_meta($post_id, 'meta_msd_keywords', $data_keywords);
}
add_action('save_post', 'structured_data_page_save');

// Save all our data
function structured_data_post_save($post_id)
{
	// Check if our nonce is set.
	if ( ! isset( $_POST['msd_nonce'] ) )
	{
		return;
	}
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['msd_nonce'], 'metabox_structured_data_post' ) )
	{
		return;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	{
		return;
	}
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] )
	{
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} 
	else 
	{
		if ( ! current_user_can( 'edit_post', $post_id ) )
		{
			return;
		}
	}		

	// Make sure that it is set
	if (!isset( $_POST['msd_title'])){ return; }
	if (!isset( $_POST['msd_url'])){ return; }
	if (!isset( $_POST['msd_headline'])){ return; }
	if (!isset( $_POST['msd_description'])){ return; }
	if (!isset( $_POST['msd_keywords'])){ return; }
	if (!isset( $_POST['msd_article_body'])){ return; }
	if (!isset( $_POST['msd_article_section'])){ return; }
	if (!isset( $_POST['msd_author'])){ return; }
	if (!isset( $_POST['msd_author_link'])){ return; }

	// Sanitize user input
	$data_title = sanitize_text_field($_POST['msd_title']);
	$data_url = sanitize_text_field($_POST['msd_url']);
	$data_headline = sanitize_text_field($_POST['msd_headline']);
	$data_description = sanitize_text_field($_POST['msd_description']);
	$data_keywords = sanitize_text_field($_POST['msd_keywords']);
	$data_article_section = sanitize_text_field($_POST['msd_article_section']);
	$data_article_body = sanitize_text_field($_POST['msd_article_body']);
	$data_author = sanitize_text_field($_POST['msd_author']);
	$data_author_link = sanitize_text_field($_POST['msd_author_link']);

	// Update the meta field in the database
	update_post_meta($post_id, 'meta_msd_title', $data_title);
	update_post_meta($post_id, 'meta_msd_url', $data_url);
	update_post_meta($post_id, 'meta_msd_headline', $data_headline);
	update_post_meta($post_id, 'meta_msd_description', $data_description);
	update_post_meta($post_id, 'meta_msd_keywords', $data_keywords);
	update_post_meta($post_id, 'meta_msd_article_section', $data_article_section);
	update_post_meta($post_id, 'meta_msd_article_body', $data_article_body);
	update_post_meta($post_id, 'meta_msd_author', $data_author);
	update_post_meta($post_id, 'meta_msd_author_link', $data_author_link);
}
add_action('save_post', 'structured_data_post_save');

// Prepend or append the Structured Data into the page content
function lms_append_structured_data($content)
{
	// Setup
	global $post;
	$post_id = $post->ID;

	// Check if we're doing a page
	if (is_page())
	{
		// Metadata to be inserted
		$metadata = array(
			'meta_msd_url' => '<meta itemprop="url" content="@@" />',
			'meta_msd_headline' => '<h2 itemprop="headline">@@</h2>',
			'meta_msd_description' => '<meta itemprop="description" content="@@" />',
			'meta_msd_keywords' => '<meta itemprop="keywords" content="@@" />',
		);

		// Get all of our metadata
		$c = '';

		// First pull in the site title
		$post_meta = get_post_meta($post_id, 'meta_msd_title');
		$meta = $post_meta[0];
		if ($meta)
			$c .= '<meta property="og:site_name" content="'.$meta.'" />';

		// Then start our structured data
		$c .= '<div itemscope="" itemtype="http://schema.org/WebPage">';
		foreach ($metadata as $i => $tag)
		{
			$post_meta = get_post_meta($post_id, $i);
			$meta = $post_meta[0];

			if ($meta)
			{
				if ($i == 'meta_msd_keywords')
				{
					$meta = explode(', ', $post_meta[0]);
					$data = '';
					foreach ($meta as $keyword)
						$data .= str_replace('@@', $keyword, $tag);
				}
				else
					$data = str_replace('@@', $meta, $tag);
				$c .= $data;
			}
		}
		$c .= '</div>';
	}

	// Nope, we're doing a post
	else
	{
		// Metadata to be inserted
		$metadata = array(
			'meta_msd_url' => '<meta itemprop="url" content="@@" />',
			'meta_msd_headline' => '<h2 itemprop="headline">@@</h2>',
			'meta_msd_description' => '<meta itemprop="description" content="@@" />',
			'meta_msd_keywords' => '<meta itemprop="keywords" content="@@" />',
			'meta_msd_article_section' => '<meta itemprop="articleSection" content="@@" />',
			'meta_msd_article_body' => '<meta itemprop="articleBody" content="@@" />',
		);

		// Get all of our metadata
		$c = '';

		// First pull in the site title
		$post_meta = get_post_meta($post_id, 'meta_msd_title');
		$meta = $post_meta[0];
		if ($meta)
			$c .= '<meta property="og:site_name" content="'.$meta.'" />';

		// Then start our structured data
		$c .= '<div itemscope="" itemtype="http://schema.org/Article">';
		foreach ($metadata as $i => $tag)
		{
			$post_meta = get_post_meta($post_id, $i);
			$meta = $post_meta[0];

			if ($meta)
			{
				if ($i == 'meta_msd_keywords')
				{
					$meta = explode(', ', $post_meta[0]);
					$data = '';
					foreach ($meta as $keyword)
						$data .= str_replace('@@', $keyword, $tag);
				}
				else
					$data = str_replace('@@', $meta, $tag);
				$c .= $data;
			}
		}
		
		// Add the author meta
		$post_meta = get_post_meta($post_id, 'meta_msd_author');
		$meta_author = $post_meta[0];
		$post_meta = get_post_meta($post_id, 'meta_msd_author_link');
		$meta_author_link = $post_meta[0];
		if ($meta_author && $meta_author_link)
			$c .= 'Written By <a target="_blank" href="'.$meta_author_link.'">'.$meta_author.'</a>';

		// Add the article word count
		$wordcount = str_word_count($content);
		$c .= '<meta itemprop="wordcount" content="'.$wordcount.'" />';

		$c .= '</div>';
	}

	// Prepend metadata to content
	$c .= $content;

    // Return the content
    return $c;
}
add_filter('the_content', 'lms_append_structured_data');

/* -------------------------------- */
/*  Widgets                         */
/* -------------------------------- */

// Testimonials Widget
class Widget_Testimonials extends WP_Widget
{
	function Widget_Testimonials()
	{
		$widget_ops = array('classname' => 'widget-stories', 'description' => 'Displays a list of recently added Success Stories' );
		$this->WP_Widget('Widget_Testimonials', 'Success Stories', $widget_ops);
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label>
			</p>
		<?php
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		return $instance;
	}

	function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

		if (!empty($title))
			echo $before_title . $title . $after_title;;

	    echo '<a class="big" href="/success-stories">Read More About Our Cases</a>';
	    echo '<div class="box">';
		    $args = array(
		    	'post_type' => 'testimonials',
		    	'posts_per_page' => 3,
		    );
			$loop = new WP_Query($args);
			while ($loop->have_posts()) : $loop->the_post();
				the_content();
			endwhile;
		echo '</div>';

		echo $after_widget;
	}
}
//add_action('widgets_init', create_function('', 'return register_widget("Widget_Testimonials");'));

/* -------------------------------- */
/*  Shortcodes                      */
/* -------------------------------- */

//add_shortcode('success-stories', 'shortcode_success_stories');
function shortcode_success_stories($atts)
{
	/*extract(shortcode_atts(array(
		'attr_1' => 'attribute 1 default',
		'attr_2' => 'attribute 2 default',
	), $atts));*/

	$html = '';
	
	$args = array(
    	'post_type' => 'testimonials',
    );
	$loop = new WP_Query($args);
	while ($loop->have_posts()) : $loop->the_post();
		$id = get_the_id();
		$html .= '<p>'.get_the_content($id).'</p>';
	endwhile;
	wp_reset_query();

	return $html;
}

/* -------------------------------- */
/*  Custom Functions                */
/* -------------------------------- */

// Custom excerpt length
function the_excerpt_max_charlength($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '...';
	} else {
		echo $excerpt;
	}
}

// Custom excerpt with removed structured data 
function custom_get_the_excerpt()
{
	global $post;
	$output = '';
	$excerpt = get_the_excerpt($post->ID);
	$structured_data = get_post_meta($post->ID, 'meta_msd_headline');
	$output = str_replace($structured_data[0], '', $excerpt);
	return $output;
}