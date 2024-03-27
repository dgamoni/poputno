<?php get_header(); ?>
    <section class="featured_box author" id="featured_box">
        <div class="wrap cf archive_top_posts">
            <div id="acontent">
                <div class="wrap">
                    <h3 class="archive_top_title"><big><?php
                            if (is_day()) :
                                printf('Архив за день: %s', get_the_date());

                            elseif (is_month()) :
                                printf('Архив за месяц: %s', get_the_date(_x('F Y', 'monthly archives date format')));

                            elseif (is_year()) :
                                printf('Архив за год: %s', get_the_date(_x('Y', 'yearly archives date format')));

                            else :
                                echo 'Архивы';

                            endif;
                            ?></big></h3>
                </div>
            </div>
        </div>
    </section>
<?php get_template_part('loop'); ?>
<?php get_footer(); ?>