<?php
/**
 * Month Single Event
 * This file contains one event in the month view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/month/single-event.php
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

global $post;
$day = tribe_events_get_current_month_day();
$event_id = "{$post->ID}-{$day['daynum']}";

list($start_date, $start_time) = explode(' ', tribe_get_start_date($post));
list($end_date, $end_time) = explode(' ', tribe_get_end_date($post));

list($d, $m, $y) = explode('.', $start_date);

if ($start_time) {
    list($hour, $min) = explode(":", $start_time);
    $start_time_timestamp = mktime($hour, $min, 0, $m, $d, $y);
}

if ($end_time) {
    list($hour, $min) = explode(":", $end_time);
    $end_time_timestamp = mktime($hour, $min, 0, $m, $d, $y);
}

$time_str = $start_time;
if ($end_date_timestamp > $start_time_timestamp)
    $time_str .= '-' . $end_time;


?>

<a href="<?php tribe_event_link($post); ?>" class="cal-event">
    <div class="ev_time"><?php echo $time_str; ?></div>
    <?php the_title() ?>
</a>