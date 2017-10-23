<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<?php 
		seocharset();
		seokeywords();
		seodescription();
		wp_head();
	?>
	<title><?php wp_title(''); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=0.8">

	<!-- Trajan Font -->
	<script>
		(function(d) {
			var config = {
				kitId: 'vji1qyy',
				scriptTimeout: 3000
			},
			h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
		})(document);
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="<?php themedir() ?>/includes/parallax.js-master/parallax.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=PT+Sans:700|Raleway' rel='stylesheet' type='text/css'>
	<meta name="google-site-verification" content="KeNFR2h4_Nb6XPJ6CPtBMfTv_qnUH-Gvbqhdkdq1sM0" />
</head>

<body class="<?php echo (is_page('36') ? 'home' : 'interior'); ?>">
//<!-- echo (is_front_page() ? 'home' : 'interior'); -->

	<!-- Navbar -->
<nav id="top" class="navbar navbar-fixed-top alternate" role="navigation">
	<div class="wrapper">

		<!-- Logo  -->
		<div class="logo">
			<a href="/john">
			<img class="img-responsive" src="<?php themedir() ?>/images/logo-3.png" />
			</a>
		</div>
		<!-- mobile logo-->
		<div>
			<div class="logo-mobile">
				<a href="/john">
				<img class="img-responsive" src="<?php themedir() ?>/images/logo-2-img.png" />
				</a>
			</div>
			<!-- Mobile Button -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <i class="fa fa-bars"></i>
                <!-- <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar top-bar"></span>
				<span class="icon-bar middle-bar"></span>
				<span class="icon-bar bottom-bar"></span> -->
            </button>
			<!-- <div class="mobile-ham-menu">
				<div id="hmBtn" onclick="toggleCP()">
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div> -->
		</div>
		<div id="cp"></div>
			<!-- Nav Bar Attempt -->
		<div class="collapse navbar-collapse">
		    <?php 
		    	wp_nav_menu(array(
		    		'theme_location' => 'primary',
		    		'menu_class' => 'nav navbar-nav',
		    		'fallback_cb' => 'wp_page_menu',
		    		'walker' => new wp_bootstrap_navwalker(),
		    	));
		    ?>
	    </div>
			<!-- <div class="menu-primary-container">
				<ul class="nav navbar-nav">
					<li class="menu">
						<a href="#ab-us">About</a>
					</li>
					<li class="menu">
						<a href="#we-de">We Design</a>
						<i class="fa fa-angle-down"></i>
					</li>
					<li class="menu">
						<a href="#me-de">Designers</a>
						<i class="fa fa-angle-down"></i>
					</li>
					<li class="menu">
						<a href="#de-pr">Projects</a>
						<i class="fa fa-angle-down"></i>
					</li>
					<li class="menu">
						<a href="#co-us">Contact</a>
						<i class="fa fa-angle-down"></i>
					</li>
				</ul>
			</div> -->
	</div>
</nav>

<header id="wf-header"> 

	<!-- Background -->
	<!-- <div class="background"> -->
		<?php if (is_page('36')) : ?>
			<!-- <img class="bg" src="<?php //themedir() ?>/wf-images/ws-hero-img.jpg" data-stellar-ratio="0.2" data-stellar-vertical-offset="0" /> -->
			<div class="background parallax-window" data-parallax="scroll" data-image-src="<?php themedir() ?>/wf-images/ws-hero-img.jpg" data-position-y="50px">
			</div>

		<?php else : ?>
			<div class="background"> <!-- background div should go away if added back before if satement -->
			<img class="bg" src="<?php themedir() ?>/images/bg-1.jpg" data-stellar-ratio="0.2" data-stellar-vertical-offset="-200" />
		<?php endif; ?>
	<!-- </div> -->

	<!-- Banner -->


	<?php if (is_page('36')) : ?>
		
		<!-- -->
		<!-- <div class="container"> -->
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div id="header-well" class="well">
						<div class="text-center">
							<h1>Design Company<br>
								<small class="text-center">NEW HEADER Where Your Dream Home Becomes A Reality</small>
							</h1>
							<div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php else : ?>

				<?php
				if (is_single()) {
					if (get_post_type() == 'attorney-profiles')
						$title = 'Contact';
					else
						$title = 'Blog';
				}
				elseif (is_404()) {
					$title = '404';
				}
				elseif (is_home()) {
					$title = 'Blog';
				}
				elseif (is_search()) {
					$title = 'Search';
				}
				elseif (is_archive()) {
					$title = 'Blog';
				}
				else {
								// Get current menu item's title
					$menu_items = wp_get_nav_menu_items('primary');
					foreach($menu_items as $item) {
						if ($item->object_id == get_the_ID())
							$title = $item->title;
					}
					if ($title == '')
						$title = empty($post->post_parent) ? get_the_title($post->ID) : get_the_title($post->post_parent);
				}
				?>

				<div class="text">
					<h1><?php echo $title; ?></h1>
				</div>

			<?php endif; ?>

			<!-- Nav Bar Attempt End -->

		</div>
	</div>
</nav>
<!-- Tag For About Link -->
<div id="ab-us"></div>
</header>



