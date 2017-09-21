<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_FirebaseExample
 */
class NF_Firebase_Fields_FirebaseExample extends NF_Fields_Textbox
{
    protected $_name = 'firebase';

    protected $_section = 'common';

    protected $_type = 'textbox';

    protected $_templates = 'textbox';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Firebase Example Field', 'ninja-forms' );
    }
}