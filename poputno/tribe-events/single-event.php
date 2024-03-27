<?php

/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @since  2.1
 * @author Modern Tribe Inc.
 *
 */

if (!defined('ABSPATH')) {

    die('-1');

}

$event_id = get_the_ID();

$map = tribe_get_meta('tribe_venue_map');

$event_venue = tribe_get_venue($event_id);

$adress = tribe_get_zip($event_id);
if(tribe_get_country($event_id) == 'Ukraine'){
    $adress .= 'Украина';
} else {
    $adress .= tribe_get_country($event_id);
}


if ($adress)

    $adress .= ', ';

$adress .= tribe_get_city($event_id);

$adress_region = tribe_get_region($event_id);

if ($adress && $adress_region)

    $adress .= ', ';

$adress .= $adress_region;

if ($adress)

    $adress .= ', ';

$adress .= ' ' . tribe_get_address($event_id);

/* ********************************************* */

$phone = tribe_get_phone($event_id);


$url = tribe_get_event_website_url();

if (!$url)

    $url = tribe_get_organizer_website_url();


list($start_date, $start_time) = explode(' ', tribe_get_start_date($event_id));

list($end_date, $end_time) = explode(' ', tribe_get_end_date($event_id));

//var_dump();

list($d, $m, $y) = explode('.', $start_date);

$start_date_str = $d . '<span>.' . $m . '</span>';

//$start_date_timestamp = mktime(0, 0, 0, $m, $d, $y);


if ($start_time) {

    list($hour, $min) = explode(":", $start_time);

    $start_time = $hour . ':<span>' . $min . '</span>';

    //$start_time_timestamp = mktime($hour, $min, 0, $m, $d, $y);

}


if ($end_time) {

    list($hour, $min) = explode(":", $end_time);

    $end_time = $hour . ':<span>' . $min . '</span>';

    //$end_time_timestamp = mktime($hour, $min, 0, $m, $d, $y);

}


list($d, $m, $y) = explode('.', $end_date);

$end_date_str = $d . '<span>.' . $m . '</span>';

//$end_date_timestamp = mktime(0, 0, 0, $m, $d, $y);

$date_str = $start_date_str;


if ($end_date_timestamp > $start_date_timestamp)

    $date_str .= ' - ' . $end_date_str;


$time_str = $start_time;

if ($end_date_timestamp > $start_time_timestamp)

    $time_str .= ' - ' . $end_time;

?>

<?php while (have_posts()) :

the_post(); ?>

<div class="wrap cf">

<div class="post event">

<div class="cal-nav cf">

    <?php if (preg_match('/events/', $_SERVER['HTTP_REFERER'], $match)) {

        $url_back = $_SERVER['HTTP_REFERER'];

    } else {

        $url_bacl = get_bloginfo('url') . '/events/';

    }?>

    <a href="<?php echo get_bloginfo('url') . '/events/'; ?>" class="prev">Вернуться в календарь</a>

</div>

<?php tribe_events_the_notices(); ?>

<h1><?php the_title(); ?></h1>

<aside class="post_meta">

    <div class="post_likes">

        <?php if (get_post_status() == 'publish') { ?>

            <?php content_soc_likes(); ?>

        <?php } ?>

    </div>

</aside>

<div class="event-head">

    <time class="sq" datetime="<?php echo $start_date; ?>">
        <p>Дата</p>
        <?php echo $date_str; ?>
    </time>

    <?php if ($start_time && $end_time) { ?>

        <time class="sq" datetime="<?php echo $time_str; ?>">
            <p>Время</p>
            <?php echo $time_str; ?>
        </time>

    <?php } ?>

    <?php if ($phone) { ?>

        <div class="sq">

            <p>Телефон организатора</p>
            <?php echo $phone; ?>

        </div>

    <?php } ?>

    <?php if ($url) { ?>

        <div class="sq link">

            <p>Сайт</p>

            <a href="<?php echo $url; ?>"><?php echo $url; ?></a>

        </div>

    <?php } ?>

    <?php if ($cost = get_post_meta($event_id, '_EventCost', true)) { ?>

        <div class="sq link">

            <p>Стоимость</p>

            <?php echo $cost . ' ' . get_post_meta($event_id, '_EventCurrencySymbol', true) ?>

        </div>

    <?php } ?>

</div>

<?php if ($event_venue) { ?>

    <div class="ven">Место проведения</div>

    <p><?php echo $event_venue; ?></p>

<?php } ?>

<?php if (!empty($adress)) { ?>

    <address class="address-marker"><?php echo $adress; ?></address>

<?php } ?>

<?php if (get_post_meta($event_id, '_EventShowMap', true)) { ?>
    <div id="g-map" class="g-map">

        <?php echo tribe_get_meta('tribe_venue_map'); ?>
    </div>
<?php } ?>

<div class="txt">

    <?php echo tribe_event_featured_image(); ?>

    <?php the_content(); ?>

</div>

<?php

if (preg_match('/tribe_list/', $_SERVER['HTTP_REFERER'], $match)) {

    ?>

    <div class="cal-nav cf">

        <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="prev">К списку</a>

    </div>

<?php } ?>



<div class="alignleft widget_like">

    <?php footer_soc_likes(); ?>

</div>

<div class="post_ads" style="overflow: hidden;">

    <!-- AIN_728x90 -->

    <div id='div-gpt-ad-1348523472889-0' style='width:728px; height:90px;'>

        <script type='text/javascript'>

            // googletag.cmd.push(function () {

            //     googletag.display('div-gpt-ad-1348523472889-0');

            // });

        </script>

    </div>

</div>


<section class="comment_box wrap cf" id="comments-box">

    <div class="comment_list column_c233" onclick="return false;">

        <div class="widget_orphus" onclick="return false;" style="clear: left;">


            <div class="orfus">

                        <span class="orf">

                            Заметили ошибку? Выделите ее и нажмите Ctrl+Enter, чтобы сообщить нам.

                        </span>


                <div style="display:none;">

                    <script type="text/javascript" src="/orphus/orphus.js"></script>

                    <a href="http://orphus.ru" id="orphus" target="_blank" title="undefined">

                        <img alt="Система Orphus" src="/orphus/orphus.gif" border="0" width="257" height="48"></a>

                </div>


            </div>

        </div>



        <?php if (get_post_status() == 'publish') : ?>

            <noindex><?php comments_template('', true); ?></noindex>

        <?php endif; ?>

    </div>


</section>

</div>

<?php if (get_post_type() == TribeEvents::POSTTYPE && tribe_get_option('showComments', 'no') == 'yes') {

    comments_template();

} ?>

<?php endwhile; ?>

<?php get_sidebar(); ?>

</div>