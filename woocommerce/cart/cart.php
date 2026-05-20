<?php

/**
 * Cart Page
 *
 * Override: yourtheme/woocommerce/cart/cart.php
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');
?>

<section class="cart-page">

	<div class="catalog-breadcrumbs">
		<?php woocommerce_breadcrumb(); ?>
	</div>

	<h1 class="cart-page__title">Корзина</h1>

	<form class="woocommerce-cart-form cart-custom" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

		<?php do_action('woocommerce_before_cart_table'); ?>

		<div class="cart-custom__list">

			<?php do_action('woocommerce_before_cart_contents'); ?>

			<?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
				<?php
				$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
				$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

				if (!$_product || !$_product->exists() || $cart_item['quantity'] <= 0 || !apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
					continue;
				}

				$product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
				$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
				$product_sku       = $_product->get_sku();
				$thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail'), $cart_item, $cart_item_key);
				$item_data_html    = wc_get_formatted_cart_item_data($cart_item);
				?>

				<div class="cart-custom-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

					<div class="cart-custom-item__image">
						<?php if ($product_permalink) : ?>
							<a href="<?php echo esc_url($product_permalink); ?>">
								<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
								?>
							</a>
						<?php else : ?>
							<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
							?>
						<?php endif; ?>
					</div>

					<div class="cart-custom-item__content">

						<div class="cart-custom-item__head">
							<div>Товар</div>
							<div>Цена</div>
							<div>Количество</div>
							<div>Всего</div>
							<div></div>
						</div>

						<div class="cart-custom-item__main">

							<div class="cart-custom-item__product">
								<?php if ($product_permalink) : ?>
									<a class="cart-custom-item__title" href="<?php echo esc_url($product_permalink); ?>">
										<?php echo esc_html($product_name); ?>
									</a>
								<?php else : ?>
									<div class="cart-custom-item__title">
										<?php echo esc_html($product_name); ?>
									</div>
								<?php endif; ?>

								<?php if ($product_sku) : ?>
									<div class="cart-custom-item__sku">
										Артикул <?php echo esc_html($product_sku); ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="cart-custom-item__price">
								<?php
								echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</div>

							<div class="cart-custom-item__quantity">
								<?php
								if ($_product->is_sold_individually()) {
									$min_quantity = 1;
									$max_quantity = 1;
								} else {
									$min_quantity = 0;
									$max_quantity = $_product->get_max_purchase_quantity();
								}

								$product_quantity = woocommerce_quantity_input(
									array(
										'input_name'   => "cart[{$cart_item_key}][qty]",
										'input_value'  => $cart_item['quantity'],
										'max_value'    => $max_quantity,
										'min_value'    => $min_quantity,
										'product_name' => $product_name,
									),
									$_product,
									false
								);

								echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</div>

							<div class="cart-custom-item__subtotal">
								<?php
								echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</div>

							<div class="cart-custom-item__remove">
								<?php
								echo apply_filters(
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a role="button" href="%s" class="remove cart-custom-item__remove-link" aria-label="%s" data-product_id="%s" data-product_sku="%s">Удалить товар</a>',
										esc_url(wc_get_cart_remove_url($cart_item_key)),
										esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
										esc_attr($product_id),
										esc_attr($_product->get_sku())
									),
									$cart_item_key
								); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</div>

						</div>

						<?php if ($item_data_html) : ?>
							<div class="cart-custom-item__config">
								<div class="cart-custom-item__config-title">
									Конфигурация
								</div>

								<div class="cart-custom-item__meta">
									<?php
									$cart_item_data = wc_get_formatted_cart_item_data($cart_item, true);

									if (!empty($cart_item['variation'])) :
										foreach ($cart_item['variation'] as $attribute_key => $attribute_value) :
											if (empty($attribute_value)) {
												continue;
											}

											$taxonomy = str_replace('attribute_', '', $attribute_key);
											$label = wc_attribute_label($taxonomy);

											if (taxonomy_exists($taxonomy)) {
												$term = get_term_by('slug', $attribute_value, $taxonomy);
												$value = $term && !is_wp_error($term) ? $term->name : $attribute_value;
											} else {
												$value = $attribute_value;
											}
									?>

											<div class="cart-custom-item__config-row">
												<div class="cart-custom-item__config-name">
													<?php echo esc_html($label); ?>:
												</div>

												<div class="cart-custom-item__config-line"></div>

												<div class="cart-custom-item__config-value">
													<?php echo esc_html($value); ?>
												</div>

												<?php if ($product_permalink) : ?>
													<a class="cart-custom-item__config-edit" href="<?php echo esc_url($product_permalink); ?>">
														Редактировать
													</a>
												<?php endif; ?>
											</div>

										<?php endforeach; ?>
									<?php else : ?>
										<?php echo $item_data_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
										?>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

					</div>

				</div>

			<?php endforeach; ?>

			<?php do_action('woocommerce_cart_contents'); ?>
			<?php do_action('woocommerce_after_cart_contents'); ?>

		</div>

		<div class="cart-custom__actions">
			<?php if (wc_coupons_enabled()) : ?>
				<div class="coupon cart-custom__coupon">
					<label for="coupon_code" class="screen-reader-text">
						<?php esc_html_e('Coupon:', 'woocommerce'); ?>
					</label>

					<input
						type="text"
						name="coupon_code"
						class="input-text"
						id="coupon_code"
						value=""
						placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />

					<button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>">
						<?php esc_html_e('Apply coupon', 'woocommerce'); ?>
					</button>

					<?php do_action('woocommerce_cart_coupon'); ?>
				</div>
			<?php endif; ?>

			<button type="submit" class="button cart-custom__update" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">
				<?php esc_html_e('Update cart', 'woocommerce'); ?>
			</button>

			<?php do_action('woocommerce_cart_actions'); ?>
			<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
		</div>

		<?php do_action('woocommerce_after_cart_table'); ?>

	</form>

	<div class="cart-custom-summary">
		<div class="cart-custom-summary__total">
			<span>Итого:</span>
			<strong><?php echo wp_kses_post(WC()->cart->get_cart_total()); ?></strong>
		</div>

		<div class="cart-custom-summary__count">
			<?php
			$cart_count = WC()->cart->get_cart_contents_count();

			if ($cart_count % 10 === 1 && $cart_count % 100 !== 11) {
				$word = 'товар';
			} elseif (
				in_array($cart_count % 10, array(2, 3, 4), true)
				&& ! in_array($cart_count % 100, array(12, 13, 14), true)
			) {
				$word = 'товара';
			} else {
				$word = 'товаров';
			}

			echo esc_html($cart_count . ' ' . $word);
			?>
		</div>

		<a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="cart-custom-summary__checkout">
			Оформить заказ
		</a>
	</div>

</section>

<?php do_action('woocommerce_after_cart'); ?>