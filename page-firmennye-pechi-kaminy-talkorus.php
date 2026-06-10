<?php
/*
 * Template for the Firmennye Pechi Kaminy Talkorus page.
 * Template Name: Firmennye Pechi Kaminy Talkorus Page
 */

get_header();

$sp_obj = new SpClass();

while (have_posts()) :
	the_post();

	$brand_image_url = function ($image, $size = 'full') {
		if (!$image) {
			return '';
		}

		if (is_array($image) && !empty($image['url'])) {
			return $image['url'];
		}

		if (is_numeric($image)) {
			return wp_get_attachment_image_url($image, $size);
		}

		if (is_string($image)) {
			return $image;
		}

		return '';
	};

	$brand_image_alt = function ($image) {
		if (is_array($image) && !empty($image['alt'])) {
			return $image['alt'];
		}

		if (is_numeric($image)) {
			return get_post_meta($image, '_wp_attachment_image_alt', true);
		}

		return '';
	};

	$page_title = esc_html(get_the_title());
	$page_title = preg_replace('/(TALKORUS)/i', '<span>$1</span>', $page_title);
?>

	<div class="page brand-page">
		<div class="container">
			<div class="catalog-breadcrumbs no-mobile">
				<?php woocommerce_breadcrumb(); ?>
			</div>

			<div class="entry-header">
				<h1><?php echo wp_kses($page_title, array('span' => array())); ?></h1>
			</div>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php if (function_exists('have_rows') && have_rows('firmennye_pechi_stats')) : ?>
				<section class="brand-stats" aria-label="<?php echo esc_attr__('Characteristics', 'talkorus-theme-master'); ?>">
					<?php
					while (have_rows('firmennye_pechi_stats')) :
						the_row();

						$value = get_sub_field('value');
						$label = get_sub_field('label');
					?>
						<?php if ($value || $label) : ?>
							<div class="brand-stats__item">
								<?php if ($value) : ?>
									<div class="brand-stats__value">
										<?php echo wp_kses_post($value); ?>
									</div>
								<?php endif; ?>

								<?php if ($label) : ?>
									<div class="brand-stats__label">
										<?php echo esc_html($label); ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					<?php endwhile; ?>
				</section>
			<?php endif; ?>
		</div>

		<?php
		$intro_title = function_exists('get_field') ? get_field('firmennye_pechi_intro_title') : '';
		$intro_text  = function_exists('get_field') ? get_field('firmennye_pechi_intro_text') : '';
		$intro_image = function_exists('get_field') ? get_field('firmennye_pechi_intro_image') : '';

		if ($intro_title || $intro_text || $intro_image || (function_exists('have_rows') && have_rows('firmennye_pechi_features'))) :
		?>
			<section class="brand-intro">
				<div class="container">
					<?php if ($intro_title) : ?>
						<h2 class="brand-intro__title">
							<?php echo wp_kses_post($intro_title); ?>
						</h2>
					<?php endif; ?>

					<div class="brand-intro__main">
						<?php if ($intro_text) : ?>
							<div class="brand-intro__content">
								<?php echo wp_kses_post($intro_text); ?>
							</div>
						<?php endif; ?>

						<?php
						$intro_image_url = $brand_image_url($intro_image, 'large');
						if ($intro_image_url) :
						?>
							<div class="brand-intro__media">
								<img src="<?php echo esc_url($intro_image_url); ?>" alt="<?php echo esc_attr($brand_image_alt($intro_image)); ?>" />
							</div>
						<?php endif; ?>
					</div>

					<?php if (function_exists('have_rows') && have_rows('firmennye_pechi_features')) : ?>
						<div class="brand-features">
							<?php
							while (have_rows('firmennye_pechi_features')) :
								the_row();

								$icon      = get_sub_field('icon');
								$icon_url  = $brand_image_url($icon, 'thumbnail');
								$icon_alt  = $brand_image_alt($icon);
								$title     = get_sub_field('title');
							?>
								<?php if ($icon_url || $title) : ?>
									<div class="brand-features__item">
										<?php if ($icon_url) : ?>
											<div class="brand-features__icon">
												<img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($icon_alt); ?>" />
											</div>
										<?php endif; ?>

										<?php if ($title) : ?>
											<div class="brand-features__title">
												<?php echo wp_kses_post($title); ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							<?php endwhile; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if (function_exists('have_rows') && have_rows('firmennye_pechi_principle_items')) : ?>
			<section class="brand-principle">
				<div class="container">
					<div class="section-divider">
						<span class="line"></span>

						<div class="section-divider__icon">
							<img src="<?php echo esc_url(get_template_directory_uri() . '/img/divider-icon.svg'); ?>" alt="" />
						</div>

						<span class="line"></span>
					</div>

					<?php
					$principle_title = get_field('firmennye_pechi_principle_title');

					if ($principle_title) :
					?>
						<h2 class="brand-principle__title">
							<?php echo wp_kses_post($principle_title); ?>
						</h2>
					<?php endif; ?>

					<div class="brand-principle__grid">
						<?php
						while (have_rows('firmennye_pechi_principle_items')) :
							the_row();

							$image     = get_sub_field('image');
							$image_url = $brand_image_url($image, 'large');
							$title     = get_sub_field('title');
							$text      = get_sub_field('text');
						?>
							<?php if ($image_url || $title || $text) : ?>
								<article class="brand-principle-card">
									<?php if ($image_url) : ?>
										<div class="brand-principle-card__image">
											<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($brand_image_alt($image)); ?>" />
										</div>
									<?php endif; ?>

									<div class="brand-principle-card__content">
										<?php if ($title) : ?>
											<h3 class="brand-principle-card__title">
												<?php echo esc_html($title); ?>
											</h3>
										<?php endif; ?>

										<?php if ($text) : ?>
											<div class="brand-principle-card__text">
												<?php echo wp_kses_post($text); ?>
											</div>
										<?php endif; ?>
									</div>
								</article>
							<?php endif; ?>
						<?php endwhile; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if (function_exists('have_rows') && have_rows('firmennye_pechi_certificate_images')) : ?>
			<section class="brand-certificates">
				<div class="container">
					<div class="section-divider">
						<span class="line"></span>

						<div class="section-divider__icon">
							<img src="<?php echo esc_url(get_template_directory_uri() . '/img/divider-icon.svg'); ?>" alt="" />
						</div>

						<span class="line"></span>
					</div>

					<div class="brand-certificates__inner">
						<div class="brand-certificates__slider swiper">
							<div class="swiper-wrapper">
								<?php
								while (have_rows('firmennye_pechi_certificate_images')) :
									the_row();

									$image     = get_sub_field('image');
									$image_url = $brand_image_url($image, 'large');
								?>
									<?php if ($image_url) : ?>
										<div class="brand-certificates__slide swiper-slide">
											<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($brand_image_alt($image)); ?>" />
										</div>
									<?php endif; ?>
								<?php endwhile; ?>
							</div>

							<button class="brand-certificates__nav brand-certificates__nav--prev" type="button" aria-label="Предыдущий сертификат"></button>
							<button class="brand-certificates__nav brand-certificates__nav--next" type="button" aria-label="Следующий сертификат"></button>

							<div class="brand-certificates__pagination swiper-pagination"></div>
						</div>

						<div class="brand-certificates__content">
							<?php
							$certificate_title = get_field('firmennye_pechi_certificate_title');
							$certificate_text  = get_field('firmennye_pechi_certificate_text');

							if ($certificate_title) :
							?>
								<h2 class="brand-certificates__title">
									<?php echo wp_kses_post($certificate_title); ?>
								</h2>
							<?php endif; ?>

							<?php if ($certificate_text) : ?>
								<div class="brand-certificates__text">
									<?php echo wp_kses_post($certificate_text); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$cta_title = function_exists('get_field') ? get_field('firmennye_pechi_cta_title') : '';
		$cta_text  = function_exists('get_field') ? get_field('firmennye_pechi_cta_text') : '';
		$cta_bg    = function_exists('get_field') ? get_field('firmennye_pechi_cta_bg') : '';
		$cta_bg_url = $brand_image_url($cta_bg, 'large');

		if ($cta_title || $cta_text || $cta_bg_url || (function_exists('have_rows') && have_rows('firmennye_pechi_cta_links'))) :
		?>
			<section class="brand-cta">
				<div class="container">
					<div
						class="brand-cta__inner"
						<?php if ($cta_bg_url) : ?>
							style="background-image: linear-gradient(rgba(33, 33, 33, 0.78), rgba(33, 33, 33, 0.78)), url('<?php echo esc_url($cta_bg_url); ?>');"
						<?php endif; ?>
					>
						<?php if ($cta_title) : ?>
							<h2 class="brand-cta__title">
								<?php echo wp_kses_post($cta_title); ?>
							</h2>
						<?php endif; ?>

						<?php if ($cta_text) : ?>
							<div class="brand-cta__text">
								<?php echo wp_kses_post($cta_text); ?>
							</div>
						<?php endif; ?>

						<?php if (function_exists('have_rows') && have_rows('firmennye_pechi_cta_links')) : ?>
							<div class="brand-cta__links">
								<?php
								while (have_rows('firmennye_pechi_cta_links')) :
									the_row();

									$icon     = get_sub_field('icon');
									$icon_url = $brand_image_url($icon, 'thumbnail');
									$url      = get_sub_field('url');
									$label    = get_sub_field('label');
								?>
									<?php if ($url && ($icon_url || $label)) : ?>
										<a class="brand-cta__link" href="<?php echo esc_url($url); ?>" aria-label="<?php echo esc_attr($label); ?>">
											<?php if ($icon_url) : ?>
												<img src="<?php echo esc_url($icon_url); ?>" alt="" />
											<?php else : ?>
												<span><?php echo esc_html($label); ?></span>
											<?php endif; ?>
										</a>
									<?php endif; ?>
								<?php endwhile; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</div>

<?php endwhile;

get_sidebar();
get_footer();
