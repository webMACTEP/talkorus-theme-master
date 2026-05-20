<?php
/*
 * The template for displaying all pages
 */

get_header();
$sp_obj = new SpClass();

while (have_posts()) : the_post(); ?>

	<div class="page">
		<div class="container">

			<?php
			$hide_entry_header = function_exists('get_field') ? get_field('hide_entry_header') : false;

			if (!$hide_entry_header) : ?>
				<div class="entry-header">
					<h1><?php $sp_obj->get_title(); ?></h1>
				</div>
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</div>

	</div>

<?php endwhile;

get_sidebar();
get_footer();
