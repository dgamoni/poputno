<?php
/**
 * Month View Single Day
 * This file contains one day in the month grid
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/month/single-day.php
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

$day = tribe_events_get_current_month_day();

?>

<?php if ($day['date'] != 'previous' && $day['date'] != 'next') : ?>
    <?php if ($day['events']->have_posts()): ?>
        <a href="<?php echo tribe_get_day_link($day['date']) ?>">
            <time datetime="<?php echo $day['date']; ?>"><?php echo $day['daynum'] ?></time>
        </a>

        <!-- Events List -->
        <?php while ($day['events']->have_posts()) : $day['events']->the_post() ?>
            <?php tribe_get_template_part('month/single', 'event') ?>
        <?php endwhile; ?>
    <?php else: ?>
        <a href="#" onclick="return false;">
            <time datetime="<?php echo $day['date']; ?>"><?php echo $day['daynum'] ?></time>
        </a>
    <?php endif; ?>

<?php endif; ?>