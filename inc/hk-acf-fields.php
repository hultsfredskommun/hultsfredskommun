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
		'id' => '5048edc031ca0',
		'title' => 'Relaterad information',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_5048ad53aae54',
				'label' => 'Relaterat',
				'name' => 'hk_related',
				'type' => 'flexible_content',
				'instructions' => '',
				'required' => '0',
				'layouts' => 
				array (
					0 => 
					array (
						'label' => 'Inlägg',
						'name' => 'hk_related_posts',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Inlägg',
								'name' => 'hk_related_post',
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
								'key' => 'field_5048afee75ba5',
								'order_no' => '0',
							),
							1 => 
							array (
								'label' => 'Beskrivning',
								'name' => 'hk_related_post_description',
								'type' => 'textarea',
								'default_value' => '',
								'formatting' => 'br',
								'key' => 'field_5048afee75bfd',
								'order_no' => '1',
							),
						),
					),
					1 => 
					array (
						'label' => 'Extern länk',
						'name' => 'hk_related_links',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Namn',
								'name' => 'hk_related_link_name',
								'type' => 'text',
								'default_value' => '',
								'formatting' => 'none',
								'key' => 'field_5048afee75c57',
								'order_no' => '0',
							),
							1 => 
							array (
								'label' => 'Länk',
								'name' => 'hk_relate_link_url',
								'type' => 'text',
								'default_value' => '',
								'formatting' => 'none',
								'key' => 'field_5048afee75ca5',
								'order_no' => '1',
							),
							2 => 
							array (
								'label' => 'Beskrivning',
								'name' => 'hk_related_link_description',
								'type' => 'textarea',
								'default_value' => '',
								'formatting' => 'br',
								'key' => 'field_5048afee75cf1',
								'order_no' => '2',
							),
						),
					),
					2 => 
					array (
						'label' => 'Filer',
						'name' => 'hk_related_files',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Fil',
								'name' => 'hk_related_file',
								'type' => 'file',
								'save_format' => 'id',
								'key' => 'field_5048afee75d45',
								'order_no' => '0',
							),
							1 => 
							array (
								'label' => 'Beskrivning',
								'name' => 'hk_related_file_description',
								'type' => 'textarea',
								'default_value' => '',
								'formatting' => 'br',
								'key' => 'field_5048afee75d93',
								'order_no' => '1',
							),
						),
					),
				),
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_5048af3786941',
					),
					1 => 
					array (
						'key' => 'field_5048af378698e',
					),
				),
				'button_label' => 'Lägg till en ny rad',
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
		'id' => '5048edc031ead',
		'title' => 'Utvald bild',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_5048db469fef5',
				'label' => 'Bilder',
				'name' => 'hk_featured_images',
				'type' => 'repeater',
				'instructions' => '',
				'required' => '0',
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_5048db469ff3e',
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
				'button_label' => 'Lägg till en ny rad',
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
				1 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'hk_kontakter',
					'order_no' => '1',
				),
				2 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'hk_slideshow',
					'order_no' => '2',
				),
			),
			'allorany' => 'any',
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
		'id' => '5048edc032013',
		'title' => 'Utvald kontakt',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_5048dbf579c0b',
				'label' => 'Kontakter',
				'name' => 'hk_contacts',
				'type' => 'repeater',
				'instructions' => '',
				'required' => '0',
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_5048dbf579c54',
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
				'layout' => 'table',
				'button_label' => 'Lägg till en ny rad',
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
		'id' => '5048edc032149',
		'title' => 'Sluta publicera',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_5046fe5d332c7',
				'label' => 'Datum',
				'name' => 'hk_stop_publish',
				'type' => 'date_picker',
				'instructions' => '',
				'required' => '0',
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
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
		'menu_order' => 1,
	));
	register_field_group(array (
		'id' => '5048edc032267',
		'title' => 'Artikelns extra information',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_5048dc7a43e1a',
				'label' => 'Extra text',
				'name' => 'optional-text',
				'type' => 'textarea',
				'instructions' => '',
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
		'menu_order' => 50,
	));
	register_field_group(array (
		'id' => '5048edc0324cf',
		'title' => 'Inbäddat videoklipp',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_5048dc4653524',
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
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 55,
	));

}
?>