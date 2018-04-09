<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_home extends MY_Controller {

	function __construct() {
		parent::__construct();

	}
	
	function index(){
	
	}
	
	function subhead(){
		return $this->load->view('home_subhead',$this->data,true);
	}
	
}