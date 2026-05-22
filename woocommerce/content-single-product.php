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

<section class="site-section about-info">
	<div class="container">
		<div class="section-divider">
			<span class="line"></span>

			<div class="section-divider__icon">
				<img src="<?php echo get_template_directory_uri(); ?>/img/divider-icon.svg" alt="" />
			</div>

			<span class="line"></span>
		</div>

		<h2>FAQ</h2>

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

<?php talkorus_recently_viewed_products(5); ?>

<?php do_action('woocommerce_after_single_product'); ?>