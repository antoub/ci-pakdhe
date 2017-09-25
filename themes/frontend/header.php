<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Blank Page</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?php echo css_asset('bootstrap.min.css','bootstrap');?>
	<?php echo css_asset('font-awesome.min.css','font-awesome');?>
	<?php echo css_asset('AdminLTE.min.css','adminlte');?>
	<?php echo css_asset('skins/_all-skins.css','adminlte');?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
	
	<?php echo js_asset('jquery.min.js');?>
	<?php echo js_asset('bootstrap.min.js','bootstrap');?>
	<?php echo js_asset('app.min.js','adminlte');?>
	
	<script type="text/javascript">
		var BASE_URL = '<?php echo base_url();?>';
		var SITE_URL = '<?php echo site_url();?>';
	</script>
</head>