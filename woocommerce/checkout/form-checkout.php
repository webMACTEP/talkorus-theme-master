<?php

/**
 * Checkout Form
 *
 * Override: yourtheme/woocommerce/checkout/form-checkout.php
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

if (
	! $checkout->is_registration_enabled()
	&& $checkout->is_registration_required()
	&& ! is_user_logged_in()
) {
	echo esc_html(apply_filters(
		'woocommerce_checkout_must_be_logged_in_message',
		__('You must be logged in to checkout.', 'woocommerce')
	));
	return;
}

/**
 * Убираем стандартную таблицу order review.
 * Оставляем только блок payment + кнопку оформления.
 */
remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
?>

<section class="checkout-page">

	<div class="catalog-breadcrumbs">
		<?php woocommerce_breadcrumb(); ?>
	</div>

	<h1 class="checkout-page__title">Оформление заказа</h1>

	<form
		name="checkout"
		method="post"
		class="checkout woocommerce-checkout checkout-custom"
		action="<?php echo esc_url(wc_get_checkout_url()); ?>"
		enctype="multipart/form-data"
		aria-label="<?php echo esc_attr__('Checkout', 'woocommerce'); ?>">

		<section class="checkout-order">
			<h2 class="checkout-section-title">Состав заказа</h2>

			<div class="checkout-order__items">
				<?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
					<?php
					$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

					if (
						! $_product
						|| ! $_product->exists()
						|| $cart_item['quantity'] <= 0
						|| ! apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)
					) {
						continue;
					}

					$product_name      = $_product->get_name();
					$product_permalink = $_product->is_visible() ? $_product->get_permalink($cart_item) : '';
					$product_sku       = $_product->get_sku();
					$thumbnail         = $_product->get_image('woocommerce_thumbnail');
					$subtotal          = WC()->cart->get_product_subtotal($_product, $cart_item['quantity']);
					?>

					<div class="checkout-order-card">
						<div class="checkout-order-card__image">
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

						<div class="checkout-order-card__content">
							<?php if ($product_permalink) : ?>
								<a class="checkout-order-card__title" href="<?php echo esc_url($product_permalink); ?>">
									<?php echo esc_html($product_name); ?>
								</a>
							<?php else : ?>
								<div class="checkout-order-card__title">
									<?php echo esc_html($product_name); ?>
								</div>
							<?php endif; ?>

							<?php if ($product_sku) : ?>
								<div class="checkout-order-card__sku">
									Артикул <?php echo esc_html($product_sku); ?>
								</div>
							<?php endif; ?>

							<div class="checkout-order-card__total">
								<span>Всего:</span>
								<strong><?php echo wp_kses_post($subtotal); ?></strong>
							</div>
						</div>
					</div>

				<?php endforeach; ?>
			</div>
		</section>

		<?php if ($checkout->get_checkout_fields()) : ?>

			<?php do_action('woocommerce_checkout_before_customer_details'); ?>

			<section class="checkout-personal" id="customer_details">
				<h2 class="checkout-section-title">Персональные данные</h2>

				<div class="checkout-personal__fields">
					<?php do_action('woocommerce_checkout_billing'); ?>
				</div>

				<div class="checkout-personal__comments">
					<?php do_action('woocommerce_checkout_shipping'); ?>
				</div>
			</section>

			<?php do_action('woocommerce_checkout_after_customer_details'); ?>

		<?php endif; ?>

		<section class="checkout-bottom">
			<div class="checkout-bottom__summary">
				<div class="checkout-bottom__total">
					<span>Итого:</span>
					<strong><?php echo wp_kses_post(WC()->cart->get_cart_total()); ?></strong>
				</div>

				<div class="checkout-bottom__count">
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
			</div>

			<div id="order_review" class="woocommerce-checkout-review-order checkout-payment">
				<?php do_action('woocommerce_checkout_order_review'); ?>
			</div>
		</section>

	</form>
</section>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>