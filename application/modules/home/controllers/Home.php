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
	
	function not_found(){
		$this->data['tpl']='single';
		$this->data['content']=$this->load->view('home_404','',true);
		$this->display();	
	}
	
	function info(){
		$this->data['tpl']='single';
		$this->data['content']=$this->load->view('home_info','',true);
		$this->display();		
	}
	
	
}