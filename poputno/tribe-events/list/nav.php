<?php
/**
 * List View Nav Template
 * This file loads the list view navigation.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/nav.php
 *
 * @package TribeEventsCalendar
 * @since  3.0
 * @author Modern Tribe Inc.
 *
 */

if (!defined('ABSPATH')) {
    die('-1');
} ?>

<ul class="tribe-events-sub-nav">
    <!-- Left Navigation -->
    <?php if (tribe_is_past()) : ?>
        <li class="tribe-events-nav-next tribe-events-nav-left tribe-events-past cal-nav cf">
            <?php if (get_next_posts_link()) : ?>
                <a class="prev"
                   href="<?php tribe_get_past_link() ?>"><?php _e('Предыдущие события', 'tribe-events-calendar') ?></a>
            <?php endif; ?>
        </li><!-- .tribe-events-nav-previous -->
    <?php elseif (tribe_is_upcoming()) : ?>
        <?php if (get_previous_posts_link()) : ?>
            <li class="tribe-events-nav-previous tribe-events-nav-left cal-nav cf">
            <a class="prev" href="<?php echo tribe_get_upcoming_link() ?>"
               rel="pref"><?php _e('Предыдущие события', 'tribe-events-calendar') ?></a>
        <?php else : ?>
            <li class="tribe-events-nav-previous tribe-events-nav-left tribe-events-past cal-nav cf">
            <a class="prev" href="<?php echo tribe_get_past_link() ?>"
               rel="pref"><?php _e('Предыдущие события', 'tribe-events-calendar') ?></a>
        <?php endif; ?>
        </li><!-- .tribe-events-nav-previous -->
    <?php endif; ?>

    <!-- Right Navigation -->
    <?php if (tribe_is_past()) : ?>
        <?php if (get_query_var('paged') > 1) : ?>
            <li class="tribe-events-nav-previous tribe-events-nav-right tribe-events-past cal-nav cf">
            <a class="next" href="<?php echo tribe_get_past_link() ?>"
               rel="pref"><?php _e('Следующие события', 'tribe-events-calendar') ?></a>
        <?php elseif (!get_previous_posts_link()) : ?>
            <li class="tribe-events-nav-previous tribe-events-nav-right cal-nav cf">
            <a class="next" href="<?php echo tribe_get_upcoming_link() ?>"
               rel="next"><?php _e('Следующие события', 'tribe-events-calendar') ?></a>
        <?php endif; ?>
        </li><!-- .tribe-events-nav-previous -->
    <?php elseif (tribe_is_upcoming()) : ?>
        <li class="tribe-events-nav-next tribe-events-nav-right cal-nav cf">
            <?php if (get_next_posts_link()) : ?>
                <a class="next" href="<?php echo tribe_get_upcoming_link() ?>"
                   rel="next"><?php _e('Следующие события', 'tribe-events-calendar') ?></a>
            <?php endif; ?>
        </li><!-- .tribe-events-nav-previous -->
    <?php endif; ?>
</ul>