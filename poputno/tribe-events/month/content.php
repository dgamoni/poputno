<?php
/**
 * Month View Content Template
 * The content template for the month view of events. This template is also used for
 * the response that is returned on month view ajax requests.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/month/content.php
 *
 * @package TribeEventsCalendar
 * @since  3.0
 * @author Modern Tribe Inc.
 *
 */

if (!defined('ABSPATH')) {
    die('-1');
} ?>
<div class="wrap">
    <div class="vac-head cf">
        <!-- Month Title -->
        <?php do_action('tribe_events_before_the_title') ?>
        <h1 class="lefter">Календарь мероприятий</h1>
        <a href="/add_event" class="add_vacancy">Добавить мероприятие</a>
    </div>
    <div class="calendar">
        <?php do_action('tribe_events_after_the_title') ?>

        <!-- Notices -->
        <?php tribe_events_the_notices() ?>

        <!-- Month Header -->
        <?php //do_action('tribe_events_before_header') ?>

        <div class="cal-head">
            <!-- Header Navigation -->
            <?php tribe_get_template_part('month/nav'); ?>
        </div>

        <!-- #tribe-events-header -->
        <?php //do_action('tribe_events_after_header') ?>

        <!-- Month Grid -->
        <?php tribe_get_template_part('month/loop', 'grid') ?>

        <!-- Month Footer -->
        <div class="cal-head" id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
            <?php tribe_get_template_part('month/nav_footer'); ?>
        </div>

        <!-- #tribe-events-footer -->
        <?php //do_action('tribe_events_after_footer') ?>

    </div>
</div>
