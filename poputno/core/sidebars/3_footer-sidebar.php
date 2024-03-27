<?php

function ain_footer_sidebar_init()
{
    register_sidebar(array(
        'name' => 'Футер',
        'id' => 'right-footer-widget-area',
        'description' => 'Правая колонка футера',
        'before_widget' => '<div id="%1$s" class="widget widget_list">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget_header"><span>',
        'after_title' => '</span></div>',
    ));
}

add_action('widgets_init', 'ain_footer_sidebar_init');
