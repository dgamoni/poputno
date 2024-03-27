<?php get_header(); ?>

<!-- Left menu element-->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left">
    <?php echo do_shortcode('[ULWPQSF id=145]' );?>
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


<?php if (is_paged()) { ?>
    <section class="featured_box author" id="featured_box">
        <div class="wrap cf archive_top_posts">
            <div id="acontent">
                <div class="wrap">
                    <h3 class="archive_top_title"><big>Страница: <?php echo get_query_var('paged'); ?></big></h3>
                </div>
            </div>
        </div>
    </section>
<?php

}

if (!is_paged()) {
    //Два верхним огромных поста
    top_two_big_posts_and_adv();

    //var_dump($exclude_posts_for_main_query);

    //Это лучшее в категориях и на главной
    //featured_posts_home_page();

}


$num_posts = 0;
$all_post_ids = array();
$excluded_posts = array();

if (have_posts()):  while (have_posts()): the_post();

    $num_posts++;

    $all_post_ids[] = get_the_ID();

    if ($num_posts == 1) {
        echo '<!-- posts container -->
                <div class="new_posts_container">';
        echo '      <ul class="new_posts new_posts_wrapper ajax-content">';
    }

    get_template_part('content');

    if (is_paged() && $num_posts == 3) {
        ?>
<!--         <li class="new_post_item">
            <div class="fresh_adv"> -->
                <?php //echo get_field( 'head_adv', 'options' ); ?>
                <!-- Premium_300x250 -->
                <!-- <div id='div-gpt-ad-1348523403678-0' style='height: 250px;'> -->
                    <!--<script type='text/javascript'>-->
<!--                         // googletag.cmd.push(function () {
                        //     googletag.display('div-gpt-ad-1348523403678-0');
                        // }); -->
                     <!--</script>-->
<!--                 </div>
            </div>
        </li> -->
    <?php
    }

    if ((!is_paged() && $num_posts == 8) || (is_paged() && $num_posts == 7)) {
        // echo '</ul>';
        // echo '</div>';
        // echo '<div class="new_job_events">';
        // rand_vac_end_event_block();
        // echo '</div>';
        // echo '    <!-- posts container -->
        //      <div class="new_posts_container">';
        // echo '  <ul class="new_posts new_posts_wrapper ajax-content">';
    }
endwhile;endif;

echo '</ul>';
echo '</div>';

if (count($all_post_ids) >= 2) {
    //$excluded_posts = array_slice($all_post_ids, -2, 2);
}

//var_dump( get_excluded_posts_fog_loops() );
//var_dump( get_two_last_posts_id_for_exclude() );
//var_dump( get_featured_posts_for_exclude() );

?>


<?php 
global $exclude_posts_for_main_query;
//ajax_pagination($custom_query = false, $inner_class = '.ajax-content', $posts_per_page = 15, $ajax_action = 'ain_ajax_pagination', null, $excluded_posts); 
ajax_pagination($custom_query = false, $inner_class = '.ajax-content', $posts_per_page = 15, $ajax_action = 'ain_ajax_pagination', null, $excluded_posts = $exclude_posts_for_main_query); ?>
    
    <div class="cf"></div>

    <div class="fresh_navigation">
        <?php
        global $wp_query;
        

        $big = 999999999; // need an unlikely integer
        echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $wp_query->max_num_pages,
            'prev_text' => __('<'),
            'next_text' => __('>'),
            
        ));
        ?>
    </div>

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