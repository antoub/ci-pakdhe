<?php if($auth_meta['act']['access']):?>
<!-- Codemirror -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/codemirror.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/dialog/dialog.min.css">
<?php echo css_asset('sce.css','fba');?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/theme/blackboard.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/fold/foldgutter.min.css" />

<section class="content">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title"><i class="<?php echo $icon;?>"></i>&nbsp;<?php echo $title;?></h3>
			<span class="pull-right">
				<?php echo modules::run('acl/widget_acl/group_org_user');?>		
			</span>
			
		</div>
		<div class="box-content clearfix" id="fba"></div>
	</div>

	<!-- Codemirror -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/codemirror.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/fold/foldcode.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/fold/foldgutter.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/fold/brace-fold.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/fold/xml-fold.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/fold/indent-fold.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/fold/markdown-fold.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/fold/comment-fold.js"></script>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/mode/clike/clike.min.js"></script>	
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/mode/javascript/javascript.min.js"></script>
  
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/mode/xml/xml.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/mode/css/css.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/mode/htmlmixed/htmlmixed.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/dialog/dialog.min.js"></script>

	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/search/searchcursor.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/search/search.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/addon/selection/active-line.js"></script>
	
  
	<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/4.3.0/mode/php/php.min.js"></script>

	<script type="text/javascript">
	<?php //include_once('sce.js');?>
	</script>
	<?php echo js_asset('sce.js','fba');?>

	<script>
		var config = {
				host: '<?php echo site_url('acl/sce/'); ?>',
				api: 'get_dir' 
			};
			fba(config);
			
			$(document).ready(function(){
				$('body').addClass('sidebar-collapse');
				
				$('#btn-save-fba').click(function(){
					var path = $('#rf').html();
					var content = h.getValue();
					$.ajax({
					  type: "POST",
					  url: SITE_URL+'/acl/sce/save/',
					  data: {path:path,content:content},
					  crossDomain: false,
					  dataType: "json",
					  success: function(ret){
							alert(ret.msg);
					  }
					});
				});
				
				$('#btn-new-fba').click(function(){
					var new_fname = prompt("Please enter your file name:", "Test00.php");
					if (new_fname){
						$.ajax({
						  type: "POST",
						  url: SITE_URL+'/acl/sce/addNewFile/',
						  data: {curr_dir:curr_dir,fname:new_fname},
						  crossDomain: false,
						  dataType: "json",
						  success: function(ret){
								alert(ret.msg);
								location.replace(config.host+'?path='+curr_dir);								
						  }
						});							
					};
				  
				});
				
				$('#btn-del-fba').click(function(){
				  var path = $('#rf').html();
				  if(path){
				  	var r = confirm("Are you sure to delete file : \n"+path);
				  	if (r == true) {
						$.ajax({
						  type: "POST",
						  url: SITE_URL+'/acl/sce/delFile/',
						  data: {curr_dir:curr_dir,path_file:path},
						  crossDomain: false,
						  dataType: "json",
						  success: function(ret){
								alert(ret.msg);
								location.replace(config.host+'?path='+curr_dir);
						  }
						});					
					};				  
				  }else{
				  	alert('Pilih File terlebih dahulu.');
				  }  
				});
			  
			  $('#btn-new-folder-fba').click(function(){
					var new_fname = prompt("Please enter your new folder name:", "folder001");
					if (new_fname){
						$.ajax({
						  type: "POST",
						  url: SITE_URL+'/acl/sce/addNewFolder/',
						  data: {path:curr_dir,fname:new_fname},
						  crossDomain: false,
						  dataType: "json",
						  success: function(ret){
								alert(ret.msg);
								location.replace(config.host+'?path='+curr_dir);
						  }
						});							
					};				  
			  });
				
				
			  
			});
		</script>
		
</section>

<?php else:?>
	Anda tidak berhak mengakses halaman ini.
<?php endif;?>