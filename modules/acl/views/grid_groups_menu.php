<?php if($auth_meta['access']):?>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-heading bg-blue">
					<i class="<?php echo $icon;?>"></i>&nbsp;Manage <?php echo $title;?>
					<span class="label bg-black"><span id="total_record"></span>&nbsp;Total Records</span>&nbsp;
					<span class="pull-right">
						<?php echo modules::run('acl/widget_acl/group_org_user');?>					
					</span>
				</div>
			<div id="toolbar">		
				<?php if($auth_meta['add']):?>
					<a id="btn-add" class="btn btn-primary btn-sm" href="<?php echo site_url('acl/groups_menu/add/');?>" alt="ADD">
						<i class="fa fa-plus-circle"></i>&nbsp;Add
					</a>
				<?php endif;?>
				<?php if($auth_meta['edit']):?>
					<a id="btn-edit" class="btn btn-info btn-sm" href="<?php echo site_url('acl/groups_menu/edit/');?>" alt="Edit">
						<i class="fa fa-pencil"></i>&nbsp;Edit
					</a>
				<?php endif;?>
				<?php if($auth_meta['del']):?>
					<a id="btn-del" class="btn btn-danger btn-sm" href="<?php echo site_url('acl/groups_menu/del/');?>" alt="Del">
						<i class="fa fa-trash-o"></i>&nbsp;Del
					</a>
				<?php endif;?>
			</div>
				<table id="grid_kec"
						data-show-refresh="true"
						data-show-export="true"
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
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Nama Group</label>
								<select id="group_id" name="group_id" style="width:100%;" class="form-control" tabindex="1">
									<option value="0">---Pilih-Group---</option>
									<?php foreach($ls_groups as $k=>$v):?>
										<option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Nama Menu</label>
								<select id="menu_id" name="menu_id" style="width:100%;" class="form-control" tabIndex="2" disabled>
									<option value="0">---Pilih-Menu---</option>
									<?php foreach($ls_menu as $k=>$v):?>
										<option value="<?php echo $v['id'];?>"><?php echo ($v['parent_id'])? '--&nbsp': '';echo $v['name'];?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
							  <label>Hak Akses</label>
								<span class="form-control mychkbx">
									<input tabIndex="3" type="checkbox" class="mychkbx" name="akses" id="akses">&nbsp;Akses&nbsp;
									<input tabIndex="4" type="checkbox" class="mychkbx" name="tambah" id="tambah">&nbsp;Tambah/Add&nbsp;
									<input tabIndex="5" type="checkbox" class="mychkbx" name="ubah" id="ubah">&nbsp;Ubah/Edit&nbsp;
									<input tabIndex="6" type="checkbox" class="mychkbx" name="hapus" id="hapus">&nbsp;Hapus/Del&nbsp;
								</span>
							</div>
						</div>
					</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>			
        <button tabIndex="7" type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
      </div>
			</form>
    </div>
  </div>
</div>

<script>
	var selections = [];
  
	function getRowSelections() {
    return $.map($('#grid_kec').bootstrapTable('getSelections'), function (row) {
			return row;
		});
  };
  
	function myAccessFormat(val,rec,idx){
		if(val==1){
			return '<i class="fa fa-check-square-o"></i>';
		}else{
			return '<i class="fa fa-square-o"></i>';
		}
	}

$(document).ready(function(){		
	//$('select').select2();

	$('#grid_kec').bootstrapTable({
		toolbar:'#toolbar',
		search:true,
		pagination:true,
		pageSize:10,
		url: SITE_URL+'/acl/groups_menu/get_json/',
		singleSelect:true,		
		columns: [
				{
					field: 'state',
					checkbox: true,
          align: 'center',
          valign: 'middle'
        },
				{
						field: 'groups_name',
						title: 'NAMA GROUP',
						halign:'center',
						sortable:true
				},
				{
						field: 'menus_name',
						title: 'NAMA MENUS',
						halign:'center',
						sortable:true
				},
				{
						field: 'akses',
						title: 'AKSES',
						halign:'center',
						sortable:true,
						formatter:myAccessFormat
				},
				{
						field: 'tambah',
						title: 'TAMBAH/ADD',
						halign:'center',
						sortable:true,
						formatter:myAccessFormat
				},
				{
						field: 'ubah',
						title: 'UBAH/EDIT',
						halign:'center',
						sortable:true,
						formatter:myAccessFormat
				},
				{
						field: 'hapus',
						title: 'HAPUS/DEL',
						halign:'center',
						sortable:true,
						formatter:myAccessFormat
				}
				],
				onLoadSuccess:function(e){
					$('#total_record').html(e.total);
					$('.fixed-table-pagination').addClass('panel-footer clearfix bg-gray-active');
				},
				onExpandRow:function(index, row){
					console.log(index);
					$(this).bootstrapTable('collapseAllRows');
					$(this).bootstrapTable('expandRow',index);
				}
	});
	
	<?php if($auth_meta['add']):?>
		$('#btn-add').click(function(e){
			$('#frm-wil-gp').trigger("reset");
    	$('.modal-header').removeClass().addClass("modal-header").addClass("mybg-primary");
			$('#title_act').html('<i class="fa fa-plus-circle"></i>&nbsp;Form Add');
			$('#act').val('add');
			
			$('#menu_id').attr('disabled', 'disabled');
			$('.mychkbx').attr('disabled', 'disabled');
			
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
				$('.modal-header').removeClass().addClass("modal-header").addClass("mybg-info");
				$('#title_act').html('<i class="fa fa-pencil"></i>&nbsp;Form Edit');
				$('#act').val('edit');
				
				//load row
				$('#id').val(rowSel[0].id);
				$('#group_id').val(rowSel[0].group_id);
				$('#menu_id').removeAttr('disabled', 'disabled');
				$('#menu_id').val(rowSel[0].menu_id);

				if(rowSel[0].akses=='1') {
					$('#akses').prop('checked','checked');
					$('#akses').val(1);
				}
				if(rowSel[0].tambah=='1') {
					$('#tambah').prop('checked','checked');
					$('#tambah').val(1);
				}
				if(rowSel[0].ubah=='1') {
					$('#ubah').prop('checked','checked');
					$('#ubah').val(1);
				}
				if(rowSel[0].hapus=='1') {
					$('#hapus').prop('checked','checked');
					$('#hapus').val(1);
				}
				$('.mychkbx').removeAttr('disabled', 'disabled');
				
				$('#myModal').modal('show');
			}else{
				alert('Silahkan memilih record yang akan diedit terlebih dulu.');
			}
			e.preventDefault();
		});
	<?php endif;?>
	
	<?php if(($auth_meta['add'])||($auth_meta['edit'])):?>
		$('input[type="checkbox"]').change(function(){
			this.value = (Number(this.checked));
		});
		
		$('#group_id').change(function(){
			$('#menu_id').removeAttr('disabled', 'disabled');
		});
		
		$('#menu_id').change(function(){
			$('.mychkbx').removeAttr('disabled', 'disabled');
		});
	
		$('#frm-wil-gp').submit(function(e){
			var form_data=$("#frm-wil-gp").serialize();
			var url_form = ($('#act').val()=='edit') ? SITE_URL+"/acl/groups_menu/act_edit/" : SITE_URL+"/acl/groups_menu/act_add/";				
				$.ajax({
						type: "POST",
						url: url_form,
						dataType: "json",
						data: form_data,
						success: function(data){
							$('.<?=$csrf['name'];?>').val(data.<?=$csrf['name'];?>);
							if(data.resp){
								$('#grid_kec').bootstrapTable('refresh');
								alert("Selamat,\n\r"+data.msg);
							}else{
								alert("Ada kesalahan.\n\r"+data.msg);
							}
							$('#myModal').modal('hide');
						}
				});
			e.preventDefault();			
		});
		
	<?php endif;?>
	
	<?php if($auth_meta['del']):?>
		$('#btn-del').click(function(e){
			var rowSel=getRowSelections();
			if(rowSel.length){
				var r = confirm("Apakah anda yakin akan mengdel data tersebut !");
				if (r == true) {
					$.ajax({
						type: "POST",
						url: SITE_URL+"/acl/groups_menu/act_del/",
						dataType: "json",
						data: {id:rowSel[0].id,<?=$csrf['name'];?>:$('.<?=$csrf['name'];?>').val()},
						success: function(data){
							$('.<?=$csrf['name'];?>').val(data.<?=$csrf['name'];?>);
							if(data.resp){
								alert("Selamat,\n\r"+data.msg);
								$('#grid_kec').bootstrapTable('refresh');
							}else{
								alert("Ada kesalahan.\n\r"+data.msg);
							}
						}
					});
				}				
			}else{
				alert('Silahkan memilih record yang akan didel terlebih dulu.');			
			}
			e.preventDefault();
		});
	<?php endif;?>
	
	
});
</script>

<?php else:?>
	Anda tidak berhak mengakses halaman ini.
<?php endif;?>