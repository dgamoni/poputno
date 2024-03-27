<?php
/**
 * Template Name: Вакансии
 */

get_header();
?>
    <section class="main" id="main">

        <div class="wrap cf">

            <div class="calendar-content ">
                <div class="vac-head cf">
                    <h1>Вакансии</h1>
                    <a href="/jobs/add-job" class="add_vacancy" style="margin-top: -1px;">Добавить вакансию</a>
                    <?php if (is_user_logged_in()) { ?>
                        <a href="/cabinet" style="margin-top: 1px;">Мои вакансии</a>
                    <?php } ?>
                </div>
                <div class="vac-filter cf">
                    <ul class="cat-list">
                        <li class="cat"><a href="<?php bloginfo('url'); ?>/jobs" class="active">Все</a></li>
                        <?php
                        $terms = get_terms("univac_cat", array('hide_empty' => false));
                        $count = count($terms);
                        if ($count > 0) {
                            foreach ($terms as $term) {
                                echo '<li class="cat "><a class="' . get_vacancy_cat_color($term->term_id) . '" href="' . get_term_link($term, 'univac_cat') . '">' . $term->name . '</a></li> ';
                            }
                        } ?>
                    </ul>
                    <div class="vac-amount">
                        <?php echo $sPublishedVacs = (int)wp_count_posts('univac_vacancy')->publish; ?>
                        <?php echo declension($sPublishedVacs, array('Вакансия', 'Вакансии', 'Вакансий')); ?>
                    </div>
                </div>
                <ul class="vacancies-list">
                    <?php
                    $wp_query = new WP_Query(array('post_type' => 'univac_vacancy', 'posts_per_page' => 22, 'paged' => $paged));
                    if ($wp_query->have_posts()) :
                        while ($wp_query->have_posts()) : $wp_query->the_post();
                            get_template_part('content', 'vacancy');
                        endwhile;
                    endif;

                    ?>
                </ul>

                <?php ajax_pagination($wp_query, $inner_class = '.vacancies-list', $posts_per_page = 13, $ajax_action = 'pagination_vacancy', $post_type = 'univac_vacancy'); ?>
                <?php wp_reset_query(); ?>
            </div>

            <?php get_sidebar(); ?>
        </div>

    </section>
<?php get_footer(); ?>