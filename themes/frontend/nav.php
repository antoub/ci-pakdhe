<header class="main-header">
	<nav class="navbar navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<a href="<?php echo site_url();?>" class="navbar-brand"><b>App</b>Name</a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
			</div>
			
			<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="#"><i class="fa fa-info-circle"></i>&nbsp;Info</a></li>
					<li><a href="#"><i class="fa fa-cube"></i>&nbsp;Data</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-bar-chart"></i>&nbsp;Statistics <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><i class="fa fa-bar-chart"></i>&nbsp;Stat 1</a></li>
							<li><a href="#"><i class="fa fa-bar-chart"></i>&nbsp;Stat 2</a></li>
						</ul>
					</li>
				</ul>
				
			</div>
			
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input class="form-control" id="navbar-search-input" placeholder="Search" type="text">
						</div>
					</form>
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-power-off"></i>&nbsp;Login
						</a>
						<ul class="dropdown-menu">
							<li class="user-header">
								<form>
									<div class="form-group">
										<label class="pull-left">Email address</label>
										<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
									</div>
									<div class="form-group">
										<label class="pull-left">Password</label>
										<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
									</div>								
							</li>
							<li class="user-footer bg-gray">
								<div class="pull-right">
									<button class="btn btn-primary btn-flat">Sign in</a>
								</div>
								</form>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- /.navbar-custom-menu -->
		</div>
		<!-- /.container-fluid -->
	</nav>
</header>