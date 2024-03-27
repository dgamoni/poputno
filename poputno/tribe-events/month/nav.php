<?php
/**
 * Month View Nav Template
 * This file loads the month view navigation.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/month/nav.php
 *
 * @package TribeEventsCalendar
 * @since  3.0
 * @author Modern Tribe Inc.
 *
 */

if (!defined('ABSPATH')) {
    die('-1');
} ?>

<?php do_action('tribe_events_before_nav') ?>

<span class="tribe-events-nav-previous">
<a href="<?php echo tribe_get_previous_month_link(); ?>" class="prev-month">
    <?php
    echo tribe_get_previous_month_text();
    ?>
</a>
</span>

<span class="tribe-events-nav-next">
<a href="<?php echo tribe_get_next_month_link(); ?>" class="next-month">
    <?php echo tribe_get_next_month_text(); ?>
</a>
</span>

<div class="month-name"><?php if (tribe_is_month()) {
        echo sprintf(__('%s', 'tribe-events-calendar'),
            date_i18n('F Y', strtotime(tribe_get_month_view_date()))
        );
    } ?></div>

<?php //do_action('tribe_events_after_nav') ?>
