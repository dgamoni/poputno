<?php
/**
 * Template Name: Брендирование4
 */

//branding_init();

get_header(); ?>
    <section class="main branding_page branding_page4" id="main">

        <div class="wrap cf">

            <div class="post brending_page">
                <div class="post_height">
                    <?php while (have_posts()):
                        $post_id = get_the_ID();
                        the_post(); ?>
<!--                        <div class="brand-container">-->
<!--                            <h1>--><?php //the_title(); ?><!--</h1>-->
<!--                            --><?php //the_content(); ?>
<!--                        </div>-->
                        <div class="tagposts tagposts_nead cf">
                            <li class="fresh_latest_post">
                                <a href="http://ain.ua/2014/10/07/543805" style="background-image: url(http://ain.ua/wp-content/uploads/2014/10/43-460x250.jpg);">
                                    <div class="fresh_gradient">
                                        <p class="fresh_small">
                                            1 час 33 минуты      назад            </p>

                                        <h3 class="fresh_big">Сергей Петренко назвал 5 типичных ошибок украинских стартапов в презентациях для инвесторов</h3>

                                        <p class="fresh_meta">
                                            <span class="fresh_views_count">339</span>
                                            <span class="fresh_favs_count">14</span>
                                        </p>
                                    </div>
                                </a>
                            </li>
                            <li class="fresh_latest_post">
                                <a href="http://ain.ua/2014/10/07/543805" style="background-image: url(http://ain.ua/wp-content/uploads/2014/10/43-460x250.jpg);">
                                    <div class="fresh_gradient">
                                        <p class="fresh_small">
                                            1 час 33 минуты      назад            </p>

                                        <h3 class="fresh_big">Сергей Петренко назвал 5 типичных ошибок украинских стартапов в презентациях для инвесторов</h3>

                                        <p class="fresh_meta">
                                            <span class="fresh_views_count">339</span>
                                            <span class="fresh_favs_count">14</span>
                                        </p>
                                    </div>
                                </a>
                            </li>
                        </div>



                    <?php endwhile; ?>

                    <hr/>
                    <div class="tagposts cf">
                        <?php

                        $slug_term = get_field('brending_pages_tag_slug');

                        if ($slug_term) {
                            $fwidget_args = array(
                                'post_type' => 'post',
                                'posts_per_page' => 9,
                                'post__not_in' => array($id_of_sticky_post),
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'post_tag',
                                        //'field' => 'id',
                                        'field' => 'slug',

                                        'terms' => $slug_term
                                    )
                                ),
                            );
                            $brending_query = new WP_Query($fwidget_args);
                        }
                        if ($brending_query->have_posts()):
                            while ($brending_query->have_posts()) : $brending_query->the_post();
                                get_template_part('content');
                            endwhile;
                        endif;
                        wp_reset_postdata();

                        ?>
                    </div>
                    <?php
                    ajax_pagination($custom_query = $brending_query, $inner_class = '.tagposts', $posts_per_page = 9, $ajax_action = 'ain_ajax_pagination_by_tag');
                    ?>
                </div>

            </div>
            <?php if (get_field('brending_pages_enable_sidebar', $brending_page_id)) { ?>
                <div class="sidebar" id="sidebar">
                    <?php
                    if (is_active_sidebar('brending_page_sidebar_' . get_field('brending_pages_tag_slug'))) :
                        dynamic_sidebar('brending_page_sidebar_' . get_field('brending_pages_tag_slug'));
                    endif;
                    ?>
                </div>
            <?php
            } else {
                get_sidebar();
            }
            ?>


    </section>

    <script>
        // jQuery(document).ready(function(){
        //         jQuery('.wrapper-sticky').addClass('brand_header');
        // });

    </script>

<?php get_footer(); ?>