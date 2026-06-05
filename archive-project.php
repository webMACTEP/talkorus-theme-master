<?php
get_header();
?>

<main class="projects-page">
    <div class="container">

        <div class="catalog-breadcrumbs">
            <?php woocommerce_breadcrumb(); ?>
        </div>

        <h1 class="projects-page__title">
            Проекты
        </h1>

        <?php
        $project_categories = get_terms(array(
            'taxonomy'   => 'project_cat',
            'hide_empty' => true,
        ));
        ?>

        <?php if (!empty($project_categories) && !is_wp_error($project_categories)) : ?>
            <div class="projects-page__categories">
                <div class="projects-page__wrapp">
                    <a class="projects-page__category active" href="<?php echo esc_url(get_post_type_archive_link('project')); ?>">
                        Все проекты
                    </a>

                    <?php foreach ($project_categories as $category) : ?>
                        <a class="projects-page__category" href="<?php echo esc_url(get_term_link($category)); ?>">
                            <?php echo esc_html($category->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (have_posts()) : ?>
            <section class="site-section projects-section projects-section--archive">
                <div class="projects-section__grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/project-card'); ?>
                    <?php endwhile; ?>
                </div>

                <div class="projects-page__pagination">
                    <?php
                    the_posts_pagination(array(
                        'prev_text' => 'Назад',
                        'next_text' => 'Вперед',
                    ));
                    ?>
                </div>
            </section>
        <?php else : ?>
            <p>Проекты пока не добавлены.</p>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
