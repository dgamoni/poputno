<?php
if (function_exists("register_options_page")) {
    $slug = 'header-settings';
    $id = 10;
    register_options_page('Настройка Шапки сайта', $slug);
    register_field_group(array(
        'id' => $id,
        'title' => 'Настройка Шапки сайта',
        'fields' =>
            array(
                0 => array(
					'key' => 'field_535fbe32cfc7d',
					'label' => 'Реклама в шапке',
					'name' => 'head_adv',
					'type' => 'textarea',
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'formatting' => 'html',
                ),
            ),
        'location' =>
            array(
                'rules' =>
                    array(
                        0 =>
                            array(
                                'param' => 'options_page',
                                'operator' => '==',
                                'value' => $slug,
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