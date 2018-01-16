<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MX_Controller {

	public function index() {
		$this->load->view('welcome_message');
	}
	
	function test1(){
		echo "hello welcome test1";
	}
	
}
