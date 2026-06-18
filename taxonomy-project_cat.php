<?php
get_header();

$current_term = get_queried_object();
?>

<main class="projects-page projects-page--category">
    <div class="container">

        <div class="catalog-breadcrumbs">
            <?php woocommerce_breadcrumb(); ?>
        </div>

        <h1 class="projects-page__title">
            <?php echo esc_html($current_term->name); ?>
        </h1>

        <?php
        $project_categories = get_terms(array(
            'taxonomy'   => 'project_cat',
            'hide_empty' => true,
        ));
        ?>

        <?php if (!empty($project_categories) && !is_wp_error($project_categories)) : ?>
            <div class="projects-page__categories">
                <a class="projects-page__category" href="<?php echo esc_url(get_post_type_archive_link('project')); ?>">
                    Все проекты
                </a>

                <?php foreach ($project_categories as $category) : ?>
                    <a
                        class="projects-page__category <?php echo $current_term->term_id === $category->term_id ? 'active' : ''; ?>"
                        href="<?php echo esc_url(get_term_link($category)); ?>"
                    >
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (have_posts()) : ?>
            <section class="site-section projects-section projects-section--archive">
                <div class="projects-section__grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/project-card'); ?>
                    <?php endwhile; ?>
                </div>

            </section>
        <?php else : ?>
            <p>В этой категории пока нет проектов.</p>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
