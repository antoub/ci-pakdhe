<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Wzx
	{
		private $CI;
		
		function __construct()
		{
			$this->CI=& get_instance();
		}
		
		function json($query='',$search_fields=array())
		{
			$ret = array(
			'total'=>0,
			'rows'=>array()
			);
			$limit=isset($_GET['limit']) ? $_GET['limit'] : 10;
			$offset=isset($_GET['offset']) ? $_GET['offset'] : 0;
			$search=(isset($_GET['search'])) ? $_GET['search'] : '';
			$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'id';
			$order = (isset($_GET['order'])) ? $_GET['order'] : 'asc';
			
			$SQL_BASE=$query.' ';
			if($search<>''){
				//get where with filter if SQL_BASE having where :
				$SQL_BASE.= (strpos($query, 'WHERE') !== false) ? ' AND (' : ' WHERE ';
				
				if(count($search_fields)>=1){
					//berdasarkan kolom tertentu
					foreach($search_fields as $k=>$v){
						$filter[]="lower(".$v.") like '%".strtolower($search)."%' ";
					}
					$SQL_BASE.=implode(" OR ",$filter);
				}
				$SQL_BASE.= (strpos($query, 'WHERE') !== false) ? ')' : ' ';
				
				$ls_data=$this->CI->db->query($SQL_BASE)->result_array();
				$ret['total'] = count($ls_data);
				
				//get where with limit
				$SQL=($sort) ? $SQL_BASE.' ORDER BY '.$sort.' '.$order : $SQL_BASE;
				$SQL.=' LIMIT '.$offset.','.$limit;
				$ls_data_limit=$this->CI->db->query($SQL)->result_array();
				$ret['rows'] = $ls_data_limit;
				
				}else{
				//get all
				$ls_data=$this->CI->db->query($SQL_BASE)->result_array();
				$ret['total'] = count($ls_data);
				
				//get limit
				$SQL=($sort) ? $SQL_BASE.' ORDER BY '.$sort.' '.$order : $SQL_BASE;
				$SQL.=' LIMIT '.$offset.','.$limit;
				$ls_data_limit=$this->CI->db->query($SQL)->result_array();
				$ret['rows'] = $ls_data_limit;
			}
			
			return $ret;
		}
		
		//extend field_data with comments from table fields
		function tabel_desc($tbl_name='')
		{
			$fields = $this->CI->db->field_data($tbl_name);
			$query = "SELECT COLUMN_NAME,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$this->CI->db->database."' AND TABLE_NAME = '".$tbl_name."'";
			$result_comment = $this->CI->db->query($query)->result_array();
			$tbl_prop=array();
			foreach($fields as $k=>$v){
				$tbl_prop[$v->name]['field_name']=$v->name;
				$tbl_prop[$v->name]['type']=$v->type;
				$tbl_prop[$v->name]['max_length']=$v->max_length;
				$tbl_prop[$v->name]['default']=$v->default;
				$tbl_prop[$v->name]['primary_key']=$v->primary_key;
				foreach($result_comment as $key=>$val){
					if($val['COLUMN_NAME']==$v->name)
					$tbl_prop[$v->name]['comment']=json_decode($val['COLUMN_COMMENT'],true);				
				}
			}
			return $tbl_prop;
		}
		
		function get_field_master($tbl_name='')
		{
			$res = array();
			$fields = $this->tabel_desc($tbl_name);
			foreach($fields as $k=>$v){
				if(isset($v['comment']['tbl_master'])){
					$res[$k]['tbl_master']=$v['comment']['tbl_master'];
					$res[$k]['field_id']=$v['comment']['field_id'];
					$res[$k]['field_name']=$v['comment']['field_name'];
				}
			}
			return $res;
		}
		
		
	}	