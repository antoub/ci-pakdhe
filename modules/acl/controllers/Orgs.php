<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orgs extends MY_Admin {

	function __construct() {
		parent::__construct();

		$this->data['tpl']='single';
		$this->data['icon']='fa fa-university';
		
		$this->data['title']='Organisasi';
		$this->data['table_name'] = 'orgs';
		$this->data['content']='';
		$this->data['css']=css_asset('bootstrap-table.min.css','bootstrap-table');
		$this->data['js']=js_asset('bootstrap-table.min.js','bootstrap-table');
	}
	
	function index(){
		$mydata = $this->data;
		$mydata['auth_meta'] = $this->meta('acl/orgs/',true);
		//print_r($mydata);die;
		$mydata['tbl_icon']=$this->data['icon'];
		$mydata['tbl_title']=$this->data['title'];
		$mydata['tbl']='mytabel';
		$arr_tree = $this->the_org_child_tree($_SESSION['user_org']);
		if(count($arr_tree)){
			$mydata['tree_org']=$arr_tree;
		}else{
			$mydata['tree_org']=array($_SESSION['user_org']);
		}
		$mydata['fields'] = $this->db->list_fields($this->data['table_name']);

		$this->data['content']=$this->load->view('grid_orgs',$mydata,true);
		$this->display();
		
	}
	
	function __search($keywords=''){
		$mysearchwhere='';
		$this->db->select(''.$this->data['table_name'].'.*');
		$this->db->from($this->data['table_name']);
		$this->__filter_org();
		
		$fields = $this->db->list_fields($this->data['table_name']);
		foreach($fields as $k=>$v){
			$arr_search[$k]=' upper('.$this->data['table_name'].'.'.$v.') like "%'.$keywords.'%" ';
		}
		$mysearchwhere=' ('.implode(' OR ',$arr_search).') ';
		$this->db->where($mysearchwhere);
	}	

	function __filter_org(){
		if($_SESSION['user_group']==3){
			//group camat
			//get all child orgs
			$ls_child = the_org_child($_SESSION['user_org']);
			if(count($ls_child)){
				//foreach($ls_child as $k=>$v){
					//$this->db->or_where('org_id',$v);
				//}
				$this->db->where('( org_id in ('.implode(',',$ls_child).') )');
			}
		}elseif($_SESSION['user_group']==4){
			//group gampong
			$this->db->where('org_id',$_SESSION['user_org']);
			
		}elseif($_SESSION['user_group']==1){
			//group admin 
			
		}
	}
	
	function get_json(){
		header('Content-Type: application/json');
		$limit=$_GET['limit'];
		$offset=$_GET['offset'];
		$search=(isset($_GET['search'])) ? $_GET['search'] : '';
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'id';
		$order = (isset($_GET['order'])) ? $_GET['order'] : 'asc';
		
		if($search<>''){
			
			$this->__search($search);
			$ls_data_all = $this->db->get()->result_array();
			$ret['total']=count($ls_data_all);
			
			$this->__search($search);
			$this->db->limit($limit,$offset);
			if(($sort)&&($order))
				$this->db->order_by($sort,$order);
			$ls_data = $this->db->get()->result_array();
		}else{
			$this->db->select('*');
			$this->db->from($this->data['table_name']);
			
			//ambil total data :
			//$ret['total']=$this->db->count_all($this->data['table_name']);
			$ls_data = $this->db->get()->result_array();
			$ret['total']=count($ls_data);

			$this->db->select('*');
			$this->db->from($this->data['table_name']);

			$this->db->limit($limit,$offset);
			if(($sort)&&($order))
				$this->db->order_by($sort,$order);
			$ls_data = $this->db->get()->result_array();
			
		}		
		$ret['rows']=$ls_data;
		
		echo json_encode($ret);
	}

	function edit(){
		$fields = $this->db->field_data($this->data['table_name']);

		foreach($fields as $k=>$v){
			if(isset($_POST[$v->name]))
				$data[$v->name] = $_POST[$v->name];
		}
		
		/*
		$user = $this->ion_auth->user()->row();
		$data['id_user']= $user->id;
		$now = date("Y-m-d H:i:s");
		$data['changed_date']= $now;
		*/
		
		$this->db->where('id', $data['id']);
		$this->db->update($this->data['table_name'], $data);
		$last_insert_id=$data['id'];
		if($last_insert_id){
			$mydata['resp']=true;
			$mydata['message']='berhasil mengubah data.';
		}else{
			$mydata['resp']=false;
			$mydata['message']='gagal mengubah data.';		
		}
		header('Content-Type: application/json');
		echo json_encode($mydata);
	}
	
	function add(){		
		$fields = $this->db->field_data($this->data['table_name']);
		foreach($fields as $k=>$v){
			if(isset($_POST[$v->name])){
				if($v->primary_key){
					//do nothing for primary key
				}else{
					if(!empty($_POST[$v->name]))
						$data[$v->name] = $_POST[$v->name];
				}
			}
		}
		
		/*
		$user = $this->ion_auth->user()->row();
		$data['id_user']= $user->id;
		$now = date("Y-m-d H:i:s");
		$data['changed_date']= $now;
		*/

		$this->db->insert($this->data['table_name'], $data);
		$last_insert_id=$this->db->insert_id();
		if($last_insert_id){
			$mydata['resp']=true;
			$mydata['message']='berhasil menambah data.';
		}else{
			$mydata['resp']=false;
			$mydata['message']='gagal menambah data.';		
		}
		header('Content-Type: application/json');
		echo json_encode($mydata);		
	}

	
	function remove(){
		$resp=array(
			'success'=>true,
			'message'=>'Berhasil Menghapus'
		);
		$this->db->delete($this->data['table_name'], array('id' => $_POST['id']));
		
		
		header('Content-Type: application/json');
		echo json_encode($resp);
	}
	
	
}