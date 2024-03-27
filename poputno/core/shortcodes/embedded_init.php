<?php
//
//add_action('init', 'embed_shortcode_button_init');
function embed_shortcode_button_init()
{

    if (!current_user_can('edit_posts') && !current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
        return;

    add_filter("mce_external_plugins", "embed_register_tinymce_plugin");

    add_filter('mce_buttons', 'embed_add_tinymce_button');
}

function embed_register_tinymce_plugin($plugin_array)
{
    $plugin_array['embed_button'] = CORE_URL . '/shortcodes/embed/js/shortcode.js';
    return $plugin_array;
}

function embed_add_tinymce_button($buttons)
{
    $buttons[] = "embed_button";
    return $buttons;
}