<?php

/**

 * Event Submission Form Price Block

 * Renders the pricing fields in the submission form.

 *

 * Override this template in your own theme by creating a file at

 * [your-theme]/tribe-events/community/modules/cost.php

 *

 * @package TribeCommunityEvents

 * @since  3.1

 * @author Modern Tribe Inc.

 *

 */



if ( !defined('ABSPATH') ) { die('-1'); }



?>



<!-- Event Cost -->

<?php do_action( 'tribe_events_community_before_the_cost' ); ?>



<div class="tribe-events-community-details eventForm " id="event_cost">



	<table class="" cellspacing="0" cellpadding="0">



		<tr>

			<td colspan="2" class="tribe_sectionheader">

				<h4><?php _e('Стоимость события', 'tribe-events-calendar'); ?></h4>

			</td><!-- .tribe_sectionheader -->

		</tr>

		<tr>

			<td>

				<label for="EventCurrencySymbol">

					<?php _e('Валюта','tribe-events-calendar'); ?>:

				</label>
				<input type='text' id="EventCurrencySymbol" name="EventCurrencySymbol" size="2" value="<?php tribe_community_events_form_currency_symbol(); ?>" />

			</td>

			<td>

				<label for="EventCost">

					<?php _e('Стоимость','tribe-events-calendar'); ?>:

				</label>
				<input type='text' id="EventCost" name="EventCost" size="6" value="<?php echo (isset($_POST['EventCost'])) ? esc_attr($_POST['EventCost']) : tribe_get_cost(); ?>" />

			</td>

		</tr>

	

		<tr>

			<td></td>

			<td><small><?php _e('Оставьте пустым, чтобы скрыть поле. Введите 0 для событий, которые бесплатные.', 'tribe-events-calendar'); ?></small></td>

		</tr>



	</table><!-- #event_cost -->



</div><!-- .tribe-events-community-details -->



<?php do_action( 'tribe_events_community_after_the_cost' ); ?>