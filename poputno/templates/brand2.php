<?php
/**
 * Template Name: Брендирование2
 */

//branding_init();

get_header(); ?>
    <section class="main branding_page branding_page2" id="main">

        <div class="wrap cf">

            <div class="post brending_page">
                <div class="post_height">
                    <?php while (have_posts()):
                        $post_id = get_the_ID();
                        the_post(); ?>
                        <div class="brand-container">
                            <h1><?php the_title(); ?></h1>
                            <img class="brend_bg_img" src="http://ain.stage.decollete.com.ua/wp-content/themes/ain6/assets/img/content/New_logo.png" alt=""/>
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
//                                    get_template_part('content');
                                ?>

                                    <li class="fresh_latest_post">
                                        <a href="<?php the_permalink(); ?>"
                                           style="background-image: url(<?php echo get_img_post(get_the_ID(), 'fresh_latest_post'); ?>);">
                                            <div class="fresh_gradient">
                                                <p class="fresh_small">
                                                    <?php echo get_time_deails(get_the_ID()); ?>
                                                </p>

                                                <h3 class="fresh_big"><?php the_title(); ?></h3>

                                                <p class="fresh_meta">
                                    <span class="fresh_views_count"><?php $res = get_soc_votes(get_the_ID());
                                        echo $res['view']; ?></span>
                                                    <?php /* <span class="fresh_comments_count"><?php echo $res['cn']; ?></span>*/ ?>
                                                    <span class="fresh_favs_count"><?php $res = get_soc_votes(get_the_ID());
                                                        echo $res['sum']; ?></span>
                                                </p>
                                            </div>
                                        </a>
                                    </li>



                                <?php

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