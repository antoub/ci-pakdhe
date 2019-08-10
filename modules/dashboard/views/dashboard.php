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
		<div class="col-md-6">
			<div class="panel">
				<div class="panel-body" style="border:1px solid #AAA;">
					<div class="media">
						<div class="media-left media-top">
							<img class="media-object" src="<?=base_url('assets/image/'.$this->MYCFG['logo']);?>" alt="<?=$this->MYCFG['logo'];?>" width="120px"/>
						</div>
						<div class="media-body">
							<h3 class="media-heading"><?=$this->MYCFG['name_short'].$this->MYCFG['name_short2'].' Ver.'.$this->MYCFG['version'];?></h3>
							<h4 class="media-heading"><?=$this->MYCFG['name_long'];?></h4>
							<h5 class="media-heading"><?=$this->MYCFG['org_name'];?></h5>
							<h5 class="media-heading"><?=$this->MYCFG['city_name'];?></h5>
							<h5 class="media-heading"><?=$this->MYCFG['province_name'];?></h5>
							<?php //print_r($this->MYCFG);?>
						</div>
					</div>
				</div>
			</div>
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