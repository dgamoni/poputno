<?php
/**
 * Event Submission Form
 * The wrapper template for the event submission form.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/edit-event.php
 *
 * @package TribeCommunityEvents
 * @since  3.1
 * @author Modern Tribe Inc.
 *
 */

if (!defined('ABSPATH')) {
    die('-1');
} ?>
<div class="wrap cf">
    <div class="post">
        <h1>Добавление события</h1>
        <?php

        //global $wpdb;
        //$post_content = $wpdb->get_var( $wpdb->prepare( "SELECT post_content from $wpdb->posts WHERE post_content LIKE '%%%s%%' AND post_type in ('page')", '[tribe_community_events]' ) );

        //echo $post_content;

        //echo apply_filters('the_content', $post_content); ?>

        <?php tribe_get_template_part('community/modules/header-links'); ?>

        <?php do_action('tribe_events_community_form_before_template'); ?>

        <form method="post" enctype="multipart/form-data" class="test">

            <?php wp_nonce_field('ecp_event_submission'); ?>

            <!-- Event Title -->
            <?php do_action('tribe_events_community_before_the_event_title') ?>

            <div class="events-community-post-title">
                <?php // Validation
                $class = ($_POST && empty($event->post_title)) ? 'error' : ''; ?>
                <label for="post_title"
                       class="<?php echo $class; ?>">
                    <?php _e('Заголовок события:', 'tribe-events-community'); ?>
                    <small class="req" style="color:red;"><?php _e('*', 'tribe-events-community'); ?>
                    </small>
                </label>
                <?php tribe_community_events_form_title(); ?>
            </div>
            <!-- .events-community-post-title -->

            <?php do_action('tribe_events_community_after_the_event_title') ?>


            <!-- Event Description -->
            <?php do_action('tribe_events_community_before_the_content'); ?>

            <div class="events-community-post-content">
                <?php // Validation
                $class = ($_POST && empty($event->post_content)) ? 'error' : ''; ?>
                <label for="post_content"
                       class="<?php echo $class; ?>"><?php _e('Описание события:', 'tribe-events-community'); ?>
                    <small class="req" style="color: red;"><?php _e('*', 'tribe-events-community'); ?></small>
                </label>
                <?php tribe_community_events_form_content(); ?>
            </div>
            <!-- .tribe-events-community-post-content -->

            <?php do_action('tribe_events_community_after_the_content'); ?>



            <?php tribe_get_template_part('community/modules/image'); ?>

            <?php tribe_get_template_part('community/modules/datepickers'); ?>

            <?php tribe_get_template_part('community/modules/venue'); ?>

            <?php tribe_get_template_part('community/modules/organizer'); ?>

            <?php tribe_get_template_part('community/modules/website'); ?>

            <?php tribe_get_template_part('community/modules/custom'); ?>

            <?php tribe_get_template_part('community/modules/cost'); ?>

            <!-- Spam Control -->
            <?php TribeCommunityEvents::instance()->formSpamControl(); ?>

            <!-- Form Submit -->
            <?php do_action('tribe_events_community_before_form_submit'); ?>
            <div class="tribe-events-community-footer tribe-events-community-footer1">
                <input type="submit" id="post" class="button submit events-community-submit" value="<?php

                if ($event->post_title)
                    echo apply_filters('tribe_ce_event_update_button_text', __('Обновить', 'tribe-events-community'));
                else
                    echo apply_filters('tribe_ce_event_submit_button_text', __('Отправить', 'tribe-events-community'));

                ?>" name="community-event"/>
            </div>
            <!-- .tribe-events-community-footer -->
            <?php do_action('tribe_events_community_after_form_submit'); ?>

        </form>
        <?php do_action('tribe_events_community_form_after_template'); ?>
    </div>
    <?php get_sidebar(); ?>
</div>