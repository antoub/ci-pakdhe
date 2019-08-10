  <header class="main-header">
    <a href="<?php echo site_url('dashboard/');?>" class="logo">
      <span class="logo-mini"><b><?php echo substr($MYCFG['name_short'],0,1);?></b><?php echo substr($MYCFG['name_short'],1,2);?></span>
      <span class="logo-lg"><b><?php echo $MYCFG['name_short'];?></b><?php echo $MYCFG['name_short2'];?></span>
    </a>
    
		<nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
					<li>
						<a href="<?php echo site_url();?>" target="_blank">
							<i class="fa fa-home"></i>&nbsp;Frontend
						</a>
					</li>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user-circle-o"></i>&nbsp;<?php echo $_SESSION['first_name'].' '.$_SESSION['last_name'];?>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header" style="text-align:left !important;">
                <p>
                  <i class="fa fa-user-circle-o"></i>&nbsp;<?php echo $_SESSION['first_name'].' '.$_SESSION['last_name'];?><br />
									<i class="fa fa-tags"></i>&nbsp;<?php echo strtoupper($_SESSION['group_name']);?><br/>
									<i class="fa fa-university"></i> <?php echo strtoupper($_SESSION['org_name']);?><br />
									<i class="fa fa-envelope"></i>&nbsp;<?php echo $_SESSION['email'];?><br />
									<i class="fa fa-phone-square"></i>&nbsp;<?php echo $_SESSION['phone'];?></a>
                </p>
              </li>
              <li class="user-footer bg-black">
                <div class="pull-right">
                  <a href="<?php echo site_url('acl/logout/');?>" class="btn btn-danger btn-flat"><i class="fa fa-power-off"></i>&nbsp;Log out</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>