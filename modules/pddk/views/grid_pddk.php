<?php if($auth_meta['act']['access']):?>
<section class="content">
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-heading bg-blue clearfix">
				<span class="pull-left">
					<i class="<?php echo $auth_meta['icon'];?>"></i>&nbsp;<?php echo $auth_meta['title'];?>
					<span class="label bg-black"><span id="total_record"></span>&nbsp;Total Records</span>
				</span>
				<span class="pull-right">
					<?php echo modules::run('acl/widget_acl/group_org_user');?>				
				</span>
			</div>
			<div id="toolbar">
				<?php if($auth_meta['act']['add']):?>
					<a id="btn-add" class="btn btn-primary btn-sm" alt="Add">
						<i class="fa fa-plus-circle"></i>&nbsp;Add
					</a>
				<?php endif;?>
				<?php if($auth_meta['act']['edit']):?>
					<a id="btn-edit" class="btn btn-info btn-sm" alt="Edit">
						<i class="fa fa-pencil"></i>&nbsp;Edit
					</a>
				<?php endif;?>
				<?php if($auth_meta['act']['del']):?>
					<a id="btn-del" class="btn btn-danger btn-sm" alt="Del">
						<i class="fa fa-trash-o"></i>&nbsp;Del
					</a>
				<?php endif;?>
			</div>
			<table id="thegrid"></table>
			
		</div>
	</div>
</div>
</section>

<script type="text/javascript">
  function responseHandler(res) 
	{
		$.each(res.rows, function (i, row) {
			row.state = $.inArray(row.id, selections) !== -1;
		});
		return res;
  };
	
	function getRowSelections() 
	{
    return $.map($('#grid').bootstrapTable('getSelections'), function (row) {
			return row
		});
  };
		
	function enable_btn(){
		$('#btn-edit').prop("disabled",false);
		$('#btn-del').prop("disabled",false);
	};
	
	function disable_btn(){
		$('#btn-edit').prop("disabled",true);
		$('#btn-del').prop("disabled",true);
	}
	
	$(document).ready(function(){
		$('#thegrid').bootstrapTable({
			toolbar:'#toolbar',
			search:true,
			singleSelect:true,
			showRefresh:true,
			classes:"table table-no-bordered table-responsive",
			pagination:true,
			idField:'id',
			sidePagination:"server",
			responseHandler:responseHandler,
			pageSize: 10,
			pageList:"[5, 10, 20, 50, 100, 200]",
			url: SITE_URL+'/pddk/get_json/',
			columns: [
				{
					field: 'state',
					checkbox: true,
          align: 'center',
          valign: 'middle'
        },			
			],
			onLoadSuccess:function(e){
				disable_btn();
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
		
	});
</script>

<?php else:?>
	Anda tidak berhak mengakses halaman ini.
<?php endif;?>