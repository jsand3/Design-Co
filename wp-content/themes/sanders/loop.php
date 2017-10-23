<?php 
	if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('<p id="breadcrumbs">','</p>');
	}

	$subtitle = '';
	if (is_page('firm-overview'))
		$subtitle = 'A Proud Tradition of Legal Service';
	if (is_page('practice-areas'))
		$subtitle = 'Serving Your Legal Needs';
	if (is_page('contact')) 
		$subtitle = 'Contact Campbell Kyle Proffitt LLP'; 
?>

<?php 
	if (have_posts()) while(have_posts()): 
		the_post();
		the_title('<div class="heading"><h2>','</h2>'.($subtitle ? '<h4>'.$subtitle.'</h4>' : '').'</div>');
		the_content();
	endwhile; 
?>