<?php

/* SERACH */
acf_add_local_field_group(array(
    'key' => 'group_612ceeef98ddd',
    'title' => 'Rek.ai',
    'fields' => array(
        array(
            'key' => 'field_618a936a55576',
            'label' => 'Enable',
            'name' => 'rekai_enable',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '15%',
                'class' => '',
                'id' => '',
            ),
            'show_in_rest' => 0,
            'message' => '',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
        ),
        array(
            'key' => 'field_61288d47b2222',
            'label' => 'ID',
            'name' => 'rekai_id',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_618a936a55576',
                        'operator' => '==',
                        'value' => 1,
                    ),
                ),
            )
,            'wrapper' => array(
                'width' => '30%',
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
            'key' => 'field_618a936a55577',
            'label' => 'Autocomplete search',
            'name' => 'rekai_autocomplete',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_61288d47b2222',
                        'operator' => '!=',
                        'value' => '',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '15%',
                'class' => '',
                'id' => '',
            ),
            'show_in_rest' => 0,
            'message' => '',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'hultsfred-options',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
acf_add_local_field_group(array(
    'key' => 'group_612ceeef98dd3',
    'title' => 'Advanced',
    'fields' => array(
        array(
            'key' => 'field_618a936a54576',
            'label' => 'Enable mellanstartsida istället för widget',
            'name' => 'mellanstart_on_sub_category_enable',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '50%',
                'class' => '',
                'id' => '',
            ),
            'show_in_rest' => 0,
            'message' => '',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'hultsfred-options',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
