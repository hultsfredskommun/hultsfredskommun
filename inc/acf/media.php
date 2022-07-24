<?php

	/* media / attachment */
	register_field_group(array (
		'id' => 'acf_media',
		'title' => 'Media',
		'fields' => array (
			array (
				'key' => 'field_52d8166aeb5a4',
				'label' => 'Fotograf / källa',
				'name' => 'source',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'ef_media',
					'operator' => '==',
					'value' => 'all',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));