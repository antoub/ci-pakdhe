<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Admin {
	
	function __construct() {
		parent::__construct();
		$this->data['tpl']='single';
		$this->data['icon']='fa fa-cogs';
		$this->data['subicon']='fa fa-university';
		$this->data['title']='Users';
		$this->data['table_name'] = 'users';
		$this->data['content']='';
		$this->data['css']=css_asset('bootstrap-table.min.css','bootstrap-table');
		$this->data['css'].=css_asset('bootstrap3-wysihtml5.min.css','bootstrap-wysihtml5');
		$this->data['js']=js_asset('bootstrap-table.min.js','bootstrap-table');
		$this->data['js'].=js_asset('bootstrap3-wysihtml5.all.min.js','bootstrap-wysihtml5');
		$this->data['auth_meta'] = $this->meta('acl/users/',true);
	}

	function index(){
		$this->load->library('form_validation');
		$mydata['auth_meta'] = $this->meta('acl/users/',true);
		$mydata['tbl_icon']=$this->data['subicon'];
		$mydata['tbl_title']=$this->data['title'];
		$mydata['tbl']='mytabel';

		$mydata['groups'] = $this->db->get('groups')->result();
		$this->db->order_by('parent_id,name','asc');		
		$mydata['orgs'] = $this->db->get('orgs')->result_array();
		
		//for org,bid,sie 
		$mydata['tree_org']=$this->buildtree($mydata['orgs']);
		$this->data['content']=$this->load->view('grid_users',$mydata,true);
		$this->display();
	}


	function get_json(){
		$ret = array(
			'total'=>0,
			'rows'=>array()
		);
		header('Content-Type: application/json');
		
		$limit=isset($_GET['limit']) ? $_GET['limit'] : 10;
		$offset=isset($_GET['offset']) ? $_GET['offset'] : 0;
		$search=(isset($_GET['search'])) ? $_GET['search'] : '';
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'email,username';
		$order = (isset($_GET['order'])) ? $_GET['order'] : 'asc';
		$SQL_BASE = "
			select 
			users.id,
			users.username,
			users.email, 
			users.first_name,
			users.last_name,
			users.company,
			users.phone,
			users_groups.group_id,
			groups.name as groups,
			users_orgs.org_id,
			orgs.name as orgs
			from 
			((((users left join users_groups on users_groups.user_id=users.id)
			left join groups on groups.id=users_groups.group_id)
			left join users_orgs on users_orgs.user_id=users.id)
			left join orgs on orgs.id=users_orgs.org_id)
		";
		
		if($search<>''){
			//get where
			$SQL_BASE.='WHERE ';
			$SQL_BASE.='lower(username) like "%'.strtolower($search).'%" OR ';
			$SQL_BASE.='lower(email) like "%'.strtolower($search).'%" OR ';
			$SQL_BASE.='lower(first_name) like "%'.strtolower($search).'%" OR ';
			$SQL_BASE.='lower(last_name) like "%'.strtolower($search).'%" OR ';
			$SQL_BASE.='lower(groups.name) like "%'.strtolower($search).'%" OR ';
			$SQL_BASE.='lower(orgs.name) like "%'.strtolower($search).'%" ';
			$ls_data=$this->db->query($SQL_BASE)->result_array();

			$ret['total'] = count($ls_data);
						
			//get where with limit
			$SQL=($sort) ? $SQL_BASE.' ORDER BY '.$sort.' '.$order : $SQL_BASE;
			$SQL.=' LIMIT '.$offset.','.$limit;
			$ls_data_limit=$this->db->query($SQL)->result_array();
			$ret['rows'] = $ls_data_limit;

		}else{
			//get all
			$ls_data=$this->db->query($SQL_BASE)->result_array();
			$ret['total'] = count($ls_data);
			//get limit
			$SQL=($sort) ? $SQL_BASE.' ORDER BY '.$sort.' '.$order : $SQL_BASE;
			$SQL.=' LIMIT '.$offset.','.$limit;
			$ls_data_limit=$this->db->query($SQL)->result_array();
			$ret['rows'] = $ls_data_limit;
		}

		echo json_encode($ret);	
	}
	
	function add(){
		$this->load->library('form_validation');

		$ret=array(
			'resp'=>false,
			'message'=>'Gagal Menambah Data'
		);

		$this->form_validation->set_rules('first_name','First name','trim');
  		$this->form_validation->set_rules('last_name','Last name','trim');
  		$this->form_validation->set_rules('company','Company','trim');
  		$this->form_validation->set_rules('phone','Phone','trim');
  		$this->form_validation->set_rules('username','Username','trim|required|is_unique[users.username]');
  		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[users.email]');
  		$this->form_validation->set_rules('password','Password','required');
  		$this->form_validation->set_rules('groups','Groups','required|integer');
  		$this->form_validation->set_rules('orgs','Orgs','required|integer');
		
		if($this->form_validation->run()===FALSE){
			$ret=array(
				'resp'=>false,
				'message'=> validation_errors()
			);
		}else{
			$username=$_POST['username'];
			$password=$_POST['password'];
			$email   =$_POST['email'];
			$group_ids = $this->input->post('groups');
			
			$org_id = $this->input->post('orgs');
			$bidang_id = $this->input->post('bidang');
			$seksi_id = $this->input->post('seksi');

			$additional_data = array(
      			'first_name' => $this->input->post('first_name'),
      			'last_name' => $this->input->post('last_name'),
      			'company' => $this->input->post('company'),
     			'phone' => $this->input->post('phone')
    		);


			if ($this->ion_auth->register($username, $password, $email, $additional_data,array($group_ids))) {
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				
				$user_id=$this->getLastInserted('users','id');

				$data['user_id']=$user_id;
				$data['org_id']=$org_id;
				$this->db->insert('users_orgs', $data); 

				$ret=array(
					'resp'=>true,
					'message'=>'Berhasil Menambah Data'
				);
			}else{
				$ret=array(
					'resp'=>true,
					'message'=> $this->ion_auth->errors()
				);
			}
		}
		echo json_encode($ret);	
	}

	function getLastInserted($table, $id) {
		$this->db->select_max($id);
		$Q = $this->db->get($table);
		$row = $Q->row_array();
		return $row[$id];
 	}
	
	function edit(){
		$id = $this->input->post('id') ? $this->input->post('id') : $id;
		$this->load->library('form_validation');

		$ret=array(
			'resp'=>false,
			'message'=>'Gagal Mengubah Data'
		);

		$this->form_validation->set_rules('first_name','First name','trim');
  	$this->form_validation->set_rules('last_name','Last name','trim');
 		$this->form_validation->set_rules('company','Company','trim');
  	$this->form_validation->set_rules('phone','Phone','trim');
  	$this->form_validation->set_rules('username','Username','trim|required');
  	$this->form_validation->set_rules('email','Email','trim|required|valid_email');
  	$this->form_validation->set_rules('groups[]','Groups','required|integer');
  	$this->form_validation->set_rules('id','User ID','trim|integer|required');

  		if($this->form_validation->run()===FALSE){
			$ret=array(
				'resp'=>false,
				'message'=> validation_errors()
			);
		}else{
			$id = $this->input->post('id');

			$org_id = $this->input->post('orgs');
			$bidang_id = $this->input->post('bidang');
			$seksi_id = $this->input->post('seksi');
    	
			$data_edit = array(
      			'username' => $this->input->post('username'),
      			'email' => $this->input->post('email'),
      			'first_name' => $this->input->post('first_name'),
      			'last_name' => $this->input->post('last_name'),
      			'company' => $this->input->post('company'),
      			'phone' => $this->input->post('phone')
    		);

				if(strlen($this->input->post('password'))>=0) $data_edit['password'] = $this->input->post('password');

    		$this->ion_auth->update($id, $data_edit);

    		//Update the groups user belongs to
    		$groups = $this->input->post('groups');
    		if (isset($groups) && !empty($groups)){
      			$this->ion_auth->remove_from_group('', $id);
        		$this->ion_auth->add_to_group($groups, $id);
    		}

    		//Update the orgs user belongs to
    		$orgs = $this->input->post('orgs');
    		if (isset($orgs) && !empty($orgs)){
      			$this->db->delete('users_orgs', array('user_id' => $id));

						$data['user_id']=$id;
						$data['org_id']=$org_id;
						$this->db->insert('users_orgs', $data); 
						
    		}

    		$this->session->set_flashdata('message',$this->ion_auth->messages());
    		$ret=array(
				'resp'=>true,
				'message'=>'Berhasil Mengubah Data'
			);
		}

		echo json_encode($ret);
	}
	
	function del(){
		$id=$_POST['id'];
		//delete records
		$this->db->delete('users', array('id' => $id));
		$ret=array(
			'resp'=>true,
			'message'=>'Berhasil Menghapus Data.'
		);
		
		echo json_encode($ret);
	}

	function get_users_orgs(){
		$user_id=$_POST['id'];

		$this->db->select('*');
		$this->db->from('users_orgs');
		$this->db->where('user_id',$user_id);

		$ls_data = $this->db->get()->result_array();
		
		$ret['data_orgs']=$ls_data;

		echo json_encode($ret);
		
	}

	function get_users_groups(){
		$user_id=$_POST['id'];

		$this->db->select('*');
		$this->db->from('users_groups');
		$this->db->where('user_id',$user_id);

		$ls_data = $this->db->get()->result_array();
		
		$ret['rows']=$ls_data;

		echo json_encode($ret);
	}
		
}