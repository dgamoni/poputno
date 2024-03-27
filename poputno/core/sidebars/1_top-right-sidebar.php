<?php

function ain_top_sidebar_init()
{
    register_sidebar(array(
        'name' => 'Хедер справа',
        'id' => 'right-top-widget-area',
        'description' => 'Правый блок хедера',
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'ain_top_sidebar_init');
