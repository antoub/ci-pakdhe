<section class="content-header">
	<h1 style="border-bottom:1px solid #DDD;"><i class="<?php echo $icon;?>"></i>&nbsp;List <?php echo $title;?></h1>
	<span class="breadcrumb">
		<?php echo modules::run('acl/widget_acl/group_org_user');?>		
	</span>
</section>
<section class="content">	
	<div class="row">
		<div class="col-md-6">
			<div class="panel">
				<div class="panel-heading bg-black">
					<i class="<?php echo $icon;?>"></i>&nbsp;List <?php echo $title;?>
					<span class="badge bg-green pull-right" id="total_cat"> Menus</span>
				</div>
				<div id="tree_category" class="treeview text-black"></div>
				<div class="panel-footer bg-dark text-white clearfix">
					<div class="row">
						<div class="col-md-4">
							<button class="btn btn-primary btn-sm bg-blue" name="btn-mytree" id="btn-mytree">
								<i class="fa fa-th-list"></i>&nbsp;Expand/Collapse All
							</button>
						</div>
						<div class="col-md-8">
							<p class="small text-justify">Pilih salah satu <strong>item</strong> diatas untuk diedit, atau tekan tombol <span class="label label-success bg-green">Reset Form</span> untuk menambahkan <strong>item</strong> baru.</p>
						</div>
					</div>
				</div>
			</div>
		</div>		
		<div class="col-md-6">
			<div class="panel">
				<div class="panel-heading bg-black">
					<i class="<?php echo $icon;?>"></i>&nbsp;Form <?php echo $title;?>
					<span id="txt_action" class="pull-right badge bg-green">Add New Menu</span>
				</div>
				<form name="frm-category" id="frm-category">
					<input id="id" name="id" value="14" type="hidden">
					<input id="act" name="act" value="edit" type="hidden">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Parent</label>
									<select name="parent_id" id="parent_id" class="form-control" tabindex="10" style="width:99% !important;">
										<option value="0">--Choose-Parent--</option>
									</select>
								</div>
								<div class="form-group">
									<label class="control-label">Path</label>
									<input type="text" id="path" name="path" class="form-control input-sm" tabindex="11" value="" />
								</div>
							<div class="form-group">
								<label class="control-label">Name</label>
								<input class="form-control" id="name" name="name" placeholder="Nama Menu" tabindex="12" type="text">
							</div>
							<div class="form-group">
								<label class="control-label">Remarks</label>
								<input type="text" id="remark" name="remark" class="form-control input-sm" tabindex="13" value="" />
							</div>
						</div>
							<div class="col-md-6">
								<label class="control-label">Icon</label>
								<input type="text" id="icon" name="icon" class="form-control input-sm" tabindex="21" value="" readonly />							
								<div  name="myicon" id="myicon"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Flag/Status</label>
									<select id="flag" name="flag" class="form-control" tabindex="14" style="width:100%;">
										<option value="0">--Pilih-Status--</option>
										<option value="draft">Draft</option>
										<option value="publish">Publish</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Order Number</label>
									<input type="text" id="list_order" name="list_order" class="form-control input-sm" tabindex="22" value="" />
									</div>								
							</div>
						</div>
						
					</div>
					<div class="panel-footer bg-dark clearfix">
						<button class="btn btn-col-4 btn-success" name="btn-rst" id="btn-rst">
							<i class="fa fa-refresh"></i>&nbsp;Reset Form
						</button>
						<button class="btn btn-col-4 btn-danger" name="btn-del" id="btn-del">
							<i class="fa fa-trash-o"></i>&nbsp;Delete Data
						</button>
						<button class="btn btn-col-4 btn-primary" name="btn-save" id="btn-save">
							<i class="fa fa-save"></i>&nbsp;Save Data
						</button>
					</div>
				</form>
			</div>
		</div>

	</div>

</section>


<script>
$(document).ready(function(){
	var mydata=[];
	var current_node;
	var condition = 'buka';
	
	$('#myicon').iconpicker({
		iconset:'fontawesome',
		cols:5,
		placement:'center',
		arrowNextIconClass:'fa fa-arrow-right',
		arrowPrevIconClass:'fa fa-arrow-left',
		selectedClass:'btn-primary'
	}).on('change', function(e) { 
		$('#icon').val('fa '+e.icon)
	});	
	
	function reset_form(){
		$('#frm-category').trigger("reset");		
		$('#id').val('');
		$('#act').val('add');
		$('#btn-del').attr('disabled',true);
	}
	
	function getCat(){
		var tmp=[];
		$.ajax({
			type: "GET",
			url: SITE_URL+'/acl/menus/jsonMenus/',
			dataType: "json",
			success:function(catData){
				mydata=catData;
				var treeData = [];
				$.each(catData,function(idx,val){
					var cnodes=[];
					if(jQuery.type(val.nodes)=='object'){
						$.each(val.nodes,function(index,nilai){
							cnodes.push({
								id:nilai.id,
								parent_id:nilai.parent_id,
								icon:nilai.icon,
								text:nilai.text, 
								name:nilai.name, 
								path:nilai.path, 
								remark:nilai.remark, 
								list_order:nilai.list_order, 
								flag:nilai.flag, 
								selectable: true
							});
						});
					}else{
						//the parents
						
					}
					treeData.push({
						id:val.id,
						parent_id:val.parent_id,
						icon: val.icon,
						text:val.text,
						name:val.name,
						path:val.path,
						remark:val.remark, 
						list_order:val.list_order, 
						flag:val.flag, 
						selectable: true,
						nodes:cnodes
					});
				});

				$('#tree_category').treeview({
					expandIcon: 'fa fa-plus',
					collapseIcon: 'fa fa-minus',
					emptyIcon: 'fa',
					color: '#000', 
					backColor: '#FFF',
					template : [{badge:'<span class="badge badge-secondary pull-right"></span>'}],
					data: treeData, 
					showTags: true
				});
				
				$('#tree_category').treeview('expandAll');
				render_tags();
				render_act(mydata);
			}
		});
		reset_form();
	};
	
	getCat();
	
	function render_act(params){
		var treeViewObject = $('#tree_category').data('treeview'),
			allCollapsedNodes = treeViewObject.getCollapsed(),
			allExpandedNodes = treeViewObject.getExpanded(),
			allNodes = allCollapsedNodes.concat(allExpandedNodes);		
			$('#total_cat').html(allNodes.length+' Menus');

		//populate select
		var options = $("#parent_id");
		options.html('');
		options.append($("<option />").val('0').text('--Choose-Parent--'));
		$.each(allExpandedNodes,function(idx,data){
			options.append($("<option />").val(data.id).text(data.text));
		});

		//re-apply action on nodes.
		$('#tree_category').on('nodeSelected', function(event, data) {
			current_node = data.id;
			$('#act').val('edit');
			$('#id').val(data.id);
			$('#name').val(data.name);
			$('#parent_id').val(data.parent_id);
			$('#path').val(data.path);
			$('#remark').val(data.remark);
			if(data.icon){
				$('#icon').val(data.icon);
				$('#myicon').iconpicker('setIcon', data.icon.replace('fa ',''));
			}
			
			$('#list_order').val(data.list_order);
			$('#flag').val(data.flag);
			
			$('#btn-del').attr('disabled',false);
			$('#txt_action').html('Edit Menu : '+data.name);
			render_tags();
		});
		
		$('#tree_category').on('nodeUnselected', function(event, data) {
			$('#txt_action').html('Add New Menu');
			reset_form();
			render_tags();
		});

	}
	
	function render_tags(){
		$('#tree_category span.badge').addClass('badge-secondary pull-right');		
	}
	
	$('#frm-category').submit(function(e){
		var formData = $(this).serialize();
		var formUrl = ($('#act').val()=='add') ? SITE_URL+'/acl/menus/act_add/' : SITE_URL+'/acl/menus/act_edit/';
		
		$.ajax({
			type: "POST",
			url: formUrl,
			data: formData,
			dataType: "json",
			success: function(data){
				if(data.resp){
					alert(data.msg);
				}else{
					alert(data.msg);
				}
				getCat();
				$('#frm-category').trigger("reset");				
			}
		});	
		
		e.preventDefault();
	});
	
	$('#btn-rst').click(function(e){
		current_node = $('#tree_category').treeview('getSelected');
		$('#tree_category').treeview('uncheckAll', { silent: true });
		$('#tree_category').treeview('toggleNodeSelected',current_node);
		
		reset_form();
		e.preventDefault();
	});
	
	$('#btn-del').click(function(){
		var r = confirm("Apakah anda yakin akan menghapus data tersebut !");
		if (r == true) {
			
			$.ajax({
				type: "POST",
				url: SITE_URL+'/acl/menus/act_del/',
				dataType: "json",
				data: {id:$('#id').val()},
				success: function(data){
					if(data.success){
						alert("Selamat,\n\r"+data.msg);
						getCat();
						$('#frm-category').trigger("reset");
					}else{
						alert("Ada kesalahan.\n\r"+data.msg);
					}
				}
			});
		}		
	});
	
	$('#btn-mytree').click(function(e){
		if(condition=='tutup'){
				$('#tree_category').treeview('expandAll', { silent: true });
				condition = 'buka';
			}else{
				$('#tree_category').treeview('collapseAll', { silent: true });
				condition = 'tutup';
			}


	});
	
});
</script>		