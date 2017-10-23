<?php if (have_posts()) while (have_posts()): ?>

	<div class="post">	
		<?php
			the_post();
			the_title('<h2>' . sprintf('<a href="%s">', get_permalink()), '</a></h2>');
			the_excerpt();
			echo sprintf('<p><a href="%1$s">View page</a></p>', get_permalink());
		?>
	</div>

<?php endwhile; ?>