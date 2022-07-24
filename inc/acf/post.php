<?php


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
                                'Blanketter' => 'Blanketter & e-tjänster',
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



/* POST STOP PUBLISH */
$options = get_option("hk_theme");
if ($options['enable_cron_stop_publish']) {

    if (function_exists('acf_add_local_field_group') ) {

        acf_add_local_field_group(array (
            'key' => 'acf_sluta-publicera',
            'title' => 'Sluta publicera',
            'fields' => array (
                array (
                    'key' => 'field_51bffccf1a73f',
                    'label' => 'Datum',
                    'name' => 'hk_stop_publish_date',
                    'type' => 'date_picker',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'display_format' => 'Y-m-d',
                    'return_format' => 'Ymd',
                    'first_day' => 1,
                ),
                array (
                    'key' => 'field_51bffe875ccc4',
                    'label' => 'Tid',
                    'name' => 'hk_stop_publish_hour',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
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
                    'default_value' => array (
                    ),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'ajax' => 0,
                    'return_format' => 'value',
                    'placeholder' => '',
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
            'options' =>
              array (
                'position' => 'side',
                'layout' => 'default',
                'hide_on_screen' =>
                array (
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

    }


}