<?php 
	get_header();
	get_template_part('loop', 'header');
	if (have_posts()) while (have_posts()): ?>

	<div class="email-attorney">	
		<?php
			the_post();
			if (function_exists('yoast_breadcrumb')) {
				yoast_breadcrumb('<div class="breadcrumbs">','</div>');
			}

			// Title
			echo '<div class="heading">';
				echo '<h2>Email '.get_the_title().'</h2>';
			echo '</div>';

			// Form with dynamically populated attorney email field
			$email = get_post_meta($post->ID, 'meta_attorneys_email', true);
			gravity_form(5, false, false, false, array('attorney-email' => $email), true, 19);
		?>
	</div>

<?php endwhile; 
	get_template_part('loop', 'footer');
	get_footer();
?>