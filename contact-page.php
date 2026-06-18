<?php
/*
* Template name: Contact Page
 */


get_header();
$sp_obj = new SpClass();

while (have_posts()) : the_post(); ?>

	<div class="page contacts-page">
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


		<!-- Contacts -->

		<?php if (have_rows('kontakty')) : ?>
			<div class="container">
				<div class="contacts-list">
					<?php while (have_rows('kontakty')) : the_row();

						$title = get_sub_field('title');
						$icon  = get_sub_field('icon');
						$info  = get_sub_field('info');
					?>
						<div class="contacts-list__item">
							<div class="icon">
								<?php if ($icon) : ?>
									<div class="contacts-list__icon">
										<img src="<?php echo esc_url($icon['url']); ?>"
											alt="<?php echo esc_attr($icon['alt']); ?>">
									</div>
								<?php endif; ?>

							</div>

							<div class="info">
								<?php if ($title) : ?>
									<h3 class="contacts-list__title">
										<?php echo esc_html($title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($info) : ?>
									<div class="contacts-list__info">
										<?php echo wp_kses_post($info); ?>
									</div>
								<?php endif; ?>

							</div>


						</div>
					<?php endwhile; ?>
					<div class="messgrs">
						<a href="https://t.me/Talkorus" target="_blank">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width="56"
								height="56"
								viewBox="0 0 56 56"
								fill="none">
								<g clip-path="url(#clip0_75_52)">
									<path
										d="M28 56C43.464 56 56 43.464 56 28C56 12.536 43.464 0 28 0C12.536 0 0 12.536 0 28C0 43.464 12.536 56 28 56Z"
										fill="#039BE5" />
									<path
										d="M12.812 27.3933L39.8086 16.9843C41.0616 16.5317 42.156 17.29 41.75 19.1847L41.7523 19.1823L37.1556 40.838C36.815 42.3733 35.9026 42.7467 34.6263 42.0233L27.6263 36.8643L24.25 40.117C23.8766 40.4903 23.5616 40.8053 22.8383 40.8053L23.3353 33.6817L36.3086 21.9613C36.8733 21.4643 36.1826 21.1843 35.4383 21.679L19.406 31.773L12.4946 29.617C10.9943 29.141 10.9616 28.1167 12.812 27.3933Z"
										fill="white" />
								</g>
								<defs>
									<clipPath id="clip0_75_52">
										<rect width="56" height="56" fill="white" />
									</clipPath>
								</defs>
							</svg>
						</a>
						<a href="https://max.ru/u/f9LHodD0cOKmq1A0bbbV8BdjhVZ2m6-GAmIIXFXP8yaKcKjgWt3TDQ5xfGI" target="_blank">
							<img src="<?php echo get_template_directory_uri(); ?>/img/Max_logo_2025.png" alt="" />
						</a>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<!-- map -->

		<?php
		$karta = get_field('karta');

		if ($karta) :
		?>
			<div class="container">

				<div class="contacts-map">
					<?php echo $karta; ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- аккордеон -->

		<?php
		$rekvizity = get_field('rekvizity');
		$ohrana    = get_field('ohrana_truda_soutik');

		if ($rekvizity || $ohrana) :
		?>
			<section class="site-section about-info ">
				<div class="container">


					<div class="about-info__accordion">

						<?php if ($rekvizity) : ?>
							<div class="about-info__item">
								<button class="about-info__head" type="button">
									<span class="about-info__icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M12 16.5C11.8082 16.5 11.6162 16.4267 11.4698 16.2803L3.9698 8.7803C3.67674 8.48723 3.67674 8.01267 3.9698 7.7198C4.26286 7.42692 4.73743 7.42673 5.0303 7.7198L12 14.6895L18.9698 7.7198C19.2629 7.42674 19.7374 7.42674 20.0303 7.7198C20.3232 8.01286 20.3234 8.48742 20.0303 8.7803L12.5303 16.2803C12.3839 16.4267 12.1919 16.5 12 16.5Z" fill="black" />
										</svg>
									</span>

									<span class="about-info__title">
										Реквизиты
									</span>
								</button>

								<div class="about-info__body">
									<div class="about-info__content">
										<?php echo wp_kses_post($rekvizity); ?>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ($ohrana) : ?>
							<div class="about-info__item">
								<button class="about-info__head" type="button">
									<span class="about-info__icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M12 16.5C11.8082 16.5 11.6162 16.4267 11.4698 16.2803L3.9698 8.7803C3.67674 8.48723 3.67674 8.01267 3.9698 7.7198C4.26286 7.42692 4.73743 7.42673 5.0303 7.7198L12 14.6895L18.9698 7.7198C19.2629 7.42674 19.7374 7.42674 20.0303 7.7198C20.3232 8.01286 20.3234 8.48742 20.0303 8.7803L12.5303 16.2803C12.3839 16.4267 12.1919 16.5 12 16.5Z" fill="black" />
										</svg>
									</span>

									<span class="about-info__title">
										Охрана труда СОУТ/ИК
									</span>
								</button>

								<div class="about-info__body">
									<div class="about-info__content">
										<?php echo wp_kses_post($ohrana); ?>
									</div>
								</div>
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
