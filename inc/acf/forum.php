<?php

    acf_add_local_field_group(array(
        'key' => 'group_6318bdea889d9',
        'title' => 'Foruminlägg',
        'fields' => array(
            array(
                'key' => 'field_6318dec7a7395',
                'label' => 'Fråga',
                'name' => 'fraga',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_6318d45058f22',
                'label' => 'Inkom',
                'name' => 'inkom_datum',
                'type' => 'date_picker',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'Ymd',
                'return_format' => 'j F, Y',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_6318d49542d85',
                'label' => 'Underskrift',
                'name' => 'underskrift',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
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
                'key' => 'field_6318d33636be0',
                'label' => 'Svar',
                'name' => 'svar',
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
                    'layout_6318d34571dfc' => array(
                        'key' => 'layout_6318d34571dfc',
                        'name' => 'svar',
                        'label' => 'Svar',
                        'display' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_6318d3e036be2',
                                'label' => 'Svar',
                                'name' => 'svar',
                                'type' => 'wysiwyg',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'tabs' => 'all',
                                'toolbar' => 'full',
                                'media_upload' => 1,
                                'delay' => 0,
                            ),
                            array(
                                'key' => 'field_6318d36836be1',
                                'label' => 'Datum',
                                'name' => 'datum',
                                'type' => 'date_picker',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'display_format' => 'Ymd',
                                'return_format' => 'j F, Y',
                                'first_day' => 1,
                            ),
                            array(
                                'key' => 'field_6318d41636be3',
                                'label' => 'Underskrift',
                                'name' => 'underskrift',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
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
                ),
                'button_label' => 'Lägg till rad',
                'min' => '',
                'max' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'hk_forum',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            0 => 'the_content',
            1 => 'excerpt',
            2 => 'discussion',
            3 => 'comments',
            4 => 'format',
            5 => 'page_attributes',
            6 => 'featured_image',
            7 => 'categories',
            8 => 'tags',
            9 => 'send-trackbacks',
        ),
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    