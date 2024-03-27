<?php
// Подключаем миниатюры
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}

// Задаем названия и размеры миниатюр
add_image_size('ain-thumb-widget-important', 240, 140, true);
add_image_size('ain-small-widget', 50, 50, true);
add_image_size('ain-related-post', 180, 120, true);
add_image_size('ain-post', 300, 190, true);
add_image_size('ain-post-not-excerpt', 300, 300, true);
add_image_size('fresh_latest_post', 460, 250, true);

