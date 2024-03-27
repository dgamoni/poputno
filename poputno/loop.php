<?php
$num_posts = 0;
$all_post_ids = array();
$excluded_posts = array();
$hasBanner = false;

if (have_posts()):  while (have_posts()): the_post();
    $num_posts++;
    if ($num_posts == 1) {
        echo '<!-- posts container -->
                <div class="new_posts_container">';
        echo '      <ul class="new_posts new_posts_wrapper  ajax-content">';
    }

    $all_post_ids[] = get_the_ID();

    get_template_part('content');

    if ((!is_category() || is_paged()) && $num_posts == 3) {
        ?>

        <?php

        $hasBanner = true;

    }

    if ((!is_category() || $hasBanner) && $num_posts == 7 || is_category() && !$hasBanner && $num_posts == 8) {

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

if (is_category() && !is_paged()) {
    //$excluded_posts = array_slice($all_post_ids, -2, 2);
}

echo '</ul>';
echo '</div>';

?>
<?php 
global $exclude_posts_for_main_query;
ajax_pagination($custom_query = false, $inner_class = '.ajax-content', $posts_per_page = 15, $ajax_action = 'ain_ajax_pagination', null, $excluded_posts = $exclude_posts_for_main_query);
//ajax_pagination($custom_query = false, $inner_class = '.ajax-content', $posts_per_page = 16, $ajax_action = 'ain_ajax_pagination', null, $excluded_posts);
//ajax_pagination($custom_query = false, $inner_class = '.ajax-content', $posts_per_page = 15, $ajax_action = 'ain_ajax_pagination', null);
 ?>

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

<?php /*
<!-- posts container -->
<div class="new_posts_container">
    <ul class="new_posts new_posts_wrapper ajax-content">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <?php get_template_part('content'); ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </ul>
</div>
<?php ajax_pagination($custom_query = false, $inner_class = '.lp_continue', $posts_per_page = 16, $ajax_action = 'ain_ajax_pagination'); ?>

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
*/
?>