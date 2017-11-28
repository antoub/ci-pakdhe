<div class="box box-widget widget-user-2">
	<div class="widget-user-header bg-blue-active">
		<div class="widget-user-image">
			<i class="<?php echo $MYCFG['GENERAL']['APP_NAME_ICON'];?> pull-left" style="font-size:60px;"></i>
		</div>
		<h3 class="widget-user-username"><?php echo '<strong>'.$MYCFG['GENERAL']['APP_NAME'].'</strong>'.$MYCFG['GENERAL']['VERSION'];?></h3>
		<h5 class="widget-user-desc">Resume Data</h5>
	</div>
	<div class="box-footer no-padding">
		<ul class="nav nav-stacked">
			<li class="active">
				<a href="#" data-html="true" data-toggle="tooltip" data-placement="left" title="Total Organisasi SKPK+Gampong">
					<i class="fa fa-university fa-tw"></i>&nbsp;Organisasi <span class="pull-right badge bg-black"><?php echo $resume['total_org'];?></span>
				</a>
			</li>
			<li>
				<a href="#" data-html="true" data-toggle="tooltip" data-placement="left" title="Total User App. <?php echo $MYCFG['GENERAL']['APP_NAME'];?>">
					<i class="fa fa-users fa-tw"></i>&nbsp;Users <span class="pull-right badge bg-black"><?php echo $resume['total_user'];?></span>
				</a>
			</li>
			<li class="active">
				<a href="#" data-html="true" data-toggle="tooltip" data-placement="left" title="Total Group App. <?php echo $MYCFG['GENERAL']['APP_NAME'];?>">
					<i class="fa fa-tags fa-tw"></i>&nbsp;Groups <span class="pull-right badge bg-black"><?php echo $resume['total_group'];?></span>
				</a>
			</li>
			
			<li>
				<a href="#">
					<i class="fa fa-archive fa-tw"></i>&nbsp;PROJECT <span class="pull-right badge bg-black"><?php echo $resume['total_project'];?></span>
				</a>
			</li>
			<li class="active">
				<a href="#">
					<i class="fa fa-sellsy fa-tw"></i>&nbsp;MONITORING <span class="pull-right badge bg-black"><?php echo $resume['total_project'];?></span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class="fa fa-address-card fa-tw"></i>&nbsp;TICKET <span class="pull-right badge bg-black"><?php echo $resume['total_project'];?></span>
				</a>
			</li>
		</ul>
	</div>
</div>