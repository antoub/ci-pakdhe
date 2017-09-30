<section class="content-header">
	<h1 style="padding-bottom:10px;border-bottom:1px dashed #999;">
		Dashboard
		<small>Control panel</small>
		<span class="pull-right">
		<?php echo modules::run('acl/widget/group_org_user');?>					
		</span>
	</h1>
</section>
		
<section class="content">
	<div class="row">
		<div class="col-md-6">
			<?php include_once('form_profile.php');?>
		</div>
		<div class="col-md-3">
				<?php echo modules::run('acl/widget_acl/users_box');?>			
				<?php echo modules::run('acl/widget_acl/orgs_box');?>
				<?php echo modules::run('pddk/widget_pddk/jml_pddk_box','Fakir Uzur');?>
				<?php echo modules::run('pddk/widget_pddk/jml_pddk_box','Yatim');?>
		</div>
		<div class="col-md-3">
				<?php echo modules::run('acl/widget_acl/groups_box');?>
				<?php echo modules::run('pddk/widget_pddk/jml_box');?>
				<?php echo modules::run('pddk/widget_pddk/jml_pddk_box','Piatu');?>
		</div>
	</div>
	
</section>

<script>
$(document).ready(function(){
	
	$('.tgl').each(function(){
		var tgl=$(this).html();
		$(this).html(moment($(this).html()).format("dddd, DD-MMM-YYYY HH:mm"));
	});
	
});
</script>