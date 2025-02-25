<?php

/**

 * Edit Venue Form

 * This is used to edit an event venue.

 *

 * Override this template in your own theme by creating a file at

 * [your-theme]/tribe-events/community/edit-venue.php

 *

 * @package TribeCommunityEvents

 * @since  3.1

 * @author Modern Tribe Inc.

 *

 */



if ( !defined('ABSPATH') ) { die('-1'); } ?>



<?php tribe_get_template_part( 'community/modules/header-links' ); ?>



<form method="post" class="add_event_form">



	<?php wp_nonce_field( 'ecp_venue_submission' ); ?>



	<!-- Venue Title -->

	<?php $venue_name = esc_attr( tribe_get_venue() ); ?>

	<div class="events-community-post-title">

		<label for="post_title" class="<?php echo ( $_POST && empty( $venue_name ) ) ? 'error' : ''; ?>">

			<?php _e( 'Venue Name:', 'tribe-events-community' ); ?>

			<small class="req"><?php _e( '(required)', 'tribe-events-community' ); ?></small>

		</label>

		<input type="text" name="post_title" value="<?php echo $venue_name; ?>"/>



	</div><!-- .events-community-post-title -->



	<!-- Venue Description -->

	<div class="events-community-post-content">



		<label for="post_content">

			<?php _e( 'Venue Description:', 'tribe-events-community' ); ?>

			<small class="req"></small>

		</label>



		<?php // if admin wants rich editor (and using WP 3.3+) show the WYSIWYG, otherwise default to a textarea

		$content = tribe_community_events_get_venue_description();

		if(TribeCommunityEvents::instance()->useVisualEditor && function_exists( 'wp_editor')) {

			$settings = array(

				'wpautop' => true,

				'media_buttons' => false,

				'editor_class' => 'frontend',

				'textarea_rows' => 5,

			);

			echo wp_editor( $content, 'tcepostcontent', $settings );

		} else {

			echo '<textarea name="tcepostcontent">'. esc_textarea( $content ) .'</textarea>';

		} ?>



	</div><!-- .events-community-post-content -->



	<?php tribe_get_template_part( 'community/modules/venue' ); ?>



	<!-- Form Submit -->

	<div class="tribe-events-community-footer tribe-events-community-footer1">



		<input type="submit" class="button submit events-community-submit" value="<?php

			echo ( $post->ID ) ? __( 'Update Venue', 'tribe-events-community' ) : __( 'Submit Venue', 'tribe-events-community' );

		?>" name="community-event" />



	</div><!-- .tribe-events-community-footer -->



</form>

