<?php
/**
 * Header links for edit forms.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/header-links.php
 *
 * @package TribeCommunityEvents
 * @since  3.1
 * @author Modern Tribe Inc.
 *
 */

if (!defined('ABSPATH')) {
    die('-1');
}
$current_user = wp_get_current_user();

if (is_user_logged_in() && isset($_POST['post_title'])) {

//    echo '<div id="my-events"><a href="/cabinet" class="button">'. __( 'Мои события', 'tribe-events-community' ) .'</a></div>';
//	echo '<div style="clear:both"></div>';

    ?>

    <script>
       jQuery('.post').removeClass('post');
    </script>


    <section class="main" id="main">

        <div class="wrap cf" style="padding-top:0;">

            <div class="calendar-content cabinet">
                <h2 style="margin-bottom:20px; margin-top: 30px;">Событие сохранено</h2>
                Данные были успешно сохранены.
                <br><br>
                <a class="red-btn" href="/cabinet" style="margin-top:10px; display: inline-block;">Вернуться в личный кабинет</a>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </section>
<?

}

//echo tribe_community_events_get_messages();
?>
