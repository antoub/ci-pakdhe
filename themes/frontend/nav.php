<header class="main-header">
	<nav class="navbar navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<a href="<?php echo site_url();?>" class="navbar-brand"><i class="fa fa-cube"></i>&nbsp;<b><?php echo $MYCFG['name_short'];?></b><?php echo $MYCFG['name_short2'];?></a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
			</div>
			
			<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="<?php echo site_url('home/info/');?>"><i class="fa fa-info-circle"></i>&nbsp;Info</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-cube"></i>&nbsp;Data <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><i class="fa fa-bar-chart"></i>&nbsp;Data 1</a></li>
						</ul>
					</li>					
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-bar-chart"></i>&nbsp;Statistics <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><i class="fa fa-bar-chart"></i>&nbsp;Statistik 1</a></li>
						</ul>
					</li>
				</ul>
				
			</div>
			
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<?php if(!$this->ion_auth->logged_in()):?>
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-power-off"></i>&nbsp;Login
						</a>
						<ul class="dropdown-menu">
							<li class="user-header">
								<form name="frm-login" id="frm-login" action="<?php echo site_url('acl/login');?>" method="POST">
									<div class="form-group">
										<label class="pull-left">Email Address</label>
										<input type="text" class="form-control" id="user_name" name="user_name" placeholder="Email User">
									</div>
									<div class="form-group">
										<label class="pull-left">Password</label>
										<input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password">
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
					<?php else:?>
					<li>
						<a href="<?php echo site_url('dashboard');?>">
							<i class="fa fa-cogs"></i>&nbsp;Dashboard
						</a>
					</li>
					<?php endif;?>
				</ul>
			</div>
		</div>
	</nav>
	<script>
		$(document).ready(function(){
			$('#frm-login').submit(function(e){
				var form_data = $(this).serialize();
				
				$.ajax({
					type: "POST",
					url: $(this).attr('action'),
					data: form_data,
					dataType: 'json',
					success: function(ret){
						console.log(ret);
						if(ret.result){
							window.location.replace(ret.url);
						}else{
							alert(ret.msg);
						}
					},
				});
				
				e.preventDefault();
			});
		});
	</script>
</header>