<?php
/**
 * Delete Event Module
 * This is used to delete a user submitted event.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/delete.php
 *
 * @package TribeCommunityEvents
 * @since  2.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

?>


    <section class="main" id="main">

        <div class="wrap cf">

            <div class="calendar-content cabinet">
                <h1>Событие успешно удалено</h1>
                Ваше событие было удалено успешно.
                <br><br>
                <a href="/cabinet" style="color: #dc4536;">Вернуться в личный кабинет</a>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </section>