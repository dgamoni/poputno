<?php get_header(); ?>

    <!-- Left menu element-->
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left">
        <?php echo do_shortcode('[ULWPQSF id=161]' );?>
    </nav>

    <!-- dgamoni left block -->
    <div class="po_main_left">

        <!-- title -->
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

    </div> 
    <!-- enf left -->

    <!-- sidebar -->
    <?php global $brending_page_id;
            if ( get_field( 'brending_pages_enable_sidebar', $brending_page_id ) ) {
                ?>
                <div class="sidebar " id="sidebar">
                    <?php
                        if ( is_active_sidebar( 'brending_page_sidebar_' . get_field( 'brending_pages_tag_slug', $brending_page_id ) ) ) :
                            dynamic_sidebar( 'brending_page_sidebar_' . get_field( 'brending_pages_tag_slug', $brending_page_id ) );
                        endif;
                    ?>
                </div>
            <?php
            } else {
                get_sidebar();
            }
        ?>

    <div class="cf"></div>
    <!-- end sidebar -->

<?php get_footer(); ?>