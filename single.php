<?php
/*
 * The template for displaying all single posts
 */

get_header();
$sp_obj = new SpClass();

while (have_posts()) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		<div class="container">

			<div class="entry-header">
				<h1><?php $sp_obj->get_title(); ?></h1>
			</div>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</div>

	</article>

	<div class="container">

		<?php
		if (comments_open() || get_comments_number()) :
			comments_template();
		endif;
		?>

	</div>

<?php


endwhile;

get_sidebar();
get_footer();
