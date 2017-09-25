<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->data['tpl']='home';		
	}
	
	function index(){
		$this->data['content']=$this->load->view('home_content','',true);
		$this->display();
	}
}