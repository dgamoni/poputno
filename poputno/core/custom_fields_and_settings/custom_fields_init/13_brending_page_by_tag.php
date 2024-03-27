<?php
if (function_exists("register_options_page")) {

    $id = 13;

    register_field_group(array(
        'id' => $id,
        'title' => 'Настройки брендинга',
        'fields' =>
            array(
                1 =>
                    array(
                        'key' => 'field_' . $id . '_1',
                        'label' => 'Показывать администратору',
                        'name' => 'brending_pages_show_only_admin',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => '0',
                        'default_value' => '',
                        'formatting' => '',
                        'order_no' => 1,
                    ),
                2 =>
                    array(
                        'key' => 'field_' . $id . '_2',
                        'label' => 'Тег',
                        'name' => 'brending_pages_tag_slug',
                        'type' => 'text',
                        'instructions' => '',
                        'column_width' => '',
                        'default_value' => '',
                        'formatting' => 'html',
                        'order_no' => 2,
                    ),
                3 =>
                    array(
                        'key' => 'field_' . $id . '_3',
                        'label' => 'Включить сайдбар',
                        'name' => 'brending_pages_enable_sidebar',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => '0',
                        'default_value' => '',
                        'formatting' => '',
                        'order_no' => 3,
                    ),
                4 =>
                    array(
                        'key' => 'field_' . $id . '_4',
                        'label' => 'Фоновое изображение',
                        'name' => 'brending_pages_background_image',
                        'type' => 'image',
                        'instructions' => '',
                        'column_width' => '',
                        'default_value' => '',
                        'preview_size' => 'large',
                        'order_no' => 4,
                    ),
                5 =>
                    array(
                        'key' => 'field_' . $id . '_5',
                        'label' => 'Фоновый цвет',
                        'name' => 'brending_pages_background_color',
                        'type' => 'color_picker',
                        'instructions' => '',
                        'default_value' => '',
                        'order_no' => 5,
                    ),
                6 =>
                    array(
                        'key' => 'field_' . $id . '_6',
                        'label' => 'Ссылка',
                        'name' => 'brending_pages_link',
                        'type' => 'text',
                        'instructions' => '',
                        'column_width' => '',
                        'default_value' => '',
                        'formatting' => 'html',
                        'order_no' => 6,
                    ),
                7 =>
                    array(
                        'key' => 'field_' . $id . '_7',
                        'label' => 'Высота линка',
                        'name' => 'brending_pages_link_height',
                        'type' => 'number',
                        'instructions' => '',
                        'column_width' => '',
                        'default_value' => '',
                        'formatting' => 'html',
                        'order_no' => 7,
                    ),
                8 =>
                    array(
                        'key' => 'field_' . $id . '_8',
                        'label' => 'Отступ сверху',
                        'name' => 'brending_pages_top_margin',
                        'type' => 'number',
                        'instructions' => '',
                        'column_width' => '',
                        'default_value' => '',
                        'formatting' => 'html',
                        'order_no' => 8,
                    ),
                9 =>
                    array(
                        'key' => 'field_' . $id . '_9',
                        'label' => 'Фиксировать фон',
                        'name' => 'brending_pages_background_fixed',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => '0',
                        'default_value' => '',
                        'formatting' => '',
                        'order_no' => 9,
                    ),
            ),
        'location' =>
            array(
                'rules' =>
                    array(
                        0 =>
                            array(
                                'param' => 'page_template',
                                'operator' => '==',
                                'value' => 'templates/spec-project-brending.php',
                                'order_no' => 0,
                            ),
                        1 =>
                            array(
                                'param' => 'page_template',
                                'operator' => '==',
                                'value' => 'templates/brand2.php',
                                'order_no' => 0,
                            ),

                    ),
                'allorany' => 'all',
            ),
        'options' =>
            array(
                'position' => 'normal',
                'layout' => 'default',
                'hide_on_screen' =>
                    array(),
            ),
        'menu_order' => 0,
    ));

}