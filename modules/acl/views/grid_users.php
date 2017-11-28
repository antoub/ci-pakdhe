<section class="content">
	<div class="panel">
		<div class="panel-heading bg-blue">
			<span class="<?php echo $tbl_icon;?>"></span>&nbsp;<?php echo $tbl_title;?>
			<span class="label bg-black"><span id="total_record"></span>&nbsp;Total Records</span>&nbsp;
			
			<span class="pull-right">
				<?php echo modules::run('acl/widget_acl/group_org_user');?>
			</span>

		</div>
		<div id="toolbar">
			<?php if($auth_meta['act']['add']):?>
			<button id="btn-add" name="btn-add" class="btn btn-primary btn-sm">
				<i class="fa fa-plus-circle"></i>&nbsp;Add New
			</button>
			<?php endif;?>
			<?php if($auth_meta['act']['edit']):?>
			<button id="btn-edit" name="btn-edit" class="btn btn-info btn-sm" disabled><i class="fa fa-pencil"></i> Edit</button>
			<?php endif;?>
			<?php if($auth_meta['act']['del']):?>
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
					<div class="col-md-6">
						<div class="form-group">
							<label>Username</label>
							<input type="text" name="username" id="username" class="form-control" />
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" name="email" id="email" class="form-control" />
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" id="password" class="form-control" />
						</div>
						<div class="form-group">
							<label>First Name</label>
							<input type="text" name="first_name" id="first_name" class="form-control" />
						</div>
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" name="last_name" id="last_name" class="form-control" />
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" id="phone" class="form-control" />
						</div>
							
					</div>
					<div class="col-md-6" >

						<div class="form-group" id="cgroups">
							<label>Group</label>
							<select id="groups" name="groups" class="form-control input-sm">
								<?php foreach($groups as $group):?>
									<option value="<?php echo $group->id;?>"><?php echo $group->name;?></option>
								<?php endforeach;?>
							</select>
						</div>
						
						<div class="form-group" id="corgs">
							<label>Organisasi/SKPK</label>
							<select id="orgs" name="orgs" class="form-control input-sm">
								<?php foreach($tree_org as $all):?>
									<option value="<?php echo $all['id'];?>"><?php echo $all['name'];?></option>
									<?php if(count($all['nodes'])):?>
										<?php foreach($all['nodes'] as $key_org=>$val_org):?>
											<option value="<?php echo $val_org['id'];?>">-&nbsp;<?php echo strtoupper($val_org['name']);?></option>
												<?php if(count($val_org['nodes'])):?>
													<?php foreach($val_org['nodes'] as $key_skpk=>$val_skpk):?>
														<option value="<?php echo $val_skpk['id'];?>">--&nbsp;<?php echo $val_skpk['name'];?></option>
														<?php if(count($val_skpk['nodes'])):?>
															<?php foreach($val_skpk['nodes'] as $key_bid=>$val_bid):?>
																<option value="<?php echo $val_bid['id'];?>">---&nbsp;<?php echo $val_bid['name'];?></option>
																<?php if(count($val_bid['nodes'])):?>
																	<?php foreach($val_bid['nodes'] as $key_sie=>$val_sie):?>
																		<option value="<?php echo $val_sie['id'];?>">----&nbsp;<?php echo $val_sie['name'];?></option>														
																	<?php endforeach;?>
																<?php endif;?>
															<?php endforeach;?>
														<?php endif;?>
														
													<?php endforeach;?>
												<?php endif;?>											
										<?php endforeach;?>
									<?php endif;?>
								<?php endforeach;?>
							</select>
						</div>

						<div class="form-group">
							<label>Company/Desc</label>
							<input type="text" name="company" id="company" class="form-control" />
						</div>
						
					</div>
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
   		// $('#btn-add').prop("disabled",false);
   		$('#btn-edit').prop("disabled",false);
   		$('#btn-remove').prop("disabled",false);
	};
	
	function disable_btn(){
   		// $('#btn-add').prop("disabled",true);
   		$('#btn-edit').prop("disabled",true);
   		$('#btn-remove').prop("disabled",true);
	}
	
	$(document).ready(function(){		
	
		$('#grid_org').bootstrapTable({
				toolbar:'#toolbar',
				search:true,
				url: SITE_URL+'/acl/users/get_json/',
				singleSelect:false,
				pageSize: 10,
				pageList:"[5, 10, 20, 50, 100, 200]" ,
				columns: [
				{
					field: 'state',
					checkbox: true,
					align: 'center',
					valign: 'middle'
				}, {
						field: 'id',
						halign:'center',
						title: 'ID'
				}, {
						field: 'username',
						title: 'USERNAME',
						halign:'center',
						sortable:true

				}, {
						field: 'email',
						halign:'center',
						title: 'EMAIL',
						sortable:true
				}, {
						field: 'first_name',
						title: 'FIRST NAME',
						halign:'center'
				}, {
						field: 'last_name',
						title: 'LAST NAME',
						halign:'center'
				}, {
						field: 'groups',
						title: 'GROUPS',
						halign:'center'
				}, {
						field: 'orgs',
						title: 'ORGS',
						halign:'center'
				}
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

			$('#mdl_org').modal('show');
		});
	
		$('#btn-edit').click(function(e){
			$('.modal-header').removeClass('bg-blue');
			$('.modal-header').addClass('bg-teal');
			$('#title_act').html('<i class="fa fa-pencil"></i>&nbsp;Edit');
			$('#act').val('edit');

			//populate data
			var all_orgs='';
			var row=getRowSelections();
			$('#id').val(row[0].id);
			$('#username').val(row[0].username);
			$('#password').val('');
			$('#email').val(row[0].email);
			$('#first_name').val(row[0].first_name);
			$('#last_name').val(row[0].last_name);
			$('#company').val(row[0].company);
			$('#phone').val(row[0].phone);
			$('#groups').val(row[0].group_id);
			$('#orgs').val(row[0].org_id);
			$('#bidang').val(row[0].bidang_id);
			$('#seksi').val(row[0].seksi_id);
		
			$('#mdl_org').modal('show');
		});
		
		$('#btn-remove').click(function(){
				var r = confirm("Apakah anda yakin akan menghapus data tersebut !");
				if (r == true) {
					selections = getRowSelections();
					var mydata='id='+selections[0].id;
					
					$.ajax({
						type: "POST",
						url: SITE_URL+'/acl/users/del/',
						dataType: "json",
						data: mydata,
						success: function(data){
							if(data.resp){
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
			var url_form = ($('#act').val()=='edit') ? SITE_URL+"/acl/users/edit/" : SITE_URL+"/acl/users/add/";
			
			$.ajax({
					type: "POST",
					url: url_form,
					dataType: "json",
					data: form_data,
					success: function(data){
						// alert(data);
						if(data.resp){
							alert("Selamat,\n\r"+data.message);
							$('#mdl_org').modal('hide');
							//location.reload();
							$('#grid_org').bootstrapTable('refresh');
							
						}else{
							alert("Ada kesalahan.\n\r"+data.message);
							// $('#mdl_org').modal('hide');
						}
					}
			});
			e.preventDefault();			
		});
	

	});
</script>
