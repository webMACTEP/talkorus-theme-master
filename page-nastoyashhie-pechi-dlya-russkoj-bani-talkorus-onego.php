<?php
/*
 * Template for the Nastoyashhie Pechi Dlya Russkoj Bani Talkorus Onego page.
 * Template Name: Nastoyashhie Pechi Dlya Russkoj Bani Talkorus Onego Page
 */

get_header();

while (have_posts()) :
	the_post();

	$onego_image_url = function ($image, $size = 'full') {
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

	$onego_image_alt = function ($image) {
		if (is_array($image) && !empty($image['alt'])) {
			return $image['alt'];
		}

		if (is_numeric($image)) {
			return get_post_meta($image, '_wp_attachment_image_alt', true);
		}

		return '';
	};

	$onego_file_url = function ($file) {
		if (!$file) {
			return '';
		}

		if (is_array($file) && !empty($file['url'])) {
			return $file['url'];
		}

		if (is_numeric($file)) {
			return wp_get_attachment_url($file);
		}

		if (is_string($file)) {
			return $file;
		}

		return '';
	};

	$onego_divider = function () { ?>
		<div class="section-divider">
			<span class="line"></span>

			<div class="section-divider__icon">
				<img src="<?php echo esc_url(get_template_directory_uri() . '/img/divider-icon.svg'); ?>" alt="" />
			</div>

			<span class="line"></span>
		</div>
	<?php };

	$page_title = esc_html(get_the_title());
	$page_title = preg_replace('/(TALKORUS|ОНЕГО)/iu', '<span>$1</span>', $page_title);
?>

	<div class="page brand-page onego-page">
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

			<?php if (function_exists('have_rows') && have_rows('onego_stats')) : ?>
				<section class="onego-stats" aria-label="<?php echo esc_attr__('Characteristics', 'talkorus-theme-master'); ?>">
					<?php
					while (have_rows('onego_stats')) :
						the_row();

						$value = get_sub_field('value');
						$label = get_sub_field('label');
					?>
						<?php if ($value || $label) : ?>
							<div class="onego-stats__item">
								<?php if ($value) : ?>
									<div class="onego-stats__value">
										<?php echo wp_kses_post($value); ?>
									</div>
								<?php endif; ?>

								<?php if ($label) : ?>
									<div class="onego-stats__label">
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
		$intro_title = function_exists('get_field') ? get_field('onego_intro_title') : '';
		$intro_text  = function_exists('get_field') ? get_field('onego_intro_text') : '';
		$intro_image = function_exists('get_field') ? get_field('onego_intro_image') : '';

		if ($intro_title || $intro_text || $intro_image || (function_exists('have_rows') && have_rows('onego_features'))) :
		?>
			<section class="onego-intro">
				<div class="container">
					<?php if ($intro_title) : ?>
						<h2 class="onego-intro__title">
							<?php echo wp_kses_post($intro_title); ?>
						</h2>
					<?php endif; ?>

					<div class="onego-intro__main">
						<?php if ($intro_text) : ?>
							<div class="onego-intro__content">
								<div class="onego-intro__text">
									<?php echo wp_kses_post($intro_text); ?>
								</div>
							</div>
						<?php endif; ?>

						<?php
						$intro_image_url = $onego_image_url($intro_image, 'large');
						if ($intro_image_url) :
						?>
							<div class="onego-intro__media">
								<img src="<?php echo esc_url($intro_image_url); ?>" alt="<?php echo esc_attr($onego_image_alt($intro_image)); ?>" />
							</div>
						<?php endif; ?>
					</div>

					<?php if (function_exists('have_rows') && have_rows('onego_features')) : ?>
						<div class="brand-features onego-features">
							<?php
							while (have_rows('onego_features')) :
								the_row();

								$icon     = get_sub_field('icon');
								$icon_url = $onego_image_url($icon, 'thumbnail');
								$title    = get_sub_field('title');
							?>
								<?php if ($icon_url || $title) : ?>
									<div class="brand-features__item onego-features__item">
										<?php if ($icon_url) : ?>
											<div class="brand-features__icon">
												<img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($onego_image_alt($icon)); ?>" />
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

		<?php if (function_exists('have_rows') && have_rows('onego_videos')) : ?>
			<section class="onego-section onego-videos">
				<div class="container">
					<?php $onego_divider(); ?>

					<?php
					$videos_title = get_field('onego_videos_title');

					if ($videos_title) :
					?>
						<h2 class="onego-section__title">
							<?php echo wp_kses_post($videos_title); ?>
						</h2>
					<?php endif; ?>

					<div class="onego-videos__grid">
						<?php
						while (have_rows('onego_videos')) :
							the_row();

							$preview     = get_sub_field('preview');
							$preview_url = $onego_image_url($preview, 'large');
							$video_url   = $onego_file_url(get_sub_field('video'));
							$title       = get_sub_field('title');
						?>
							<?php if ($preview_url || $video_url || $title) : ?>
								<?php if ($video_url) : ?>
									<button class="about-us__video onego-videos__card" type="button" data-video-src="<?php echo esc_url($video_url); ?>">
								<?php else : ?>
									<div class="onego-videos__card">
								<?php endif; ?>
									<?php if ($preview_url) : ?>
										<img src="<?php echo esc_url($preview_url); ?>" alt="<?php echo esc_attr($onego_image_alt($preview)); ?>" />
									<?php endif; ?>

									<?php if ($title) : ?>
										<span class="onego-videos__label">
											<?php echo esc_html($title); ?>
										</span>
									<?php endif; ?>

									<?php if ($video_url) : ?>
										<span class="about-us__play onego-videos__play">
											<svg xmlns="http://www.w3.org/2000/svg" width="58" height="58" viewBox="0 0 58 58" fill="none">
												<circle opacity="0.2" cx="29" cy="29" r="29" fill="#FFBC3B" />
												<circle cx="29" cy="29" r="16" fill="#FFBC3B" />
												<path d="M33.4 28.15C34.33 28.69 34.33 30.03 33.4 30.57L26.9 34.32C25.96 34.86 24.8 34.19 24.8 33.08V25.62C24.8 24.51 25.96 23.84 26.9 24.38L33.4 28.15Z" fill="white" />
											</svg>
										</span>
									<?php endif; ?>
								<?php echo $video_url ? '</button>' : '</div>'; ?>
							<?php endif; ?>
						<?php endwhile; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$story_title = function_exists('get_field') ? get_field('onego_story_title') : '';
		$story_text  = function_exists('get_field') ? get_field('onego_story_text') : '';

		if ($story_title || $story_text || (function_exists('have_rows') && have_rows('onego_story_images'))) :
		?>
			<section class="onego-section onego-story">
				<div class="container">
					<?php $onego_divider(); ?>

					<div class="onego-story__inner">
						<?php if (function_exists('have_rows') && have_rows('onego_story_images')) : ?>
							<div class="onego-story__images">
								<?php
								while (have_rows('onego_story_images')) :
									the_row();

									$image     = get_sub_field('image');
									$image_url = $onego_image_url($image, 'large');
								?>
									<?php if ($image_url) : ?>
										<div class="onego-story__image">
											<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($onego_image_alt($image)); ?>" />
										</div>
									<?php endif; ?>
								<?php endwhile; ?>
							</div>
						<?php endif; ?>

						<div class="onego-story__content">
							<?php if ($story_title) : ?>
								<h2 class="onego-section__title">
									<?php echo wp_kses_post($story_title); ?>
								</h2>
							<?php endif; ?>

							<?php if ($story_text) : ?>
								<div class="onego-story__text">
									<?php echo wp_kses_post($story_text); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if (function_exists('have_rows') && have_rows('onego_reasons')) : ?>
			<section class="onego-section onego-reasons">
				<div class="container">
					<?php $onego_divider(); ?>

					<?php
					$reasons_title    = get_field('onego_reasons_title');
					$reasons_subtitle = get_field('onego_reasons_subtitle');
					?>

					<?php if ($reasons_title) : ?>
						<h2 class="onego-section__title">
							<?php echo wp_kses_post($reasons_title); ?>
						</h2>
					<?php endif; ?>

					<?php if ($reasons_subtitle) : ?>
						<div class="onego-section__subtitle">
							<?php echo esc_html($reasons_subtitle); ?>
						</div>
					<?php endif; ?>

					<div class="onego-reasons__slider swiper">
						<div class="swiper-wrapper">
							<?php
							$reason_index = 1;

							while (have_rows('onego_reasons')) :
								the_row();

								$title = get_sub_field('title');
								$text  = get_sub_field('text');
							?>
								<?php if ($title || $text) : ?>
									<div class="onego-reasons__slide swiper-slide">
										<article class="onego-reason-card">
											<div class="onego-reason-card__number">
												<?php echo esc_html(sprintf('%02d', $reason_index)); ?>
											</div>

											<?php if ($title) : ?>
												<h3 class="onego-reason-card__title">
													<?php echo esc_html($title); ?>
												</h3>
											<?php endif; ?>

											<?php if ($text) : ?>
												<div class="onego-reason-card__text">
													<?php echo wp_kses_post($text); ?>
												</div>
											<?php endif; ?>
										</article>
									</div>
								<?php endif; ?>
							<?php
								$reason_index++;
							endwhile;
							?>
						</div>

						<div class="onego-reasons__pagination swiper-pagination"></div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if (function_exists('have_rows') && have_rows('onego_principle_images')) : ?>
			<section class="onego-section onego-principle">
				<div class="container">
					<?php $onego_divider(); ?>

					<?php
					$principle_title = get_field('onego_principle_title');

					if ($principle_title) :
					?>
						<h2 class="onego-section__title">
							<?php echo wp_kses_post($principle_title); ?>
						</h2>
					<?php endif; ?>

					<div class="onego-principle__grid">
						<?php
						while (have_rows('onego_principle_images')) :
							the_row();

							$image     = get_sub_field('image');
							$image_url = $onego_image_url($image, 'large');
							$caption   = get_sub_field('caption');
						?>
							<?php if ($image_url || $caption) : ?>
								<figure class="onego-principle__item">
									<?php if ($image_url) : ?>
										<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($onego_image_alt($image)); ?>" />
									<?php endif; ?>

									<?php if ($caption) : ?>
										<figcaption><?php echo wp_kses_post($caption); ?></figcaption>
									<?php endif; ?>
								</figure>
							<?php endif; ?>
						<?php endwhile; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if (function_exists('have_rows') && have_rows('onego_certificate_images')) : ?>
			<section class="brand-certificates onego-certificates">
				<div class="container">
					<?php $onego_divider(); ?>

					<div class="brand-certificates__inner">
						<div class="brand-certificates__slider swiper">
							<div class="swiper-wrapper">
								<?php
								while (have_rows('onego_certificate_images')) :
									the_row();

									$image     = get_sub_field('image');
									$image_url = $onego_image_url($image, 'large');
								?>
									<?php if ($image_url) : ?>
										<div class="brand-certificates__slide swiper-slide">
											<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($onego_image_alt($image)); ?>" />
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
							$certificate_title = get_field('onego_certificate_title');
							$certificate_text  = get_field('onego_certificate_text');

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

		<?php if (function_exists('have_rows') && have_rows('onego_models')) : ?>
			<section class="onego-section onego-models">
				<div class="container">
					<?php $onego_divider(); ?>

					<?php
					$models_title = get_field('onego_models_title');

					if ($models_title) :
					?>
						<h2 class="onego-section__title">
							<?php echo wp_kses_post($models_title); ?>
						</h2>
					<?php endif; ?>

					<div class="onego-models__list">
						<?php
						$model_index = 0;

						while (have_rows('onego_models')) :
							the_row();

							$title    = get_sub_field('title');
							$subtitle = get_sub_field('subtitle');
							$text     = get_sub_field('text');
							$reverse  = $model_index % 2 === 1;
						?>
							<div class="onego-model <?php echo $reverse ? 'onego-model--reverse' : ''; ?>">
								<div class="onego-model__content">
									<?php if ($title) : ?>
										<h3 class="onego-model__title">
											<?php echo wp_kses_post($title); ?>
										</h3>
									<?php endif; ?>

									<?php if ($subtitle) : ?>
										<div class="onego-model__subtitle">
											<?php echo esc_html($subtitle); ?>
										</div>
									<?php endif; ?>

									<?php if ($text) : ?>
										<div class="onego-model__text">
											<?php echo wp_kses_post($text); ?>
										</div>
									<?php endif; ?>
								</div>

								<?php if (have_rows('images')) : ?>
									<div class="onego-model__slider swiper">
										<div class="swiper-wrapper">
											<?php
											while (have_rows('images')) :
												the_row();

												$image     = get_sub_field('image');
												$image_url = $onego_image_url($image, 'large');
											?>
												<?php if ($image_url) : ?>
													<div class="onego-model__slide swiper-slide">
														<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($onego_image_alt($image)); ?>" />
													</div>
												<?php endif; ?>
											<?php endwhile; ?>
										</div>

										<div class="onego-model__pagination swiper-pagination"></div>
									</div>
								<?php endif; ?>
							</div>
						<?php
							$model_index++;
						endwhile;
						?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if (function_exists('have_rows') && have_rows('onego_textures')) : ?>
			<section class="onego-section onego-textures">
				<div class="container">
					<?php $onego_divider(); ?>

					<?php
					$textures_title = get_field('onego_textures_title');

					if ($textures_title) :
					?>
						<h2 class="onego-section__title">
							<?php echo wp_kses_post($textures_title); ?>
						</h2>
					<?php endif; ?>

					<div class="onego-textures__slider swiper">
						<div class="swiper-wrapper">
							<?php
							while (have_rows('onego_textures')) :
								the_row();

								$image     = get_sub_field('image');
								$image_url = $onego_image_url($image, 'large');
								$title     = get_sub_field('title');
								$text      = get_sub_field('text');
							?>
								<?php if ($image_url || $title || $text) : ?>
									<div class="onego-textures__slide swiper-slide">
										<article class="onego-texture-card">
											<?php if ($image_url) : ?>
												<div class="onego-texture-card__image">
													<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($onego_image_alt($image)); ?>" />
												</div>
											<?php endif; ?>

											<?php if ($title) : ?>
												<h3 class="onego-texture-card__title">
													<?php echo esc_html($title); ?>
												</h3>
											<?php endif; ?>

											<?php if ($text) : ?>
												<div class="onego-texture-card__text">
													<?php echo wp_kses_post($text); ?>
												</div>
											<?php endif; ?>
										</article>
									</div>
								<?php endif; ?>
							<?php endwhile; ?>
						</div>

						<div class="onego-textures__pagination swiper-pagination"></div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$cta_title  = function_exists('get_field') ? get_field('onego_cta_title') : '';
		$cta_text   = function_exists('get_field') ? get_field('onego_cta_text') : '';
		$cta_bg     = function_exists('get_field') ? get_field('onego_cta_bg') : '';
		$cta_bg_url = $onego_image_url($cta_bg, 'large');

		if ($cta_title || $cta_text || $cta_bg_url || (function_exists('have_rows') && have_rows('onego_cta_links'))) :
		?>
			<section class="brand-cta onego-cta">
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

						<?php if (function_exists('have_rows') && have_rows('onego_cta_links')) : ?>
							<div class="brand-cta__links">
								<?php
								while (have_rows('onego_cta_links')) :
									the_row();

									$icon     = get_sub_field('icon');
									$icon_url = $onego_image_url($icon, 'thumbnail');
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
