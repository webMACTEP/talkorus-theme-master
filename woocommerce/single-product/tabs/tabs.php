<?php

/**
 * Single Product tabs
 */

defined('ABSPATH') || exit;

$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($product_tabs)) : ?>

	<div class="product-tabs woocommerce-tabs wc-tabs-wrapper">

		<div class="product-tabs__nav-wrap">
			<ul class="product-tabs__nav tabs wc-tabs" role="tablist">
				<?php $tab_index = 0; ?>

				<?php foreach ($product_tabs as $key => $product_tab) : ?>
					<?php
					$is_active = $tab_index === 0 ? ' active' : '';
					?>

					<li
						role="presentation"
						class="product-tabs__nav-item <?php echo esc_attr($key); ?>_tab<?php echo esc_attr($is_active); ?>"
						id="tab-title-<?php echo esc_attr($key); ?>">
						<a
							class="product-tabs__nav-link"
							href="#tab-<?php echo esc_attr($key); ?>"
							role="tab"
							aria-controls="tab-<?php echo esc_attr($key); ?>">
							<?php echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key)); ?>
						</a>
					</li>

					<?php $tab_index++; ?>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="product-tabs__content">
			<?php $panel_index = 0; ?>

			<?php foreach ($product_tabs as $key => $product_tab) : ?>
				<?php
				$is_active = $panel_index === 0 ? ' active' : '';
				?>

				<div
					class="product-tabs__panel woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab<?php echo esc_attr($is_active); ?>"
					id="tab-<?php echo esc_attr($key); ?>"
					role="tabpanel"
					aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
					<?php
					if (isset($product_tab['callback'])) {
						call_user_func($product_tab['callback'], $key, $product_tab);
					}
					?>
				</div>

				<?php $panel_index++; ?>
			<?php endforeach; ?>
		</div>

		<?php do_action('woocommerce_product_after_tabs'); ?>

	</div>

<?php endif; ?>