<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(
  'mailchimp_api_key' => array(
		'name' => 'mailchimp_api_key',
		'type' => 'textbox',
		'group' => 'primary',
		'label' => __( 'Mailchimp API KEY', 'ninja-forms' ),
		'placeholder' => __( '###############################-us5', 'ninja-forms' ),
		'width' => 'full',
		'value' => '',
		'use_merge_tags' => TRUE
	),

  'mailchimp_list' => array(
    'name' => 'mailchimp_list',
		'type' => 'textbox',
		'group' => 'primary',
		'label' => __( 'Mailchimp LIST', 'ninja-forms' ),
		'placeholder' => __( '5a745b43c7', 'ninja-forms' ),
		'width' => 'full',
		'value' => '',
		'use_merge_tags' => TRUE
  ),

	/*
	 * Endpoint
	 */
	'endpoint' => array(
		'name' => 'endpoint',
		'type' => 'textbox',
		'group' => 'primary',
		'label' => __( 'Endpoint', 'ninja-forms' ),
		'placeholder' => __( 'https://remote/path', 'ninja-forms' ),
		'width' => 'full',
		'value' => 'https://platindestek.com/platinbox/musteri_adayi_ekle.asp',
		'use_merge_tags' => TRUE
	),

	/*
	 * Json Body
	 */
	'json_body' => array(
		'name' => 'json_body',
		'type' => 'textarea',
		'group' => 'primary',
		'label' => __( 'JSON Body', 'ninja-forms' ),
		'placeholder' => '',
		'value' => '"key1": "value1"' . "\n" . '"key2": "value2"',
		'width' => 'full',
		'use_merge_tags' => array(
			'include' => array(
				'calcs',
			),
		)
	),
);
