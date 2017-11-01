<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(

	/*
	 * Firebase Legacy Token
	 */

	'firebase_db_type' => array(
		'name' => 'firebase_db_type',
		'type' => 'select',
		'group' => 'primary',
		'label' => __( 'Database Type', 'ninja-forms' ) . ' <span style=\'color: red;\'>* NEW</span>',
		'options' => array(
			array( 'label' => 'Realtime Database', 'value' => 'realtime' ),
			array( 'label' => 'Firestore', 'value' => 'firestore' )
		),
		'width' => 'full',
		'value' => 'realtime'
	),

	/*
	 * Service account token
	 */
	'firebase_json_key' => array(
		'name' => 'firebase_json_key',
		'type' => 'textarea',
		'group' => 'primary',
		'label' => __( 'JSON Service Key', 'ninja-forms' ),
		'placeholder' => '',
		'value' => '',
		'width' => 'full'
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
		'label' => __( 'FIrebase Project Name', 'ninja-forms' ),
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
