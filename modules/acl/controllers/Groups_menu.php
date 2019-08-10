<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_menu extends MY_Admin {
	
	function __construct(){
		parent::__construct();
		$this->data['tpl']='single';
	}

	function index() {
		$this->data['css']=css_asset('bootstrap-table.min.css','bootstrap-table');
		$this->data['css'].=css_asset('bootstrap-table-group-by.css','bootstrap-table');
		$this->data['css'].=css_asset('select2.min.css','select2');
		
		$this->data['js']=js_asset('bootstrap-table.min.js','bootstrap-table');
		$this->data['js'].=js_asset('bootstrap-table-group-by.js','bootstrap-table');
		$this->data['js'].=js_asset('select2.full.min.js','select2');
		
		$meta = $this->meta('acl/groups_menu/',true);
		$this->data['auth_meta']=$meta['act'];
		$this->data['icon']=$meta['icon'];
		$this->data['title']=$meta['title'];
		$this->data['ls_menu']=$this->__get_menu_all();

		$obj_groups=$this->ion_auth->groups()->result();
		$this->data['ls_groups']=	$array = json_decode(json_encode($obj_groups), true); 
		
		$this->data['content']=$this->load->view('grid_groups_menu',$this->data,true);
		$this->display($this->data);
	}
	
	function __get_menu_all(){
		$this->db->order_by('list_order','asc');
		$res = $this->db->get('menus')->result_array();
		return $res;
	}
	
	function get_json(){
		$ret = array(
			$this->data['csrf']['name']=>$this->data['csrf']['hash'],		
			'total'=>0,
			'rows'=>array()
		);
		header('Content-Type: application/json');
		
		$limit=isset($_GET['limit']) ? $_GET['limit'] : 10;
		$offset=isset($_GET['offset']) ? $_GET['offset'] : 0;
		$search=(isset($_GET['search'])) ? $_GET['search'] : '';
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'groups_name,list_order';
		$order = (isset($_GET['order'])) ? $_GET['order'] : 'asc';

		$SQL_BASE='
			select 
			groups_menus.id as id,
			group_id,
			groups.name as groups_name,
			menu_id,
			menus.name as menus_name,
			menus.list_order,
			akses, tambah, ubah, hapus
			from 
			((groups_menus left join groups on groups.id=groups_menus.group_id) 
				left join menus on menus.id=groups_menus.menu_id) 
		';
		
		if($search<>''){
			//get where
			$SQL_BASE.='WHERE ';
			$SQL_BASE.='lower(groups.name) like "%'.strtolower($search).'%" OR ';
			$SQL_BASE.='lower(menus.name) like "%'.strtolower($search).'%" ';
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
	
	function act_add(){
		$ret=array(
			$this->data['csrf']['name']=>$this->data['csrf']['hash'],		
			'resp'=>false,
			'msg'=>'Gagal Menambah Data'
		);
		
		$data['group_id']=$_POST['group_id'];
		$data['menu_id']=$_POST['menu_id'];
		
		$data['akses']=(isset($_POST['akses'])) ?$_POST['akses']:0;
		$data['tambah']=(isset($_POST['tambah']))?$_POST['tambah']:0;
		$data['ubah']=(isset($_POST['ubah'])) ? $_POST['ubah']:0;
		$data['hapus']=(isset($_POST['hapus']))? $_POST['hapus']:0;

		$this->db->insert('groups_menus', $data); 
		$last_insert_id=$this->db->insert_id();
		if($last_insert_id){
			$ret['resp']=true;
			$ret['msg']='Berhasil Menambah Data';
		}
		echo json_encode($ret);	
	}
	
	function act_edit(){
		$ret=array(
			$this->data['csrf']['name']=>$this->data['csrf']['hash'],
			'resp'=>false,
			'msg'=>'Gagal Mengubah Data'
		);
		
		$data['group_id']=$_POST['group_id'];
		$data['menu_id']=$_POST['menu_id'];
		
		$data['akses']=(isset($_POST['akses'])) ?$_POST['akses']:0;
		$data['tambah']=(isset($_POST['tambah']))?$_POST['tambah']:0;
		$data['ubah']=(isset($_POST['ubah'])) ? $_POST['ubah']:0;
		$data['hapus']=(isset($_POST['hapus']))? $_POST['hapus']:0;

		$this->db->update('groups_menus', $data,array('id'=>$_POST['id'])); 
		$ret['resp']=true;
		$ret['msg']='Berhasil Mengubah Data';
		echo json_encode($ret);		
	}
	
	function act_del(){
		$id=$_POST['id'];
		//delete records
		$this->db->delete('groups_menus', array('id' => $id));
		$ret=array(
			$this->data['csrf']['name']=>$this->data['csrf']['hash'],
			'resp'=>true,
			'msg'=>'Berhasil Menghapus Data.'
		);
		
		echo json_encode($ret);
	}

}