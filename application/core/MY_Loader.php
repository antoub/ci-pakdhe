<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {
	function __construct() {
		parent::__construct();
		$this->_ci_ob_level  = ob_get_level();
		$this->_ci_view_paths = array(FCPATH . 'themes/' => TRUE);
	}	
}