<?php
// Установка меню
if (function_exists('register_nav_menu')) {
    register_nav_menus( array( 'general' => 'Основное меню', ) );
    register_nav_menus( array( 'primary' => 'Меню в шапке', ) );
    register_nav_menus( array( 'secondary' => 'Подменю', ) );
    register_nav_menus( array( 'footer' => 'Меню в подвале', ) );
}