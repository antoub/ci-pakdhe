<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget extends MY_Controller {

	function __construct() {
		parent::__construct();

	}
	
	function index(){
	
	}
	
	function org(){
	
	}

	function group_org_user(){
		$html='<span class="label panel-sm bg-black">';
		$html.='<i class="fa fa-tags"></i>&nbsp;'.strtoupper($_SESSION['user_group_name']).'&nbsp;';
		$html.='<i class="fa fa-university"></i>&nbsp;'.$_SESSION['user_org_name'].'&nbsp;';
		$html.='</span>';
		return $html;		
	}
	
	function group(){
	
	}
	
	function user(){
	
	}
	
	
	
}