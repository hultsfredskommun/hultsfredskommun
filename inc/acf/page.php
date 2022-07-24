<?php


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
        'allorany' => 'any',
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



/* FULLSKÄRM SIDA */
register_field_group(array (
    'id' => '50f53001d8c98',
    'title' => 'Redirect adress',
    'fields' =>
    array (
        0 =>
        array (
            'key' => 'field_504b21d9177e7',
            'label' => 'Länk att skicka vidare till',
            'name' => 'hk_redirect',
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
            'key' => 'field_52243a0577dd9',
            'label' => 'Tid innan sidan hoppar vidare (i sekunder).',
            'name' => 'hk_timeout',
            'type' => 'text',
            'default_value' => '5',
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
                'value' => 'hk_fullscreen_page.php',
                'order_no' => 0,
            ),
        ),
        'allorany' => 'any',
    ),
    'options' =>
    array (
        'position' => 'normal',
        'layout' => 'default',
        'hide_on_screen' => array (),
    ),
    'menu_order' => 0,
));