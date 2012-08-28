<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Internet Dreams</title>
<link rel="stylesheet" href="<?=base_url();?>assets/admin/css/screen.css" type="text/css" media="screen" title="default" />
<!--  jquery core -->
<script src="<?=base_url();?>assets/admin/js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>

<!-- Custom jquery scripts -->
<script src="js/jquery/custom_jquery.js" type="text/javascript"></script>

<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="<?=base_url();?>assets/admin/js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
</head>
<body id="login-bg"> 
 
<!-- Start: login-holder -->
<div id="login-holder">

	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->
	<div id="loginbox" style="margin-top: 150px;">
	
		<!--  start login-inner -->
		<div style="color: white; text-align: center;" id="login-inner">
			<h1 style="font-size: 25px;">Coming Soon!</h1>
			<br/>
			<p>infro adhaskjdhaksjdhas dasdjha ksjdh akjsd kjasdknasd kasjdhkas kjasd</p>
			<br/>
			<p>
			<?php if (!$this->tank_auth->is_logged_in()):?>
				<?php echo anchor('/admin/login/', 'Login'); ?>
			<?php else:?>
				<?php if($role_id<='1'): echo 'Welcome <strong>'.$username.'</strong>... to enter the Administration panel click here: '. anchor('admin/dashboard/', 'AdminCp'). ' |'; endif; ?> 
				<?php if($role_id=='2'): echo 'Welcome <strong>'.$username.'</strong>... to enter the Moderation panel click here: '. anchor('admin/media_center/media', 'ModCp'). ' |'; endif; ?>
				<?php echo anchor('/auth/logout/', 'Logout'); ?>
			<?php endif; ?>
			</p>
		</div>
		
	</div>
</div>
</body>
</html>