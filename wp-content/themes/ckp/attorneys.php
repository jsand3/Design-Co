<?php
/*
* Template Name: Attorney Profiles
*/
	get_header(); 
	get_template_part('loop', 'header'); 
?>

	<?php 
		if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb('<p id="breadcrumbs">','</p>');
		}
	?>

	<?php 
		if (have_posts()) while(have_posts()): 
			the_post();
			the_title('<div class="heading"><h2>','</h2><h4>Experience That Makes a Difference</h4></div>');
			//the_content();
		endwhile;  
	?>

	<div class="row">
		<div class="col-sm-6">
			<p>Our attorneys have more than 250 years of combined experience and bring to each case a broad base of legal, professional and practical experience. Our attorneys consist of several former prosecutors, two Certified Family Law Specialists*, two Collaborative Family Law Practitioners*, four Registered Family Law Mediators*, three Registered Civil Law Mediators, a former employee of the Indiana Department of Revenue, a licensed real estate agent, a former Chair of the employment law and business law section of the Indiana Bar Association, a past president of Carmel and Fishers Indiana Chambers of Commerce, and a former employee of the United States Securities and Exchange Commission.</p>
			<p>Additionally, the firm is very active in the Indiana State Bar Association and has been honored to have two members as past presidents, two members who have served on its Board of Governors, and one member of the firm to serve as its first counsel to the Bar Association President. Furthermore at least three members of the firm have chaired sections of the Bar Association.</p>
		</div>
		<div class="col-sm-6">
			<p>Our attorneys are highly regarded in the legal community. Six members of our firm were listed for inclusion as Super Lawyers or Rising Stars in the 2011 or 2012 Indianapolis Monthly Magazine. Several of our attorneys are AV Preeminent rated* by the Martindale-Hubbell peer review rating system, the highest rating for legal ability and ethics. We are the only firm whose home office is in Hamilton County with three lawyers listed in Woodward/White's Best Lawyers in America.<p>
			<p>We look forward to speaking with you about your legal needs. To schedule a consultation with an Indianapolis area lawyer at our firm, contact our law offices in Carmel or Noblesville, Indiana.</p>
			<p>Call (317)773-2090 to contact our Noblesville office. Call (317)846-6514 to contact our Carmel office. You may also contact us by e-mail.</p>
		</div>
	</div>

	<div class="view-attorneys">
		<p>Please view our attorney profiles to learn more about our legal team</p>
		<div class="line"></div>
	</div>

	<div class="attorneys">
		<div class="row">
		<?php 
			$attorneys = new WP_Query(array(
				'post_type' => 'attorney-profiles',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'posts_per_page' => -1
			));
			$i = 0;
			if ($attorneys->have_posts()) {
				while ($attorneys->have_posts()) {
					$attorneys->the_post();
					if ($i >= 5) {
						$i = 0;
						echo '</div><div class="row">';
					}
					?>

					<div class="column col-md-5ths">     
						<div class="attorney">
							<?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>
							<div class="text"> 
								<a href="<?php echo get_the_permalink(get_post_meta($attorneys->post->ID, 'meta_attorneys_link', true)); ?>">
									<?php echo get_the_title(); ?>
								</a>
							</div>
						</div>
					</div>

					<?php
					$i++;
				}
			}
			wp_reset_postdata();
		?>
		</div>
	</div>

<?php 
	get_template_part('loop', 'footer');
	get_footer(); 
?>