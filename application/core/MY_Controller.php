<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
	
	class MY_Controller extends MX_Controller{
		
		public function __construct(){
			parent::__construct();
			
		}
		
		function __nocache() {
			$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
			$this->output->set_header('Pragma: no-cache');
		}
		
		function display(){
			if($this->data['tpl']=='home'){
				$tpl='frontend/home';
				}elseif($this->data['tpl']=='single'){
				$tpl='frontend/single';
				}else{
				$tpl='frontend/'.$this->data['tpl'];
			}
			$this->load->view($tpl,$this->data);
		}
		
	}
	
	class MY_Admin extends MY_Controller {
		
		public function __construct(){
			parent::__construct();
		}
		
	}		