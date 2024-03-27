<?php
	$id = 3;
	register_field_group( array(
		                      'id'         => $id,
		                      'title'      => 'Параметры',
		                      'fields'     => array(
			                      4 => array(
				                      'key'           => 'field_' . $id . '_4',
				                      'label'         => 'Добавить пост в избранное',
				                      'name'          => 'uni_slider_on',
				                      'type'          => 'true_false',
				                      'instructions'  => '',
				                      'required'      => '0',
				                      'default_value' => '',
				                      'formatting'    => '',
				                      'order_no'      => 4,
			                      ),
		                      ),
		                      'location'   => array(
			                      'rules'    => array(
				                      0 => array(
					                      'param'    => 'post_type',
					                      'operator' => '==',
					                      'value'    => 'post',
					                      'order_no' => 0,
				                      ),
			                      ),
			                      'allorany' => 'all',
		                      ),
		                      'options'    => array(
			                      'position'       => 'normal',
			                      'layout'         => 'default',
			                      'hide_on_screen' => array(),
		                      ),
		                      'menu_order' => 0,
	                      ) );

	// Слайдер

	$i      = 0;
	$id     = 3;
	$args   = array();
	$fields = array();

	$args['title'] = 'Платный пост';

	$fields[] = array(
		'key'           => 'field_' . $id . '_' . ++$i,
		'label'         => 'Включить',
		'name'          => 'paid_post',
		'type'          => 'true_false',
		'instructions'  => '',
		'required'      => '0',
		'default_value' => '',
		'formatting'    => '',
	);
	$fields[] = array(
		'key'           => 'field_' . $id . '_' . ++$i,
		'label'         => 'Отключить рекламу',
		'name'          => 'paid_post_disable_ads',
		'type'          => 'true_false',
		'instructions'  => '',
		'required'      => '0',
		'default_value' => '',
		'formatting'    => '',
	);


	$args['fields']   = $fields;
	$args['location'] = array(
		'rules'    => array(
			0 => array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'post',
				'order_no' => 0,
				'group_no' => 1
			),
		),
		'allorany' => 'all',
	);

	$args['options']    = array(
		'position'       => 'normal',
		'layout'         => 'default',
		'hide_on_screen' => array(),
	);
	$args['menu_order'] = 0;

	register_field_group( $args );
