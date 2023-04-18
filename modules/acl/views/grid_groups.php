<?php if($auth_meta['access']):?>
<section class="content">
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-heading bg-blue clearfix">
				<span class="pull-left">
					<i class="<?php echo $icon;?>"></i>&nbsp;Manage <?php echo $title;?>
					<span class="label bg-black"><span id="total_record"></span>&nbsp;Total Records</span>
				</span>
				<span class="pull-right">
					<?php echo modules::run('acl/widget_acl/group_org_user');?>				
				</span>
			</div>
		<div id="toolbar">
			<?php if($auth_meta['add']):?>
				<button id="btn-add" class="btn btn-primary btn-sm" href="<?php echo site_url('acl/groups/add/');?>" alt="ADD">
					<i class="fa fa-plus-circle"></i>&nbsp;Add
				</button>
			<?php endif;?>
			<?php if($auth_meta['edit']):?>
				<button id="btn-edit" class="btn btn-info btn-sm" href="<?php echo site_url('acl/groups/edit/');?>" alt="Edit" disabled>
					<i class="fa fa-pencil"></i>&nbsp;Edit
				</button>
			<?php endif;?>
			<?php if($auth_meta['del']):?>
				<button id="btn-del" class="btn btn-danger btn-sm" href="<?php echo site_url('acl/groups/del/');?>" alt="Del" disabled>
					<i class="fa fa-trash-o"></i>&nbsp;Del
				</button>
			<?php endif;?>
		</div>
			<table id="thegrid"
					data-show-refresh="true"
          data-classes="table table-no-bordered"
 					
          data-pagination="true"
          data-id-field="id"
          data-page-list="[10, 25, 50, 100, ALL]"
          data-side-pagination="server" >
			</table>
			
		</div>
	</div>
</div>
</section>

<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      	<div class="modal-header bg-primary">
        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>			
        	<h4 class="modal-title"><span id="title_act"></span></h4>
      	</div>
		<form role="form" id="frm-wil-gp" name="frm-wil-gp" method="POST" action="#">
      		<div class="modal-body">
				<input type="hidden" name="act" id="act" value="" />
				<input type="hidden" id="id" name="id" value="" />
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Nama Group</label>
								<input type="text" id="name" name="name" class="form-control input-sm" value="" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Deskripsi</label>
								<textarea id="description" name="description"  rows="5" class="form-control input-sm"></textarea>
							</div>
						</div>
					</div>
      		</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>			
				<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
			</div>
		</form>
    </div>
  </div>
</div>

<script>
	var selections = [];
  
	function getRowSelections() {
    	return $.map($('#thegrid').bootstrapTable('getSelections'), function (row) {
			return row;
		});
 	 };

	function enable_btn() {
		$('#btn-edit').prop("disabled", false);
		$('#btn-del').prop("disabled", false);
	};

	function disable_btn() {
		$('#btn-edit').prop("disabled", true);
		$('#btn-del').prop("disabled", true);
	}

	$(document).ready(function(){		

	$('#thegrid').bootstrapTable({
		toolbar:'#toolbar',
		pagination:true,
		search:true,
		pageSize:10,
		url: SITE_URL+'/acl/groups/get_json/',
		singleSelect:true,
		columns: [
			{
				field: 'state',
				checkbox: true,
          		align: 'center',
          		valign: 'middle'
        	},
			{
				field: 'name',
				title: 'NAMA GROUP',
				halign:'center',
				sortable:true
			},
			{
				field: 'description',
				title: 'DESKRIPSI',
				halign:'center',
				sortable:true
			}
		],
		onLoadSuccess:function(e){
			$('#total_record').html(e.total);
			$('.fixed-table-pagination').addClass('panel-footer clearfix bg-gray-active');
			disable_btn();
		},
		onCheck: function(row) {
			enable_btn();
		},
		onUncheck: function(row) {
			disable_btn();
		}
	});
	
	<?php if($auth_meta['add']):?>
		$('#btn-add').click(function(e){
			$('#frm-wil-gp').trigger("reset");
    	$('.modal-header').removeClass().addClass("modal-header").addClass("bg-primary");
			$('#title_act').html('<i class="fa fa-plus-circle"></i>&nbsp;Form Add');
			$('#act').val('add');
			
			$('#myModal').modal('show');
			e.preventDefault();
		});
		
		$('#nama_kec').change(function(e){
			
		});
	<?php endif;?>
	
	<?php if($auth_meta['edit']):?>

		$('#btn-edit').click(function(e){
			var rowSel=getRowSelections();
			if(rowSel.length){
				$('#frm-wil-gp').trigger("reset");
				$('.modal-header').removeClass().addClass("modal-header").addClass("bg-info");
				$('#title_act').html('<i class="fa fa-pencil"></i>&nbsp;Form Edit');
				$('#act').val('edit');
				
				//load row
				$('#id').val(rowSel[0].id);
				$('#name').val(rowSel[0].name);
				$('#description').val(rowSel[0].description);
				
				$('#myModal').modal('show');
			}else{
				swal('Warning', 'Silahkan memilih record yang akan diedit terlebih dulu', 'warning');
			}
			e.preventDefault();
		});
	<?php endif;?>
	
	<?php if(($auth_meta['add'])||($auth_meta['edit'])):?>
			$('#frm-wil-gp').submit(function(e){
			var form_data=$("#frm-wil-gp").serialize();
			var url_form = ($('#act').val()=='edit') ? SITE_URL+"/acl/groups/act_edit/" : SITE_URL+"/acl/groups/act_add/";				
				$.ajax({
						type: "POST",
						url: url_form,
						dataType: "json",
						data: form_data,
						success: function(data){
							$('.<?=$csrf['name'];?>').val(data.<?=$csrf['name'];?>);
							if(data.success){
								swal('Success', 'Selamat.\n\r' + data.msg, 'success');

								$('#myModal').modal('hide');
								$('#thegrid').bootstrapTable('refresh');
							}else{
								swal('Warning', 'Ada kesalahan.\n\r' + data.msg, 'warning');

								$('#myModal').modal('hide');
							}
						}
				});
			e.preventDefault();			
		});
		
		$('#nama_kec').change(function(e){
			$('#id_kec').val($('#nama_kec :selected').attr('id_kec'));
		});		
	<?php endif;?>
	
	<?php if($auth_meta['del']):?>
		$('#btn-del').click(function(e){
			swal({
				title: 'Apakah anda yakin akan menghapus ?',
				text: "Data yang terhapus tidak dapat dikembalikan !",
				icon: 'warning',
				buttons: true,
				dangerMode: true
			}).then(function(isConfirm) {
				if (isConfirm) {
					var rowSel=getRowSelections();
					if(rowSel.length){
						$.ajax({
							type: "POST",
							url: SITE_URL+"/acl/groups/act_del/",
							dataType: "json",
							data: {id:rowSel[0].id,<?=$csrf['name'];?>:$('.<?=$csrf['name'];?>').val()},
							success: function(data){
								$('.<?=$csrf['name'];?>').val(data.<?=$csrf['name'];?>);
								if(data.success){
									swal('Success', 'Selamat.\n\r' + data.msg, 'success');
									$('#thegrid').bootstrapTable('refresh');
									}else{
										swal('Warning', 'Ada Kesalahan.\n\r' + data.msg, 'success');
									}
								}
							});

					}else{
						swal('Warning', 'Silahkan memilih record yang akan diedit terlebih dulu', 'warning');
					}
				}
			});
			e.preventDefault();
		});
		<?php endif;?>
	
	
});
</script>

<?php else:?>
	Anda tidak berhak mengakses halaman ini.
<?php endif;?>