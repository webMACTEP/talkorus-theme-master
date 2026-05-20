<?php
/*
 * sp functions and definitions
 */

if (! function_exists('sp_setup')) :

	function sp_setup()
	{

		load_theme_textdomain('sp-theme', get_template_directory() . '/languages');

		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');


		register_nav_menus(array(
			'menu-1' => esc_html__('Primary', 'sp-theme'),
		));

		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));


		add_theme_support('custom-background', apply_filters('sp_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)));

		add_theme_support('customize-selective-refresh-widgets');

		add_theme_support('custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		));
	}
endif;

add_action('after_setup_theme', 'sp_setup');


function sp_content_width()
{
	$GLOBALS['content_width'] = apply_filters('sp_content_width', 640);
}
add_action('after_setup_theme', 'sp_content_width', 0);

//Register widget area.
function sp_widgets_init()
{
	register_sidebar(array(
		'name'          => esc_html__('Sidebar', 'sp-theme'),
		'id'            => 'sidebar-1',
		'description'   => esc_html__('Add widgets here.', 'sp-theme'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
}
add_action('widgets_init', 'sp_widgets_init');

//Enqueue scripts and styles.
function sp_scripts()
{
	wp_enqueue_style('cms-style', get_stylesheet_uri());
	wp_enqueue_style('styles', get_template_directory_uri() . '/css/style.css');
	wp_enqueue_style('desktop', get_template_directory_uri() . '/css/desktop.css');
	wp_enqueue_style('tablet', get_template_directory_uri() . '/css/tablet.css');
	wp_enqueue_style('mobile', get_template_directory_uri() . '/css/mobile.css');
	wp_enqueue_style('swiper-style', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');

	wp_enqueue_script('jquery');
	wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);
	wp_enqueue_script(
		'script',
		get_template_directory_uri() . '/js/main.js',
		array('jquery', 'swiper'),
		null,
		true
	);

	wp_localize_script(
		'script',
		'talkorusCartVariation',
		array(
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'nonce'   => wp_create_nonce('talkorus_cart_variation_nonce'),
		)
	);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'sp_scripts');

//Include the TGM_Plugin_Activation class.
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';

//Implement the Custom Header feature.
require get_template_directory() . '/inc/custom-header.php';

//Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/sp-class.php';

//Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

//Customizer additions.
require get_template_directory() . '/inc/customizer.php';




/////////////////////////////////////////////////////////// dev




add_action('after_setup_theme', 'talkorus_add_woocommerce_support');

function talkorus_add_woocommerce_support()
{
	add_theme_support('woocommerce');

	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}

function talkorus_recently_viewed_products($limit = 5)
{
	if (empty($_COOKIE['woocommerce_recently_viewed'])) {
		return;
	}

	$limit = absint($limit);

	if (!$limit) {
		$limit = 5;
	}

	$viewed_products = explode('|', wp_unslash($_COOKIE['woocommerce_recently_viewed']));
	$viewed_products = array_map('absint', $viewed_products);
	$viewed_products = array_filter($viewed_products);
	$viewed_products = array_unique($viewed_products);

	if (empty($viewed_products)) {
		return;
	}

	// Берем не 5, а больше, чтобы после фильтрации скрытых/удаленных товаров осталось 5
	$query_ids = array_slice($viewed_products, 0, 30);

	$visibility_terms = wc_get_product_visibility_term_ids();

	$tax_query = array();

	if (!empty($visibility_terms['exclude-from-catalog'])) {
		$tax_query[] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'term_taxonomy_id',
			'terms'    => array($visibility_terms['exclude-from-catalog']),
			'operator' => 'NOT IN',
		);
	}

	$args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'posts_per_page'      => count($query_ids),
		'post__in'            => $query_ids,
		'orderby'             => 'post__in',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if (!empty($tax_query)) {
		$args['tax_query'] = $tax_query;
	}

	$recently_viewed_query = new WP_Query($args);

	if (!$recently_viewed_query->have_posts()) {
		wp_reset_postdata();
		return;
	}
?>

	<section class="recently-viewed">
		<div class="container">

			<div class="section-divider">
				<span class="line"></span>

				<div class="section-divider__icon">
					<img src="<?php echo esc_url(get_template_directory_uri() . '/img/divider-icon.svg'); ?>" alt="" />
				</div>

				<span class="line"></span>
			</div>

			<h2 class="recently-viewed__title">
				Вы смотрели
			</h2>

			<ul class="recently-viewed__products">
				<?php
				$counter = 0;

				while ($recently_viewed_query->have_posts()) :
					$recently_viewed_query->the_post();

					if ($counter >= $limit) {
						break;
					}

					wc_get_template_part('content', 'product');

					$counter++;
				endwhile;
				?>
			</ul>

		</div>
	</section>

<?php
	wp_reset_postdata();
}

add_filter('woocommerce_product_add_to_cart_text', 'talkorus_change_add_to_cart_text', 10, 2);

function talkorus_change_add_to_cart_text($text, $product)
{
	return 'Заказать';
}


add_filter('woocommerce_variable_price_html', 'talkorus_variable_price_from_min', 10, 2);

function talkorus_variable_price_from_min($price, $product)
{
	if (! $product || ! $product->is_type('variable')) {
		return $price;
	}

	$min_price = $product->get_variation_price('min', true);

	if ($min_price === '') {
		return $price;
	}

	return '<span class="price-from">от</span> ' . wc_price($min_price);
}

add_filter('woocommerce_breadcrumb_defaults', 'talkorus_breadcrumb_defaults');

function talkorus_breadcrumb_defaults($defaults)
{
	$defaults['delimiter']   = '<span class="breadcrumb-separator"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11" fill="none">
  <path d="M7.56252 5.50001C7.56252 5.58792 7.52892 5.67592 7.4618 5.74304L4.0243 9.18054C3.88998 9.31486 3.67248 9.31486 3.53824 9.18054C3.40401 9.04622 3.40392 8.82871 3.53824 8.69448L6.73271 5.50001L3.53824 2.30554C3.40392 2.17122 3.40392 1.95371 3.53824 1.81948C3.67256 1.68524 3.89007 1.68516 4.0243 1.81948L7.4618 5.25698C7.52892 5.3241 7.56252 5.4121 7.56252 5.50001Z" fill="#54595F"/>
</svg></span>';
	$defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb" aria-label="Breadcrumb">';
	$defaults['wrap_after']  = '</nav>';
	$defaults['before']      = '';
	$defaults['after']       = '';
	$defaults['home']        = 'Главная';

	return $defaults;
}

add_action('wp', 'talkorus_remove_single_product_breadcrumbs');

function talkorus_remove_single_product_breadcrumbs()
{
	if (is_product()) {
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
	}
}


add_action('template_redirect', 'talkorus_track_product_view', 20);

function talkorus_track_product_view()
{
	if (!is_singular('product')) {
		return;
	}

	global $post;

	if (empty($post->ID)) {
		return;
	}

	$product_id = absint($post->ID);

	if (!$product_id) {
		return;
	}

	$viewed_products = array();

	if (!empty($_COOKIE['woocommerce_recently_viewed'])) {
		$viewed_products = explode('|', wp_unslash($_COOKIE['woocommerce_recently_viewed']));
		$viewed_products = array_map('absint', $viewed_products);
		$viewed_products = array_filter($viewed_products);
	}

	// Убираем текущий товар из старого места, чтобы не было дублей
	$viewed_products = array_diff($viewed_products, array($product_id));

	// Новый просмотр ставим в начало списка
	array_unshift($viewed_products, $product_id);

	// Храним больше 5, чтобы если часть товаров скрыта/удалена, блок всё равно мог набрать 5
	$viewed_products = array_slice($viewed_products, 0, 30);

	$cookie_value = implode('|', $viewed_products);

	wc_setcookie('woocommerce_recently_viewed', $cookie_value);

	// Важно: обновляем $_COOKIE в текущем запросе
	$_COOKIE['woocommerce_recently_viewed'] = $cookie_value;
}

add_filter('woocommerce_empty_price_html', 'talkorus_price_on_request');
add_filter('woocommerce_variable_empty_price_html', 'talkorus_price_on_request');
add_filter('woocommerce_variation_empty_price_html', 'talkorus_price_on_request');

function talkorus_price_on_request($price)
{
	return '<span class="price-on-request">Цена по запросу</span>';
}

function talkorus_product_subcategories_dropdown($parent_slug)
{
	if (empty($parent_slug)) {
		return;
	}

	$parent_term = get_term_by('slug', $parent_slug, 'product_cat');

	if (!$parent_term || is_wp_error($parent_term)) {
		return;
	}

	$subcategories = get_terms(array(
		'taxonomy'   => 'product_cat',
		'parent'     => $parent_term->term_id,
		'hide_empty' => false,
		'orderby'    => 'menu_order',
		'order'      => 'ASC',
	));

	if (empty($subcategories) || is_wp_error($subcategories)) {
		return;
	}

	echo '<ul class="main-menu-subcategories">';

	foreach ($subcategories as $subcategory) {
		$subcategory_link = get_term_link($subcategory);

		if (is_wp_error($subcategory_link)) {
			continue;
		}

		echo '<li class="main-menu-subcategories__item">';
		echo '<a class="main-menu-subcategories__link" href="' . esc_url($subcategory_link) . '">';
		echo esc_html($subcategory->name);
		echo '</a>';
		echo '</li>';
	}

	echo '</ul>';
}

//корзина

add_filter('woocommerce_add_to_cart_fragments', 'talkorus_update_floating_cart_fragment');

function talkorus_update_floating_cart_fragment($fragments)
{
	if (is_cart() || ! function_exists('WC') || ! WC()->cart) {
		return $fragments;
	}

	$cart_count = WC()->cart->get_cart_contents_count();

	ob_start();
?>
	<a
		href="<?php echo esc_url(wc_get_cart_url()); ?>"
		class="floating-cart <?php echo $cart_count > 0 ? 'is-visible' : ''; ?>"
		aria-label="Перейти в корзину">
		<span class="floating-cart__icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M7.2 19.2C6.5373 19.2 6 19.7373 6 20.4C6 21.0627 6.5373 21.6 7.2 21.6C7.8627 21.6 8.4 21.0627 8.4 20.4C8.4 19.7373 7.8627 19.2 7.2 19.2Z" fill="currentColor" />
				<path d="M18 19.2C17.3373 19.2 16.8 19.7373 16.8 20.4C16.8 21.0627 17.3373 21.6 18 21.6C18.6627 21.6 19.2 21.0627 19.2 20.4C19.2 19.7373 18.6627 19.2 18 19.2Z" fill="currentColor" />
				<path d="M3 3.6H5.082L6.81 15.192C6.9348 16.0308 7.6554 16.65 8.5032 16.65H18.2556C19.0614 16.65 19.7586 16.0872 19.929 15.3L21.186 9.492C21.399 8.508 20.649 7.575 19.6422 7.575H7.302L6.915 4.977C6.795 4.1706 6.1026 3.6 5.2872 3.6H3C2.6688 3.6 2.4 3.8688 2.4 4.2C2.4 4.5312 2.6688 4.8 3 4.8ZM7.482 8.775H19.6422C19.884 8.775 20.064 8.9994 20.0124 9.2358L18.7554 15.0438C18.7044 15.2796 18.4956 15.45 18.2556 15.45H8.5032C8.2506 15.45 8.0358 15.2652 7.9992 15.0156L7.482 8.775Z" fill="currentColor" />
			</svg>
		</span>

		<span class="floating-cart__count">
			<?php echo esc_html($cart_count); ?>
		</span>
	</a>
<?php

	$fragments['a.floating-cart'] = ob_get_clean();

	return $fragments;
}

add_filter('woocommerce_coupons_enabled', 'talkorus_disable_coupons_on_checkout');

function talkorus_disable_coupons_on_checkout($enabled)
{
	if (is_checkout()) {
		return false;
	}

	return $enabled;
}
add_filter('woocommerce_checkout_fields', 'talkorus_checkout_fields');

function talkorus_checkout_fields($fields)
{
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_country']);
	unset($fields['billing']['billing_state']);
	unset($fields['billing']['billing_city']);
	unset($fields['billing']['billing_postcode']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_last_name']);

	$fields['billing']['billing_first_name']['label'] = '';
	$fields['billing']['billing_first_name']['placeholder'] = 'ФИО';
	$fields['billing']['billing_first_name']['class'] = array('form-row-first', 'checkout-field-name');
	$fields['billing']['billing_first_name']['priority'] = 10;
	$fields['billing']['billing_first_name']['required'] = true;

	$fields['billing']['billing_phone']['label'] = '';
	$fields['billing']['billing_phone']['placeholder'] = 'Номер телефона';
	$fields['billing']['billing_phone']['class'] = array('form-row-middle', 'checkout-field-phone');
	$fields['billing']['billing_phone']['priority'] = 20;
	$fields['billing']['billing_phone']['required'] = true;

	$fields['billing']['billing_email']['label'] = '';
	$fields['billing']['billing_email']['placeholder'] = 'E-mail';
	$fields['billing']['billing_email']['class'] = array('form-row-last', 'checkout-field-email');
	$fields['billing']['billing_email']['priority'] = 30;
	$fields['billing']['billing_email']['required'] = true;

	$fields['billing']['billing_address_1']['label'] = '';
	$fields['billing']['billing_address_1']['placeholder'] = 'Ваш адрес';
	$fields['billing']['billing_address_1']['class'] = array('form-row-wide', 'checkout-field-address');
	$fields['billing']['billing_address_1']['priority'] = 40;
	$fields['billing']['billing_address_1']['required'] = true;

	if (isset($fields['order']['order_comments'])) {
		$fields['order']['order_comments']['label'] = 'Комментарий к заказу';
		$fields['order']['order_comments']['placeholder'] = 'Комментарий ( по желанию )';
		$fields['order']['order_comments']['class'] = array('form-row-wide', 'checkout-field-comment');
	}

	return $fields;
}

add_filter('woocommerce_order_button_text', 'talkorus_checkout_button_text');

function talkorus_checkout_button_text()
{
	return 'Оформить заказ';
}

add_action('wp_ajax_talkorus_update_cart_item_variation', 'talkorus_update_cart_item_variation');
add_action('wp_ajax_nopriv_talkorus_update_cart_item_variation', 'talkorus_update_cart_item_variation');

function talkorus_update_cart_item_variation()
{
	check_ajax_referer('talkorus_cart_variation_nonce', 'nonce');

	if (! function_exists('WC') || ! WC()->cart) {
		wp_send_json_error(array(
			'message' => 'Корзина недоступна.',
		));
	}

	$cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field(wp_unslash($_POST['cart_item_key'])) : '';
	$product_id    = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
	$attributes    = isset($_POST['attributes']) && is_array($_POST['attributes']) ? wp_unslash($_POST['attributes']) : array();

	if (! $cart_item_key || ! $product_id || empty($attributes)) {
		wp_send_json_error(array(
			'message' => 'Недостаточно данных.',
		));
	}

	$cart = WC()->cart->get_cart();

	if (empty($cart[$cart_item_key])) {
		wp_send_json_error(array(
			'message' => 'Товар не найден в корзине.',
		));
	}

	$old_cart_item = $cart[$cart_item_key];
	$quantity      = isset($old_cart_item['quantity']) ? absint($old_cart_item['quantity']) : 1;

	$product = wc_get_product($product_id);

	if (! $product || ! $product->is_type('variable')) {
		wp_send_json_error(array(
			'message' => 'Это не вариативный товар.',
		));
	}

	$clean_attributes = array();

	foreach ($attributes as $key => $value) {
		$key   = sanitize_title($key);
		$value = sanitize_text_field($value);

		if ($key && $value) {
			$clean_attributes[$key] = $value;
		}
	}

	if (empty($clean_attributes)) {
		wp_send_json_error(array(
			'message' => 'Не выбраны атрибуты.',
		));
	}

	$data_store   = WC_Data_Store::load('product');
	$variation_id = $data_store->find_matching_product_variation($product, $clean_attributes);

	if (! $variation_id) {
		wp_send_json_error(array(
			'message' => 'Такой вариации нет.',
		));
	}

	$existing_target_key = '';

	foreach (WC()->cart->get_cart() as $key => $item) {
		if ($key === $cart_item_key) {
			continue;
		}

		if (
			absint($item['product_id']) === $product_id
			&& absint($item['variation_id']) === absint($variation_id)
		) {
			$existing_target_key = $key;
			break;
		}
	}

	$cart_item_data = $old_cart_item;

	unset(
		$cart_item_data['key'],
		$cart_item_data['product_id'],
		$cart_item_data['variation_id'],
		$cart_item_data['variation'],
		$cart_item_data['quantity'],
		$cart_item_data['data'],
		$cart_item_data['line_tax_data'],
		$cart_item_data['line_subtotal'],
		$cart_item_data['line_subtotal_tax'],
		$cart_item_data['line_total'],
		$cart_item_data['line_tax']
	);

	WC()->cart->remove_cart_item($cart_item_key);

	$new_cart_item_key = WC()->cart->add_to_cart(
		$product_id,
		$quantity,
		$variation_id,
		$clean_attributes,
		$cart_item_data
	);

	if (! $new_cart_item_key) {
		wp_send_json_error(array(
			'message' => 'Не удалось обновить вариацию.',
		));
	}

	WC()->cart->calculate_totals();
	WC()->cart->set_session();

	$new_cart_item = WC()->cart->get_cart_item($new_cart_item_key);

	if (! $new_cart_item) {
		wp_send_json_success(array(
			'needs_reload' => true,
		));
	}

	$new_product = $new_cart_item['data'];

	$cart_count = WC()->cart->get_cart_contents_count();

	if ($cart_count % 10 === 1 && $cart_count % 100 !== 11) {
		$count_word = 'товар';
	} elseif (
		in_array($cart_count % 10, array(2, 3, 4), true)
		&& ! in_array($cart_count % 100, array(12, 13, 14), true)
	) {
		$count_word = 'товара';
	} else {
		$count_word = 'товаров';
	}

	wp_send_json_success(array(
		'needs_reload'       => ! empty($existing_target_key),
		'new_cart_item_key'  => $new_cart_item_key,
		'price_html'         => WC()->cart->get_product_price($new_product),
		'subtotal_html'      => WC()->cart->get_product_subtotal($new_product, $new_cart_item['quantity']),
		'cart_total_html'    => WC()->cart->get_cart_total(),
		'cart_count_text'    => $cart_count . ' ' . $count_word,
		'remove_url'         => wc_get_cart_remove_url($new_cart_item_key),
	));
}
