<?php


$imagesizeArr = array(  'thumbnail-image' => 'thumbnail-image',
						'featured-image' => 'featured-image',
						'slideshow-image' => 'slideshow-image',
						'wide-image' => 'wide-image',
						'contact-image' => 'contact-image',
						'thumbnail-news-image' => 'thumbnail-news-image');

$rekai_array = [];
if (function_exists("get_field") && get_field('rekai_enable', 'options')) {
$rekai_array = array( array (
			'key' => '56bb0a25a41aa',
			'name' => 'lagg_till_rekai',
			'label' => 'Rek.ai',
			'display' => 'block',
			'sub_fields' => array (
				array (
					'key' => 'field_56cc0a2e618aa',
					'label' => 'Rubrik',
					'name' => 'title',
					'type' => 'text',
					'instructions' => 'Rubrik som syns över listan.',
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
				array(
					'key' => 'field_61f8fa4d79b07',
					'label' => 'Antal',
					'name' => 'nrofhits',
					'type' => 'number',
					'instructions' => 'Antal länkar som ska visas.',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '25%',
						'class' => '',
						'id' => '',
					),
					'default_value' => '4',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => '',
					'max' => '',
					'step' => '',
				),
				array (
					'key' => 'field_56cc104207faa',
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
						'three-quarters' => 'Tre fjärdedelar',						
					),
					'default_value' => array (
						'one-whole'
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
					'key' => 'field_56eabc5e154aa',
					'label' => 'D&ouml;lj puff',
					'name' => 'inactive',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '15%',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
				),

				array (
					'key' => 'field_56cc104207f92',
					'label' => 'Stil',
					'name' => 'rek_style',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '35%',
						'class' => '',
						'id' => '',
					),

					'choices' => array (
						'none' => 'Löpande',
						'rows' => 'Rader',
						
					),
					'default_value' => array (
						'none'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'placeholder' => '',
					'disabled' => 0,
					'readonly' => 0,
				),
				
			)
		) 
	);
}
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
			'layouts' => array_merge(
				$rekai_array, array (
				array (
					'key' => '56bb0a25a45555',
					'name' => 'lagg_till_links',
					'label' => 'L&auml;nkar',
					'display' => 'block',
					'sub_fields' => array (



						array (
							'key' => 'field_56cc0a2e65555',
							'label' => 'Rubrik',
							'name' => 'title',
							'type' => 'text',
							'instructions' => 'Rubrik som syns över listan.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '45%',
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
							'key' => 'field_56cc104205555',
							'label' => 'Layout',
							'name' => 'layout',
							'type' => 'select',
							'instructions' => 'Hur stor del av skärmen som puffen använda.',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '40%',
								'class' => '',
								'id' => '',
							),

							'choices' => array (
								'one-whole' => 'Fullbredd',
								'one-half' => 'En halv',
								'one-third' => 'En tredjedel',
								'two-thirds' => 'Två tredjedelar',
								'one-quarter' => 'En fjärdedel',
								'three-quarters' => 'Tre fjärdedelar',
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
							'key' => 'field_56eabc5e155555',
							'label' => 'D&ouml;lj puff',
							'name' => 'inactive',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '15%',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
						),


						array(
							'key' => 'field_6217ded68a2e9',
							'label' => 'Länk',
							'name' => 'link_wrapper',
							'type' => 'repeater',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '100%',
								'class' => '',
								'id' => '',
							),
							'collapsed' => '',
							'min' => 0,
							'max' => 0,
							'layout' => 'table',
							'button_label' => '',
							'sub_fields' => array(
								array(
									'key' => 'field_621891088cace',
									'label' => 'title',
									'name' => 'title',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_6217dee58a2ea',
									'label' => 'link',
									'name' => 'link',
									'type' => 'flexible_content',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'layouts' => array(
										'layout_6218944019389' => array(
											'key' => 'layout_6218944019389',
											'name' => 'extern',
											'label' => 'Extern',
											'display' => 'block',
											'sub_fields' => array(
												array(
													'key' => 'field_62189276087b9',
													'label' => 'Extern',
													'name' => 'extern',
													'type' => 'text',
													'instructions' => '',
													'required' => 0,
													'conditional_logic' => 0,
													'wrapper' => array(
														'width' => '',
														'class' => '',
														'id' => '',
													),
													'default_value' => '',
													'placeholder' => '',
													'prepend' => '',
													'append' => '',
													'maxlength' => '',
												),
											),
											'min' => '',
											'max' => '',
										),
										'layout_621894853ba82' => array(
											'key' => 'layout_621894853ba82',
											'name' => 'inlagg',
											'label' => 'Inlägg',
											'display' => 'block',
											'sub_fields' => array(
												array(
													'key' => 'field_621894853ba83',
													'label' => 'Inlägg',
													'name' => 'inlagg',
													'type' => 'page_link',
													'instructions' => '',
													'required' => 0,
													'conditional_logic' => 0,
													'wrapper' => array(
														'width' => '',
														'class' => '',
														'id' => '',
													),
													'post_type' => array(
														0 => 'post',
													),
													'taxonomy' => '',
													'allow_null' => 0,
													'allow_archives' => 1,
													'multiple' => 0,
												),
											),
											'min' => '',
											'max' => '',
										),
										'layout_621894ad3ba84' => array(
											'key' => 'layout_621894ad3ba84',
											'name' => 'kategori',
											'label' => 'Kategori',
											'display' => 'block',
											'sub_fields' => array(
												array(
													'key' => 'field_621894ad3ba85',
													'label' => 'Kategori',
													'name' => 'kategori',
													'type' => 'taxonomy',
													'instructions' => '',
													'required' => 0,
													'conditional_logic' => 0,
													'wrapper' => array(
														'width' => '',
														'class' => '',
														'id' => '',
													),
													'taxonomy' => 'category',
													'field_type' => 'select',
													'allow_null' => 0,
													'add_term' => 0,
													'save_terms' => 0,
													'load_terms' => 0,
													'return_format' => '',
													'multiple' => 0,
												),
											),
											'min' => '',
											'max' => '',
										),
									),
									'button_label' => 'Lägg till länk',
									'min' => 1,
									'max' => 1,
								),
							),
						),


					)
				),
				array (
					'key' => '56bb0a25a45544',
					'name' => 'lagg_till_tags',
					'label' => 'Etiketter',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_56cc0a2e65544',
							'label' => 'Rubrik',
							'name' => 'title',
							'type' => 'text',
							'instructions' => 'Rubrik som syns över listan.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '45%',
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
							'key' => 'field_56cc104205544',
							'label' => 'Layout',
							'name' => 'layout',
							'type' => 'select',
							'instructions' => 'Hur stor del av skärmen som puffen använda.',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '40%',
								'class' => '',
								'id' => '',
							),

							'choices' => array (
								'one-whole' => 'Fullbredd',
								'one-half' => 'En halv',
								'one-third' => 'En tredjedel',
								'two-thirds' => 'Två tredjedelar',
								'one-quarter' => 'En fjärdedel',
								'three-quarters' => 'Tre fjärdedelar',
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
							'key' => 'field_56eabc5e155544',
							'label' => 'D&ouml;lj puff',
							'name' => 'inactive',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '15%',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
						),

					)
				),
				
				array (
					'key' => '56bb0a25a4190',
					'name' => 'lagg_till_news',
					'label' => 'Nyheter',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_56cc0a2e618ab',
							'label' => 'Rubrik',
							'name' => 'title',
							'type' => 'text',
							'instructions' => 'Rubrik som syns över nyheterna.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '25%',
								'class' => '',
								'id' => '',
							),
							'default_value' => 'Nyheter',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array(
							'key' => 'field_61f8fa4d79b08',
							'label' => 'Antal',
							'name' => 'num_news',
							'type' => 'number',
							'instructions' => 'Antal nyheter som ska visas.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '25%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '4',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'min' => '',
							'max' => '',
							'step' => '',
						),

						array (
							'key' => 'field_56cc104207f90',
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
								'three-quarters' => 'Tre fjärdedelar',
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
							'key' => 'field_56eabc5e15491',
							'label' => 'D&ouml;lj puff',
							'name' => 'inactive',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '15%',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
						),
						array(
							'key' => 'field_61f8fa4d79b09',
							'label' => 'Antal kolumner',
							'name' => 'num_news_cols',
							'type' => 'number',
							'instructions' => 'Antal kolumner.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '25%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '3',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'min' => '',
							'max' => '',
							'step' => '',
						),
						array(
							'key' => 'field_64165de834ad7',
							'label' => 'Nyhetsikon - transparent - kvadratisk',
							'name' => 'news_icon',
							'aria-label' => '',
							'type' => 'image',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '40%',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'id',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
							'preview_size' => 'thumbnail',
						),
						array (
							'key' => 'field_56cc104207f91',
							'label' => 'Bildutseende',
							'name' => 'image_style',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '35%',
								'class' => '',
								'id' => '',
							),

							'choices' => array (
								'none' => 'Ingen',
								'circle' => 'Rund',
								'thumbnail' => 'Tumnagel',
							),
							'default_value' => array (
								'none',
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
							'disabled' => 0,
							'readonly' => 0,
						),

				)
			),

			array (
				'key' => '56bb0a25a4100',
				'name' => 'lagg_till_code',
				'label' => 'Kod',
				'display' => 'block',
				'sub_fields' => array (
					array (
						'key' => 'field_56cc104207f50',
						'label' => 'Layout',
						'name' => 'layout',
						'type' => 'select',
						'instructions' => 'Hur stor del av skärmen som puffen använda.',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '45%',
							'class' => '',
							'id' => '',
						),

						'choices' => array (
							'one-whole' => 'Fullbredd',
							'one-half' => 'En halv',
							'one-third' => 'En tredjedel',
							'two-thirds' => 'Två tredjedelar',
							'one-quarter' => 'En fjärdedel',
							'three-quarters' => 'Tre fjärdedelar',
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
						'key' => 'field_56cc104207f60',
						'label' => 'Antal rader',
						'name' => 'num_rows',
						'type' => 'select',
						'instructions' => 'Antal rader som innehållet ska synas.',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '40%',
							'class' => '',
							'id' => '',
						),

						'choices' => array (
							'span-rows-1' => '1 rad',
							'span-rows-2' => '2 rader',
							'span-rows-3' => '3 rader',
							'span-rows-4' => '4 rader',
							
						),
						'default_value' => array (
							'span-rows-1' => '1 rad'
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
						'key' => 'field_56eabc5e15411',
						'label' => 'D&ouml;lj puff',
						'name' => 'inactive',
						'type' => 'true_false',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '15%',
							'class' => '',
							'id' => '',
						),
						'message' => '',
						'default_value' => 0,
					),

					array (
						'key' => 'field_56cc0a2e61830',
						'label' => 'Kod',
						'name' => 'code',
						'type' => 'textarea',
						'instructions' => 'HTML-kod',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '100%',
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

					)
				),
				

				array (
					'key' => '56bb0a25a4101',
					'name' => 'lagg_till_driftstorning',
					'label' => 'Driftstörning',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_56cc104207f51',
							'label' => 'Layout',
							'name' => 'layout',
							'type' => 'select',
							'instructions' => 'Hur stor del av skärmen som puffen använda.',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '45%',
								'class' => '',
								'id' => '',
							),
	
							'choices' => array (
								'one-whole' => 'Fullbredd',
								'one-half' => 'En halv',
								'one-third' => 'En tredjedel',
								'two-thirds' => 'Två tredjedelar',
								'one-quarter' => 'En fjärdedel',
								'three-quarters' => 'Tre fjärdedelar',
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
							'key' => 'field_56cc104207f61',
							'label' => 'Antal rader',
							'name' => 'num_rows',
							'type' => 'select',
							'instructions' => 'Antal rader som innehållet ska synas.',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '40%',
								'class' => '',
								'id' => '',
							),
	
							'choices' => array (
								'span-rows-1' => '1 rad',
								'span-rows-2' => '2 rader',
								'span-rows-3' => '3 rader',
								'span-rows-4' => '4 rader',
								
							),
							'default_value' => array (
								'span-rows-1' => '1 rad'
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
							'key' => 'field_56eabc5e15412',
							'label' => 'D&ouml;lj puff',
							'name' => 'inactive',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '15%',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
						),
	
	
					)
				),

				array (
					'key' => '56bb0a25a4103',
					'name' => 'lagg_till_wide_size_start',
					'label' => 'Utvalda puffar',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_56cc104207f51',
							'label' => 'Layout',
							'name' => 'layout',
							'type' => 'select',
							'instructions' => 'Hur stor del av skärmen som puffen använda.',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '45%',
								'class' => '',
								'id' => '',
							),
	
							'choices' => array (
								'one-whole-wide' => 'Helbredd',
								'one-whole' => 'Fullbredd',
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
					)
				),

				array (
					'key' => '56bb0a25a4104',
					'name' => 'lagg_till_wide_size_stop',
					'label' => 'Utvalda puffar - stopp',
					'display' => 'block',
					'sub_fields' => array ()
				),

				array (
					'key' => '56bb0a25a4102',
					'name' => 'lagg_till_bubble',
					'label' => 'Bubblare',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_56cc104207f52',
							'label' => 'Layout',
							'name' => 'layout',
							'type' => 'select',
							'instructions' => 'Hur stor del av skärmen som puffen använda.',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '70%',
								'class' => '',
								'id' => '',
							),
	
							'choices' => array (
								'one-whole-wide' => 'Helbredd',
								'one-whole' => 'Fullbredd',
								// 'one-half' => 'En halv',
								// 'one-third' => 'En tredjedel',
								// 'two-thirds' => 'Två tredjedelar',
								// 'one-quarter' => 'En fjärdedel',
								// 'three-quarters' => 'Tre fjärdedelar',
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
							'key' => 'field_56eabc5e15414',
							'label' => 'Bläddra automatiskt',
							'name' => 'animate',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '15%',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
						),
						array (
							'key' => 'field_56eabc5e15413',
							'label' => 'D&ouml;lj puff',
							'name' => 'inactive',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '15%',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
						),
	
					)
				),


				array (
					'key' => '56bb0a27a4100',
					'name' => 'lagg_till_title',
					'label' => 'Rubrik',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_56cc072e6183b',
							'label' => 'Rubrik',
							'name' => 'title',
							'type' => 'text',
							'instructions' => '',
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
							'key' => 'field_56cc104267f50',
							'label' => 'Layout',
							'name' => 'layout',
							'type' => 'select',
							'instructions' => 'Hur stor del av skärmen som puffen använda.',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '45%',
								'class' => '',
								'id' => '',
							),
	
							'choices' => array (
								'one-whole' => 'Fullbredd',
								'one-half' => 'En halv',
								'one-third' => 'En tredjedel',
								'two-thirds' => 'Två tredjedelar',
								'one-quarter' => 'En fjärdedel',
								'three-quarters' => 'Tre fjärdedelar',
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
							'key' => 'field_56eab75e15411',
							'label' => 'D&ouml;lj puff',
							'name' => 'inactive',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '15%',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
						),
	
						array (
							'key' => 'field_56cc0a2e91830',
							'label' => 'Text',
							'name' => 'description',
							'type' => 'textarea',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '100%',
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
	
						)
					),
						

				array (
					'key' => '56bb0a25a4143',
					'name' => 'lagg_till_puff',
					'label' => 'Puff',
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
							'default_value' => array ( 'featured-image'
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
								'width' => '35%',
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
								'width' => '25%',
								'class' => '',
								'id' => '',
							),
							'choices' => array (
								'one-whole' => 'Fullbredd',
								'one-half' => 'En halv',
								'one-third' => 'En tredjedel',
								'two-thirds' => 'Två tredjedelar',
								'one-quarter' => 'En fjärdedel',
								'three-quarters' => 'Tre fjärdedelar',
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
							'key' => 'field_56eabc5e154d0',
							'label' => 'D&ouml;lj puff',
							'name' => 'inactive',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '15%',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
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
								array(
									'key' => '56bb0f17cd046',
									'name' => 'category',
									'label' => 'Kategori',
									'display' => 'block',
									'sub_fields' => array (
										array(
											'key' => 'field_6307362bf26db',
											'label' => 'Kategori',
											'name' => 'category',
											'type' => 'taxonomy',
											'instructions' => '',
											'required' => 0,
											'conditional_logic' => 0,
											'wrapper' => array(
												'width' => '',
												'class' => '',
												'id' => '',
											),
											'taxonomy' => 'category',
											'field_type' => 'select',
											'allow_null' => 0,
											'add_term' => 0,
											'save_terms' => 0,
											'load_terms' => 0,
											'return_format' => 'id',
											'multiple' => 0,
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
											'key' => 'field_56bb0f17cd004',
											'label' => 'Extern URL',
											'name' => 'extern',
											'type' => 'text',
											'instructions' => 'Ange URL till extern sida, inklusive https://',
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
								array (
									'key' => '56bb0f17cd043',
									'name' => 'video',
									'label' => 'Video',
									'display' => 'block',
									'sub_fields' => array (
										array (
											'key' => 'field_56bb0f17cd044',
											'label' => 'Video URL',
											'name' => 'video_url',
											'type' => 'text',
											'instructions' => 'Stöd för youtube och vimeo. Klistra in den vanliga sökvägen till videon. Videon kommer autostarta i ett popupfönster när man klickar på bilden.',
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




						array (
							'key' => 'field_56dd0a2e6183b',
							'label' => 'Video -- gammal, änvänd länka till och välj video istället.',
							'name' => 'video',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '65%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 1,
							'disabled' => 0,
						),
					),

					'min' => '',
					'max' => '',

				),
			),
		)
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
