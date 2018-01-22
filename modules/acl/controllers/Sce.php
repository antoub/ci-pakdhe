<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sce extends MY_Admin {
	var $path = 'modules/';
	var $dont_del = array('Sce.php','sce_view.php');
	
	function __construct(){
		parent::__construct();
		$this->data = $this->meta('acl/sce/',true);
		
		$this->load->helper('file');
		$this->data['tpl']='single';
	}
	
	function index(){
		$meta = $this->meta('acl/sce/',true);
		$this->data['auth_meta']=$meta['act'];
		$this->data['content']=$this->load->view('sce_view',$this->data,true);
		$this->display($this->data);
	}
	
	function save(){
		$full_path_file = $this->path.$_POST['path'];
		$data_content = $_POST['content'];
		if (!write_file($full_path_file, $data_content)){
			$ret['res']=false;
			$ret['msg']="Tidak berhasil menyimpan :\n".$_POST['path'];
		}else{
			$ret['res']=true;
			$ret['msg']="Berhasil menyimpan :\n".$_POST['path'];
		}
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: '.BASE_URL());
		echo json_encode($ret);		
	}
	
	function addNewFile(){
		$full_path_file = $this->path.$_POST['curr_dir'].'/'.$_POST['fname'];
		$data_content_default = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');";
		if (!write_file($full_path_file, $data_content_default)){
			$ret['res']=false;
			$ret['msg']="Tidak berhasil menyimpan :\n".$_POST['fname'];
		}else{
			$ret['res']=true;
			$ret['msg']="Berhasil menyimpan :\n".$_POST['fname'];
		}
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: '.BASE_URL());
		echo json_encode($ret);		
	}
	
	function delFile(){
		$curr_dir = $_POST['curr_dir'];
		$pathfile = $_POST['path_file'];
		$file_only = str_replace($curr_dir.'/','',$pathfile);
		if(in_array($file_only,$this->dont_del)){
				$ret['res']=false;
				$ret['msg']="Dilarang menghapus file editor ini :\n".$pathfile;			
		}else{
			if(unlink($this->path.$pathfile)) {
				$ret['res']=true;
				$ret['msg']="Berhasil menghapus :\n".$pathfile;			
			}else {
				$ret['res']=false;
				$ret['msg']="Gagal menghapus :\n".$pathfile;			
			}		
		}
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: '.BASE_URL());
		echo json_encode($ret);		
	}
	
	function addNewFolder(){
		$full_path_folder=$this->path.$_POST['path'].'/'.$_POST['fname'];
		/*
		print_r($full_path_folder);
		*/
		if(!is_dir($full_path_folder)) {
      if(mkdir($full_path_folder,0755,TRUE)){
				$ret['res']=true;
				$ret['msg']="Folder ".$full_path_folder." berhasil dibuat.";						
			}else{
				$ret['res']=false;
				$ret['msg']="Folder ".$full_path_folder." tidak berhasil dibuat.";			
			}
    }else{
				$ret['res']=false;
				$ret['msg']="Folder ".$full_path_folder." sudah ada.";			
		}
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: '.BASE_URL());
		echo json_encode($ret);
		/*
		*/
	}
	
	function item($dir){
		$files = array();
		if(scandir($dir)){
			foreach(scandir($dir) as $f) {		
				if(!$f || $f[0] == '.') {
					continue; // Abaikan file tersembunyi
				}
				$files[] = array(
					"name" => $f
				);
			}
		}
		return $files;
	}
	
	function scan($path = ''){
		$files = array();
		if(preg_match('/\.\./', $path)){
			$path = '';
		}
		$files['status'] = 'success';
		$browser = (empty($path) ? $this->path : $this->path . '/' .$path);
		// Apakah benar-benar terdapat folder/file?
		if(file_exists($browser)){
			$files['status'] = 'success';
			$files['curr_dir'] = $path;
			$files['data']=array();
			foreach(scandir($browser) as $f) {
				if(!$f || $f[0] == '.') {
					continue; // Abaikan file tersembunyi
				}
				if(is_dir($browser . '/' . $f)) {
					// List folder
					$files['data'][] = array(
						"name" => $f,
						"type" => "dir",
						"modif" => date('Y-m-d h:i:s',filemtime($browser . '/' . $f)),
						"path" => (empty($path) ? $f : $path . '/' .$f),
						"items" => count($this->item($browser . '/' . $f)) // Menscan lagi isi folder
					);
				}else{
					// List file
					$files['data'][] = array(
						"name" => $f,
						"type" => "file",
						"dir" => $this->path,
						"path" => (empty($path) ? $f : $path . '/' .$f),
						"modif" => date('Y-m-d h:i:s',filemtime($browser . '/' . $f)),
						"size" => filesize($browser . '/' . $f) // Mendapatkan ukuran file
					);
				}
			}
		}else{
			$files['status'] = 'error';
			$files['curr_dir'] = $path;
		}

		return $files;
	}
	
	function read($file){
		if(preg_match('/\.\./', $file)){
			return array('status' => 'error');
		}else{
			$browser = (empty($file) ? $this->path : $this->path . '/' .$file);
			$text = file_get_contents($browser);
			return array('status' => 'success', 'text' => $text);
		}
	}
	
	function get_dir(){
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: '.BASE_URL());

		// Scan direktori
		if(isset($_POST['path'])){
			// Jalankan fungsi scan->('SUB DIR NAME')
			$res = $this->scan($_POST['path']);
			// Output list direktori & file dalam format JSON
			echo json_encode($res);
		}

		// Read file
		else if(!empty($_POST['file'])){
			// Jalankan fungsi scan->('SUB DIR NAME')
			$res = $this->read($_POST['file']);
			// Output isi file
			echo json_encode($res);
		}
	}
	
}