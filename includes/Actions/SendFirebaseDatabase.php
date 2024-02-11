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

  private function processMailchimp($settings, $body) {
    try {
      $mailchimp = new \MailchimpMarketing\ApiClient();

      $token = preg_match("/(.+)-(.+)/", $settings['mailchimp_api_key'], $matches);

      $mailchimp->setConfig([
        'apiKey' => $matches[0],
        'server' => $matches[2],
      ]);

      $response = $mailchimp->lists->addListMember($settings['mailchimp_list'], [
          'email_address' => $body['email'],
          'status' => 'subscribed',
          'merge_fields' => [
              'FNAME' => $body['name'],
              'LNAME' => '',
              'PHONE' => $body['phoneNumber'],
          ],
      ], false);
    } catch (\throwable $e) {
      error_log( print_r($e, true ) );
    }
  }

  private function processCustom($settings, $body) {
    try {
      foreach( $body as &$value ) {
          $value = iconv( 'UTF-8','ISO-8859-9', $value );
      }

      $body = http_build_query($body);

      // Initialize cURL
      $curl = curl_init();

      // Set cURL options
      curl_setopt( $curl, CURLOPT_URL, $settings['endpoint'] );
      curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "POST" );
      curl_setopt( $curl, CURLOPT_POSTFIELDS, $body );
      curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/x-www-form-urlencoded',
          'Content-Length: ' . strlen($body))
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
      // 	"url" => $settings['endpoint'],
      // 	"request" => $body,
      // 	"response" => $response,
      // 	"code" => $httpcode,
      // ], true ) );

      // Check Request
      if ($response === false || $httpcode < 200 || $httpcode >= 300) {
        $curlError = curl_error( $curl );
        $errors[ 'data_not_sent' ] = sprintf( __( 'Your email action "%s" has an error. Please check this setting and try again. ERROR: %s', 'ninja-forms'), $settings[ 'label' ], $curlError ? $curlError : $httpcode . ' - ' . $response );
      }

      // Close connection
      curl_close( $curl );
    } catch (\throwable $e) {
      error_log( print_r($e, true ) );
    }
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

		$body = json_decode($json, true);

    $this->processCustom($action_settings, $body);
    $this->processMailchimp($action_settings, $body);

    return $data;
  }
}
