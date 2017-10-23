<?php

	/* ================================================================
		SETUP
	================================================================  */

	// Compile LESS?
	$compile_less = true;

	// Global Template Includes
	$include = array(
		'less'            => true,  // Include LESS compiled stylesheets
		'fontawesome'     => true,  // Include Fontawesome icons
		'bootstrap'       => true,  // Include Bootstrap responsive framework
		'scripts'         => true,  // Include javascript
		'owl'             => true,  // Include the Owl carousel slider
		'slick'           => false, // Include the Slick responsive slider
		'browserselector' => false, // Include BrowserSelector CSS classes
		'googlemaps'      => true, // Include the Google Maps Javascript API
		'stellar'         => true, // Include Stellar parallax
		'inview'          => false, // Include Inview plugin
		'enqueue_gform'   => true,  // Enqueue the gravity form scripts ahead of time
		'gform_ajax'      => true,  // Use AJAX for gravity form submission
		'masonry'         => true,  // Use jQuery Masonry 
	);

	// Google Maps API Key
	$google_maps_api_key = 'AIzaSyA5VWLsiSutNRFcUA_C-siZQ0VUYFWP-3A';



	/* ================================================================
		THEME FEATURES
	================================================================  */

	$contentPostTypes = array('post', 'page');
	
	// Add featured image support to theme
	add_theme_support('post-thumbnails');
	
	// Add menu support
	register_nav_menu('primary', 'Primary Menu');
		
	// Used for messaging, etc.
	//add_image_size('large-feature', 980, 300);
	//add_filter('image_size_names_choose', create_function('$sizes', 'return array_merge($sizes, array(\'large-feature\' => \'Large Feature\'));'));
	
	//add_action('wp_dashboard_setup', 'custom_dashboard_widgets');
	//add_filter('the_search_query', 'search_all_post_types');
	//add_action('admin_init', 'custom_taxonomies');
	//add_action('add_meta_boxes', 'seo_meta_box_setup');
	//add_action('save_post', 'seo_meta_box_save');
	//add_action('widgets_init', 'custom_sidebars');
	add_action('wp_enqueue_scripts', 'enqueue_javascript');
	add_action('wp_enqueue_scripts', 'enqueue_style');
	//add_action('admin_menu', 'theme_options_init');

	/*function custom_sidebars() 
	{
		register_sidebar(array(
			'name'          => 'Business Law',
			'id'            => 'business-law',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		));
	}*/

	/* ================================================================
		SCRIPTS
	================================================================  */
	
	function enqueue_javascript() 
	{
		global $include;
		
		if ($include['scripts'])
	    	wp_enqueue_script('jquery');
	    if ($include['bootstrap'])
	    	wp_enqueue_script('bootstrap-script', themedir(false) . '/includes/bootstrap/js/bootstrap.min.js');
	    //if ($include['enqueue_gform'])
	   // {
	    	//gravity_form_enqueue_scripts(1, $include['gform_ajax']);
	    	//gravity_form_enqueue_scripts(2, $include['gform_ajax']);
	    	//gravity_form_enqueue_scripts(3, $include['gform_ajax']);
	    //}
	    if ($include['owl'])
        	wp_enqueue_script('owl-script', themedir(false) . '/includes/owl/owl.carousel.min.js');
	    if ($include['slick'])
        	wp_enqueue_script('slick-script', themedir(false) . '/includes/slick/slick.min.js');
        if ($include['googlemaps'])
        {
        	wp_enqueue_script('maps-api', 'https://maps.googleapis.com/maps/api/js?key='.$google_maps_api_key.'&sensor=false');
        	wp_enqueue_script('maps-infobox', themedir(false) . '/includes/maps/infobox-min.js');
        	wp_enqueue_script('maps-label', themedir(false) . '/includes/maps/markerwithlabel-min.js');
        	wp_enqueue_script('maps-script', themedir(false) . '/js/maps.js');
        }
        if ($include['browserselector'])
        	wp_enqueue_script('browser-selector', themedir(false) . '/includes/browserselector/css_browser_selector.js');
        if ($include['stellar'])
        	wp_enqueue_script('theme-stellar', themedir(false) . '/includes/stellar/jquery.stellar.js');
        if ($include['inview'])
        	wp_enqueue_script('theme-inview', themedir(false) . '/includes/inview/jquery.inview.min.js');
        if ($include['masonry'])
        	wp_enqueue_script('theme-masonry-fix', themedir(false) . '/includes/masonry/imagesloaded.pkgd.min.js');
        	wp_enqueue_script('theme-masonry', themedir(false) . '/includes/masonry/masonry.pkgd.min.js');
        if ($include['scripts'])
        {
        	wp_enqueue_script('theme-script', themedir(false) . '/js/script.js');
        }
	}



	/* ================================================================
		STYLES & FONTS
	================================================================  */
	
	function enqueue_style()
	{
		global $compile_less;
		global $include;

		// Compile less
		if ($compile_less)
		{
			try 
			{
				// Compile less
				require('lessc.inc.php');
				
				$formatter = new lessc_formatter_classic;
				$formatter->indentChar = "\t";
				
				$less = new lessc;
				$less->setFormatter($formatter);
			    $less->checkedCompile(get_template_directory().'/less/style.less', get_template_directory().'/css/style.css');
			    $less->checkedCompile(get_template_directory().'/less/alternate.less', get_template_directory().'/css/alternate.css');
			    $less->checkedCompile(get_template_directory().'/less/responsive.less', get_template_directory().'/css/responsive.css');
			} 
			catch (Exception $ex) 
			{
			    echo "lessphp fatal error: ".$ex->getMessage();
			    exit;
			}
		}
	
		// Styles
        wp_enqueue_style('theme-style', themedir(false) . '/style.css');
        if ($include['bootstrap'])
        	wp_enqueue_style('bootstrap-style', themedir(false) . '/includes/bootstrap/css/bootstrap.min.css');
        if ($include['fontawesome'])
        	wp_enqueue_style('fontawesome-style', themedir(false) . '/includes/fontawesome/css/font-awesome.min.css');
        if ($include['owl'])
        {
        	wp_enqueue_style('owl-style', themedir(false) . '/includes/owl/owl.carousel.css');
        	wp_enqueue_style('owl-theme-style', themedir(false) . '/includes/owl/owl.theme.css');
        }
        if ($include['slick'])
        	wp_enqueue_style('slick-style', themedir(false) . '/includes/slick/slick.css');
        if ($include['less'])
        {
        	wp_enqueue_style('theme-less-style', themedir(false) . '/css/style.css');
        	wp_enqueue_style('theme-less-alternate', themedir(false) . '/css/alternate.css');
        	wp_enqueue_style('theme-less-responsive', themedir(false) . '/css/responsive.css');
        }

        // Fonts
        wp_enqueue_style('font-lato', 'http://fonts.googleapis.com/css?family=Lato:400,300');
        wp_enqueue_style('font-crimson', 'http://fonts.googleapis.com/css?family=Crimson+Text:400,400italic,700');
	}



