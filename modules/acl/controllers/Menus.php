<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends MY_Admin {
	var $meta;
	
	function __construct(){
		parent::__construct();
		$this->meta = $this->meta('acl/menus/',true);
		$this->data['tpl']='single';
	}

	function index() {
		
		$meta = $this->meta('acl/users/',true);		
		$this->data['auth_meta']=$meta['act'];
		
		$this->data['icon']=$this->meta['icon'];
		$this->data['title']=$this->meta['title'];
		
		$this->data['css']=css_asset('bootstrap-treeview.min.css','bootstrap-treeview');
		//$this->data['css']=css_asset('jquery.treegrid.css','treegrid');
		$this->data['css'].=css_asset('bootstrap-iconpicker.min.css','bootstrap-iconpicker');
		
		$this->data['js']=js_asset('bootstrap-treeview.min.js','bootstrap-treeview');
		//$this->data['js']=js_asset('jquery.treegrid.min.js','treegrid');
		//$this->data['js'].=js_asset('jquery.treegrid.bootstrap3.js','treegrid');
		$this->data['js'].=js_asset('iconset/iconset-fontawesome-all.js','bootstrap-iconpicker');
		$this->data['js'].=js_asset('bootstrap-iconpicker.min.js','bootstrap-iconpicker');
		
		$this->data['content']=$this->load->view('tree_menus',$this->data,true);
		$this->display($this->data);		
	}
	
	function jsonMenus($ret=false){
		$this->db->order_by('list_order','asc');
		$this->db->select('menus.*, menus.name as text, (select count(id) from menus where menus.parent_id=menus.id) as tags');
		$ls_category=$this->db->get('menus')->result_array();
		//$arr_cat=$ls_category;
		$arr_cat=$this->buildtree($ls_category);
		
		if($ret){
			return $arr_cat;
		}else{
			header('Content-Type: application/json');
			echo json_encode($arr_cat);
		}
	}

	function get_json(){
		$ret = array(
			'total'=>0,
			'rows'=>array()
		);
		
		$limit=isset($_GET['limit']) ? $_GET['limit'] : 10;
		$offset=isset($_GET['offset']) ? $_GET['offset'] : 0;
		$search=(isset($_GET['search'])) ? $_GET['search'] : '';
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'list_order';
		$order = (isset($_GET['order'])) ? $_GET['order'] : 'asc';

		$SQL_BASE='
			select *,
			IFNULL((select name from menus mp where mp.id=menus.parent_id),"PARENT") as parent_name
			from menus
		';
		
		if($search<>''){
			//get where
			$SQL_BASE.='WHERE ';
			$SQL_BASE.='name like "%'.$search.'%" OR ';
			$SQL_BASE.='path like "%'.$search.'%" ';
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
			$this->data['csrf']['name']=>$this->data['csrf']['hash'],		
			'success'=>false,
			'msg'=>'Gagal Menambah Data'
		);
		if(($_POST['name'])&&($_POST['path'])&&($_POST['list_order'])&&($_POST['remark'])&&($_POST['flag'])){
			$data['parent_id']=$_POST['parent_id'];
			$data['name']=$_POST['name'];
			$data['path']=$_POST['path'];
			$data['list_order']=$_POST['list_order'];
			$data['icon']=$_POST['icon'];
			$data['remark']=$_POST['remark'];
			$data['flag']=$_POST['flag'];
			$this->db->insert('menus', $data); 
			$last_insert_id=$this->db->insert_id();
			if($last_insert_id){
				$ret['success']=true;
				$ret['msg']='Berhasil Menambah Data';
			}
		}
		echo json_encode($ret);	
	}
	
	function act_edit(){
		$ret=array(
			$this->data['csrf']['name']=>$this->data['csrf']['hash'],		
			'success'=>false,
			'msg'=>'Gagal Mengubah Data'
		);
		
		$data['parent_id']=$_POST['parent_id'];
		$data['name']=$_POST['name'];
		$data['path']=$_POST['path'];
		$data['list_order']=$_POST['list_order'];
		$data['icon']=$_POST['icon'];
		$data['remark']=$_POST['remark'];
		$data['flag']=$_POST['flag'];

		$this->db->update('menus', $data,array('id'=>$_POST['id'])); 
		$ret['success']=true;
		$ret['msg']='Berhasil Mengubah Data';
		echo json_encode($ret);		
	}
	
	function act_del(){
		$id=$_POST['id'];
		//delete groups_menus records
		$this->db->delete('groups_menus', array('menu_id' => $id));
		
		//delete records
		$this->db->delete('menus', array('id' => $id));
		$ret=array(
			$this->data['csrf']['name']=>$this->data['csrf']['hash'],		
			'success'=>true,
			'msg'=>'Berhasil Menghapus Data.'
		);
		
		echo json_encode($ret);
	}
	
}