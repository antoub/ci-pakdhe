<?php if($auth_meta['access']):?>

<section class="content">
	<div class="panel">
		<div class="panel-heading bg-blue">
			<span class="<?php echo $tbl_icon;?>"></span>&nbsp;<?php echo $tbl_title;?>
			<span class="label bg-black"><span id="total_record"></span>&nbsp;Total Records</span>
			<span class="pull-right">
				<?php echo modules::run('acl/widget_acl/group_org_user');?>
			</span>
			
		</div>
		<div id="toolbar">
			<?php if($auth_meta['add']):?>
			<button id="btn-add" name="btn-add" class="btn btn-primary btn-sm" disabled>
				<i class="fa fa-plus-circle"></i>&nbsp;Add Child
			</button>
			<?php endif;?>
			<?php if($auth_meta['edit']):?>
			<button id="btn-edit" name="btn-edit" class="btn btn-info btn-sm" disabled><i class="fa fa-pencil"></i> Edit</button>
			<?php endif;?>
			<?php if($auth_meta['del']):?>
			<button id="btn-remove" name="btn-remove" class="btn btn-danger btn-sm" disabled><i class="fa fa-remove"></i> Delete</button>
			<?php endif;?>
			
		</div>
		<table id="grid_org"
					data-show-refresh="true"
          data-show-export="true"
          data-classes="table table-no-bordered table-responsive"
					
          data-pagination="true"
          data-id-field="id"
          data-page-list="[10, 25, 50, 100, ALL]"
          data-side-pagination="server"
					data-response-handler="responseHandler">
		</table>
	</div>
</section>

<div class="modal" id="mdl_org">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title"><span id="title_act"></span> <?php echo $tbl_title?></h4>
			</div>
			<form role="form" id="frm-org-mdl" name="frm-org-mdl" method="POST">
			<div class="modal-body">
				<input type="hidden" name="id" id="id" value="" />
				<input type="hidden" name="act" id="act" value="" />
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Parent Organisasi</label>
							<input type="hidden" name="parent_id" id="parent_id" value="" />
							<input type="hidden" name="parent_name" id="parent_name" value="" />
							<div id="html_parent_name" name="html_parent_name"></div>
						</div>
					</div>
				</div>
				<div class="row">
						<?php 
							$arr_disable = array('id','parent_id','parent_name');
							foreach($fields as $k=>$v):?>
							<?php if(!in_array($v,$arr_disable)):?>
							<div class="col-md-6">
								<div class="form-group">
									<label><?php echo str_replace('_',' ',strtoupper($v));?></label>
									<input type="text" name="<?php echo $v;?>" id="<?php echo $v;?>" class="form-control" />
								</div>
							</div>
							<?php endif;?>
						<?php endforeach;?>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i>&nbsp;Save Changes</button>
			</div>
			</form>
		</div>
	</div>	
</div>	


<script>
	var selections = [];
	var org_allowed = <?php echo json_encode($tree_org);?>;
	
  function responseHandler(res) {
		$.each(res.rows, function (i, row) {
			row.state = $.inArray(row.id, selections) !== -1;
		});
		return res;
  };
	
	function getRowSelections() {
    return $.map($('#grid_org').bootstrapTable('getSelections'), function (row) {
			return row
		});
  };
	
	function enable_btn(){
   $('#btn-add').prop("disabled",false);
   $('#btn-edit').prop("disabled",false);
   $('#btn-remove').prop("disabled",false);
	};
	
	function disable_btn(){
   $('#btn-add').prop("disabled",true);
   $('#btn-edit').prop("disabled",true);
   $('#btn-remove').prop("disabled",true);
	}
	
	$(document).ready(function(){		
	
		$('#grid_org').bootstrapTable({
				toolbar:'#toolbar',
				search:true,
				url: SITE_URL+'/acl/orgs/get_json/',
				singleSelect:true,
				//pageSize: 10,
				//pageList:"[5, 10, 20, 50, 100, 200]" ,
				columns: [
				{
					field: 'state',
					checkbox: true,
          align: 'center',
          valign: 'middle'
        },
				<?php foreach($fields as $k=>$v):if($v<>'id'):?>
				{
						field: '<?php echo $v;?>',
						halign:'center',
						title: '<?php echo str_replace('_',' ',strtoupper($v));?>',
						sortable:true
				},
				<?php endif;endforeach;?>
				],
				onLoadSuccess:function(e){
					$('#total_record').html(e.total);
					$('.fixed-table-pagination').addClass('panel-footer clearfix bg-gray-active');
				},
				onCheck:function(row){
					enable_btn();
				},
				onUncheck:function(row){
					disable_btn();
				}
		});
	
		$('#btn-add').click(function(e){
			$('#frm-org-mdl').trigger("reset");

			$('.modal-header').removeClass('bg-teal');
			$('.modal-header').addClass('bg-blue');
			$('#title_act').html('<i class="fa fa-plus-circle"></i>&nbsp;Add');
			$('#act').val('add');
			//populate data
			var row=getRowSelections();
			
			$('#parent_id').val(row[0].id);
			$('#parent_name').val(row[0].name);
			$('#html_parent_name').html(row[0].name);

			$('#mdl_org').modal('show');
		});
	
		$('#btn-edit').click(function(e){
			$('.modal-header').removeClass('bg-blue');
			$('.modal-header').addClass('bg-teal');
			$('#title_act').html('<i class="fa fa-pencil"></i>&nbsp;Edit');
			$('#act').val('edit');
			//populate data
			var row=getRowSelections();
			$.each(row[0],function(k,v){
				$('#'+k+'').val(v);
			});
			$('#html_parent_name').html(row[0].name);
			
			$('#mdl_org').modal('show');
		});
		
		$('#btn-remove').click(function(){
				var r = confirm("Apakah anda yakin akan menghapus data tersebut !");
				if (r == true) {
					selections = getRowSelections();
					var mydata='id='+selections[0].id;
					
					$.ajax({
						type: "POST",
						url: SITE_URL+'/acl/orgs/del/',
						dataType: "json",
						data: mydata,
						success: function(data){
							if(data.success){
								alert("Selamat,\n\r"+data.message);
								//location.reload();						
								$('#grid_org').bootstrapTable('refresh');
							}else{
								alert("Ada kesalahan.\n\r"+data.message);
							}
						}
					});
				} else {
				
				}			
		});
	
		$('#frm-org-mdl').submit(function(e){
			var form_data=$("#frm-org-mdl").serialize();
			var url_form = ($('#act').val()=='edit') ? SITE_URL+"/acl/orgs/edit/" : SITE_URL+"/acl/orgs/add/";
			
			$.ajax({
					type: "POST",
					url: url_form,
					dataType: "json",
					data: form_data,
					success: function(data){
						if(data.resp){
							alert("Selamat,\n\r"+data.message);
							$('#mdl_org').modal('hide');
							//location.reload();
							$('#grid_org').bootstrapTable('refresh');
							
						}else{
							alert("Ada kesalahan.\n\r"+data.message);
							$('#mdl_org').modal('hide');
						}
					}
			});
			e.preventDefault();			
		});
	

	});
</script>

<?php else:?>
	Anda tidak berhak mengakses halaman ini.
<?php endif;?>