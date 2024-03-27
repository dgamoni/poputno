<?php

/**
 * List View Template
 * The wrapper template for a list of events. This includes the Past Events and Upcoming Events views
 * as well as those same views filtered to a specific category.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list.php
 *
 * @package TribeEventsCalendar
 * @since  2.1
 * @author Modern Tribe Inc.
 *
 */



if (!defined('ABSPATH')) {

    die('-1');

} ?>





<div class="wrap cf">

    <div class="calendar-content">

        <div class="vac-head cf bb">

            <h3 class="lefter">Календарь мероприятий</h3>
             
            <a href="/add_event" class="add_vacancy">Добавить мероприятие</a>


            <?php

            if (preg_match('/events/', $_SERVER['HTTP_REFERER'], $match)) {

                $url = $_SERVER['HTTP_REFERER'];

            } else {

                $url = '/events';

            }

            ?>

            <a href="<?php echo $url; ?>" class="cal_back"><span>&#8249;</span> Календарь</a>

        </div>



        <?php do_action('tribe_events_before_template'); ?>



        <!-- Tribe Bar -->

        <?php //tribe_get_template_part('modules/bar'); ?>

        <br><br>

        <!-- Main Events Content -->

        <?php tribe_get_template_part('list/content'); ?>
     

        <div class="tribe-clear"></div>



        <?php do_action('tribe_events_after_template') ?>

<!--   <div class="post_ads">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/adspost.jpg" alt="">
            </div> -->

    </div>


    <?php get_sidebar(); ?>



</div>