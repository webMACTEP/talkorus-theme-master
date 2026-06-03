<?php
get_header();

$current_project_id = get_the_ID();
?>

<main class="single-project-page">
    <div class="container">

        <div class="catalog-breadcrumbs">
            <?php woocommerce_breadcrumb(); ?>
        </div>

        <?php while (have_posts()) : the_post(); ?>

            <?php
            $project_gallery = function_exists('get_field') ? get_field('talkorus_project_gallery', get_the_ID()) : array();

            $button_link = function_exists('get_field') ? get_field('talkorus_project_button_link', get_the_ID()) : '';
            $button_text = function_exists('get_field') ? get_field('talkorus_project_button_text', get_the_ID()) : '';

            if (empty($button_text)) {
                $button_text = 'Заказать проект';
            }

            if (empty($button_link)) {
                $button_link = '#';
            }
            ?>

            <article <?php post_class('single-project'); ?>>

                <h1 class="single-project__title">
                    <?php the_title(); ?>
                </h1>

                <div class="single-project__top">

                    <div class="single-project__gallery-wrap">
                        <?php if (!empty($project_gallery)) : ?>
                            <div class="single-project-gallery swiper">
                                <div class="swiper-wrapper">
                                    <?php foreach ($project_gallery as $image) : ?>
                                        <?php
                                        if (empty($image['url'])) {
                                            continue;
                                        }

                                        $image_large = !empty($image['sizes']['large']) ? $image['sizes']['large'] : $image['url'];
                                        $image_alt   = !empty($image['alt']) ? $image['alt'] : get_the_title();
                                        ?>

                                        <div class="swiper-slide">
                                            <img
                                                src="<?php echo esc_url($image_large); ?>"
                                                alt="<?php echo esc_attr($image_alt); ?>"
                                                loading="lazy">
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <button class="single-project-gallery__nav single-project-gallery__nav--prev" type="button" aria-label="Предыдущий слайд">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M7.49995 12C7.49995 12.1918 7.57327 12.3838 7.7197 12.5302L15.2197 20.0302C15.5128 20.3233 15.9873 20.3233 16.2802 20.0302C16.5731 19.7371 16.5733 19.2626 16.2802 18.9697L9.31045 12L16.2802 5.0302C16.5733 4.73714 16.5733 4.26258 16.2802 3.9697C15.9871 3.67683 15.5126 3.67664 15.2197 3.9697L7.7197 11.4697C7.57327 11.6161 7.49995 11.8081 7.49995 12Z" fill="#353535" />
                                    </svg>
                                </button>

                                <button class="single-project-gallery__nav single-project-gallery__nav--next" type="button" aria-label="Следующий слайд">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M16.5 12C16.5 12.1918 16.4267 12.3838 16.2803 12.5302L8.7803 20.0302C8.48723 20.3233 8.01267 20.3233 7.7198 20.0302C7.42692 19.7371 7.42673 19.2626 7.7198 18.9697L14.6895 12L7.7198 5.0302C7.42674 4.73714 7.42674 4.26258 7.7198 3.9697C8.01286 3.67683 8.48742 3.67664 8.7803 3.9697L16.2803 11.4697C16.4267 11.6161 16.5 11.8081 16.5 12Z" fill="#353535" />
                                    </svg>
                                </button>
                            </div>
                        <?php elseif (has_post_thumbnail()) : ?>
                            <div class="single-project__image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="single-project__info">
                        <div class="single-project__date">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                                <path d="M22.0945 6.78594C21.9711 4.7332 20.257 3.125 18.1925 3.125H17.1875V2.34375C17.1875 1.9125 16.8375 1.5625 16.4062 1.5625C15.975 1.5625 15.625 1.9125 15.625 2.34375V3.125H9.37496V2.34375C9.37496 1.9125 9.02496 1.5625 8.59371 1.5625C8.16246 1.5625 7.81246 1.9125 7.81246 2.34375V3.125H6.80738C4.74254 3.125 3.02848 4.7332 2.90543 6.78594C2.67379 10.6469 2.67809 14.5633 2.91832 18.4262C3.0402 20.3879 4.61168 21.9594 6.5734 22.0812C8.53941 22.2035 10.5195 22.2645 12.4996 22.2645C14.4793 22.2645 16.4597 22.2035 18.4257 22.0812C20.3875 21.9594 21.9589 20.3879 22.0808 18.4262C22.3214 14.5652 22.3257 10.6492 22.0945 6.78594ZM20.5218 18.3293C20.4484 19.5063 19.5058 20.4488 18.3293 20.5219C14.4613 20.7621 10.5386 20.7621 6.67066 20.5219C5.49371 20.4484 4.55113 19.5059 4.47809 18.3293C4.29332 15.3594 4.25543 12.3582 4.35426 9.375H20.6461C20.7445 12.3594 20.7066 15.3605 20.5218 18.3293ZM8.59371 6.25C9.02496 6.25 9.37496 5.9 9.37496 5.46875V4.6875H15.625V5.46875C15.625 5.9 15.975 6.25 16.4062 6.25C16.8375 6.25 17.1875 5.9 17.1875 5.46875V4.6875H18.1925C19.432 4.6875 20.4609 5.65039 20.5347 6.8793C20.5531 7.18945 20.5609 7.50156 20.5761 7.8125H4.42379C4.43941 7.50156 4.44684 7.18945 4.4652 6.8793C4.53902 5.65039 5.56754 4.6875 6.80738 4.6875H7.81246V5.46875C7.81246 5.9 8.16246 6.25 8.59371 6.25Z" fill="#A9613D"></path>
                                <path d="M8.59375 14.0625C9.24096 14.0625 9.76562 13.5378 9.76562 12.8906C9.76562 12.2434 9.24096 11.7188 8.59375 11.7188C7.94654 11.7188 7.42188 12.2434 7.42188 12.8906C7.42188 13.5378 7.94654 14.0625 8.59375 14.0625Z" fill="#A9613D"></path>
                                <path d="M12.5 14.0625C13.1472 14.0625 13.6719 13.5378 13.6719 12.8906C13.6719 12.2434 13.1472 11.7188 12.5 11.7188C11.8528 11.7188 11.3281 12.2434 11.3281 12.8906C11.3281 13.5378 11.8528 14.0625 12.5 14.0625Z" fill="#A9613D"></path>
                                <path d="M8.59375 17.9688C9.24096 17.9688 9.76562 17.4441 9.76562 16.7969C9.76562 16.1497 9.24096 15.625 8.59375 15.625C7.94654 15.625 7.42188 16.1497 7.42188 16.7969C7.42188 17.4441 7.94654 17.9688 8.59375 17.9688Z" fill="#A9613D"></path>
                                <path d="M16.4062 14.0625C17.0535 14.0625 17.5781 13.5378 17.5781 12.8906C17.5781 12.2434 17.0535 11.7188 16.4062 11.7188C15.759 11.7188 15.2344 12.2434 15.2344 12.8906C15.2344 13.5378 15.759 14.0625 16.4062 14.0625Z" fill="#A9613D"></path>
                                <path d="M16.4062 17.9688C17.0535 17.9688 17.5781 17.4441 17.5781 16.7969C17.5781 16.1497 17.0535 15.625 16.4062 15.625C15.759 15.625 15.2344 16.1497 15.2344 16.7969C15.2344 17.4441 15.759 17.9688 16.4062 17.9688Z" fill="#A9613D"></path>
                                <path d="M12.5 17.9688C13.1472 17.9688 13.6719 17.4441 13.6719 16.7969C13.6719 16.1497 13.1472 15.625 12.5 15.625C11.8528 15.625 11.3281 16.1497 11.3281 16.7969C11.3281 17.4441 11.8528 17.9688 12.5 17.9688Z" fill="#A9613D"></path>
                            </svg>

                            <span><?php echo esc_html(get_the_date('F, Y')); ?></span>
                        </div>

                        <div class="single-project__content">
                            <?php the_content(); ?>
                        </div>

                        <a class="single-project__button" href="<?php echo esc_url($button_link); ?>">
                            <?php echo esc_html($button_text); ?>
                        </a>
                    </div>

                </div>

            </article>

        <?php endwhile; ?>

        <?php
        $related_projects = new WP_Query(array(
            'post_type'           => 'project',
            'post_status'         => 'publish',
            'posts_per_page'      => 4,
            'orderby'             => 'rand',
            'post__not_in'        => array($current_project_id),
            'ignore_sticky_posts' => true,
        ));
        ?>

        <?php if ($related_projects->have_posts()) : ?>
            <section class="site-section projects-section projects-section--related">
                <div class="section-divider">
                    <span class="line"></span>

                    <div class="section-divider__icon">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/divider-icon.svg'); ?>" alt="">
                    </div>

                    <span class="line"></span>
                </div>

                <h2>ДРУГИЕ ПРОЕКТЫ</h2>

                <div class="projects-section__grid">
                    <?php while ($related_projects->have_posts()) : $related_projects->the_post(); ?>
                        <?php get_template_part('template-parts/project-card'); ?>
                    <?php endwhile; ?>
                </div>
            </section>

            <?php wp_reset_postdata(); ?>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
