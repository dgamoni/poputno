<?php

$start_date = tribe_get_start_date($post->ID, false);
list($d, $m, $y) = explode('.', $start_date);

?>
<div class="vac-item">
    <time datetime="<?php echo $start_date; ?>">
        <?php echo $d; ?><span>.<?php echo $m; ?></span>
    </time>
    <div class="comp-txt cf">
        <?php
        $canEdit = current_user_can('edit_post', $post->ID);
        $canDelete = current_user_can('delete_post', $post->ID);
        if ($canEdit) {
            ?>
            <div class="">
                <h4>
                    <a target="_blank"
                       href="<?php echo tribe_get_event_link($post); ?>"><?php echo $post->post_title; ?></a>
                </h4>

                <div class="comp-venue">
                    <?php if (tribe_has_venue($post->ID)) {
                        $venue_id = tribe_get_venue_id($post->ID);
                        if (current_user_can('edit_post', $venue_id)) {
                            echo '<a href="' . TribeCommunityEvents::instance()->getUrl('edit', $venue_id, null, TribeEvents::VENUE_POST_TYPE) . '">' . tribe_get_venue($post->ID) . '</a>';
                        } else {
                            echo tribe_get_venue($post->ID);
                        }
                    } ?>
                </div>
            </div>
        <?php
        } else {
            echo $post->post_title;
        } ?>
        <div class="row-actions">
							<span class="view">
								<a target="_blank"
                                   href="<?php echo tribe_get_event_link($post); ?>"><?php _e('Просмотр', 'tribe-events-community'); ?></a>
							</span>
            <?php if ($canEdit) {
                //echo TribeCommunityEvents::instance()->getEditButton($post, 'Редактировать', '<span class="edit wp-admin events-cal"> |', '</span> ');
                echo ' | <a href="' . tribe_community_events_edit_event_link($post->ID) . '">Редактировать</a>';
            }
            if ($canDelete) {
                echo str_replace('Delete', 'Удалить', TribeCommunityEvents::instance()->getDeleteButton($post));
            } ?>
        </div>
        <!-- .row-actions -->

        <div
            class="status"><?php echo TribeCommunityEvents::instance()->getEventStatusIcon($post->post_status); ?></div>
    </div>


</div>
