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
if( function_exists('acf_add_local_field_group') ):

$imagesizeArr = array(  'thumbnail-image' => 'thumbnail-image',
						'featured-image' => 'featured-image',
						'slideshow-image' => 'slideshow-image',
						'wide-image' => 'wide-image',
						'contact-image' => 'contact-image',
						'thumbnail-news-image' => 'thumbnail-news-image');
						
acf_add_local_field_group(array (
	'key' => 'group_56bb0a0915e14',
	'title' => 'Mellanstartsida',
	'fields' => array (
	
		array (
			'key' => 'field_56c2b9e22ea60',
			'label' => 'Visa det vanliga artikelflödet/startsidan under mellanstartsidan',
			'name' => 'hk_quick_show_articles',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '100%',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_56bb09f161839',
			'label' => 'Ingång',
			'name' => 'hk_quick_link',
			'type' => 'flexible_content',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'button_label' => 'Lägg till puff',
			'min' => '',
			'max' => '',
			'layouts' => array (
				array (
					'key' => '56bb0a25a4143',
					'name' => 'lagg_till_puff',
					'label' => 'Lägg till puff',
					'display' => 'block',
					'sub_fields' => array (
						
						
						array (
							'key' => 'field_56c729a6a5d1b',
							'label' => 'Bildformat',
							'name' => 'image-size',
							'type' => 'select',
							'instructions' => 'Välj vilket format bilden ska ha.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '25%',
								'class' => '',
								'id' => '',
							),
							'choices' => $imagesizeArr,
							'default_value' => array (
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
							'disabled' => 0,
							'readonly' => 0,
						),
						array (
							'key' => 'field_56cc0a2e6183b',
							'label' => 'Rubrik',
							'name' => 'title',
							'type' => 'text',
							'instructions' => 'Rubrik som syns under bilden.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '25%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_57cc0a2e6183b',
							'label' => 'Knapptext',
							'name' => 'button',
							'type' => 'text',
							'instructions' => 'Text i knapp (om bild finns).',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '15%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_56bb104207f50',
							'label' => 'Layout',
							'name' => 'layout',
							'type' => 'select',
							'instructions' => 'Hur stor del av skärmen som puffen använda.',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '35%',
								'class' => '',
								'id' => '',
							),
							'choices' => array (
								'one-whole' => 'Fullbredd',
								'one-half' => 'En halv',
								'one-third' => 'En tredjedel',
								'two-thirds' => 'Två tredjedelar',
								'one-quarter' => 'En fjärdedel',
								'two-quarters' => 'Två fjärdedelar',
								'three-quarters' => 'Tre fjärdedelar',
								'one-fifth' => 'En femtedel',
								'two-fifths' => 'Två femtedelar',
								'three-fifths' => 'Tre femtedelar',
								'four-fifths' => 'Fyra femtedelar',
							),
							'default_value' => array (
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
							'disabled' => 0,
							'readonly' => 0,
						),
						
						array (
							'key' => 'field_56bb0a146183a',
							'label' => 'Bild',
							'name' => 'image',
							'type' => 'image',
							'instructions' => 'Bild som puffen ska använda.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '25%',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'preview_size' => 'thumbnail',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
						),
						array (
							'key' => 'field_56bb0a2e6183b',
							'label' => 'Beskrivning',
							'name' => 'description',
							'type' => 'textarea',
							'instructions' => 'Text under rubriken i puffen.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '40%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						
						
						array (
							'key' => 'field_56bb0a416183c',
							'label' => 'Länka till',
							'name' => 'content',
							'type' => 'flexible_content',
							'instructions' => 'Till vilket inneh&aring;ll ska puffen peka.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '35%',
								'class' => '',
								'id' => '',
							),
							'button_label' => 'Länka till',
							'min' => 0,
							'max' => 1,
							'layouts' => array (
								array (
									'key' => '56bb0dc197435',
									'name' => 'fil',
									'label' => 'Fil',
									'display' => 'block',
									'sub_fields' => array (
										array (
											'key' => 'field_56bb0d4262dc3',
											'label' => 'Fil',
											'name' => 'file',
											'type' => 'file',
											'instructions' => '',
											'required' => 0,
											'conditional_logic' => 0,
											'wrapper' => array (
												'width' => '',
												'class' => '',
												'id' => '',
											),
											'return_format' => 'array',
											'library' => 'all',
											'min_size' => '',
											'max_size' => '',
											'mime_types' => '',
										),
									),
									'min' => '',
									'max' => '',
								),
								array (
									'key' => '56bb0f1acd048',
									'name' => 'inlagg',
									'label' => 'Inlägg',
									'display' => 'block',
									'sub_fields' => array (
										array (
											'key' => 'field_56bb0f1acd04d',
											'label' => 'Post',
											'name' => 'post',
											'type' => 'post_object',
											'instructions' => '',
											'required' => 0,
											'conditional_logic' => 0,
											'wrapper' => array (
												'width' => '',
												'class' => '',
												'id' => '',
											),
											'post_type' => array (
												0 => 'post',
											),
											'taxonomy' => array (
											),
											'allow_null' => 0,
											'multiple' => 0,
											'return_format' => 'object',
											'ui' => 1,
										),
									),
									'min' => '',
									'max' => '',
								),
								array (
									'key' => '56bb0f17cd042',
									'name' => 'extern',
									'label' => 'Extern',
									'display' => 'block',
									'sub_fields' => array (
										array (
											'key' => 'field_56bb0f17cd044',
											'label' => 'Extern URL',
											'name' => 'extern',
											'type' => 'text',
											'instructions' => 'Ange URL till extern sida, inklusive http://',
											'required' => 0,
											'conditional_logic' => 0,
											'wrapper' => array (
												'width' => '',
												'class' => '',
												'id' => '',
											),
											'default_value' => '',
											'placeholder' => '',
											'prepend' => '',
											'append' => '',
											'maxlength' => '',
											'readonly' => 0,
											'disabled' => 0,
										),
									),
									'min' => '',
									'max' => '',
								),
							),
						),
						
						/* colors and style */
						array (
							'key' => 'field_56eabc5e154d0',
							'label' => 'D&ouml;lj puff',
							'name' => 'inactive',
							'type' => 'true_false',
							'instructions' => 'Kryssa i för att d&ouml;lja puffen.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '20%',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
						),
						array (
							'key' => 'field_56eabc0f154d0',
							'label' => 'Visa avancerade inst&auml;llningar',
							'name' => 'advanced',
							'type' => 'true_false',
							'instructions' => 'De avancerade inst&auml;llningarna g&auml;ller &auml;ven n&auml;r denna ruta inte &auml;r ikryssad. Varje inst&auml;llning m&aring;ste nollst&auml;llas var f&ouml;r sig. Rutan m&aring;ste vara ikryssad f&ouml;r att &auml;ndringar ska sparas.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '80%',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
						),
						array (
							'key' => 'field_02bb104207f50',
							'label' => 'Textf&auml;rg',
							'name' => 'text-color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_56eabc0f154d0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),
						array (
							'key' => 'field_11bb104207f50',
							'label' => 'Bakgrundsf&auml;rg',
							'name' => 'background-color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_56eabc0f154d0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),
						array (
							'key' => 'field_12c729a6a5d1b',
							'label' => 'F&auml;rg p&aring; ram',
							'name' => 'border-color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_56eabc0f154d0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '33%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),
						array (
							'key' => 'field_503b104207f50',
							'label' => '&Ouml;ppna f&ouml;nster i',
							'name' => 'target',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_56eabc0f154d0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '20%',
								'class' => '',
								'id' => '',
							),
							'choices' => array (
								'top' => 'Samma f&ouml;nster',
								'blank' => 'Nytt f&ouml;nster',
							),
							'default_value' => array (
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
							'disabled' => 0,
							'readonly' => 0,
						),
						
						array (
							'key' => 'field_12cc0a2e6183b',
							'label' => 'Bredd p&aring; ram',
							'name' => 'border-width',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_56eabc0f154d0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '20%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),
						array (
							'key' => 'field_12000a2e6183b',
							'label' => 'Radie p&aring; ram',
							'name' => 'border-radius',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_56eabc0f154d0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '20%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),
						array (
							'key' => 'field_12bb104207f50',
							'label' => 'Align',
							'name' => 'text-align',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_56eabc0f154d0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '20%',
								'class' => '',
								'id' => '',
							),
							'choices' => array (
								'left' => 'left',
								'center' => 'center',
								'right' => 'right',
							),
							'default_value' => array (
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
							'disabled' => 0,
							'readonly' => 0,
						),
						array (
							'key' => 'field_12c60a2e6183b',
							'label' => 'Padding',
							'name' => 'padding',
							'type' => 'text',
							'instructions' => 'Luft runtom puffens ram i antal pixlar (px).',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_56eabc0f154d0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '20%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),

						array (
							'key' => 'field_12c70a2e6183b',
							'label' => 'Margin',
							'name' => 'margin',
							'type' => 'text',
							'instructions' => 'Luft innanför puffens ram i antal pixlar (px).',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_56eabc0f154d0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '20%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),

						
						array (
							'key' => 'field_12e40a2e6183b',
							'label' => 'Css class',
							'name' => 'css-class',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_56eabc0f154d0',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '20%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),
					),
					'min' => '',
					'max' => '',
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'hk_quick',
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

endif;


if(function_exists("register_field_group"))
{
	/*******
	 * POST
	 *******/
	
/* POST RELATED *//*
	register_field_group(array (
		'id' => '5048edc031cee',
		'title' => 'Snabbl&auml;nkar',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_5048ad53aaeee',
				'label' => 'Snabbl&auml;nkar',
				'name' => 'hk_quick',
				'type' => 'flexible_content',
				'instructions' => '',
				'required' => '0',
				'layouts' => 
				array (
					0 => 
					array (
						'label' => 'Inlägg',
						'name' => 'hk_quick_posts',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Inlägg',
								'name' => 'hk_quick_post',
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
								'key' => 'field_5048afeeeebee',
								'order_no' => '0',
							),
							1 => 
							array (
								'label' => 'Beskrivning',
								'name' => 'hk_quick_post_description',
								'type' => 'textarea',
								'default_value' => '',
								'formatting' => 'br',
								'key' => 'field_5048afee75bee',
								'order_no' => '1',
							),
							2 => 
							array (
								'key' => 'field_5048db469ffee',
								'label' => 'Bild',
								'name' => 'hk_quick_image',
								'type' => 'image',
								'save_format' => 'object',
								'preview_size' => 'thumbnail',
								'order_no' => '0',
							),
						),
					),
					1 => 
					array (
						'label' => 'Extern länk',
						'name' => 'hk_quick_links',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Namn',
								'name' => 'hk_quick_link_name',
								'type' => 'text',
								'default_value' => '',
								'formatting' => 'none',
								'key' => 'field_5048afee75345',
								'order_no' => '0',
							),
							1 => 
							array (
								'label' => 'Länk',
								'name' => 'hk_quick_link_url',
								'type' => 'text',
								'default_value' => '',
								'formatting' => 'none',
								'key' => 'field_5048afee75346',
								'order_no' => '1',
							),
							2 => 
							array (
								'label' => 'Beskrivning',
								'name' => 'hk_quick_link_description',
								'type' => 'textarea',
								'default_value' => '',
								'formatting' => 'br',
								'key' => 'field_5048afee75347',
								'order_no' => '2',
							),
							3 => 
							array (
								'key' => 'field_5048db469ffef',
								'label' => 'Bild',
								'name' => 'hk_quick_image',
								'type' => 'image',
								'save_format' => 'object',
								'preview_size' => 'thumbnail',
								'order_no' => '0',
							),
						),
					),
					2 => 
					array (
						'label' => 'Filer',
						'name' => 'hk_quick_files',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Fil',
								'name' => 'hk_quick_file',
								'type' => 'file',
								'save_format' => 'id',
								'key' => 'field_6048afee75dee',
								'order_no' => '0',
							),
							1 => 
							array (
								'label' => 'Beskrivning',
								'name' => 'hk_quick_file_description',
								'type' => 'textarea',
								'default_value' => '',
								'formatting' => 'br',
								'key' => 'field_5048afee75dee',
								'order_no' => '1',
							),
							2 => 
							array (
								'key' => 'field_5048db469ffff',
								'label' => 'Bild',
								'name' => 'hk_quick_image',
								'type' => 'image',
								'save_format' => 'object',
								'preview_size' => 'thumbnail',
								'order_no' => '0',
							),
						),
					),
					
				),
				
				'button_label' => 'Lägg till fil',
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
					'value' => 'hk_quick',
					'order_no' => '0',
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
		'menu_order' => 3,
	));*/
	
	
	
	/* POST RELATED */
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
								'key' => 'field_5048afee75d94',
								'order_no' => '1',
							),
						),
					),
					3 => 
					array (
						'label' => 'Rubriker',
						'name' => 'hk_related_titles',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'multiple' => 0,
								'allow_null' => 0,
								'choices' => array (
									'Blanketter' => 'Blanketter',
									'Se även' => 'Se även',
									'styrdokument' => 'Styrdokument',
									'taxor-och-avgifter' => 'Taxor & avgifter',
								),
								'default_value' => '',
								'key' => 'field_51c2c40ba83ff',
								'label' => 'Rubrik',
								'name' => 'hk_related_title',
								'type' => 'select',
								'column_width' => '',
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
				'button_label' => 'Lägg till fil',
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
		'menu_order' => 3,
	));
	
	/* POST AND CONTACT FIELDS */
	register_field_group(array (
		'id' => '5048edc031ede',
		'title' => 'Synonymer',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_505ad25f206a7',
				'label' => '',
				'name' => 'hk_synonym',
				'type' => 'text',
				'instructions' => 'Ange extra synonymer f&ouml;r b&auml;ttre s&ouml;kbarhet.',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'br',
				'order_no' => '6',
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
					'value' => 'hk_kontakter',
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
		'menu_order' => 2,
	));
	
			
			
	/* POST IMAGES */
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
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 2,
	));
	
	/* slidehow link */
	register_field_group(array (
		'id' => 'acf_slideshow',
		'title' => 'Slideshow',
		'fields' => array (
			array (
				'key' => 'field_530dedae4bc38',
				'label' => 'Bildspelslänk',
				'name' => 'hk_slideshow_link',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'hk_slideshow',
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


	/* POST CONTACT */
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
					1 => 
					array (
						'label' => 'Byt ut titel (frivilligt)',
						'name' => 'hk_contact_extra',
						'type' => 'text',
						'default_value' => '',
						'formatting' => 'br',
						'key' => 'field_5048afee75d93',
						'order_no' => '1',
					),
				),
				'row_min' => '0',
				'row_limit' => '',
				'layout' => 'table',
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
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 5,
	));
	
	
	register_field_group(array (
		'key' => 'group_551b7f5770eca',
		'title' => 'Vanliga frågor',
		'fields' => array (
			array (
				'key' => 'field_551b7f762310e',
				'label' => 'Vanliga frågor',
				'name' => 'hk_vanliga_fragor',
				'prefix' => '',
				'type' => 'repeater',
				'instructions' => 'Formulera frågan så enkelt och kortfattat som möjligt. Ex. Hur söker jag barnbidrag?',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'min' => '',
				'max' => '',
				'layout' => 'table',
				'button_label' => 'Lägg till rad',
				'sub_fields' => array (
					array (
						'key' => 'field_551b7f892310f',
						'label' => 'Fråga?',
						'name' => 'fraga',
						'prefix' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
					),/*
					array (
						'key' => 'field_551b7fbf23110',
						'label' => 'Kortfatta svar',
						'name' => 'svar',
						'prefix' => '',
						'type' => 'wysiwyg',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
					),*/
					array (
						'key' => 'field_56c2b9f11ea60',
						'label' => 'Utvald fråga',
						'name' => 'important',
						'type' => 'true_false',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '10%',
							'class' => '',
							'id' => '',
						),
						'message' => '',
						'default_value' => 0,
					),
				),
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
		'menu_order' => 10,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
	));

	
	/* POST STOP PUBLISH */
	$options = get_option("hk_theme");
	if ($options['enable_cron_stop_publish']) {
		register_field_group(array (
			'id' => 'acf_sluta-publicera',
			'title' => 'Sluta publicera',
			'fields' => array (
				array (
					'date_format' => 'yymmdd',
					'display_format' => 'yy-mm-dd',
					'first_day' => 1,
					'key' => 'field_51bffccf1a73f',
					'label' => 'Datum',
					'name' => 'hk_stop_publish_date',
					'type' => 'date_picker',
				),
				array (
					'multiple' => 0,
					'allow_null' => 0,
					'choices' => array (
						7 => '7:00',
						8 => '8:00',
						9 => '9:00',
						10 => '10:00',
						11 => '11:00',
						12 => '12:00',
						13 => '13:00',
						14 => '14:00',
						15 => '15:00',
						16 => '16:00',
						17 => '17:00',
						18 => '18:00',
						19 => '19:00',
						20 => '20:00',
						21 => '21:00',
						22 => '22:00',
					),
					'default_value' => 12,
					'key' => 'field_51bffe875ccc4',
					'label' => 'Tid',
					'name' => 'hk_stop_publish_hour',
					'type' => 'select',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'post',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'side',
				'layout' => 'default',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 10,
		));
	}
	
		
	/* POST EXTERNAL LINK */
	register_field_group(array (
		'id' => '5048edc032150',
		'title' => 'Extern länk',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_5046fe5d332c8',
				'label' => 'Namn',
				'name' => 'hk_external_link_name',
				'type' => 'text',
				'instructions' => 'Namn på knappen, lämna tom om bara artikellänken ska bli en extern länk',
				'required' => '0',
				'order_no' => '0',
			),
			1 => 
			array (
				'key' => 'field_5046fe5d332c9',
				'label' => 'URL',
				'name' => 'hk_external_link_url',
				'type' => 'text',
				'instructions' => 'Url till en extern sida, detta kommer göra att inläggets innehåll inte blir åtkomligt från listningar, utan bara via direktlänk.',
				'required' => '0',
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
		'menu_order' => 10,
	));
	
	/* HIDE POST FROM CATEGORY LIST */
	register_field_group(array (
		'id' => '5048edc032160',
		'title' => 'Visa bara i etikettlista',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_5046fe5d332d8',
				'label' => 'Visa bara när etikett är vald',
				'name' => 'hk_hide_from_category',
				'type' => 'true_false',
				'message' => 'Göm inlägget från kategorielistan',
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
					'order_no' => 0,
					'group_no' => 0,
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
		'menu_order' => 10,
	));
	
	/* POST EXTRA INFO */
	register_field_group(array (
		'id' => '5048edc032267',
		'title' => 'Artikelns extra information',
		'fields' => array (
			array (
				'key' => 'field_52243a0577df8',
				'label' => 'Extra text',
				'name' => 'hk_optional_text2',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_52243a0577cc8',
				'label' => 'Extra text i gr&aring; ruta',
				'name' => 'hk_optional_text',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
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



	/*******
	 * CONTACT
	 *******/
	register_field_group(array (
		'id' => '5062a4b871449',
		'title' => 'Kontaktinformation',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_505ad25f0c2bb',
				'label' => 'Titel',
				'name' => 'hk_contact_titel',
				'type' => 'text',
				'instructions' => '',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'none',
				'order_no' => '0',
			),
			1 => 
			array (
				'key' => 'field_505ad7e9928b3',
				'label' => 'Arbetsplats',
				'name' => 'hk_contact_workplaces',
				'type' => 'repeater',
				'instructions' => 'Här fyller du i vilken avdelning, förvaltning eller arbetsplats kontakten jobbar på.',
				'required' => '0',
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_505ad7e9928cf',
						'label' => 'Plats',
						'name' => 'hk_contact_workplace',
						'type' => 'text',
						'instructions' => '',
						'column_width' => '',
						'default_value' => '',
						'formatting' => 'none',
						'order_no' => '0',
					),
				),
				'row_min' => '0',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Row',
				'order_no' => '1',
			),
			2 => 
			array (
				'key' => 'field_505b206c9f70f',
				'label' => 'Telefonnummer',
				'name' => 'hk_contact_phones',
				'type' => 'flexible_content',
				'instructions' => '',
				'required' => '0',
				'layouts' => 
				array (
					0 => 
					array (
						'label' => 'Telefon',
						'name' => 'hk_contact_phone',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Nummer',
								'name' => 'number',
								'type' => 'text',
								'default_value' => '',
								'formatting' => 'none',
								'key' => 'field_5062a4b0641c8',
								'order_no' => '0',
							),
						),
					),
					1 => 
					array (
						'label' => 'Mobil',
						'name' => 'hk_contact_mobile',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Nummer',
								'name' => 'number',
								'type' => 'text',
								'default_value' => '',
								'formatting' => 'none',
								'key' => 'field_5062a4b0641d0',
								'order_no' => '0',
							),
						),
					),
					2 => 
					array (
						'label' => 'Fax',
						'name' => 'hk_contact_fax',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Nummer',
								'name' => 'number',
								'type' => 'text',
								'default_value' => '',
								'formatting' => 'none',
								'key' => 'field_5062a4b0641d5',
								'order_no' => '0',
							),
						),
					),
				),
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_505b213b16b15',
					),
				),
				'button_label' => 'Lägg till nytt nummer',
				'order_no' => '2',
			),
			3 => 
			array (
				'key' => 'field_505ad25f18351',
				'label' => 'E-post',
				'name' => 'hk_contact_emails',
				'type' => 'repeater',
				'instructions' => '',
				'required' => '0',
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_505ad25f1838b',
						'label' => 'E-post',
						'name' => 'hk_contact_email',
						'type' => 'text',
						'instructions' => '',
						'column_width' => '',
						'default_value' => '',
						'formatting' => 'none',
						'order_no' => '0',
					),
				),
				'row_min' => '0',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Lägg till e-postadress',
				'order_no' => '3',
			),
			4 => 
			array (
				'key' => 'field_505ad4be8d8d5',
				'label' => 'Beskrivning',
				'name' => 'hk_contact_description',
				'type' => 'textarea',
				'instructions' => 'En kort frivillig beskrivning av kontakten.',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'br',
				'order_no' => '4',
			),
			5 => 
			array (
				'key' => 'field_505ad25f1c69c',
				'label' => 'Besöksadress',
				'name' => 'hk_contact_address',
				'type' => 'textarea',
				'instructions' => '',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'br',
				'order_no' => '5',
			),
			6 => 
			array (
				'key' => 'field_505ad25f205a2',
				'label' => 'Besökstid',
				'name' => 'hk_contact_visit_hours',
				'type' => 'textarea',
				'instructions' => '',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'br',
				'order_no' => '6',
			),
			8 => 
			array (
				'key' => 'field_505ad28e292d9',
				'label' => 'Position',
				'name' => 'hk_contact_position',
				'type' => 'location-field',
				'instructions' => '',
				'required' => '0',
				'val' => 'address',
				'center' => '57.455560638683025,15.836223059667986',
				'zoom' => '12',
				'order_no' => '8',
			),
			9 => 
			array (
				'key' => 'field_555ad28e292d9',
				'label' => 'Position',
				'name' => 'hk_contact_position_2',
				'type' => 'google_map',
				'instructions' => '',
				'required' => '0',
				'val' => 'address',
				'center_lat' => '57.455560638683025',
				'center_lng' => '15.836223059667986',
				'zoom' => '12',
				'order_no' => '8',
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
					'value' => 'hk_kontakter',
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
				0 => 'the_content',
			),
		),
		'menu_order' => 0,
	));
	
	
	/* ENKEL ADRESS TILL SIDA */
	register_field_group(array (
		'id' => '50f53001d8c88',
		'title' => 'Enkel adress',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_505b21d9177e7',
				'label' => 'Länk att skicka vidare till',
				'name' => 'hk_redirect_link',
				'type' => 'text',
				'order_no' => 0,
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 
				array (
					'status' => 0,
					'rules' => 
					array (
						0 => 
						array (
							'field' => 'null',
							'operator' => '==',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_52243a0577dd8',
				'label' => 'Text som syns om sidan inte skickar vidare.',
				'name' => 'hk_redirect_text',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),

		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'hk_redirect_page.php',
					'order_no' => 0,
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
				0 => 'the_content',
			),
		),
		'menu_order' => 0,
	));
	
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

}
?>