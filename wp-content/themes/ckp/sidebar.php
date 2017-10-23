<!-- Sidebar -->

<div class="sidebar">

	<?php if (!is_page('contact')) : ?>
		<div class="widget contact-form">
			<h3>Contact Us</h3>
			<?php gravity_form(2, false, false, false, '', true, 10) ?>
		</div>
	<?php endif; ?>

</div>