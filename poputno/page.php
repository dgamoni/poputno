<?php get_header(); ?>
    <section class="main" id="main">

        <div class="wrap cf">
            <?php while (have_posts()): the_post(); ?>
                <div class="post">
                    <h1><?php the_title(); ?></h1>

                    <?php the_content(); ?>


                    <hr/>
                </div>
            <?php endwhile; ?>

            <?php get_sidebar(); ?>

        </div>

    </section>
<?php get_footer(); ?>