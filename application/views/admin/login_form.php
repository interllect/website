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

<script type="text/javascript">
function reloadPage()
  {
	window.location.reload()
  }
</script>

<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="<?=base_url();?>assets/admin/js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
</head>

<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>

<body id="login-bg"> 
 
<!-- Start: login-holder -->
<div id="login-holder">

	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->
	<div id="loginbox" style="margin-top: 150px;">
	
		<!--  start login-inner -->
		<div id="login-inner">

			<?php echo form_open($this->uri->uri_string()); ?>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><?php echo form_label($login_label, $login['id']); ?></td>
					<td><?php echo form_input($login); ?></td>
					<td style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></td>
				</tr>
				<tr>
					<td><?php echo form_label('Password', $password['id']); ?></td>
					<td><?php echo form_password($password); ?></td>
					<td style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></td>
				</tr>

				<?php if ($show_captcha) {
					if ($use_recaptcha) { ?>
				<tr>
					<td colspan="2">
						<div id="recaptcha_image"></div>
					</td>
					<td>
						<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
						<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
						<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="recaptcha_only_if_image">Enter the words above</div>
						<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
					</td>
					<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
					<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
					<?php echo $recaptcha_html; ?>
				</tr>
				<?php } else { ?>
				<tr>
					<td colspan="3">
						<p>Enter the code exactly as it appears:</p>
						<?php echo $captcha_html; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
					<td><?php echo form_input($captcha); ?></td>
					<td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
				</tr>
				<?php }
				} ?>

				<tr>
					<td colspan="3">
						<?php echo form_checkbox($remember); ?>
						<?php echo form_label('Remember me', $remember['id']); ?>
					</td>
				</tr>
			</table>
			<?php $attr = array('onclick' => 'reloadPage()');?>
			<?php echo form_submit('submit', 'Let me in', $attr); ?>
			<?php echo form_close(); ?>
		<!-- End: login-holder -->
		</div>
	</div>
</div>
</body>
</html>	