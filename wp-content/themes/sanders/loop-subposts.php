<?php 
	if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('<p id="breadcrumbs">','</p>');
	}
?>

<div class="heading"><h2>Blog</h2></div>

<?php if (have_posts()) while (have_posts()): ?>

	<div class="post">	
		<?php
			the_post();

			// Title
			the_title('<h2>' . sprintf('<a href="%s">', get_permalink()), '</a></h2>');
			echo '<div class="the-date">';

				// Date Posted
				echo 'Posted on '.get_the_time('F j, Y');

				// Categories
				$categories = get_the_category();
				$separator = ' ';
				$output = ', ';
				if ($categories)
				{
					foreach($categories as $category) {
						$output .= '<a href="'.get_category_link($category->term_id).'">'.$category->cat_name.'</a>'.$separator;
					}
					echo trim($output, $separator);
				}
			echo '</div>';

			// Excerpt
			the_excerpt();

			// Read More Link
			echo '<a href="'.get_permalink().'">Read More</a>';
		?>
	</div>

<?php endwhile; ?>

<nav id="page-nav">
    <?php next_posts_link(__('&laquo; Previous Entries','lop')) ?>
    <?php previous_posts_link(__('Next Entries &raquo;','lop')) ?>
</nav>