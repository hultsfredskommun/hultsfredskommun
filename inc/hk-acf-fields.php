<?php
/**
 * Activate Add-ons
 * Here you can enter your activation codes to unlock Add-ons to use in your theme. 
 * Since all activation codes are multi-site licenses, you are allowed to include your key in premium themes. 
 * Use the commented out code to update the database with your activation code. 
 * You may place this code inside an IF statement that only runs on theme activation.
 */ 
 
// if(!get_option('acf_repeater_ac')) update_option('acf_repeater_ac', "xxxx-xxxx-xxxx-xxxx");
// if(!get_option('acf_options_page_ac')) update_option('acf_options_page_ac', "xxxx-xxxx-xxxx-xxxx");
// if(!get_option('acf_flexible_content_ac')) update_option('acf_flexible_content_ac', "xxxx-xxxx-xxxx-xxxx");
// if(!get_option('acf_gallery_ac')) update_option('acf_gallery_ac', "xxxx-xxxx-xxxx-xxxx");


/**
 * Register field groups
 * The register_field_group function accepts 1 array which holds the relevant data to register a field group
 * You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 * This code must run every time the functions.php file is read
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => '503ddc4d04719',
		'title' => 'Sidans kontakt',
		'fields' => 
		array (
			0 => 
			array (
				'label' => 'Kontakter',
				'name' => 'hk_contacts',
				'type' => 'repeater',
				'instructions' => '',
				'required' => '0',
				'sub_fields' => 
				array (
					0 => 
					array (
						'label' => 'Kontakt',
						'name' => 'hk_contact',
						'type' => 'post_object',
						'post_type' => 
						array (
							0 => 'hk_kontakter',
						),
						'taxonomy' => 
						array (
							0 => 'all',
						),
						'allow_null' => '0',
						'multiple' => '0',
						'key' => 'field_503cb0281406d',
						'order_no' => '0',
					),
				),
				'row_min' => '0',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Lägg till kontakt',
				'key' => 'field_503cb02814012',
				'order_no' => '0',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 0,
	));
register_field_group(array (
		'id' => '503e1d21c339a',
		'title' => 'Sidans relaterad information',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_503cb20a573b7',
				'label' => 'Sidor',
				'name' => 'hk_related_pages',
				'type' => 'repeater',
				'instructions' => '',
				'required' => '0',
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_503cb20a57431',
						'label' => 'Sida',
						'name' => 'hk_related_page',
						'type' => 'post_object',
						'post_type' => 
						array (
							0 => 'post',
						),
						'taxonomy' => 
						array (
							0 => 'all',
						),
						'allow_null' => '0',
						'multiple' => '0',
						'order_no' => '0',
					),
					1 => 
					array (
						'label' => 'Beskrivande text',
						'name' => 'hk_related_page_description',
						'type' => 'textarea',
						'default_value' => '',
						'formatting' => 'br',
						'key' => 'field_503e1ff623fa9',
						'order_no' => '1',
					),
				),
				'row_min' => '0',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Row',
				'order_no' => '0',
			),
			1 => 
			array (
				'key' => 'field_503db64403e19',
				'label' => 'Länkar',
				'name' => 'hk_related_links',
				'type' => 'repeater',
				'instructions' => '',
				'required' => '0',
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_503dc04b7e068',
						'label' => 'Länknamn',
						'name' => 'hk_related_link_name',
						'type' => 'text',
						'default_value' => '',
						'formatting' => 'none',
						'order_no' => '0',
					),
					1 => 
					array (
						'key' => 'field_503db64403e69',
						'label' => 'Länk',
						'name' => 'hk_related_link_url',
						'type' => 'text',
						'default_value' => '',
						'formatting' => 'none',
						'order_no' => '1',
					),
					2 => 
					array (
						'label' => 'Beskrivande text',
						'name' => 'hk_related_link_description',
						'type' => 'textarea',
						'default_value' => '',
						'formatting' => 'br',
						'key' => 'field_503e1ff623fa9',
						'order_no' => '2',
					),
				),
				'row_min' => '0',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Row',
				'order_no' => '1',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => '0',
				),
				1 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'hk_related',
					'order_no' => '1',
				),
			),
			'allorany' => 'any',
		),
		'options' => 
		array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => '503ddd9094276',
		'title' => 'Extra information',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_50164bf803f5a',
				'label' => 'Extra text',
				'name' => 'optional-text',
				'type' => 'textarea',
				'instructions' => 'Extra information som ligger i artikelns högerkolumn.',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'br',
				'order_no' => '0',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => '503ddd90944a4',
		'title' => 'Inbäddat videoklipp',
		'fields' => 
		array (
			0 => 
			array (
				'label' => 'Inbäddningskoden',
				'name' => 'embedded_code',
				'type' => 'textarea',
				'instructions' => 'Klistra in inbäddningskoden till videoklippet här...',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'br',
				'key' => 'field_502ce2d515d67',
				'order_no' => '0',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => '503ddd9094681',
		'title' => 'Taxonomy',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_502de86ea580e',
				'label' => 'Etiketter',
				'name' => 'etiketter',
				'type' => 'tax',
				'instructions' => '',
				'required' => '0',
				'taxonomy' => 'post_tag',
				'taxcol' => '0',
				'hidetax' => '0',
				'order_no' => '0',
			),
			1 => 
			array (
				'label' => 'Vem',
				'name' => 'vem',
				'type' => 'tax',
				'instructions' => '',
				'required' => '0',
				'taxonomy' => 'vem',
				'taxcol' => '0',
				'hidetax' => '0',
				'key' => 'field_502dfd622c3ac',
				'order_no' => '1',
			),
			2 => 
			array (
				'label' => 'Var',
				'name' => 'var',
				'type' => 'tax',
				'instructions' => '',
				'required' => '0',
				'taxonomy' => 'ort',
				'taxcol' => '0',
				'hidetax' => '0',
				'key' => 'field_502dfd62324a8',
				'order_no' => '2',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 0,
	));
}
?>