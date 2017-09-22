<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(

 /*
	* Firebase Legacy Token
	*/

	'firebase_auth' => array(
		'name' => 'firebase_auth',
		'type' => 'textbox',
		'group' => 'primary',
		'label' => __( 'Firebase Legacy Token', 'ninja-forms' ),
		'placeholder' => '',
		'width' => 'full',
		'value' => '',
	),

	/*
   * Request Method
   */

	'request_method' => array(
		'name' => 'request_method',
		'type' => 'select',
		'group' => 'primary',
		'label' => __( 'Request Method', 'ninja-forms' ),
		'options' => array(
			array( 'label' => __( 'POST', 'ninja-forms' ), 'value' => 'POST' ),
			array( 'label' => __( 'PUT', 'ninja-forms' ), 'value' => 'PUT' ),
			array( 'label' => __( 'GET', 'ninja-forms' ), 'value' => 'GET' )
		),
		'width' => 'one-half',
		'value' => 'POST'
	),

	/*
   * Project name
   */

	'database_name' => array(
		'name' => 'database_name',
		'type' => 'textbox',
		'group' => 'primary',
		'label' => __( 'Firebase Database Name', 'ninja-forms' ),
		'placeholder' => '',
		'width' => 'one-half',
		'value' => '',
	),

	/*
	 * Endpoint
	 */

	'endpoint' => array(
		'name' => 'endpoint',
		'type' => 'textbox',
		'group' => 'primary',
		'label' => __( 'Endpoint', 'ninja-forms' ),
		'placeholder' => __( '/link/to/data.json', 'ninja-forms' ),
		'width' => 'full',
		'value' => '',
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
