<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(
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
