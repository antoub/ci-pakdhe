	<div class="widget-user-header bg-black" style="background: url('<?php echo image_asset_url('mb-bg-fb-09.png');?>') center center;">
		<h3 class="widget-user-username"><i class="fa fa-cube"></i>&nbsp;<b><?php echo $this->MYCFG['name_short'];?></b><?php echo $this->MYCFG['name_short2'];?></h3>
		<h5 class="widget-user-desc">
			<?php echo $this->MYCFG['name_long'];?><br/>
			<?php echo $this->MYCFG['org_name'];?>&nbsp;
			<?php echo $this->MYCFG['city_name'];?><br/>
			<?php echo $this->MYCFG['province_name'];?>
		</h5>
	</div>
	<div class="widget-user-image">
		<img class="img-circle" src="<?php echo image_asset_url($this->MYCFG['logo']);?>" alt="<?php echo $this->MYCFG['name_short'];?>">
	</div>