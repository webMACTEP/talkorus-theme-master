<?php
defined('ABSPATH') || exit;

global $product;

if (! $product || ! $product->is_visible()) {
    return;
}

$variation_prices = array();

if ($product->is_type('variable')) {
    foreach ($product->get_available_variations() as $variation) {
        $variation_product = wc_get_product($variation['variation_id']);
        $variation_price_html = $variation['price_html'];

        if (function_exists('talkorus_product_has_empty_price') && talkorus_product_has_empty_price($variation_product)) {
            $variation_price_html = talkorus_price_on_request('');
        } elseif (empty($variation_price_html) && isset($variation['display_price'])) {
            $variation_price_html = wc_price($variation['display_price']);
        }

        $variation_prices[] = array(
            'variation_id' => $variation['variation_id'],
            'attributes'   => $variation['attributes'],
            'price_html'   => $variation_price_html,
        );
    }
}
?>

<li <?php wc_product_class('catalog-card', $product); ?>>

    <div
        class="catalog-card__inner"
        data-default-price="<?php echo esc_attr($product->get_price_html()); ?>"
        data-variation-prices="<?php echo esc_attr(wp_json_encode($variation_prices)); ?>">

        <a class="catalog-card__link" href="<?php the_permalink(); ?>">

            <div class="catalog-card__image">
                <?php echo $product->get_image('woocommerce_thumbnail'); ?>
            </div>

            <h2 class="catalog-card__title">
                <?php the_title(); ?>
            </h2>

        </a>

        <?php if (function_exists('wvs_pro_archive_variation_template')) : ?>
            <div class="catalog-card__variations">
                <?php wvs_pro_archive_variation_template(); ?>
            </div>
        <?php endif; ?>

        <div class="catalog-card-footer">
            <div class="catalog-card__price">
                <?php echo $product->get_price_html(); ?>
            </div>

            <div class="catalog-card__button">
                <?php woocommerce_template_loop_add_to_cart(); ?>
            </div>
        </div>

    </div>

</li>
