<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acl extends MY_Controller {

  function __construct(){
    parent::__construct();
	}
	
	function login($is_return=false){
		$res = array();
		if($this->ion_auth->logged_in()){
			$res=array('result'=>true);
		}else{
			if((isset($_POST['user_name'])) && (isset($_POST['user_password']))){
				$ok = $this->ion_auth->login($_POST['user_name'], $_POST['user_password']);
				if($ok){
					$res=array('result'=>true,'msg'=>"Login Berhasil.\r\nSilahkan mengelola aplikasi ini melalui menu Dashboard.",'url'=>site_url('dashboard'));
				}else{
					$res=array(
						'result'=>false,
						'msg'=>"Login Gagal.\r\nUsername/Password Salah.\n\rSilahkan ulangi lagi."
						);
				}
			}else{			
				$res=array(
					'result'=>false,
					'msg'=>"Login Gagal.\r\nUsername/Password belum terisi.\n\rSilahkan ulangi lagi."
				);
			}
		}
		
		if($is_return){
			return json_encode($res);
		}else{
			echo json_encode($res);		
		}
	}
		
	function logout(){
		$this->ion_auth->logout();
		redirect(site_url(), 'refresh');	
	}
	
}