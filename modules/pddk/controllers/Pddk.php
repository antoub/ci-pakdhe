<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pddk extends MY_Admin {
  
  function __construct(){
	parent::__construct();
	$this->data['tpl']='single';
  }
  
  function index(){
	die('index inside pddk');
	//$this->data['content']=$this->load->view('home_content','',true);
	//$this->display();
  }
  
  function master(){
  	$this->display();
  }
  
  
}