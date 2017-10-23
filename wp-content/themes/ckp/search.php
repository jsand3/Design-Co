<?php 
	get_header();
	get_template_part('loop', 'header');
?>

	<h1>Search Results</h1>
	<p><?php echo $wp_query->post_count; ?> result(s) for "<strong><?php echo htmlentities($_GET['s']); ?></strong>".</p>

<?php 
	get_template_part('loop', 'search');
	get_template_part('loop', 'footer');
	get_footer(); 
?>