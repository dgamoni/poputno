<?php
if (function_exists("register_options_page")) {
    $slug = 'home-settings';
    $id = 12;
    register_options_page('Реклама', $slug);
    register_field_group(array(
        'id' => $id,
        'title' => 'Настройки',
        'fields' =>
            array(
                /*
                0 =>
                    array(
                        'key' => 'field_' . $id . '_1',
                        'label' => 'Включить рекламный пост на главной',
                        'name' => 'home_4_block_enable',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => '0',
                        'default_value' => '',
                        'formatting' => '',
                        'order_no' => 1,
                    ),*/
                /*1 => array(
                    'key' => 'field_' . $id . '_2',
                    'label' => 'Изображение рекламного поста',
                    'name' => 'home_4_block_ads_image',
                    'type' => 'image',
                    'instructions' => '',
                    'preview_size' => 'large',
                    'default_value' => '',
                    'formatting' => '',
                    'order_no' => 2,
                ),*/
                2 => array(
                    'key' => 'field_' . $id . '_3',
                    'label' => 'Код рекламы для блока с работой и событиями',
                    'name' => 'works_and_events_adv',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => '0',
                    'default_value' => '',
                    'formatting' => '',
                    'order_no' => 2,
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