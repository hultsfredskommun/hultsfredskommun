<?php
/* category filter and show children settings */
acf_add_local_field_group(array (
	'key' => 'group_590855185bb8d',
	'title' => 'Avancerade inställningar',
	'fields' => array (
		array (
			'key' => 'field_5940f55002803',
			'label' => 'Visa underliggande kategorier',
			'name' => 'category_show_children',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_5908553a80e22',
			'label' => 'Använd som filter',
			'name' => 'category_as_filter',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_5940f55002803',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'category',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));
