<?php

/**
 * Event Submission Form Metabox For Datepickers
 * This is used to add a metabox to the event submission form to allow for choosing the
 * event time and day.
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/datepickers.php
 *
 * @package TribeCommunityEvents
 * @since  3.1
 * @author Modern Tribe Inc.
 *

 */


if (!defined('ABSPATH')) {
    die('-1');
}


if (get_post()) {

    $all_day = tribe_community_events_is_all_day();

    $start_date = tribe_community_events_get_start_date();

    $end_date = tribe_community_events_get_end_date();

} else {

    $all_day = !empty($_POST['EventAllDay']);

    $start_date = isset($_POST['EventStartDate']) ? esc_attr($_POST['EventStartDate']) : tribe_community_events_get_start_date();

    $end_date = isset($_POST['EventEndDate']) ? esc_attr($_POST['EventEndDate']) : tribe_community_events_get_end_date();

}

?>

    <!-- Event Date Selection -->

<?php do_action('tribe_events_community_before_the_datepickers'); ?>



    <div class="tribe-events-community-details eventForm " id="event_datepickers">


        <table class="" cellspacing="0" cellpadding="0">


            <tr>

                <td colspan="2" class="tribe_sectionheader">

                    <h4 class="event-time"><?php _e('Дата и Время события', 'tribe-events-community'); ?></h4>

                </td>
                <!-- .tribe_sectionheader -->

            </tr>


            <tr id="recurrence-changed-row">

                <td colspan="2">

                    <?php _e('You have changed the recurrence rules of this event. Saving the event will update all future events.  If you did not mean to change all events, then please refresh the page.', 'tribe-events-community'); ?>

                </td>

            </tr>
            <!-- #recurrence-changed-row -->


            <tr>

                <td colspan="2"><input type="checkbox" id="allDayCheckbox" name="EventAllDay"
                                       value="yes" <?php echo ($all_day) ? 'checked' : ''; ?> /><?php _e('Событие на весь день', 'tribe-events-community'); ?>
                </td>


            </tr>


            <tr>

                <td colspan="2">

                    <label><?php _e('Дата / Время начала:', 'tribe-events-community'); ?></label>
                    <input autocomplete="off" type="text" id="EventStartDate" class="datepicker" name="EventStartDate"
                           value="<?php echo $start_date; ?>"/>

                    <span class="helper-text hide-if-js"><?php _e('YYYY-MM-DD', 'tribe-events-community'); ?></span>

			<span class="timeofdayoptions">

				Время: <?php echo tribe_community_events_form_start_time_selector(); ?>

			</span><!-- .timeofdayoptions -->

                </td>


            </tr>


            <?php /*
		<tr>

			<td colspan="2"><label><?php _e( 'Дата / Время завершения:', 'tribe-events-community' ); ?></label>
				<input autocomplete="off" type="text" id="EventEndDate" class="datepicker" name="EventEndDate" value="<?php echo $end_date; ?>" />

				<span class="helper-text hide-if-js"><?php _e( 'YYYY-MM-DD', 'tribe-events-community' ); ?></span>

			<span class="timeofdayoptions">

				@ <?php echo tribe_community_events_form_end_time_selector(); ?>

			</span><!-- .timeofdayoptions -->


			</td>

		

		</tr>
*/
            ?>


            <?php do_action('tribe_events_date_display', null, true); ?>


        </table>
        <!-- .tribe-community-event-info -->


    </div>



<?php do_action('tribe_events_community_after_the_datepickers'); ?>