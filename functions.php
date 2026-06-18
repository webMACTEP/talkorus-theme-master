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

// Enqueue scripts and styles.
function sp_scripts()
{
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	wp_enqueue_style(
		'cms-style',
		get_stylesheet_uri(),
		array(),
		filemtime(get_stylesheet_directory() . '/style.css')
	);

	wp_enqueue_style(
		'styles',
		$theme_uri . '/css/style.css',
		array(),
		filemtime($theme_dir . '/css/style.css')
	);

	wp_enqueue_style(
		'desktop',
		$theme_uri . '/css/desktop.css',
		array('styles'),
		filemtime($theme_dir . '/css/desktop.css'),
		'(min-width: 1440px)'
	);

	wp_enqueue_style(
		'tablet',
		$theme_uri . '/css/tablet.css',
		array('styles'),
		filemtime($theme_dir . '/css/tablet.css'),
		'(min-width: 744px) and (max-width: 1439px)'
	);

	wp_enqueue_style(
		'mobile',
		$theme_uri . '/css/mobile.css',
		array('styles'),
		filemtime($theme_dir . '/css/mobile.css'),
		'(max-width: 743px)'
	);

	wp_enqueue_style(
		'swiper-style',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
		array(),
		'11.0.0'
	);

	wp_enqueue_script('jquery');

	wp_enqueue_script(
		'swiper',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
		array(),
		'11.0.0',
		true
	);

	wp_enqueue_script(
		'script',
		$theme_uri . '/js/main.js',
		array('jquery', 'swiper'),
		filemtime($theme_dir . '/js/main.js'),
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

function talkorus_product_has_empty_price($product)
{
	if (!is_a($product, 'WC_Product')) {
		return false;
	}

	if ($product->is_type('variable')) {
		$variation_prices = $product->get_variation_prices(false);

		if (empty($variation_prices['price'])) {
			return true;
		}

		foreach ($variation_prices['price'] as $price) {
			if ($price !== '') {
				return false;
			}
		}

		return true;
	}

	return $product->get_price('edit') === '';
}

add_filter('woocommerce_is_purchasable', 'talkorus_allow_empty_price_products_purchase', 10, 2);

function talkorus_allow_empty_price_products_purchase($purchasable, $product)
{
	if ($purchasable || !is_a($product, 'WC_Product')) {
		return $purchasable;
	}

	if ($product->is_type(array('external', 'grouped'))) {
		return $purchasable;
	}

	return talkorus_product_has_empty_price($product) ? true : $purchasable;
}

add_filter('woocommerce_add_cart_item_data', 'talkorus_mark_empty_price_cart_item', 10, 4);

function talkorus_mark_empty_price_cart_item($cart_item_data, $product_id, $variation_id, $quantity)
{
	$product = wc_get_product($variation_id ? $variation_id : $product_id);

	if (talkorus_product_has_empty_price($product)) {
		$cart_item_data['talkorus_price_on_request'] = true;
	} else {
		unset($cart_item_data['talkorus_price_on_request']);
	}

	return $cart_item_data;
}

add_filter('woocommerce_get_cart_item_from_session', 'talkorus_restore_empty_price_cart_item_flag', 10, 2);

function talkorus_restore_empty_price_cart_item_flag($cart_item, $values)
{
	if (!empty($values['talkorus_price_on_request'])) {
		$cart_item['talkorus_price_on_request'] = true;
		return $cart_item;
	}

	if (!empty($cart_item['data']) && talkorus_product_has_empty_price($cart_item['data'])) {
		$cart_item['talkorus_price_on_request'] = true;
	}

	return $cart_item;
}

function talkorus_cart_item_is_price_on_request($cart_item)
{
	if (!empty($cart_item['talkorus_price_on_request'])) {
		return true;
	}

	return !empty($cart_item['data']) && talkorus_product_has_empty_price($cart_item['data']);
}

add_action('woocommerce_before_calculate_totals', 'talkorus_set_empty_price_cart_items_to_zero');

function talkorus_set_empty_price_cart_items_to_zero($cart)
{
	if (is_admin() && !wp_doing_ajax()) {
		return;
	}

	if (!$cart || $cart->is_empty()) {
		return;
	}

	foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
		if (!talkorus_cart_item_is_price_on_request($cart_item) || empty($cart_item['data'])) {
			continue;
		}

		$cart->cart_contents[$cart_item_key]['talkorus_price_on_request'] = true;
		$cart_item['data']->set_price(0);
	}
}

add_filter('woocommerce_cart_item_price', 'talkorus_cart_item_price_on_request_html', 10, 3);
add_filter('woocommerce_cart_item_subtotal', 'talkorus_cart_item_price_on_request_html', 10, 3);

function talkorus_cart_item_price_on_request_html($price_html, $cart_item, $cart_item_key)
{
	if (talkorus_cart_item_is_price_on_request($cart_item)) {
		return talkorus_price_on_request('');
	}

	return $price_html;
}

add_action('woocommerce_checkout_create_order_line_item', 'talkorus_mark_order_item_price_on_request', 10, 4);

function talkorus_mark_order_item_price_on_request($item, $cart_item_key, $values, $order)
{
	if (talkorus_cart_item_is_price_on_request($values)) {
		$item->add_meta_data('_talkorus_price_on_request', 'yes', true);
	}
}

add_filter('woocommerce_order_formatted_line_subtotal', 'talkorus_order_item_price_on_request_html', 10, 3);

function talkorus_order_item_price_on_request_html($subtotal, $item, $order)
{
	if ($item && $item->get_meta('_talkorus_price_on_request') === 'yes') {
		return talkorus_price_on_request('');
	}

	return $subtotal;
}

add_filter('manage_edit-product_columns', 'talkorus_add_product_attributes_admin_column', 30);

function talkorus_add_product_attributes_admin_column($columns)
{
	$new_columns = array();
	$inserted = false;

	foreach ($columns as $column_key => $column_label) {
		$new_columns[$column_key] = $column_label;

		if ('sku' === $column_key) {
			$new_columns['talkorus_product_attributes'] = 'Атрибуты';
			$inserted = true;
		}
	}

	if (!$inserted) {
		$new_columns['talkorus_product_attributes'] = 'Атрибуты';
	}

	return $new_columns;
}

add_action('manage_product_posts_custom_column', 'talkorus_render_product_attributes_admin_column', 10, 2);

function talkorus_render_product_attributes_admin_column($column, $post_id)
{
	if ('talkorus_product_attributes' !== $column || !function_exists('wc_get_product')) {
		return;
	}

	$product = wc_get_product($post_id);

	if (!$product) {
		echo '&mdash;';
		return;
	}

	$attributes = $product->get_attributes();

	if (empty($attributes)) {
		echo '&mdash;';
		return;
	}

	$rows = array();

	foreach ($attributes as $attribute) {
		if (!is_a($attribute, 'WC_Product_Attribute')) {
			continue;
		}

		$label = wc_attribute_label($attribute->get_name(), $product);
		$values = array();

		if ($attribute->is_taxonomy()) {
			$terms = wc_get_product_terms($post_id, $attribute->get_name(), array(
				'fields' => 'names',
			));

			if (!is_wp_error($terms)) {
				$values = $terms;
			}
		} else {
			$values = $attribute->get_options();
		}

		$values = array_filter(array_map('trim', array_map('wp_strip_all_tags', $values)));

		if (empty($label) || empty($values)) {
			continue;
		}

		$rows[] = '<li><strong>' . esc_html($label) . ':</strong> ' . esc_html(implode(', ', $values)) . '</li>';
	}

	if (empty($rows)) {
		echo '&mdash;';
		return;
	}

	echo '<ul class="talkorus-product-attributes-column">' . implode('', $rows) . '</ul>';
}

add_action('restrict_manage_posts', 'talkorus_render_product_attribute_admin_filter', 20, 2);

function talkorus_render_product_attribute_admin_filter($post_type, $which = '')
{
	if ('product' !== $post_type || 'top' !== $which || !function_exists('wc_get_attribute_taxonomies')) {
		return;
	}

	$attribute_taxonomies = wc_get_attribute_taxonomies();

	if (empty($attribute_taxonomies)) {
		return;
	}

	$current_value = isset($_GET['talkorus_product_attribute_filter'])
		? sanitize_text_field(wp_unslash($_GET['talkorus_product_attribute_filter']))
		: '';

	$options = array();

	foreach ($attribute_taxonomies as $attribute_taxonomy) {
		if (empty($attribute_taxonomy->attribute_name)) {
			continue;
		}

		$taxonomy = wc_attribute_taxonomy_name($attribute_taxonomy->attribute_name);

		if (!taxonomy_exists($taxonomy)) {
			continue;
		}

		$terms = get_terms(array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
		));

		if (empty($terms) || is_wp_error($terms)) {
			continue;
		}

		$label = wc_attribute_label($taxonomy);
		$options[$label] = array(
			'taxonomy' => $taxonomy,
			'terms'    => $terms,
		);
	}

	if (empty($options)) {
		return;
	}

	echo '<label class="screen-reader-text" for="talkorus-product-attribute-filter">Фильтр по атрибуту</label>';
	echo '<select name="talkorus_product_attribute_filter" id="talkorus-product-attribute-filter">';
	echo '<option value="">Все атрибуты</option>';

	foreach ($options as $label => $data) {
		echo '<optgroup label="' . esc_attr($label) . '">';

		foreach ($data['terms'] as $term) {
			$value = $data['taxonomy'] . '|' . $term->slug;
			echo '<option value="' . esc_attr($value) . '"' . selected($current_value, $value, false) . '>';
			echo esc_html($term->name);
			echo '</option>';
		}

		echo '</optgroup>';
	}

	echo '</select>';
}

add_action('pre_get_posts', 'talkorus_filter_admin_products_by_attribute');

function talkorus_filter_admin_products_by_attribute($query)
{
	if (!is_admin() || !$query->is_main_query()) {
		return;
	}

	global $pagenow;

	if ('edit.php' !== $pagenow || 'product' !== $query->get('post_type')) {
		return;
	}

	if (empty($_GET['talkorus_product_attribute_filter'])) {
		return;
	}

	$filter_value = sanitize_text_field(wp_unslash($_GET['talkorus_product_attribute_filter']));
	$filter_parts = explode('|', $filter_value, 2);

	if (count($filter_parts) !== 2) {
		return;
	}

	$taxonomy = sanitize_key($filter_parts[0]);
	$term_slug = sanitize_title($filter_parts[1]);

	if (strpos($taxonomy, 'pa_') !== 0 || !taxonomy_exists($taxonomy) || !$term_slug) {
		return;
	}

	$tax_query = $query->get('tax_query');

	if (!is_array($tax_query)) {
		$tax_query = array();
	}

	$tax_query[] = array(
		'taxonomy' => $taxonomy,
		'field'    => 'slug',
		'terms'    => array($term_slug),
	);

	$query->set('tax_query', $tax_query);
}

add_action('admin_head-edit.php', 'talkorus_product_attributes_admin_column_styles');

function talkorus_product_attributes_admin_column_styles()
{
	$screen = function_exists('get_current_screen') ? get_current_screen() : null;

	if (!$screen || 'product' !== $screen->post_type) {
		return;
	}
?>
	<style>
		.fixed .column-talkorus_product_attributes {
			width: 22%;
		}

		.talkorus-product-attributes-column {
			margin: 0;
		}

		.talkorus-product-attributes-column li {
			margin: 0 0 4px;
		}
	</style>
<?php
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

	talkorus_product_subcategories_list($parent_term->term_id);
}

function talkorus_get_product_subcategories($parent_id)
{
	return get_terms(array(
		'taxonomy'   => 'product_cat',
		'parent'     => $parent_id,
		'hide_empty' => false,
		'orderby'    => 'menu_order',
		'order'      => 'ASC',
	));
}

function talkorus_product_subcategories_list($parent_id, $depth = 1)
{
	$subcategories = talkorus_get_product_subcategories($parent_id);

	if (empty($subcategories) || is_wp_error($subcategories)) {
		return false;
	}

	echo '<ul class="main-menu-subcategories main-menu-subcategories--level-' . esc_attr($depth) . '">';

	foreach ($subcategories as $subcategory) {
		$subcategory_link = get_term_link($subcategory);

		if (is_wp_error($subcategory_link)) {
			continue;
		}

		$child_categories = talkorus_get_product_subcategories($subcategory->term_id);
		$has_children = !empty($child_categories) && !is_wp_error($child_categories);
		$item_classes = array('main-menu-subcategories__item');

		if ($has_children) {
			$item_classes[] = 'main-menu__item--has-dropdown';
			$item_classes[] = 'main-menu-subcategories__item--has-children';
		}

		echo '<li class="' . esc_attr(implode(' ', $item_classes)) . '">';
		echo '<a class="main-menu-subcategories__link" href="' . esc_url($subcategory_link) . '">';
		echo esc_html($subcategory->name);
		echo '</a>';

		if ($has_children) {
			talkorus_menu_dropdown_toggle();
			echo '<div class="main-menu__dropdown main-menu__dropdown--nested">';
			talkorus_product_subcategories_list($subcategory->term_id, $depth + 1);
			echo '</div>';
		}

		echo '</li>';
	}

	echo '</ul>';

	return true;
}

function talkorus_menu_dropdown_toggle()
{
	echo '<button class="main-menu__toggle" type="button" aria-expanded="false" aria-label="Показать подкатегории">';
	echo '<svg width="14" height="8" viewBox="0 0 14 8" fill="none" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">';
	echo '<path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
	echo '</svg>';
	echo '</button>';
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
		'price_html'         => apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($new_product), $new_cart_item, $new_cart_item_key),
		'subtotal_html'      => apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($new_product, $new_cart_item['quantity']), $new_cart_item, $new_cart_item_key),
		'cart_total_html'    => WC()->cart->get_cart_total(),
		'cart_count_text'    => $cart_count . ' ' . $count_word,
		'remove_url'         => wc_get_cart_remove_url($new_cart_item_key),
	));
}


//vkladki

add_action('acf/init', 'talkorus_register_product_tabs_acf_fields');

function talkorus_register_product_tabs_acf_fields()
{
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(array(
		'key' => 'group_talkorus_product_tabs',
		'title' => 'Вкладки товара',
		'fields' => array(
			array(
				'key' => 'field_talkorus_tab_description_heading',
				'label' => 'Описание — заголовок',
				'name' => 'talkorus_tab_description_heading',
				'type' => 'text',
				'default_value' => '',
			),
			array(
				'key' => 'field_talkorus_tab_description_content',
				'label' => 'Описание — текст',
				'name' => 'talkorus_tab_description_content',
				'type' => 'wysiwyg',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
			),
			array(
				'key' => 'field_talkorus_tab_technical_heading',
				'label' => 'Технические данные — заголовок',
				'name' => 'talkorus_tab_technical_heading',
				'type' => 'text',
				'default_value' => '',
			),
			array(
				'key' => 'field_talkorus_tab_technical_content',
				'label' => 'Технические данные — текст',
				'name' => 'talkorus_tab_technical_content',
				'type' => 'wysiwyg',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
			),
			array(
				'key' => 'field_talkorus_tab_dimensions_heading',
				'label' => 'Размеры и вес — заголовок',
				'name' => 'talkorus_tab_dimensions_heading',
				'type' => 'text',
				'default_value' => '',
			),
			array(
				'key' => 'field_talkorus_tab_dimensions_content',
				'label' => 'Размеры и вес — текст',
				'name' => 'talkorus_tab_dimensions_content',
				'type' => 'wysiwyg',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
			),

			array(
				'key' => 'field_talkorus_tab_cut_content',
				'label' => 'Печь в разрезе',
				'name' => 'talkorus_tab_cut_content',
				'type' => 'wysiwyg',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
			),
			array(
				'key' => 'field_talkorus_tab_scheme_content',
				'label' => 'Схема работы печи',
				'name' => 'talkorus_tab_scheme_content',
				'type' => 'wysiwyg',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
			),
			array(
				'key' => 'field_talkorus_tab_purpose_content',
				'label' => 'Назначения',
				'name' => 'talkorus_tab_purpose_content',
				'type' => 'wysiwyg',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
			),
			array(
				'key' => 'field_talkorus_tab_advantages_content',
				'label' => 'Преимущества',
				'name' => 'talkorus_tab_advantages_content',
				'type' => 'wysiwyg',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
			),
			array(
				'key' => 'field_talkorus_tab_docs_content',
				'label' => 'Документация',
				'name' => 'talkorus_tab_docs_content',
				'type' => 'wysiwyg',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
			),
			array(
				'key' => 'field_talkorus_tab_video_content',
				'label' => 'Видео',
				'name' => 'talkorus_tab_video_content',
				'type' => 'wysiwyg',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
			),
			array(
				'key' => 'field_talkorus_tab_projects_content',
				'label' => 'Для проектов',
				'name' => 'talkorus_tab_projects_content',
				'type' => 'wysiwyg',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				),
			),
		),
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => true,
	));
}

add_filter('woocommerce_product_tabs', 'talkorus_product_acf_tabs', 30);

function talkorus_product_acf_tabs($tabs)
{
	global $product;

	if (!$product) {
		return $tabs;
	}

	$product_id = $product->get_id();

	/*
	 * Убираем стандартные вкладки, если они не нужны.
	 */
	unset($tabs['additional_information']);
	unset($tabs['reviews']);

	$description_heading = function_exists('get_field') ? get_field('talkorus_tab_description_heading', $product_id) : '';
	$description_content = function_exists('get_field') ? get_field('talkorus_tab_description_content', $product_id) : '';
	$product_description = $product->get_description();
	$description_preview = wp_strip_all_tags((string) $description_heading . ' ' . (string) $description_content);
	$description_is_technical = strpos($description_preview, 'Технические данные') !== false;

	if ((!empty($description_content) && !$description_is_technical) || !empty($product_description)) {
		$tabs['description'] = array(
			'title'                => 'Описание',
			'priority'             => 10,
			'callback'             => 'talkorus_render_product_description_tab',
			'skip_acf_description' => $description_is_technical,
		);
	} else {
		unset($tabs['description']);
	}

	$technical_field = 'talkorus_tab_technical_content';
	$technical_heading_field = 'talkorus_tab_technical_heading';
	$technical_content = function_exists('get_field') ? get_field($technical_field, $product_id) : '';

	if (empty($technical_content) && $description_is_technical) {
		$technical_field = 'talkorus_tab_description_content';
		$technical_heading_field = 'talkorus_tab_description_heading';
	}

	$acf_tabs = array(
		'talkorus_technical' => array(
			'title'         => 'Технические данные',
			'field'         => $technical_field,
			'heading_field' => $technical_heading_field,
			'priority'      => 20,
		),
		'talkorus_dimensions' => array(
			'title'         => 'Размеры и вес',
			'field'         => 'talkorus_tab_dimensions_content',
			'heading_field' => 'talkorus_tab_dimensions_heading',
			'priority'      => 30,
		),
		'talkorus_cut' => array(
			'title'    => 'Печь в разрезе',
			'field'    => 'talkorus_tab_cut_content',
			'priority' => 40,
		),
		'talkorus_scheme' => array(
			'title'    => 'Схема работы печи',
			'field'    => 'talkorus_tab_scheme_content',
			'priority' => 50,
		),
		'talkorus_purpose' => array(
			'title'    => 'Назначения',
			'field'    => 'talkorus_tab_purpose_content',
			'priority' => 60,
		),
		'talkorus_advantages' => array(
			'title'    => 'Преимущества',
			'field'    => 'talkorus_tab_advantages_content',
			'priority' => 70,
		),
		'talkorus_docs' => array(
			'title'    => 'Документация',
			'field'    => 'talkorus_tab_docs_content',
			'priority' => 80,
		),
		'talkorus_video' => array(
			'title'    => 'Видео',
			'field'    => 'talkorus_tab_video_content',
			'priority' => 90,
		),
		'talkorus_projects' => array(
			'title'    => 'Для проектов',
			'field'    => 'talkorus_tab_projects_content',
			'priority' => 100,
		),
	);

	foreach ($acf_tabs as $tab_key => $tab_data) {
		$content = function_exists('get_field') ? get_field($tab_data['field'], $product_id) : '';

		if (empty($content)) {
			continue;
		}

		$tabs[$tab_key] = array(
			'title'    => $tab_data['title'],
			'priority' => $tab_data['priority'],
			'callback' => 'talkorus_render_product_acf_tab',
			'field'    => $tab_data['field'],
		);

		if (!empty($tab_data['heading_field'])) {
			$tabs[$tab_key]['heading_field'] = $tab_data['heading_field'];
		}
	}

	return $tabs;
}

function talkorus_render_product_description_tab($key, $tab)
{
	global $product;

	if (!$product) {
		return;
	}

	$product_id = $product->get_id();

	$skip_acf_description = !empty($tab['skip_acf_description']);
	$heading = (!$skip_acf_description && function_exists('get_field')) ? get_field('talkorus_tab_description_heading', $product_id) : '';
	$content = (!$skip_acf_description && function_exists('get_field')) ? get_field('talkorus_tab_description_content', $product_id) : '';

	if (empty($heading)) {
		$heading = get_the_title($product_id);
	}

	if (empty($content)) {
		$content = $product->get_description();
	}

	if (!empty($heading)) {
		echo '<h2>' . esc_html($heading) . '</h2>';
	}

	if (!empty($content)) {
		echo apply_filters('the_content', $content);
	}
}

function talkorus_render_product_acf_tab($key, $tab)
{
	global $product;

	if (!$product || empty($tab['field'])) {
		return;
	}

	$content = function_exists('get_field') ? get_field($tab['field'], $product->get_id()) : '';

	if (empty($content)) {
		return;
	}

	if (!empty($tab['heading_field'])) {
		$heading = function_exists('get_field') ? get_field($tab['heading_field'], $product->get_id()) : '';

		if (!empty($heading)) {
			echo '<h2>' . esc_html($heading) . '</h2>';
		}
	}

	echo apply_filters('the_content', $content);
}


// преимущества

add_action('acf/init', 'talkorus_register_product_features_acf_fields');

function talkorus_register_product_features_acf_fields()
{
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(array(
		'key' => 'group_talkorus_product_features',
		'title' => 'Преимущества товара',
		'fields' => array(
			array(
				'key' => 'field_talkorus_product_features',
				'label' => 'Преимущества',
				'name' => 'talkorus_product_features',
				'type' => 'repeater',
				'instructions' => 'Добавьте иконку и текст преимущества. Например: Быстрая сухая сборка.',
				'required' => 0,
				'layout' => 'row',
				'button_label' => 'Добавить преимущество',
				'sub_fields' => array(
					array(
						'key' => 'field_talkorus_product_feature_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
						'return_format' => 'array',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
					array(
						'key' => 'field_talkorus_product_feature_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
						'required' => 0,
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				),
			),
		),
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => true,
	));
}


add_action('woocommerce_after_add_to_cart_button', 'talkorus_single_product_consult_button');

function talkorus_single_product_consult_button()
{
	echo '<button type="button" class="single-product-custom__consult">Нужна консультация</button>';
}

add_action('woocommerce_before_add_to_cart_button', 'talkorus_simple_product_price_inside_form', 5);

function talkorus_simple_product_price_inside_form()
{
	if (!is_product()) {
		return;
	}

	global $product;

	if (!$product || !$product->is_type('simple')) {
		return;
	}

	echo '<div class="single-product-form-price">';
	echo '<span>Цена:</span>';
	woocommerce_template_single_price();
	echo '</div>';
}

add_action('acf/init', 'talkorus_register_pages_settings_acf');

function talkorus_register_pages_settings_acf()
{
	if (!function_exists('acf_add_options_page') || !function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_options_page(array(
		'page_title' => 'Настройка страниц',
		'menu_title' => 'Настройка страниц',
		'menu_slug'  => 'talkorus-pages-settings',
		'capability' => 'edit_posts',
		'redirect'   => false,
		'position'   => 59,
		'icon_url'   => 'dashicons-admin-page',
	));

	acf_add_local_field_group(array(
		'key' => 'group_talkorus_pages_settings',
		'title' => 'Общие блоки страниц',
		'fields' => array(
			array(
				'key' => 'field_talkorus_faq_tab',
				'label' => 'FAQ',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_talkorus_faq_title',
				'label' => 'Заголовок блока FAQ',
				'name' => 'talkorus_faq_title',
				'type' => 'text',
				'default_value' => 'FAQ',
				'placeholder' => 'FAQ',
			),
			array(
				'key' => 'field_talkorus_faq_items',
				'label' => 'Вопросы и ответы',
				'name' => 'talkorus_faq_items',
				'type' => 'repeater',
				'layout' => 'row',
				'button_label' => 'Добавить вопрос',
				'collapsed' => 'field_talkorus_faq_question',
				'sub_fields' => array(
					array(
						'key' => 'field_talkorus_faq_question',
						'label' => 'Вопрос',
						'name' => 'question',
						'type' => 'text',
						'required' => 0,
						'placeholder' => 'Введите вопрос',
					),
					array(
						'key' => 'field_talkorus_faq_answer',
						'label' => 'Ответ',
						'name' => 'answer',
						'type' => 'wysiwyg',
						'required' => 0,
						'tabs' => 'all',
						'toolbar' => 'basic',
						'media_upload' => 0,
					),
				),
			),

			array(
				'key' => 'field_talkorus_about_video_tab',
				'label' => 'Видео-блок',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_talkorus_about_video_title',
				'label' => 'Заголовок видео-блока',
				'name' => 'talkorus_about_video_title',
				'type' => 'text',
				'default_value' => 'ТЕПЛОНАКОПИТЕЛЬНЫЕ КАМИНЫ И ПЕЧИ TALKORUS',
				'placeholder' => 'Введите заголовок блока',
			),
			array(
				'key' => 'field_talkorus_about_video_file',
				'label' => 'Видео MP4',
				'name' => 'talkorus_about_video_file',
				'type' => 'file',
				'return_format' => 'array',
				'library' => 'all',
				'mime_types' => 'mp4',
			),
			array(
				'key' => 'field_talkorus_about_video_preview',
				'label' => 'Превью видео',
				'name' => 'talkorus_about_video_preview',
				'type' => 'image',
				'return_format' => 'array',
				'preview_size' => 'medium',
				'library' => 'all',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'talkorus-pages-settings',
				),
			),
		),
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => true,
	));
}
add_action('init', 'talkorus_register_projects_post_type');

function talkorus_register_projects_post_type()
{
	register_post_type('project', array(
		'labels' => array(
			'name'               => 'Проекты',
			'singular_name'      => 'Проект',
			'menu_name'          => 'Проекты',
			'name_admin_bar'     => 'Проект',
			'add_new'            => 'Добавить проект',
			'add_new_item'       => 'Добавить новый проект',
			'new_item'           => 'Новый проект',
			'edit_item'          => 'Редактировать проект',
			'view_item'          => 'Смотреть проект',
			'all_items'          => 'Все проекты',
			'search_items'       => 'Искать проекты',
			'not_found'          => 'Проекты не найдены',
			'not_found_in_trash' => 'В корзине проекты не найдены',
		),
		'public'              => true,
		'has_archive'         => true,
		'rewrite'             => array(
			'slug'       => 'projects',
			'with_front' => false,
		),
		'menu_icon'           => 'dashicons-portfolio',
		'menu_position'       => 22,
		'supports'            => array(
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'custom-fields',
		),
		'show_in_rest'        => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
	));
}
add_action('init', 'talkorus_register_project_taxonomy');

function talkorus_register_project_taxonomy()
{
	register_taxonomy('project_cat', array('project'), array(
		'labels' => array(
			'name'              => 'Категории проектов',
			'singular_name'     => 'Категория проекта',
			'search_items'      => 'Искать категории',
			'all_items'         => 'Все категории',
			'parent_item'       => 'Родительская категория',
			'parent_item_colon' => 'Родительская категория:',
			'edit_item'         => 'Редактировать категорию',
			'update_item'       => 'Обновить категорию',
			'add_new_item'      => 'Добавить категорию',
			'new_item_name'     => 'Название новой категории',
			'menu_name'         => 'Категории',
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array(
			'slug'       => 'project-category',
			'with_front' => false,
		),
	));
}

add_action('pre_get_posts', 'talkorus_show_all_projects_on_archives');

function talkorus_show_all_projects_on_archives($query)
{
	if (is_admin() || !$query->is_main_query()) {
		return;
	}

	if ($query->is_post_type_archive('project') || $query->is_tax('project_cat')) {
		$query->set('posts_per_page', -1);
		$query->set('no_found_rows', true);
	}
}

add_action('acf/init', 'talkorus_register_project_gallery_acf_fields');

function talkorus_register_project_gallery_acf_fields()
{
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(array(
		'key' => 'group_talkorus_project_gallery',
		'title' => 'Поля проекта',
		'fields' => array(
			array(
				'key' => 'field_talkorus_project_gallery',
				'label' => 'Галерея проекта',
				'name' => 'talkorus_project_gallery',
				'type' => 'gallery',
				'instructions' => 'Загрузите изображения проекта.',
				'required' => 0,
				'return_format' => 'array',
				'preview_size' => 'medium',
				'insert' => 'append',
				'library' => 'all',
				'min' => '',
				'max' => '',
				'mime_types' => 'jpg,jpeg,png,webp',
			),
			array(
				'key' => 'field_talkorus_project_button_link',
				'label' => 'Ссылка кнопки',
				'name' => 'talkorus_project_button_link',
				'type' => 'url',
				'instructions' => 'Например: ссылка на форму, страницу контактов или каталог.',
				'required' => 0,
				'placeholder' => 'https://...',
				'default_value' => '',
			),
			array(
				'key' => 'field_talkorus_project_button_text',
				'label' => 'Текст кнопки',
				'name' => 'talkorus_project_button_text',
				'type' => 'text',
				'required' => 0,
				'default_value' => 'Заказать проект',
				'placeholder' => 'Заказать проект',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'project',
				),
			),
		),
		'menu_order' => 10,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	));
}
