<?php get_header(); ?>
    <section class="featured_box author" id="featured_box">
        <div class="wrap cf archive_top_posts">
            <div id="acontent">
                <div class="wrap"><h3><?php author_single_meta(); ?></h3></div>
            </div>
        </div>
    </section>
<?php rewind_posts(); ?>
<?php get_template_part('loop'); ?>
<?php get_footer(); ?>