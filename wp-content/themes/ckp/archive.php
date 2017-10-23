<?php 
	get_header();
	get_template_part('loop', 'header');
?>

	<h1>Archive</h1>

<?php 
	get_template_part('loop', 'subposts');
	get_template_part('loop', 'footer');
	get_footer(); 
?>