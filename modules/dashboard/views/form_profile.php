
<div class="box box-primary">
	<div class="box-header bg-light-blue">
		<h3 class="box-title">
			<i class="fa fa-user-circle-o"></i>&nbsp;Edit My Profiles
		</h3>
		<span class="pull-right">
			<span class="label bg-black">
				<i class="fa fa-tags"></i>&nbsp;<?php echo $this->session->userdata['group_name'];?>&nbsp;
				<i class="fa fa-university"></i>&nbsp;<?php echo $this->session->userdata['org_name'];?></span>
		</span>
	</div>
	<form role="form" id="frm-profile" name="frm-profile">
		<div class="box-body">
			<input type="hidden" name="profile_id" id="profile_id" value="<?php echo $this->ion_auth->user()->row()->user_id;?>" />
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Username</label>
						<input type="text" id="profile_username" name="profile_username" class="form-control" value="<?php echo $this->ion_auth->user()->row()->username;?>" disabled>
					</div>
					<div class="form-group">
						<label>
							<input type="checkbox" name="profile_rst_pass" id="profile_rst_pass"> Reset Password
						</label>				
						<input type="password" name="profile_password" id="profile_password" class="form-control" readonly>
					</div>
					<div class="form-group">
						<label>First Name</label>
						<input type="text"  name="profile_first_name" id="profile_first_name" class="form-control" value="<?php echo $this->ion_auth->user()->row()->first_name;?>">
					</div>
					
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Email Address</label>
						<input type="email" name="profile_email" id="profile_email" value="<?php echo $this->ion_auth->user()->row()->email;?>" class="form-control">
					</div>
					<div class="form-group">
						<label>Phone Number</label>
						<input type="text" name="profile_phone" id="profile_phone" value="<?php echo $this->ion_auth->user()->row()->phone;?>" class="form-control">
					</div>
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" name="profile_last_name" id="profile_last_name" class="form-control" value="<?php echo $this->ion_auth->user()->row()->last_name;?>">
					</div>
				</div>
			</div>
			
		</div>
		<div class="box-footer bg-gray">
			<button class="btn btn-primary btn-md pull-right" type="submit"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
		</div>
  </form>
</div>


<script>
	$(document).ready(function(){
		$('#ajax_img').hide();
		$(document).ajaxStart(function() {
			$('#ajax_img').show();
		});
		$(document).ajaxStop(function() {
			$('#ajax_img').hide();
		});
		
		$("#profile_rst_pass").change(function() {
			$("#profile_password").prop("readonly", !$(this).is(":checked"));
		});
		
		$('#frm-profile').submit(function(e){
			var form_data=$("#frm-profile").serialize();
			console.log(form_data);
			
			$.ajax({
					type: "POST",
					url: SITE_URL+"/dashboard/change_profile/",
					dataType: "json",
					data: form_data,
					success: function(data){
						if(data.resp){
							alert("Selamat,\n\r"+data.message);
						}else{
							alert("Ada kesalahan.\n\r"+data.message);
						}
					}
			});
			
			e.preventDefault();
		});
		
	});
	
</script>