<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Admin {
	var $data = array();

  function __construct(){
    parent::__construct();
		$this->data['tpl']='home';
		$this->data['icon']='fa fa-dashboard';
		$this->data['subicon']='fa fa-dashboard';
		$this->data['title']='Dashboard';
		$this->data['content']='';		
	}
	
	function index(){
		$this->data['content']=$this->load->view('dashboard',$this->data,true);
		$this->display($this->data);
	}
	
	function change_profile(){
		$result = array(
			'resp'=>false,
			'message'=>'Ada yang salah pada saat mengedit profil anda.'
		);
		if(isset($_POST['profile_id'])){
			$id_user=$_POST['profile_id'];
			//ion auth edit user
			$data = array(
					'first_name' => $_POST['profile_first_name'],
					'last_name' => $_POST['profile_last_name'],
					'email' => $_POST['profile_email'],
					'phone' => $_POST['profile_phone']
					 );
			
			//ion auth edit password user
			if(isset($_POST['profile_rst_pass'])){
				$data['password']=$_POST['profile_password'];
				$msg_passwd="Edit Password berhasil.\n\rSilahkan logout untuk menguji data anda.";
			}else{
				$msg_passwd='';
			}
			$res = $this->ion_auth->update($id_user, $data);
			if($res){
				$result = array(
					'resp'=>TRUE,
					'message'=>"Edit profil berhasil.\n\r".$msg_passwd
				);				
			}else{
				$result = array(
					'resp'=>FALSE,
					'message'=>"Edit profil gagal.\n\rSilahkan ulangi."
				);			
			}
		}else{
			$result = array(
				'resp'=>false,
				'message'=>"Ada yang salah pada saat mengedit profil anda."
			);			
		}
		echo json_encode($result);
	}	
	
}