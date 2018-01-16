<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_acl extends MY_Controller {

	function __construct() {
		parent::__construct();

	}
	
	function index(){
	
	}
	
	function org(){
		return "org here gaes";
	}

	function group_org_user(){
		$html='<span class="label panel-sm bg-black">';
		$html.='<i class="fa fa-tags"></i>&nbsp;'.strtoupper($_SESSION['group_name']).'&nbsp;';
		$html.='<i class="fa fa-university"></i>&nbsp;'.strtoupper($_SESSION['org_name']).'&nbsp;';
		$html.='</span>';
		return $html;		
	}
	
	function group(){
	
	}
	
	function user(){
	
	}
	
	
	
}