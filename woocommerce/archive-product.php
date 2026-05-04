<?php
defined('ABSPATH') || exit;

get_header('shop');
?>

<main class="catalog-page">
	<div class="container">
		<div class="catalog-breadcrumbs">
			<?php woocommerce_breadcrumb(); ?>
		</div>
		<h1>Каталог товаров</h1>
		<div class="filters no-desctop">
			<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M12.6055 1.83398C13.1117 1.83398 13.5221 2.24439 13.5221 2.75065V6.41732C13.5221 6.92358 13.1117 7.33398 12.6055 7.33398C12.0992 7.33398 11.6888 6.92358 11.6888 6.41732V5.50065H2.52214C2.01587 5.50065 1.60547 5.09025 1.60547 4.58398C1.60547 4.07772 2.01587 3.66732 2.52214 3.66732H11.6888V2.75065C11.6888 2.24439 12.0992 1.83398 12.6055 1.83398ZM15.3555 4.58398C15.3555 4.07772 15.7659 3.66732 16.2721 3.66732H19.0221C19.5284 3.66732 19.9388 4.07772 19.9388 4.58398C19.9388 5.09025 19.5284 5.50065 19.0221 5.50065H16.2721C15.7659 5.50065 15.3555 5.09025 15.3555 4.58398ZM9.85547 8.25065C10.3617 8.25065 10.7721 8.66106 10.7721 9.16732V10.084H19.9388C20.4451 10.084 20.8555 10.4944 20.8555 11.0007C20.8555 11.5069 20.4451 11.9173 19.9388 11.9173H10.7721V12.834C10.7721 13.3402 10.3617 13.7507 9.85547 13.7507C9.34921 13.7507 8.9388 13.3402 8.9388 12.834V9.16732C8.9388 8.66106 9.34921 8.25065 9.85547 8.25065ZM1.60547 11.0007C1.60547 10.4944 2.01587 10.084 2.52214 10.084H6.1888C6.69506 10.084 7.10547 10.4944 7.10547 11.0007C7.10547 11.5069 6.69506 11.9173 6.1888 11.9173H2.52214C2.01587 11.9173 1.60547 11.5069 1.60547 11.0007ZM12.6055 14.6673C13.1117 14.6673 13.5221 15.0777 13.5221 15.584V19.2507C13.5221 19.7569 13.1117 20.1673 12.6055 20.1673C12.0992 20.1673 11.6888 19.7569 11.6888 19.2507V18.334H2.52214C2.01587 18.334 1.60547 17.9236 1.60547 17.4173C1.60547 16.9111 2.01587 16.5007 2.52214 16.5007H11.6888V15.584C11.6888 15.0777 12.0992 14.6673 12.6055 14.6673ZM15.3555 17.4173C15.3555 16.9111 15.7659 16.5007 16.2721 16.5007H19.0221C19.5284 16.5007 19.9388 16.9111 19.9388 17.4173C19.9388 17.9236 19.5284 18.334 19.0221 18.334H16.2721C15.7659 18.334 15.3555 17.9236 15.3555 17.4173Z" fill="#FFBC3B" />
			</svg>
			Фильтры
		</div>
		<div class="catalog-page-wrapper">

			<aside class="catalog-sidebar">
				<div class="sb-head">
					<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M12.6055 1.83398C13.1117 1.83398 13.5221 2.24439 13.5221 2.75065V6.41732C13.5221 6.92358 13.1117 7.33398 12.6055 7.33398C12.0992 7.33398 11.6888 6.92358 11.6888 6.41732V5.50065H2.52214C2.01587 5.50065 1.60547 5.09025 1.60547 4.58398C1.60547 4.07772 2.01587 3.66732 2.52214 3.66732H11.6888V2.75065C11.6888 2.24439 12.0992 1.83398 12.6055 1.83398ZM15.3555 4.58398C15.3555 4.07772 15.7659 3.66732 16.2721 3.66732H19.0221C19.5284 3.66732 19.9388 4.07772 19.9388 4.58398C19.9388 5.09025 19.5284 5.50065 19.0221 5.50065H16.2721C15.7659 5.50065 15.3555 5.09025 15.3555 4.58398ZM9.85547 8.25065C10.3617 8.25065 10.7721 8.66106 10.7721 9.16732V10.084H19.9388C20.4451 10.084 20.8555 10.4944 20.8555 11.0007C20.8555 11.5069 20.4451 11.9173 19.9388 11.9173H10.7721V12.834C10.7721 13.3402 10.3617 13.7507 9.85547 13.7507C9.34921 13.7507 8.9388 13.3402 8.9388 12.834V9.16732C8.9388 8.66106 9.34921 8.25065 9.85547 8.25065ZM1.60547 11.0007C1.60547 10.4944 2.01587 10.084 2.52214 10.084H6.1888C6.69506 10.084 7.10547 10.4944 7.10547 11.0007C7.10547 11.5069 6.69506 11.9173 6.1888 11.9173H2.52214C2.01587 11.9173 1.60547 11.5069 1.60547 11.0007ZM12.6055 14.6673C13.1117 14.6673 13.5221 15.0777 13.5221 15.584V19.2507C13.5221 19.7569 13.1117 20.1673 12.6055 20.1673C12.0992 20.1673 11.6888 19.7569 11.6888 19.2507V18.334H2.52214C2.01587 18.334 1.60547 17.9236 1.60547 17.4173C1.60547 16.9111 2.01587 16.5007 2.52214 16.5007H11.6888V15.584C11.6888 15.0777 12.0992 14.6673 12.6055 14.6673ZM15.3555 17.4173C15.3555 16.9111 15.7659 16.5007 16.2721 16.5007H19.0221C19.5284 16.5007 19.9388 16.9111 19.9388 17.4173C19.9388 17.9236 19.5284 18.334 19.0221 18.334H16.2721C15.7659 18.334 15.3555 17.9236 15.3555 17.4173Z" fill="#FFBC3B" />
					</svg>
					Фильтры
				</div>
				<?php echo do_shortcode('[br_filter_single filter_id=109]'); //Цена, руб. 
				?>
				<?php echo do_shortcode('[br_filter_single filter_id=110]'); //Высота 
				?>
				<?php echo do_shortcode('[br_filter_single filter_id=107]'); //Категории 
				?>

				<?php echo do_shortcode('[br_filter_single filter_id=240]'); //вид камня 
				?>
				<?php echo do_shortcode('[br_filter_single filter_id=250]'); //Фракция камня 
				?>
				<?php echo do_shortcode('[br_filter_single filter_id=251]'); //Вид обработки
				?>
				<?php echo do_shortcode('[br_filter_single filter_id=252]'); //Расположение
				?>
				<?php echo do_shortcode('[br_filter_single filter_id=253]'); //Объем парной
				?>
				<?php echo do_shortcode('[br_filter_single filter_id=254]'); //Модель облицовки
				?>

				<?php echo do_shortcode('[br_filter_single filter_id=241]'); //Толщина, мм 
				?>
				<?php echo do_shortcode('[br_filter_single filter_id=242]'); //Размеры (Ш х Д) 
				?>


				<?php echo do_shortcode('[br_filter_single filter_id=113]'); //Площадь обогрева 
				?>
				<?php echo do_shortcode('[br_filter_single filter_id=116]'); //Стиль 
				?>
				<?php echo do_shortcode('[br_filter_single filter_id=117]'); //Возможность готовить 
				?>

				<?php echo do_shortcode('[br_filter_single filter_id=112]'); //Наличие 
				?>

				<?php echo do_shortcode('[br_filter_single filter_id=118]'); //Выбранные фильтры 
				?>

				<?php echo do_shortcode('[br_filter_single filter_id=114]'); ?>
				<?php echo do_shortcode('[br_filter_single filter_id=115]'); ?>
			</aside>

			<section class="catalog-content">

				<?php if (woocommerce_product_loop()) : ?>

					<div class="catalog-head">

						<?php do_action('woocommerce_before_shop_loop'); ?>
					</div>

					<?php woocommerce_product_loop_start(); ?>

					<?php while (have_posts()) : ?>
						<?php the_post(); ?>
						<?php wc_get_template_part('content', 'product'); ?>
					<?php endwhile; ?>

					<?php woocommerce_product_loop_end(); ?>

					<?php
					do_action('woocommerce_after_shop_loop');
					?>

				<?php else : ?>

					<?php do_action('woocommerce_no_products_found'); ?>

				<?php endif; ?>

			</section>
		</div>
	</div>
</main>

<?php talkorus_recently_viewed_products(5); ?>

<section class="site-section branded-stoves">
	<div class="container">
		<div class="section-divider">
			<span class="line"></span>

			<div class="section-divider__icon">
				<img src="<?php echo get_template_directory_uri(); ?>/img/divider-icon.svg" alt="" />
			</div>

			<span class="line"></span>
		</div>

		<div class="branded-stoves__wrapper">
			<div class="no-desctop order-1">
				<h2>ФИРМЕННЫЕ ПЕЧИ TALKORUS</h2>
				<div class="branded-stoves__subtitle">
					новое слово в печном деле
				</div>
			</div>
			<div class="branded-stoves__content order-3">
				<div class="no-mobile">
					<h2>ФИРМЕННЫЕ ПЕЧИ TALKORUS</h2>
					<div class="branded-stoves__subtitle">
						новое слово в печном деле
					</div>
				</div>

				<ol class="branded-stoves__list">
					<li>Подовая двухоборотная топка из шамотного кирпича</li>
					<li>Духовка для приготовления пищи</li>
					<li>
						Теплонакопительная облицовка с мощной системой конвекции
					</li>
					<li>Декоративные элементы</li>
				</ol>

				<div class="branded-stoves__text">
					<p>
						Нам удалось создать дровяную печь-камин, которая сочетает
						уникальные для российского рынка показатели практичности с
						предельной эффективностью. Такая конструкция служит в течение
						практически неограниченного периода, так как при производстве
						задействуются качественные материалы, обслуживать изделие
						можно без лишних усилий, а все элементы полностью
						ремонтопригодны. Продукция Talkorus обладает повышенным
						тепловым КПД (до 82 %) и мощной конвекционной системой,
						благодаря которой помещение площадью до 120 кв. м прогревается
						всего за 2–3 часа.
					</p>

					<p>
						Подовая печь-камин Talkorus — это современная русская печь,
						которая отличается компактностью. Многооборотное движение
						дымовых газов обеспечивает надёжный источник тепла, формирует
						комфортную обстановку. Высококачественный природный камень
						способен отдавать тепло на протяжении 24 часов.
					</p>

					<p>
						Продукция компании получила сертификат соответствия «Сделано в
						Карелии». Это официальное подтверждение того, насколько
						качественными, технологичными и экологически безопасными
						являются все изделия.
					</p>
				</div>

				<a href="<?php echo esc_url(home_url('/catalog/dlya-doma/pechi-kaminy-talkorus/')); ?>" class="branded-stoves__btn">Выбрать камин</a>
			</div>
			<div class="branded-stoves__media order-2">
				<img
					src="<?php echo get_template_directory_uri(); ?>/img/branded-stove.png"
					alt="Фирменная печь Talkorus" />

				<div class="hotspot hotspot--1">
					<button
						class="hotspot__dot"
						type="button"
						aria-label="Показать описание"></button>
					<div class="hotspot__tooltip">
						Теплонакопительная облицовка с мощной системой конвекции
					</div>
				</div>

				<div class="hotspot hotspot--2">
					<button
						class="hotspot__dot"
						type="button"
						aria-label="Показать описание"></button>
					<div class="hotspot__tooltip">
						Духовка для приготовления пищи
					</div>
				</div>

				<div class="hotspot hotspot--3">
					<button
						class="hotspot__dot"
						type="button"
						aria-label="Показать описание"></button>
					<div class="hotspot__tooltip">
						Декоративные элементы и место для хранения дров
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_footer('shop');
