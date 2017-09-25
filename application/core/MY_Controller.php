<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
	/*
		Non Login Core Controller
	*/
	class MY_Controller extends MX_Controller {
		var $data;
		var $CI;
		var $MYCFG;
		
		function __construct(){
			parent::__construct();
			$this->data['content']=(isset($this->data['content'])) ? $this->data['content'] : 'Content Goes Here';
		}
		
		function __nocache() {
			$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
			$this->output->set_header('Pragma: no-cache');
		}
		
		function __current_session_user(){
			if ($this->ion_auth->logged_in()){			
				$this->session->userdata['first_name'] = $this->ion_auth->user()->row()->first_name;
				$this->session->userdata['last_name'] = $this->ion_auth->user()->row()->last_name;
				$this->session->userdata['phone'] = $this->ion_auth->user()->row()->phone;
				
			}		
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

	/*
		Login Core Controller
	*/
	class MY_Admin extends MY_Controller {
		
		public function __construct(){
			parent::__construct();
			if (!$this->ion_auth->logged_in()) redirect('/acl/login/logout');
			$this->__current_session_user();			
		}
		
	}		