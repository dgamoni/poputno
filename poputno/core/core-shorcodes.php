<?php
//
function uni_twitter_blockquote_shortcode($atts, $content = null)
{
    $return = '<blockquote class="twi-bq"><p>';
    $return .= $content;
    $return .= '</p>';
    $return .= '<a rel="nofollow" class="quote-twitter" href="https://twitter.com/intent/tweet?url=' . urlencode(get_permalink($post->ID)) . '&amp;text=' . uni_onefourty_truncate_text($content, 140, get_permalink($post->ID)) . '">Твитнуть</a>';
    $return .= '</blockquote>';
    return $return;
}

//add_shortcode('blockquote', 'uni_twitter_blockquote_shortcode');


function UniRandomEvents($atts, $content = null)
{
    global $post;
    extract(shortcode_atts(array('count' => '6'), $atts));

    $sWeekTimestamp = time() + (60 * 60 * 24 * 30);
    $sToday = date('Y-m-d H:i:s', time());
    $sNextWeek = date('Y-m-d H:i:s', $sWeekTimestamp);

    $args = array(
        'post_type' => 'tribe_events',
        'posts_per_page' => 6,
        'post__not_in' => array($post->ID),
        /*
        'meta_query' => array(
                            array (
                                'key' => '_EventStartDate',
                                'value' => array( $sToday, $sNextWeek ),
                                'type' => 'DATETIME',
                                'compare' => 'BETWEEN'
                            ),
                            array (
                                'key' => '_EventEndDate',
                                'value' => array( $sToday, $sNextWeek ),
                                'type' => 'DATETIME',
                                'compare' => 'BETWEEN'
                            )
        )
        */

    );
    $recent_events_query = new WP_Query($args);

    $output = '<div id="uni_recent_events">
<h4>Ближайшие <a href="http://ain.ua/events">мероприятия</a></h4>
<ul>';

    while ($recent_events_query->have_posts()) : $recent_events_query->the_post();
        $post = $recent_events_query->post;
        $sUnixStartTime = strtotime(get_post_meta($post->ID, '_EventStartDate', true));
        $sStartDay = dateToRussian(date('d ', $sUnixStartTime));
        $sStartDate = dateToRussian(date('F ', $sUnixStartTime));

        $output .= '
<li>
<div class="uni_event_date"><span>' . $sStartDay . '</span>' . $sStartDate . '</div>
<a class="uni_event_title" href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '">' . get_the_title() . '
</a></li>';


    endwhile;

    $output .= '</ul><div class="clearfix"></div></div>';

    wp_reset_query();

    return $output;
}

add_shortcode('recent_events', 'UniRandomEvents');

