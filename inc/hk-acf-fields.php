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
		'id' => '5044817d18ee2',
		'title' => 'Artikelns bild',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_504454d032c46',
				'label' => 'Bilder',
				'name' => 'hk_featured_images',
				'type' => 'repeater',
				'instructions' => '',
				'required' => '0',
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_504454d032c90',
						'label' => 'Bild',
						'name' => 'hk_featured_image',
						'type' => 'image',
						'save_format' => 'object',
						'preview_size' => 'thumbnail',
						'order_no' => '0',
					),
				),
				'row_min' => '0',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Lägg till bild',
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
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => '5044817d190d7',
		'title' => 'Artikelns kontakt',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_503cb02814012',
				'label' => 'Kontakter',
				'name' => 'hk_contacts',
				'type' => 'repeater',
				'instructions' => '',
				'required' => '0',
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_503cb0281406d',
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
						'order_no' => '0',
					),
				),
				'row_min' => '0',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Lägg till kontakt',
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
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => '5044817d19262',
		'title' => 'Etiketter',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_5037832c0395b',
				'label' => 'Etikett',
				'name' => 'tags',
				'type' => 'tax',
				'instructions' => '',
				'required' => '0',
				'taxonomy' => 'post_tag',
				'taxcol' => '2',
				'hidetax' => '1',
				'order_no' => '0',
			),
			1 => 
			array (
				'key' => 'field_5037832bd101d',
				'label' => 'Vem',
				'name' => 'vem',
				'type' => 'tax',
				'instructions' => '',
				'required' => '0',
				'taxonomy' => 'vem',
				'taxcol' => '2',
				'hidetax' => '1',
				'order_no' => '1',
			),
			2 => 
			array (
				'key' => 'field_5037832bdb33c',
				'label' => 'Ort',
				'name' => 'ort',
				'type' => 'tax',
				'instructions' => '',
				'required' => '0',
				'taxonomy' => 'ort',
				'taxcol' => '2',
				'hidetax' => '1',
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
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => '5044817d19422',
		'title' => 'Relaterad information',
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
						'key' => 'field_503e1ff623fa9',
						'label' => 'Beskrivande text',
						'name' => 'hk_related_page_description',
						'type' => 'textarea',
						'default_value' => '',
						'formatting' => 'br',
						'order_no' => '1',
					),
				),
				'row_min' => '0',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Lägg till rad',
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
						'key' => 'field_504073c4d1ef9',
						'label' => 'Beskrivning',
						'name' => 'hk_related_link_description',
						'type' => 'textarea',
						'default_value' => '',
						'formatting' => 'br',
						'order_no' => '2',
					),
				),
				'row_min' => '0',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Lägg till rad',
				'order_no' => '1',
			),
			2 => 
			array (
				'key' => 'field_504073c4e19aa',
				'label' => 'Filer',
				'name' => 'hk_related_files',
				'type' => 'repeater',
				'instructions' => '',
				'required' => '0',
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_504073c4e19fa',
						'label' => 'Fil',
						'name' => 'hk_related_file',
						'type' => 'file',
						'save_format' => 'id',
						'order_no' => '0',
					),
					1 => 
					array (
						'key' => 'field_504073c4e1a39',
						'label' => 'Beskrivning',
						'name' => 'hk_related_file_description',
						'type' => 'textarea',
						'default_value' => '',
						'formatting' => 'br',
						'order_no' => '1',
					),
				),
				'row_min' => '0',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Lägg till rad',
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
		'id' => '5044817d19633',
		'title' => 'Inbäddat videoklipp',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_50408e0bde984',
				'label' => 'Inbäddningskoden',
				'name' => 'embedded_code',
				'type' => 'textarea',
				'instructions' => 'Klistra in inbäddningskoden till videoklippet här.',
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
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 15,
	));
	register_field_group(array (
		'id' => '5044817d19897',
		'title' => 'Artikelns extra information',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_50408dbf40c82',
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
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 20,
	));
}
?>