<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Pddk extends MY_Admin {
		
		function __construct(){
			parent::__construct();
			$this->data['tpl']='single';
			$this->load->library('wzx');
			$this->data['tbl']='d_pddk';
			$this->data['auth_meta'] = $this->meta('pddk/master/',true);
		}
		
		function index(){
			$this->master();
		}
		
		function master(){
			$this->data['css']=css_asset('bootstrap-table.min.css','bootstrap-table');		
			$this->data['js']=js_asset('bootstrap-table.min.js','bootstrap-table');
			
			$this->data['content']=$this->load->view('grid_pddk',$this->data,true);
			$this->display();
		}
		
		function get_json(){
			$tbl_name = $this->data['tbl'];
			$fields = $this->wzx->tabel_desc($tbl_name);
			
			//start build query :
			$this->db->from($tbl_name);
			foreach($fields as $field){
				//search fields :
				if(!$field['primary_key']){
					$search_field[]=$field['field_name'];
				}
				$this->db->select($tbl_name.'.'.$field['field_name']);
			}
			$sql = $this->db->get_compiled_select();
			
			$ret = $this->wzx->json($sql,$search_field);
			
			header('Content-Type: application/json');
			echo json_encode($ret);		
		}
		
	}	