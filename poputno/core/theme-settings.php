<?php

function ain_remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'ain_remove_recent_comments_style' );

// Отлючаем обновление тем
//remove_action('load-update-core.php', 'wp_update_themes');
//add_filter('pre_site_transient_update_themes', create_function('$a', "return null;"));

// Отключаем обновление плагинов
//remove_action('load-update-core.php', 'wp_update_plugins');
//add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;"));
