<?php 
	get_header();
	get_template_part('loop', 'header');
	if (have_posts()) while (have_posts()): ?>

	<div class="post">	
		<?php
			the_post();
			if (function_exists('yoast_breadcrumb')) {
				yoast_breadcrumb('<div class="breadcrumbs">','</div>');
			}
			the_title('<h1>','</h1>');
			the_content();
		?>
	</div>

<?php endwhile; 
	get_template_part('loop', 'footer');
	get_footer();
?>