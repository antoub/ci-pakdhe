<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends MY_Admin {
	
	function __construct(){
		parent::__construct();
		$this->data['tpl']='single';		
	}

	function index() {
		$this->data['css']=css_asset('bootstrap-table.min.css','bootstrap-table');		
		$this->data['js']=js_asset('bootstrap-table.min.js','bootstrap-table');
		
		$meta = $this->meta('acl/groups/',true);
		$this->data['auth_meta']=$meta['act'];
		$this->data['icon']=$meta['icon'];
		$this->data['title']=$meta['title'];

		$obj_groups=$this->ion_auth->groups()->result();
		$this->data['ls_groups']=	$array = json_decode(json_encode($obj_groups), true); 
		$this->data['content']=$this->load->view('grid_groups',$this->data,true);
		$this->display($this->data);
	}

	function get_json(){
		$ret = array(
			'total'=>0,
			'rows'=>array()
		);
		
		$limit=isset($_GET['limit']) ? $_GET['limit'] : 10;
		$offset=isset($_GET['offset']) ? $_GET['offset'] : 0;
		$search=(isset($_GET['search'])) ? $_GET['search'] : '';
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name,description';
		$order = (isset($_GET['order'])) ? $_GET['order'] : 'asc';

		$SQL_BASE='
			select *
			from groups
		';
		
		if($search<>''){
			//get where
			$SQL_BASE.='WHERE ';
			$SQL_BASE.='name like "%'.$search.'%" OR ';
			$SQL_BASE.='description like "%'.$search.'%" ';
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
		
		header('Content-Type: application/json');
		echo json_encode($ret);		
	}
	
	function act_add(){
		$ret=array(
			'success'=>false,
			'msg'=>'Gagal Menambah Data'
		);
		
		$data['name']=$_POST['name'];
		$data['description']=$_POST['description'];
		$this->db->insert('groups', $data); 
		$last_insert_id=$this->db->insert_id();
		if($last_insert_id){
			$ret=array(
				'success'=>true,
				'msg'=>'Berhasil Menambah Data'
			);		
		}
		
		header('Content-Type: application/json');		
		echo json_encode($ret);	
	}
	
	function act_edit(){
		$ret=array(
			'success'=>false,
			'msg'=>'Gagal Mengubah Data'
		);
		
		$data['name']=$_POST['name'];
		$data['description']=$_POST['description'];
		$this->db->update('groups', $data,array('id'=>$_POST['id'])); 
		$ret=array(
				'success'=>true,
				'msg'=>'Berhasil Mengubah Data'
			);

		header('Content-Type: application/json');
		echo json_encode($ret);
	}
	
	function act_del(){
		$id=$_POST['id'];
		//delete records
		$this->db->delete('groups', array('id' => $id));
		$ret=array(
			'success'=>true,
			'msg'=>'Berhasil Menghapus Data.'
		);
		
		header('Content-Type: application/json');		
		echo json_encode($ret);
	}
		
}