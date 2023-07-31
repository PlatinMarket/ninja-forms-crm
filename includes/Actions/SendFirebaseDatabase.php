<?php if ( ! defined( 'ABSPATH' ) || ! class_exists( 'NF_Abstracts_Action' )) exit;

// Require composer autoload
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

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

    $this->_nicename = __( 'Send Firebase', 'ninja-forms' );

		$this->_settings = array_merge($this->_settings, $settings);
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
		$json = sprintf('{%s}', $action_settings['json_body']);

		// Request Body
		$requestBody = http_build_query(json_decode($json, true));

		// Initialize cURL
		$curl = curl_init();

		// Set cURL options
		curl_setopt( $curl, CURLOPT_URL, $action_settings['endpoint'] );
		curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "POST" );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $requestBody );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/x-www-form-urlencoded',
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

		// error_log( print_r([
		// 	"url" => $action_settings['endpoint'],
		// 	"request" => $requestBody,
		// 	"response" => $response,
		// 	"code" => $httpcode,
		// ], true ) );


		// Check Request
		if ($response === false || $httpcode < 200 || $httpcode >= 300) {
			$curlError = curl_error( $curl );
			$errors[ 'data_not_sent' ] = sprintf( __( 'Your email action "%s" has an error. Please check this setting and try again. ERROR: %s', 'ninja-forms'), $action_settings[ 'label' ], $curlError ? $curlError : $httpcode . ' - ' . $response );
		}

		// Close connection
		curl_close( $curl );

    return $data;
  }
}
