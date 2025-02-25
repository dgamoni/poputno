<?php
$prefix = 'uni_';

//
$slider_box = array(
    'id' => 'uni-slider-meta-box',
    'title' => 'Избранное',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Добавить пост в избранные?',
            'desc' => '',
            'id' => $prefix . 'slider_on',
            'type' => 'checkbox',
            'std' => ''
        )
    )
);

add_action('admin_menu', 'mytheme_slider_add_box');

//Додаємо мета бокс
function mytheme_slider_add_box() {
    global $slider_box;
    add_meta_box($slider_box['id'], $slider_box['title'], 'mytheme_slider_box', 'post', $slider_box['context'], $slider_box['priority']);
}

//Відображаємо мета бокс
function mytheme_slider_box() {
    global $slider_box, $post;

    echo '<input type="hidden" name="mytheme_slider_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($slider_box['fields'] as $field) {

        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
        }
        echo     '<td>',
            '</tr>';
    }

    echo '</table>';
}

//Зберігаємо дані полів мета бокса при збереженні допису
add_action('save_post', 'mytheme_save_slider_data');

// Save data from meta box
function mytheme_save_slider_data($post_id) {
    global $slider_box;

    // verify nonce
    if (!wp_verify_nonce($_POST['mytheme_slider_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($slider_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

?>