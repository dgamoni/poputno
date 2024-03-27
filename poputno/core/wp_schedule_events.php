<?php
add_action('wp', 'rss_get_counters_setup_schedule');

function rss_get_counters_setup_schedule()
{
    if (!wp_next_scheduled('rss_get_counters_daily_event')) {
        wp_schedule_event(time(), 'daily', 'rss_get_counters_daily_event');
    }
}


add_action('rss_get_counters_daily_event', 'rss_get_counters_do_this_daily');

function rss_get_counters_do_this_daily()
{
    $count = get_abbyy_cloud_ocr();
    update_option('rss_followers_count', $count);
}