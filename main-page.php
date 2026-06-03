<?php
/*
* Template name: Main Page
 */

get_header();
?>

<main>
	<section class="hero-slider">
		<div class="swiper heroSwiper">
			<div class="swiper-wrapper">
				<div
					class="swiper-slide"
					style="background-image: url(&quot;<?php echo get_template_directory_uri(); ?>/img/slide-1.webp&quot;)">
					<div class="slide-content">
						<h2>
							ЭФФЕКТИВНЫЕ ПЕЧИ И<br />
							КАМИНЫ ИЗ<br />
							ТАЛЬКОМАГНЕЗИТА
						</h2>
						<ul>
							<li>
								<img src="<?php echo get_template_directory_uri(); ?>/img/chek.svg" alt="" />
								Прогрев помещение<br />
								за 2-4 часа
							</li>
							<li>
								<img src="<?php echo get_template_directory_uri(); ?>/img/chek.svg" alt="" />
								Теплоотдача<br />
								до 24 часов
							</li>
							<li>
								<img src="<?php echo get_template_directory_uri(); ?>/img/chek.svg" alt="" />
								Экономия<br />
								дров до 36%
							</li>
							<li>
								<img src="<?php echo get_template_directory_uri(); ?>/img/chek.svg" alt="" />
								Безопасность<br />
								и экологичность
							</li>
						</ul>
						<a href="/catalog/" class="slide-btn">Перейти в каталог</a>
					</div>
				</div>

				<div
					class="swiper-slide"
					style="background-image: url(&quot;<?php echo get_template_directory_uri(); ?>/img/slide-2.webp&quot;)">
					<div class="slide-content">
						<h2>
							TALKORUS - МЫ<br />
							ДЕЛАЕМ МИР ТЕПЛЕЕ
						</h2>

						<a href="/catalog/" class="slide-btn">Перейти в каталог</a>
					</div>
				</div>

				<div
					class="swiper-slide"
					style="background-image: url(&quot;<?php echo get_template_directory_uri(); ?>/img/slide-3.webp&quot;)">
					<div class="slide-content">
						<h2>
							ПЕЧИ, СОЗДАЮЩИЕ<br />
							МИКРОКЛИМАТ<br />
							РУССКОЙ БАНИ
						</h2>
						<ul>
							<li>
								<img src="<?php echo get_template_directory_uri(); ?>/img/chek.svg" alt="" />
								Идеальный баланс<br />
								температуры и влажности
							</li>
							<li>
								<img src="<?php echo get_template_directory_uri(); ?>/img/chek.svg" alt="" />
								Комфортный<br />
								мелкодисперсный пар
							</li>
							<li>
								<img src="<?php echo get_template_directory_uri(); ?>/img/chek.svg" alt="" />
								Оздоровительное<br />
								прогревание тела
							</li>
							<li>
								<img src="<?php echo get_template_directory_uri(); ?>/img/chek.svg" alt="" />
								Полная просушка<br />
								парной после использования
							</li>
						</ul>
						<a href="/catalog/" class="slide-btn">Перейти в каталог</a>
					</div>
				</div>
				<div
					class="swiper-slide"
					style="background-image: url(&quot;<?php echo get_template_directory_uri(); ?>/img/slide-4.webp&quot;)">
					<div class="slide-content">
						<h2>
							РУССКАЯ БАНЯ - В ЛАДУ С<br />
							ПРИРОДОЙ И ЗДОРОВЬЕМ
						</h2>

						<a href="/catalog/" class="slide-btn">Перейти в каталог</a>
					</div>
				</div>
				<div
					class="swiper-slide"
					style="background-image: url(&quot;<?php echo get_template_directory_uri(); ?>/img/slide-5.webp&quot;)">
					<div class="slide-content">
						<h2>
							ОБЛИЦОВОЧНАЯ<br />
							ПЛИТКА И БАННЫЕ<br />
							КАМНИ
						</h2>
						<ul>
							<li>
								<img src="<?php echo get_template_directory_uri(); ?>/img/chek.svg" alt="" />
								Уникальные свойства<br />
								натурального камня
							</li>
							<li>
								<img src="<?php echo get_template_directory_uri(); ?>/img/chek.svg" alt="" />
								Природная красота<br />
								и эстетичность
							</li>
							<li>
								<img src="<?php echo get_template_directory_uri(); ?>/img/chek.svg" alt="" />
								Интересные<br />
								дизайнерские решения
							</li>
							<li>
								<img src="<?php echo get_template_directory_uri(); ?>/img/chek.svg" alt="" />
								Долговечность<br />
								и износостойкость
							</li>
						</ul>
						<a href="/catalog/" class="slide-btn">Перейти в каталог</a>
					</div>
				</div>
				<div
					class="swiper-slide"
					style="background-image: url(&quot;<?php echo get_template_directory_uri(); ?>/img/slide-6.webp&quot;)">
					<div class="slide-content">
						<h2>
							НЕПОВТОРИМЫЙ И<br />
							АУТЕНТИЧНЫЙ ДИЗАЙН
						</h2>

						<a href="/catalog/" class="slide-btn">Перейти в каталог</a>
					</div>
				</div>
			</div>

			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
			<div class="swiper-pagination"></div>
		</div>
	</section>
	<section class="site-section about-us">
		<div class="container">
			<div class="section-divider">
				<span class="line"></span>

				<div class="section-divider__icon">
					<img src="<?php echo get_template_directory_uri(); ?>/img/divider-icon.svg" alt="" />
				</div>

				<span class="line"></span>
			</div>

			<?php
			$about_video_title = function_exists('get_field') ? get_field('talkorus_about_video_title', 'option') : '';
			?>

			<?php if (!empty($about_video_title)) : ?>
				<h2><?php echo esc_html($about_video_title); ?></h2>
			<?php endif; ?>
			<div class="wrapper">
				<div class="about-us__info">
					<div class="about-us__item">
						<div class="about-us__icon">
							<img src="<?php echo get_template_directory_uri(); ?>/img/about-icon-1.svg" alt="" />
						</div>
						<div class="about-us__content">
							<h3>Создание проекта бесплатно</h3>
							<span class="about-us__line"></span>
							<p>
								Если в каталоге не нашлось камина, который бы Вас устраивал,
								напишите нам. Мы создадим авторский проект<br />
								по Вашему заказу.
							</p>
						</div>
					</div>

					<div class="about-us__item">
						<div class="about-us__icon">
							<img src="<?php echo get_template_directory_uri(); ?>/img/about-icon-2.svg" alt="" />
						</div>
						<div class="about-us__content">
							<h3>Изготовление, отправка</h3>
							<span class="about-us__line"></span>
							<p>
								Всегда сообщаем реальные сроки изготовления. <br />
								Предлагаем выгодные условия доставки.
							</p>
						</div>
					</div>

					<div class="about-us__item">
						<div class="about-us__icon">
							<img src="<?php echo get_template_directory_uri(); ?>/img/about-icon-3.svg" alt="" />
						</div>
						<div class="about-us__content">
							<h3>Подключение, установка</h3>
							<span class="about-us__line"></span>
							<p>
								Работаем на рынке с 2010 года. За прошедшие годы
								сформировали широкую базу надёжных партнёров-монтажников в
								различных регионах России и СНГ. Мастера установят печь,
								дымоход — без переплат, с гарантией качества.
							</p>
						</div>
					</div>
				</div>

				<?php
				$about_video_title   = function_exists('get_field') ? get_field('talkorus_about_video_title', 'option') : '';
				$about_video_file    = function_exists('get_field') ? get_field('talkorus_about_video_file', 'option') : '';
				$about_video_preview = function_exists('get_field') ? get_field('talkorus_about_video_preview', 'option') : '';

				$about_video_url = '';

				if (!empty($about_video_file) && is_array($about_video_file) && !empty($about_video_file['url'])) {
					$about_video_url = $about_video_file['url'];
				}

				$about_preview_url = '';

				if (!empty($about_video_preview) && is_array($about_video_preview) && !empty($about_video_preview['url'])) {
					$about_preview_url = $about_video_preview['url'];
				}
				?>

				<div class="about-us__media">
					<?php if (!empty($about_video_url)) : ?>
						<button class="about-us__video" type="button" data-video-src="<?php echo esc_url($about_video_url); ?>">
							<?php if (!empty($about_preview_url)) : ?>
								<img src="<?php echo esc_url($about_preview_url); ?>" alt="<?php echo esc_attr($about_video_title); ?>" />
							<?php else : ?>
								<video muted playsinline preload="metadata">
									<source src="<?php echo esc_url($about_video_url); ?>" type="video/mp4">
								</video>
							<?php endif; ?>

							<span class="about-us__play">
								<svg
									xmlns="http://www.w3.org/2000/svg"
									width="117"
									height="117"
									viewBox="0 0 117 117"
									fill="none">
									<circle
										opacity="0.2"
										cx="58.5"
										cy="58.5"
										r="58.5"
										fill="#FFBC3B" />
									<circle cx="58.5" cy="58.5" r="31.5" fill="#FFBC3B" />
									<path
										d="M66 56.7679C67.3333 57.5377 67.3333 59.4623 66 60.2321L56.25 65.8612C54.9167 66.631 53.25 65.6688 53.25 64.1292L53.25 52.8708C53.25 51.3312 54.9167 50.369 56.25 51.1388L66 56.7679Z"
										fill="white" />
								</svg>
							</span>
						</button>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<section class="site-section about-info">
		<div class="container">
			<div class="section-divider">
				<span class="line"></span>

				<div class="section-divider__icon">
					<img src="<?php echo get_template_directory_uri(); ?>/img/divider-icon.svg" alt="" />
				</div>

				<span class="line"></span>
			</div>

			<h2>О НАС</h2>

			<div class="about-info__accordion">
				<div class="about-info__item active">
					<button class="about-info__head" type="button">
						<span class="about-info__icon">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width="24"
								height="24"
								viewBox="0 0 24 24"
								fill="none">
								<path
									d="M12 16.5C11.8082 16.5 11.6162 16.4267 11.4698 16.2803L3.9698 8.7803C3.67674 8.48723 3.67674 8.01267 3.9698 7.7198C4.26286 7.42692 4.73743 7.42673 5.0303 7.7198L12 14.6895L18.9698 7.7198C19.2629 7.42674 19.7374 7.42674 20.0303 7.7198C20.3232 8.01286 20.3234 8.48742 20.0303 8.7803L12.5303 16.2803C12.3839 16.4267 12.1919 16.5 12 16.5Z"
									fill="black" />
							</svg>
						</span>
						<span class="about-info__title">
							Выпускаем надёжные, безопасные, долговечные печи и камины
							свыше 15 лет.
						</span>
					</button>

					<div class="about-info__body">
						<div class="about-info__content">
							<p>
								Заказчики рекомендуют нас близким, друзьям, знакомым. Мы
								применяем инновационный подход. Задействуем современные
								технологии при выпуске продукции. Стремимся к максимальным
								показателям безопасности и эффективности.
							</p>

							<p>
								Используем в производстве высокоточное оборудование, что
								позволяет обеспечивать наилучшее качество.
							</p>

							<p>
								В нашей команде — свыше 30 профильных мастеров с многолетним
								опытом работы.
							</p>

							<p>
								Качество продукции подтверждается государственными
								сертификатами. Разработки и технологии защищены авторскими
								правами. Выполнили свыше 450 заказов за год, из которых 20 —
								уникальные авторские проекты.
							</p>
						</div>
					</div>
				</div>

				<div class="about-info__item">
					<button class="about-info__head" type="button">
						<span class="about-info__icon">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width="24"
								height="24"
								viewBox="0 0 24 24"
								fill="none">
								<path
									d="M12 16.5C11.8082 16.5 11.6162 16.4267 11.4698 16.2803L3.9698 8.7803C3.67674 8.48723 3.67674 8.01267 3.9698 7.7198C4.26286 7.42692 4.73743 7.42673 5.0303 7.7198L12 14.6895L18.9698 7.7198C19.2629 7.42674 19.7374 7.42674 20.0303 7.7198C20.3232 8.01286 20.3234 8.48742 20.0303 8.7803L12.5303 16.2803C12.3839 16.4267 12.1919 16.5 12 16.5Z"
									fill="black" />
							</svg>
						</span>
						<span class="about-info__title">
							Почему наши печи-камины и банные печи так популярны?
						</span>
					</button>

					<div class="about-info__body">
						<div class="about-info__content">
							<p>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit.
								Doloremque et inventore alias placeat soluta nesciunt autem
								odit quaerat laboriosam temporibus facilis, laborum,
								excepturi esse. Laboriosam maxime cumque facilis quae et.
							</p>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit.
								Doloremque et inventore alias placeat soluta nesciunt autem
								odit quaerat laboriosam temporibus facilis, laborum,
								excepturi esse. Laboriosam maxime cumque facilis quae et.
							</p>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit.
								Doloremque et inventore alias placeat soluta nesciunt autem
								odit quaerat laboriosam temporibus facilis, laborum,
								excepturi esse. Laboriosam maxime cumque facilis quae et.
							</p>
						</div>
					</div>
				</div>

				<div class="about-info__item">
					<button class="about-info__head" type="button">
						<span class="about-info__icon">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width="24"
								height="24"
								viewBox="0 0 24 24"
								fill="none">
								<path
									d="M12 16.5C11.8082 16.5 11.6162 16.4267 11.4698 16.2803L3.9698 8.7803C3.67674 8.48723 3.67674 8.01267 3.9698 7.7198C4.26286 7.42692 4.73743 7.42673 5.0303 7.7198L12 14.6895L18.9698 7.7198C19.2629 7.42674 19.7374 7.42674 20.0303 7.7198C20.3232 8.01286 20.3234 8.48742 20.0303 8.7803L12.5303 16.2803C12.3839 16.4267 12.1919 16.5 12 16.5Z"
									fill="black" />
							</svg>
						</span>
						<span class="about-info__title">
							3 причины быть уверенным в качестве нашего продукта
						</span>
					</button>

					<div class="about-info__body">
						<div class="about-info__content">
							<p>
								Lorem ipsum dolor sit amet consectetur adipisicing elit.
								Dolor eveniet ullam nam corporis, nihil provident
								laboriosam, soluta sunt autem dicta numquam, expedita
								quibusdam quos laudantium. Nisi rerum quasi accusantium
								architecto.
							</p>
						</div>
					</div>
				</div>

				<div class="about-info__item">
					<button class="about-info__head" type="button">
						<span class="about-info__icon">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width="24"
								height="24"
								viewBox="0 0 24 24"
								fill="none">
								<path
									d="M12 16.5C11.8082 16.5 11.6162 16.4267 11.4698 16.2803L3.9698 8.7803C3.67674 8.48723 3.67674 8.01267 3.9698 7.7198C4.26286 7.42692 4.73743 7.42673 5.0303 7.7198L12 14.6895L18.9698 7.7198C19.2629 7.42674 19.7374 7.42674 20.0303 7.7198C20.3232 8.01286 20.3234 8.48742 20.0303 8.7803L12.5303 16.2803C12.3839 16.4267 12.1919 16.5 12 16.5Z"
									fill="black" />
							</svg>
						</span>
						<span class="about-info__title">
							Почему наш камень вам обязательно подойдёт?
						</span>
					</button>

					<div class="about-info__body">
						<div class="about-info__content">
							<p>
								Lorem ipsum dolor sit amet consectetur adipisicing elit.
								Pariatur distinctio maiores facere impedit natus quasi
								soluta libero nisi, id quidem eaque autem vel earum nulla,
								repellat illo in harum cumque!
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="site-section catalog-section">
		<div class="container">
			<div class="section-divider">
				<span class="line"></span>

				<div class="section-divider__icon">
					<img src="<?php echo get_template_directory_uri(); ?>/img/divider-icon.svg" alt="" />
				</div>

				<span class="line"></span>
			</div>

			<div class="catalog-section__head">
				<h2>КАТАЛОГ ПРОДУКЦИИ</h2>
				<p>более 200 товаров высокого качества</p>
			</div>

			<div class="catalog-section__grid">
				<a href="<?php echo esc_url(home_url('/catalog/dlya-doma/')); ?>" class="catalog-card">
					<div class="catalog-card__image">
						<img src="<?php echo get_template_directory_uri(); ?>/img/catalog-1.png" alt="Печи-камины для дома" />
					</div>
					<div class="catalog-card__title">ПЕЧИ-КАМИНЫ ДЛЯ ДОМА</div>
				</a>

				<a href="<?php echo esc_url(home_url('/catalog/dlya-bani/')); ?>" class="catalog-card">
					<div class="catalog-card__image">
						<img src="<?php echo get_template_directory_uri(); ?>/img/catalog-2.png" alt="Печи для русской бани" />
					</div>
					<div class="catalog-card__title">ПЕЧИ ДЛЯ РУССКОЙ БАНИ</div>
				</a>

				<a href="<?php echo esc_url(home_url('/catalog/plitka-i-kamni/')); ?>" class="catalog-card">
					<div class="catalog-card__image">
						<img src="<?php echo get_template_directory_uri(); ?>/img/catalog-3.png" alt="Плитка и банный камень" />
					</div>
					<div class="catalog-card__title">ПЛИТКА И БАННЫЙ КАМЕНЬ</div>
				</a>
			</div>
		</div>
	</section>
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
	<section class="site-section branded-stoves bath-stoves">
		<div class="container">
			<div class="section-divider">
				<span class="line"></span>

				<div class="section-divider__icon">
					<img src="<?php echo get_template_directory_uri(); ?>/img/divider-icon.svg" alt="" />
				</div>

				<span class="line"></span>
			</div>

			<div class="branded-stoves__wrapper bath-stoves__wrapper">
				<div class="no-desctop">
					<h2>БАННЫЕ ПЕЧИ ОНЕГО</h2>
					<div class="branded-stoves__subtitle">
						идеальные печи для русской бани
					</div>
				</div>
				<div class="branded-stoves__media bath-stoves__media">
					<img src="<?php echo get_template_directory_uri(); ?>/img/bath-stove-onego.png" alt="Банные печи ОНЕГО" />

					<div class="hotspot bath-stoves__hotspot bath-stoves__hotspot--1">
						<button
							class="hotspot__dot"
							type="button"
							aria-label="Показать описание"></button>
						<div class="hotspot__tooltip">Управляемая конвекция</div>
					</div>

					<div class="hotspot bath-stoves__hotspot bath-stoves__hotspot--2">
						<button
							class="hotspot__dot"
							type="button"
							aria-label="Показать описание"></button>
						<div class="hotspot__tooltip">Закрытая каменка-термос</div>
					</div>

					<div class="hotspot bath-stoves__hotspot bath-stoves__hotspot--3">
						<button
							class="hotspot__dot"
							type="button"
							aria-label="Показать описание"></button>
						<div class="hotspot__tooltip">
							Мощная подовая шамотная топка
						</div>
					</div>

					<div class="hotspot bath-stoves__hotspot bath-stoves__hotspot--4">
						<button
							class="hotspot__dot"
							type="button"
							aria-label="Показать описание"></button>
						<div class="hotspot__tooltip">Теплонакопительная облицовка</div>
					</div>
				</div>

				<div class="branded-stoves__content bath-stoves__content">
					<div class="no-mobile">
						<h2>БАННЫЕ ПЕЧИ ОНЕГО</h2>
						<div class="branded-stoves__subtitle">
							идеальные печи для русской бани
						</div>
					</div>

					<div class="bath-stoves__lead">
						Откройте для себя Talkorus ОНЕГО - печь для русской бани нового
						поколения
					</div>

					<ol class="branded-stoves__list bath-stoves__list">
						<li>Мощная подовая шамотная топка</li>
						<li>Закрытая каменка-термос</li>
						<li>Управляемая конвекция</li>
						<li>Теплонакопительная облицовка</li>
					</ol>

					<div class="bath-stoves__desc">
						Высокотемпературный, лёгкий пар; комфорт, польза, тепло — всего
						за ОДНУ протопку. Ощутите неповторимую атмосферу паровой русской
						бани!
					</div>

					<div class="bath-stoves__features-list">
						<div class="bath-stoves__features-col">
							<div class="bath-stoves__feature-row">
								<span class="bath-stoves__num">01</span>
								<span><strong>82 %</strong> коэффициент полезного
									действия</span>
							</div>
							<div class="bath-stoves__feature-row">
								<span class="bath-stoves__num">02</span>
								<span><strong>150 минут</strong> на прогрев парной</span>
							</div>
							<div class="bath-stoves__feature-row">
								<span class="bath-stoves__num">03</span>
								<span><strong>24 часа</strong> теплоотдачи</span>
							</div>
						</div>

						<div class="bath-stoves__features-col">
							<div class="bath-stoves__feature-row">
								<span class="bath-stoves__num">04</span>
								<span>Вномерный прогрев камней</span>
							</div>
							<div class="bath-stoves__feature-row">
								<span class="bath-stoves__num">05</span>
								<span>Существенная экономия дров, до 36%</span>
							</div>
							<div class="bath-stoves__feature-row">
								<span class="bath-stoves__num">06</span>
								<span>Возможность готовить на углях</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="bath-stoves__bottom">
				<div class="bath-stoves__stats">
					<div class="bath-stoves__stat">
						<div class="bath-stoves__stat-value">82%</div>
						<div class="bath-stoves__stat-text">
							коэффициент<br />
							полезного действия
						</div>
					</div>

					<div class="bath-stoves__stat bath-stoves__stat--icon">
						<div class="bath-stoves__stat-icon">
							<img src="<?php echo get_template_directory_uri(); ?>/img/bath-icon-1.svg" alt="" />
						</div>
						<div class="bath-stoves__stat-text">
							возможность<br />
							готовить на углях
						</div>
					</div>

					<div class="bath-stoves__stat">
						<div class="bath-stoves__stat-value">150</div>
						<div class="bath-stoves__stat-text">
							минут<br />
							на прогрев парной
						</div>
					</div>

					<div class="bath-stoves__stat bath-stoves__stat--icon">
						<div class="bath-stoves__stat-icon">
							<img src="<?php echo get_template_directory_uri(); ?>/img/bath-icon-2.svg" alt="" />
						</div>
						<div class="bath-stoves__stat-text">
							равномерный<br />
							прогрев камней
						</div>
					</div>

					<div class="bath-stoves__stat">
						<div class="bath-stoves__stat-value">24</div>
						<div class="bath-stoves__stat-text">
							часов<br />
							теплоотдачи
						</div>
					</div>

					<div class="bath-stoves__stat bath-stoves__stat--icon">
						<div class="bath-stoves__stat-icon">
							<img src="<?php echo get_template_directory_uri(); ?>/img/bath-icon-3.svg" alt="" />
						</div>
						<div class="bath-stoves__stat-text">
							существенная<br />
							экономия дров
						</div>
					</div>
				</div>

				<a href="<?php echo esc_url(home_url('/catalog/dlya-doma/dlya-bani/pechi-onego/')); ?>" class="branded-stoves__btn bath-stoves__btn">Выбрать печь</a>
			</div>
		</div>
	</section>
	<?php
	$home_projects = new WP_Query(array(
		'post_type'           => 'project',
		'post_status'         => 'publish',
		'posts_per_page'      => 8,
		'orderby'             => 'rand',
		'ignore_sticky_posts' => true,
	));
	?>

	<?php if ($home_projects->have_posts()) : ?>
		<section class="site-section projects-section">
			<div class="container">
				<div class="section-divider">
					<span class="line"></span>

					<div class="section-divider__icon">
						<img src="<?php echo esc_url(get_template_directory_uri() . '/img/divider-icon.svg'); ?>" alt="" />
					</div>

					<span class="line"></span>
				</div>

				<h2>НАШИ ПРОЕКТЫ</h2>

				<div class="projects-section__grid">
					<?php while ($home_projects->have_posts()) : $home_projects->the_post(); ?>
						<?php get_template_part('template-parts/project-card'); ?>
					<?php endwhile; ?>
				</div>

				<div class="projects-section__more">
					<a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>" class="projects-section__more-btn">
						Больше проектов
					</a>
				</div>
			</div>
		</section>

		<?php wp_reset_postdata(); ?>
	<?php endif; ?>
</main>

<?php
get_footer();
