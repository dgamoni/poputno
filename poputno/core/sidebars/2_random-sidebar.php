<?php

function ain_random_sidebar_init()
{
    register_sidebar(array(
        'name' => 'Сайдбар',
        'id' => 'primary-widget-area',
        'description' => 'Правый сайдбар',
        'before_widget' => '<div id="%1$s" class="widget widget_list">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget_header"><span>',
        'after_title' => '</span></div>',
    ));

    // register_sidebars(9, array(
    //     'name' => 'Рэндом сайдбар %d',
    //     'id' => 'secondary-widget-area',
    //     'description' => 'Sidebar with random widgets',
    //     'before_widget' => '<div id="%1$s" class="widget widget_list">',
    //     'after_widget' => '</div>',
    //     'before_title' => '<div class="widget_header"><span>',
    //     'after_title' => '</span></div>',
    // ));
}
add_action( 'widgets_init', 'ain_random_sidebar_init' );
