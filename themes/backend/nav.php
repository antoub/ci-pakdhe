  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
					<img src="<?php echo image_asset_url('fa_user-circle-o_45.png');?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info" style="margin-left:10px;margin-top:-5px;">
          <p>
						<?php echo $_SESSION['username'];?><br style="margin-bottom:2px;"/>
						<i class="fa fa-tags"></i> <?php echo strtoupper($_SESSION['group_name']);?><br style="margin-bottom:2px;"/>
						<i class="fa fa-university"></i> <?php echo strtoupper($_SESSION['org_name']);?>
					</p>
        </div>
      </div>
			<ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">MAIN MENU</li>
				<?php foreach($menus as $k=>$v):?>
					<?php if((isset($v['children']))&&(count($v['children']))):?>
						<li class="treeview">
							<a href="<?php echo site_url($v['url']);?>">
								<i class="<?php echo $v['iconCls'];?>"></i> <span><?php echo $v['text'];?></span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>								
							</a>
							<ul class="treeview-menu">
								<?php foreach($v['children'] as $key=>$val):?>
									<li>
										<a href="<?php echo site_url($val['url']);?>">
											<i class="<?php echo $val['iconCls'];?>"></i>&nbsp;<?php echo $val['text'];?>								
										</a>
									</li>
								<?php endforeach;?>
								</ul>
					<?php else:?>
						<li>
							<a href="<?php echo $v['url'];?>">
								<i class="<?php echo $v['iconCls'];?>"></i> <span><?php echo $v['text'];?></span>								
							</a>
					<?php endif;?>
						</li>
				<?php endforeach;?>
       
        <li class="header">Created By</li>
        <li>
					<a href="mailto:<?php echo $MYCFG['owner_mail'];?>">
						<i class="fa fa-envelope-o text-aqua"></i> <span><?php echo $MYCFG['owner'];?></span>
					</a>
				</li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

