<?php
/*
 * Template for the Usloviya Postavki page.
 * Template Name: Usloviya Postavki Page
 */

get_header();
$sp_obj = new SpClass();

while (have_posts()) : the_post(); ?>

	<div class="page delivery-page">
		<div class="container">
			<div class="catalog-breadcrumbs no-mobile">
				<?php woocommerce_breadcrumb(); ?>
			</div>

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

		<?php if (function_exists('have_rows') && have_rows('usloviya_postavki_steps')) : ?>
			<section class="delivery-page__steps">
				<div class="container">
					<div class="delivery-steps">
						<?php
						$step_index = 1;

						while (have_rows('usloviya_postavki_steps')) :
							the_row();

							$title = get_sub_field('title');
							$text  = get_sub_field('info');

							if (!$text) {
								$text = get_sub_field('text');
							}
						?>
							<div class="delivery-steps__item">
								<div class="delivery-steps__number">
									<?php echo esc_html(sprintf('%02d', $step_index)); ?>
								</div>

								<?php if ($title) : ?>
									<h3 class="delivery-steps__title">
										<?php echo esc_html($title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($text) : ?>
									<div class="delivery-steps__text">
										<?php echo wp_kses_post($text); ?>
									</div>
								<?php endif; ?>
							</div>
						<?php
							$step_index++;
						endwhile;
						?>
					</div>
				</div>
			</section>
		<?php endif; ?>
		<?php if (function_exists('have_rows') && have_rows('usloviya_postavki_accordion')) : ?>
			<section class="site-section about-info delivery-page__accordion-section">
				<div class="container">
					<div class="section-divider">
						<span class="line"></span>

						<div class="section-divider__icon">
							<img src="<?php echo esc_url(get_template_directory_uri() . '/img/divider-icon.svg'); ?>" alt="" />
						</div>

						<span class="line"></span>
					</div>

					<div class="about-info__accordion">
						<?php
						while (have_rows('usloviya_postavki_accordion')) :
							the_row();

							$title   = get_sub_field('title');
							$content = get_sub_field('content');

							if (!$title) {
								$title = get_sub_field('question');
							}

							if (!$content) {
								$content = get_sub_field('info');
							}

							if (!$content) {
								$content = get_sub_field('answer');
							}
						?>
							<?php if ($title || $content) : ?>
								<div class="about-info__item">
									<button class="about-info__head" type="button">
										<span class="about-info__icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M12 16.5C11.8082 16.5 11.6162 16.4267 11.4698 16.2803L3.9698 8.7803C3.67674 8.48723 3.67674 8.01267 3.9698 7.7198C4.26286 7.42692 4.73743 7.42673 5.0303 7.7198L12 14.6895L18.9698 7.7198C19.2629 7.42674 19.7374 7.42674 20.0303 7.7198C20.3232 8.01286 20.3234 8.48742 20.0303 8.7803L12.5303 16.2803C12.3839 16.4267 12.1919 16.5 12 16.5Z" fill="black" />
											</svg>
										</span>

										<?php if ($title) : ?>
											<span class="about-info__title">
												<?php echo esc_html($title); ?>
											</span>
										<?php endif; ?>
									</button>

									<?php if ($content) : ?>
										<div class="about-info__body">
											<div class="about-info__content">
												<?php echo wp_kses_post($content); ?>
											</div>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						<?php endwhile; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</div>

<?php endwhile;

get_sidebar();
get_footer();
