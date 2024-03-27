<?php
/**
 * Template Name: Брендирование
 */

//branding_init();

get_header(); ?>
    <section class="main branding_page" id="main">

        <div class="wrap cf">

            <div class="post brending_page">
                <div class="post_height">
                    <?php while (have_posts()):
                        $post_id = get_the_ID();
                        the_post(); ?>
                        <div class="brand-container">
                            <h1><?php the_title(); ?></h1>
                            <?php the_content(); ?>
                        </div>
                        <div class="tagposts tagposts_nead cf">
                            <?php

                            $slug_term = get_field('brending_pages_tag_slug');

                            if ($slug_term) {
                                $fwidget_args = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => 1,
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
                                    $id_of_sticky_post = get_the_ID();
                                    get_template_part('content');
                                endwhile;
                            endif;
                            wp_reset_postdata();

                            ?>
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