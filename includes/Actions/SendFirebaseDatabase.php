<?php if ( ! defined( 'ABSPATH' ) || ! class_exists( 'NF_Abstracts_Action' )) exit;

/**
 * Class NF_Firebase_Actions_SendFirebaseDatabase
 */
final class NF_Firebase_Actions_SendFirebaseDatabase extends NF_Abstracts_Action
{
  /**
   * @var string
   */
  protected $_name  = 'firebase';

  /**
   * @var array
   */
  protected $_tags = array();

  /**
   * @var string
   */
  protected $_timing = 'early';

  /**
   * @var int
   */
  protected $_priority = '10';

  /**
   * Constructor
   */
  public function __construct()
  {
    parent::__construct();

		$settings = NF_Firebase::config( 'ActionSendFirebaseSettings' );

		$this->_settings = array_merge( $this->_settings, $settings );

		$this->_settings = array_merge($this->_settings, $settings);

    $this->_nicename = __( 'Send Firebase', 'ninja-forms' );
	}

	/**
	 * Process form
	 *
	 * @param $action_settings
	 * @param $form_id
	 * @param $data
	 *
	 * @return mixed
	 */
  public function process( $action_settings, $form_id, $data )
  {
    $errors = $this->check_for_errors($action_settings);

    // If there is no errors so send to firebase
    if (empty($errors)) {
    	// Request Method
    	$requestMethod = $action_settings['request_method'];

    	// Generate Request Address
    	$requestAddress = sprintf('https://%s.firebaseio.com%s?auth=%s', $action_settings['database_name'], $action_settings['endpoint'], $action_settings['firebase_auth']);

    	// Request Body
    	$requestBody = json_encode($action_settings['json_body']);

	    // Initialize cURL
	    $curl = curl_init();

	    // Set cURL options
	    curl_setopt( $curl, CURLOPT_URL, $requestAddress );
	    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, $requestMethod );
	    curl_setopt( $curl, CURLOPT_POSTFIELDS, $requestBody );
	    curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
			    'Content-Type: application/json',
			    'Content-Length: ' . strlen($requestBody))
	    );

	    // Timeout
	    curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT ,0 );
	    curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );

	    // Get return value
	    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

	    // Make request
	    $response = curl_exec( $curl );
	    $httpcode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

	    // Check Request
	    if ($response === false || $httpcode < 200 || $httpcode >= 300) {
	    	$curlError = curl_error( $curl );
		    $errors[ 'data_not_sent' ] = sprintf( __( 'Your email action "%s" has an error. Please check this setting and try again. ERROR: %s', 'ninja-forms'), $action_settings[ 'label' ], $curlError ? $curlError : $httpcode . ' - ' . $response );
	    }

	    // Close connection
	    curl_close( $curl );
    }

	  // Only show errors to Administrators.
	  if ( $errors && current_user_can( 'manage_options' ) ){
		  $data[ 'errors' ][ 'form' ] = $errors;
	  }

    return $data;
  }


	/**
	 * Check form data for errors
	 *
	 * @param $action_settings
	 *
	 * @return array
	 */
	protected function check_for_errors( &$action_settings )
	{
		$errors = array();

		$fields = array('firebase_auth', 'request_method', 'database_name', 'endpoint', 'json_body');

		foreach( $fields as $field ){
			// First Check for empty
			if(!isset($action_settings[ $field ]) || !$action_settings[ $field ]) {
				$errors['empty_' . $field] = sprintf( __( 'Your email action "%s" has an empty value for the "%s" setting. Please check this setting and try again.', 'ninja-forms'), $action_settings[ 'label' ], $field );
				continue;
			}

			switch ($field) {
				// Check Json Body
				case 'json_body':
					$action_settings['json_body'] = trim($action_settings['json_body']);
					if (strpos($action_settings['json_body'], '{') === false) $action_settings['json_body'] = "{" . $action_settings['json_body'] . "}";
					// Decode & Check Json
					$action_settings['json_body'] = json_decode($action_settings['json_body']);
					if (json_last_error() !== JSON_ERROR_NONE) {
						$errors['invalid_' . $field] = sprintf( __( 'Your email action "%s" has an invalid value for the "%s" setting. Please check this setting and try again.', 'ninja-forms'), $action_settings[ 'label' ], $field );
						continue;
					}
					break;
				// Check endpoint for json ending
				case 'endpoint':
					$action_settings['endpoint'] = trim($action_settings['endpoint']);
					$endpointParts = explode('.', $action_settings['endpoint']);
					if (end($endpointParts) !== 'json') {
						$errors['invalid_' . $field] = sprintf( __( 'Your email action "%s" has an invalid value for the "%s" setting. Please check this setting and try again.', 'ninja-forms'), $action_settings[ 'label' ], $field );
						continue;
					}
					break;
			}

		}

		return $errors;
	}
}
