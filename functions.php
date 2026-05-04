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
	wp_enqueue_script('script', get_template_directory_uri() . '/js/main.js', array('jquery', 'swiper'), null, true);

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

function talkorus_change_add_to_cart_text($text, $product) {
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