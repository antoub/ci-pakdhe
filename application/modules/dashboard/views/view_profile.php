		
<section class="content">
	<div class="row">
		<div class="col-md-6">
			<?php include_once('form_profile.php');?>
		</div>
		<div class="col-md-6 ">
		
			<div class="alert">
				<h4>
					<span class="nameBadgeInfo" data-toggle="tooltip" data-placement="right" title="<?php echo $_SESSION['first_name'].'&nbsp;'.$_SESSION['last_name'];?>"><?php echo $_SESSION['first_name'].'&nbsp;'.$_SESSION['last_name'];?></span>
					<?php echo $_SESSION['first_name'].'&nbsp;'.$_SESSION['last_name'];?>
				</h4>
				<p>
					<small>
						<i class="fa fa-info-circle"></i>&nbsp;Badge Logo Icon User above (Label+Color) is based on Your First Name & Last Name.<br />Change Your First Name & Last Name to reflect yourself.
					</small>
				</p>
		</div>
	</div>
</section>
<script>
$(document).ready(function(){
	$('.nameBadgeInfo').nameBadge2({
		size:48
	});
	
});
</script>