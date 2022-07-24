<?php

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
            'label' => 'Position (gammal)',
            'name' => 'hk_contact_position',
            'type' => 'text',
            'instructions' => '',
            'required' => '0',
            'val' => 'address',
            'center' => '57.455560638683025,15.836223059667986',
            'zoom' => '12',
            'order_no' => '9',
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


