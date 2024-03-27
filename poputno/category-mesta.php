<?php get_header(); ?>

<!-- Left menu element-->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left">
    <?php echo do_shortcode('[ULWPQSF id=161]' );?>
</nav>

<!-- top tag dgamoni  -->
<div class="wrap poputno_tag">
    <ul>
        <?php top_tags();?>
    </ul>
</div>
<!-- end top tag dgamoni  -->

<!-- dgamoni  -->
<div class="po_main_left">
<!-- end dgamoni  -->

<?php if (!is_paged()) {

    //Два верхним огромных поста
    top_two_big_posts_and_adv();

    //Это лучшее в категориях и на главной
    //featured_posts_home_page();
}
//print_r(get_excluded_posts_fog_loops());
//echo '<br>';
//print_r(get_two_last_posts_id_for_exclude());
//echo '<br>';
//print_r(get_featured_posts_for_exclude());
if (is_paged()) {
    ?>
<!--     <section class="featured_box author" id="featured_box">
        <div class="wrap cf archive_top_posts">
            <div id="acontent">
                <div class="wrap">
                    <div class="spons">
                        <?php echo category_description(); ?>
                    </div>
                    <h1 class="archive_top_title">
                        <big>
                            <?php single_cat_title(); ?>
                            <?php
                            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            echo ' (' . $paged . ' стр.)';
                            ?>
                        </big>
                    </h1>
                </div>
            </div>
        </div>
    </section> -->
<?php } ?>
<?php get_template_part('loop'); ?>

<!-- dgamoni  -->
</div>
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
<!-- end dgamoni  -->

<?php get_footer(); ?>