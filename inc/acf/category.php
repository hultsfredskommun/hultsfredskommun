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
		array(
			'key' => 'field_63ac86b706008',
			'label' => 'Visa datum',
			'name' => 'visa_datum',
			'aria-label' => '',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_63ac86db06009',
			'label' => 'Sortering',
			'name' => 'sortering',
			'aria-label' => '',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'Mest klickad (standard)',
				'date_asc' => 'Datum äldst först',
				'date_desc' => 'Datum nyast först',
				'alpha_asc' => 'Alfabetisk A till Ö',
				'alpha_desc' => 'Alfabetisk Ö till A',
			),
			'default_value' => 'none',
			'return_format' => 'value',
			'multiple' => 0,
			'allow_null' => 0,
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
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
