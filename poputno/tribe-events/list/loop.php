<?php
/**
 * List View Loop
 * This file sets up the structure for the list loop
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/loop.php
 *
 * @package TribeEventsCalendar
 * @since  3.0
 * @author Modern Tribe Inc.
 *
 */

if (!defined('ABSPATH')) {
    die('-1');
} ?>

<?php
global $more;
$more = false;
?>

<!-- <ul class="tribe-events-loop hfeed vcalendar cal-list "> -->
<ul class="hfeed vcalendar cal-list new_posts new_posts_wrapper  ajax-content">
    <!-- <br><br> -->
    <?php while (have_posts()) : the_post(); ?>
        <?php do_action('tribe_events_inside_before_loop'); ?>

        <!-- Month / Year Headers -->
        <?php tribe_events_list_the_date_headers(); ?>

        <!-- Event  -->
        <li class="cal-item">
            <?php tribe_get_template_part('list/single', 'event') ?>
        </li><!-- .hentry .vevent -->


        <?php do_action('tribe_events_inside_after_loop'); ?>
    <?php endwhile; ?>

</ul><!-- .tribe-events-loop -->
