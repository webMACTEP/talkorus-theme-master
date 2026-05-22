<?php

/**
 * Custom single product content
 */

defined('ABSPATH') || exit;

global $product;

do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form();
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('single-product-custom', $product); ?>>

	<h1 class="single-product-custom__title">
		<?php the_title(); ?>
	</h1>

	<div class="single-product-custom__top">

		<div class="single-product-custom__gallery">
			<?php
			/**
			 * Галерея товара.
			 * Выводит основное изображение и миниатюры.
			 */
			woocommerce_show_product_images();
			?>

			<?php if (function_exists('have_rows') && have_rows('talkorus_product_features', get_the_ID())) : ?>
				<div class="single-product-custom__features">
					<?php while (have_rows('talkorus_product_features', get_the_ID())) : the_row(); ?>
						<?php
						$icon  = get_sub_field('icon');
						$title = get_sub_field('title');
						?>

						<?php if (!empty($icon) || !empty($title)) : ?>
							<div class="single-product-feature">
								<?php if (!empty($icon)) : ?>
									<span class="single-product-feature__icon">
										<img
											src="<?php echo esc_url($icon['url']); ?>"
											alt="<?php echo esc_attr($icon['alt'] ?: $title); ?>"
											loading="lazy">
									</span>
								<?php endif; ?>

								<?php if (!empty($title)) : ?>
									<span class="single-product-feature__title">
										<?php echo esc_html($title); ?>
									</span>
								<?php endif; ?>
							</div>
						<?php endif; ?>

					<?php endwhile; ?>
				</div>
			<?php endif; ?>


		</div>

		<div class="single-product-custom__summary">

			<div class="single-product-custom__variations">
				<?php
				/**
				 * Форма вариаций / кнопка добавления в корзину.
				 * Для variable товара здесь WooCommerce Variation Swatches
				 * должен вывести свои кнопки/свотчи.
				 */
				woocommerce_template_single_add_to_cart();
				?>
			</div>

			<div class="single-product-custom__chars">
				<h3 class="single-product-custom__block-title">
					Характеристики
				</h3>

				<?php
				$attributes = $product->get_attributes();

				if (!empty($attributes)) :
				?>
					<div class="single-product-chars">
						<?php foreach ($attributes as $attribute) : ?>
							<?php
							if (!$attribute->get_visible()) {
								continue;
							}

							$name = wc_attribute_label($attribute->get_name());

							if ($attribute->is_taxonomy()) {
								$values = wc_get_product_terms(
									$product->get_id(),
									$attribute->get_name(),
									array('fields' => 'names')
								);
								$value = implode(', ', $values);
							} else {
								$value = implode(', ', $attribute->get_options());
							}
							?>

							<div class="single-product-chars__row">
								<span class="single-product-chars__name">
									<?php echo esc_html($name); ?>:
								</span>

								<span class="single-product-chars__line"></span>

								<span class="single-product-chars__value">
									<?php echo esc_html($value); ?>
								</span>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<a class="single-product-custom__all-chars" href="#product-tabs">
					Все характеристики
				</a>
			</div>

			

		</div>

	</div>

	<div class="section-divider">
		<span class="line"></span>

		<div class="section-divider__icon">
			<img src="<?php echo esc_url(get_template_directory_uri() . '/img/divider-icon.svg'); ?>" alt="">
		</div>

		<span class="line"></span>
	</div>

	<div id="product-tabs" class="single-product-custom__tabs">
		<?php woocommerce_output_product_data_tabs(); ?>
	</div>

</div>

<?php do_action('woocommerce_after_single_product'); ?>