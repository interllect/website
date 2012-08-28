<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Welcome to Interllect - <?php $news_blogs_fix = str_replace('_',' ',str_replace('admin/','',uri_string())); echo str_replace('/',' > ',str_replace('news blogs','news & blogs', $news_blogs_fix)); ?></title>
<link rel="stylesheet" href="<?=base_url();?>assets/admin/css/screen.css" type="text/css" media="screen" title="default" />
<link rel="stylesheet" href="<?=base_url();?>assets/css/prettyphoto/prettyPhoto.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url();?>assets/colorpicker/css/colorpicker.css" type="text/css" />
<!--[if IE]>
<link rel="stylesheet" media="all" type="text/css" href="<?=base_url();?>assets/admin/css/pro_dropline_ie.css" />
<![endif]-->

<!--  jquery core -->
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/jquery-1.4.1.min.js"></script>

<!--  checkbox styling script -->
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/ui.core.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/ui.checkbox.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/jquery.bind.js"></script>
<script type="text/javaScript" src="<?=base_url();?>assets/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/audio-player.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/colorpicker/js/eye.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/colorpicker/js/utils.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/colorpicker/js/layout.js?ver=1.0.2"></script>
<script type="text/javascript">
$(function(){
	$('input').checkBox();
	$('#toggle-all').click(function(){
 	$('#toggle-all').toggleClass('toggle-checked');
	$('#mainform input[type=checkbox]').checkBox('toggle');
	return false;
	});
});
</script>  

<![if !IE 7]>

<!--  styled select box script version 1 -->
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/jquery.selectbox-0.5.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect').selectbox({ inputClass: "selectbox_styled" });
});
</script>
 

<![endif]>

<!--  styled select box script version 2 --> 
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/jquery.selectbox-0.5_style_2.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect_form_1').selectbox({ inputClass: "styledselect_form_1" });
	$('.styledselect_form_2').selectbox({ inputClass: "styledselect_form_2" });
});
</script>

<!--  styled select box script version 3 --> 
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/jquery.selectbox-0.5_style_2.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect_pages').selectbox({ inputClass: "styledselect_pages" });
});
</script>

<!--  styled file upload script --> 
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/jquery.filestyle.js"></script>
<script type="text/javascript" charset="utf-8">
  $(function() {
      $("input.file_1").filestyle({ 
          image: "<?=base_url();?>assets/admin/images/forms/choose-file.gif",
          imageheight : 21,
          imagewidth : 78,
          width : 310
      });
  });
</script>

<!-- Custom jquery scripts -->
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/custom_jquery.js"></script>
 
<!-- Tooltips -->
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/jquery.tooltip.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/jquery.dimensions.js"></script>
<script type="text/javascript">
$(function() {
	$('a.info-tooltip ').tooltip({
		track: true,
		delay: 0,
		fixPNG: true, 
		showURL: false,
		showBody: " - ",
		top: -35,
		left: 5
	});
});
</script> 


<!--  date picker script -->
<link rel="stylesheet" href="<?=base_url();?>assets/admin/css/datePicker.css" type="text/css" />
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/date.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/jquery.datePicker.js"></script>
<script type="text/javascript" charset="utf-8">
        $(function()
{

// initialise the "Select date" link
$('#date-pick')
	.datePicker(
		// associate the link with a date picker
		{
			createButton:false,
			startDate:'01/01/2005',
			endDate:'31/12/2020'
		}
	).bind(
		// when the link is clicked display the date picker
		'click',
		function()
		{
			updateSelects($(this).dpGetSelected()[0]);
			$(this).dpDisplay();
			return false;
		}
	).bind(
		// when a date is selected update the SELECTs
		'dateSelected',
		function(e, selectedDate, $td, state)
		{
			updateSelects(selectedDate);
		}
	).bind(
		'dpClosed',
		function(e, selected)
		{
			updateSelects(selected[0]);
		}
	);
	
var updateSelects = function (selectedDate)
{
	var selectedDate = new Date(selectedDate);
	$('#d option[value=' + selectedDate.getDate() + ']').attr('selected', 'selected');
	$('#m option[value=' + (selectedDate.getMonth()+1) + ']').attr('selected', 'selected');
	$('#y option[value=' + (selectedDate.getFullYear()) + ']').attr('selected', 'selected');
}
// listen for when the selects are changed and update the picker
$('#d, #m, #y')
	.bind(
		'change',
		function()
		{
			var d = new Date(
						$('#y').val(),
						$('#m').val()-1,
						$('#d').val()
					);
			$('#date-pick').dpSetSelected(d.asString());
		}
	);

// default the position of the selects to today
var today = new Date();
updateSelects(today.getTime());

// and update the datePicker to reflect it...
$('#d').trigger('change');
});
</script>

<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script type="text/javascript" src="<?=base_url();?>assets/admin/js/jquery/jquery.pngFix.pack.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
	<?php
		// chat session name
		@session_start();
		$_SESSION['username'] = $this->session->userdata('username');
		
		// pm message detector
		$this->db->select('*');
		$this->db->where('read', 0);
		$this->db->where('reciever_id', $user_id);
		$this->db->from('pm');
		$new_messages = $this->db->count_all_results();
	?>

</head>
<body> 
<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

<!-- Start: page-top-outer -->
<div id="page-top-outer">    

<!-- Start: page-top -->
<div id="page-top">

	<!-- start logo -->
	<div id="logo" style="padding-left: 10px; padding-top: 10px; margin: 0px !important;">
	<a href="<?=base_url();?>" style="float: left;"><img src="<?=base_url();?>assets/images/logo.png" width="70" style="height: auto;" alt="" /></a>
	<h1 style="float: right; color: white;">
	<?php if($role_id<='1'): echo 'Admin Panel'; endif; ?> 
	<?php if($role_id=='2'): echo 'Moderator Panel'; endif; ?> 
	</h1>
	</div>
	
	<!-- end logo -->
	
	<!--  start top-search -->
	<div id="top-search">
		<?php echo form_open('admin/search');?>
			<table border="0" cellpadding="0" cellspacing="0">
			<tr>
			<td><input type="text" name="keyword" value="Search" onblur="if (this.value=='') { this.value='Search'; }" onfocus="if (this.value=='Search') { this.value=''; }" class="top-search-inp" /></td>

			<td>
			<input type="image" src="<?=base_url();?>assets/admin/images/shared/top_search_btn.gif"  />
			</td>
			</tr>
			</table>
		</form>
	</div>
 	<!--  end top-search -->
 	<div class="clear"></div>

</div>
<!-- End: page-top -->

</div>
<!-- End: page-top-outer -->
	
<div class="clear">&nbsp;</div>


<div class="nav-outer-repeat"> 
<!--  start nav-outer -->
<div class="nav-outer"> 

		<!-- start nav-right -->
		<div id="nav-right">
		
			<div class="nav-divider">&nbsp;</div>
			<div class="showhide-account"><img src="<?=base_url();?>assets/admin/images/shared/nav/nav_myaccount.gif" width="93" height="14" alt="" /></div>
			<div class="nav-divider">&nbsp;</div>
			<a href="<?=base_url();?>auth/logout" id="logout"><img src="<?=base_url();?>assets/admin/images/shared/nav/nav_logout.gif" width="64" height="14" alt="" /></a>
			<div class="clear">&nbsp;</div>
		
			<!--  start account-content -->	
			<div class="account-content">
			<div class="account-drop-inner">
				<?php if($role_id<='1'): ?>
					<a href="<?=base_url();?>admin/settings" id="acc-settings">Settings</a>
					<div class="clear">&nbsp;</div>
					<div class="acc-line">&nbsp;</div>
				<?php endif; ?>
				<a href="<?=base_url();?>profile" id="acc-details">My Profile</a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="<?=base_url();?>forum/pm" id="acc-inbox">Personal Message</a>
				<div class="clear">&nbsp;</div>	
			</div>
			</div>
			<!--  end account-content -->
		
		</div>
		<!-- end nav-right -->

		<?php 
			/**
			 * Clear all attempt of Swear words
			 *
			 * @param	string 
			 * @return	string
			 */
			function bad_words($text)
			{
				$swearWords = array('motherfucking', 'motherfucker', 'fucker', 'fuck', 'bitch', 'shit', 'pussy', 'nigger', 'slut', 'cunt');

				$replaceWith = array('m****rf*****g', 'm****rf***r', 'f****r', 'f**k', 'b***h', 's**t', 'p***y', 'n****r', 's**t', 'c**t');

				$text = str_ireplace($swearWords, $replaceWith, $text);

				return $text;
			}
		
			$url = uri_string();
			$active_str = 'current';
			$dashboard = $media_center = $shop = $forum = $news = $about = $faq = $contact = $schedule = $lists = "";
			
			// dashboard
			if(($url=="admin/dashboard")||($url=="admin")) { $dashboard = $active_str; }else{ $dashboard = "select"; }
			
			// Media Center
			$check = strstr($url,'media_center');
			if($check !== false) { $media_center = $active_str; }else{ $media_center = "select"; }
			$this->db->where('module_name', 'media_center');
			$media_center_module = $this->db->get('modules')->row();

			// Shop
			$check = strstr($url,'shop');
			if($check !== false) { $shop = $active_str; }else{ $shop = "select"; }
			$this->db->where('module_name', 'shop');
			$shop_module = $this->db->get('modules')->row();

			// Forum
			$check = strstr($url,'forum');
			if($check !== false) { $forum = $active_str; }else{ $forum = "select"; }
			$this->db->where('module_name', 'forum');
			$forum_module = $this->db->get('modules')->row();
			
			// News
			$check = strstr($url,'news');
			if($check !== false) { $news = $active_str; }else{ $news = "select"; }
			$this->db->where('module_name', 'news_blogs');
			$news_module = $this->db->get('modules')->row();
			
			// About
			$check = strstr($url,'about');
			if($check !== false) { $about = $active_str; }else{ $about = "select"; }
			$this->db->where('module_name', 'about');
			$about_module = $this->db->get('modules')->row();
			
			// FAQ
			$check = strstr($url,'faq');
			if($check !== false) { $faq = $active_str; }else{ $faq = "select"; }
			$this->db->where('module_name', 'faq');
			$faq_module = $this->db->get('modules')->row();
			
			// Contact
			$check = strstr($url,'contact');
			if($check !== false) { $contact = $active_str; }else{ $contact = "select"; }
			$this->db->where('module_name', 'contact');
			$contact_module = $this->db->get('modules')->row();
			
			// Schedule
			$check = strstr($url,'schedule');
			if($check !== false) { $schedule = $active_str; }else{ $schedule = "select"; }
			$this->db->where('module_name', 'schedule');
			$schedule_module = $this->db->get('modules')->row();
			
			// List
			$check = strstr($url,'lists');
			if($check !== false) { $lists = $active_str; }else{ $lists = "select"; }
			$this->db->where('module_name', 'lists');
			$lists_module = $this->db->get('modules')->row();
			
			// Manage users
			$check = strstr($url,'manage_users');
			if($check !== false) { $manage_users = $active_str; }else{ $manage_users = "select"; }
		?>

		<!--  start nav -->
		<div class="nav" style=" width: 1020px !important; font-size: 12px;">
		<div class="table">
		
		<?php if($role_id<='1'): ?>
			<ul class="<?php echo $dashboard;?>"><li><a href="<?=base_url();?>admin/dashboard"><b>Dashboard</b><!--[if IE 7]><!--></a><!--<![endif]-->
			<!--[if lte IE 6]><table><tr><td><![endif]-->
			<div class="select_sub">
				<ul class="sub">
					<li><a href="<?=base_url();?>admin/dashboard/splash/">Splash</a></li>
					<li><a href="<?=base_url();?>admin/dashboard/advert/">Advert</a></li>
					<?php if($role_id<='0'): ?><li><a href="<?=base_url();?>admin/dashboard/modules/">Modules</a></li><?php endif; ?>
					<li><a href="<?=base_url();?>admin/dashboard/chat/">Chat</a></li>
				</ul>
			</div>
			<!--[if lte IE 6]></td></tr></table></a><![endif]-->
			</li>
			</ul>
		
			<div class="nav-divider">&nbsp;</div>
		<?php endif; ?>
		
		<?php if($media_center_module->status != '0') :?>
			<ul class="<?php echo $media_center;?>"><li><a href="<?=base_url();?>admin/media_center"><b>Media Center</b><!--[if IE 7]><!--></a><!--<![endif]-->
			</li>
			</ul>
		<?php endif;?>
		
		<?php if($shop_module->status != '0') :?>
			<?php if($role_id<='1'): ?> 
				<div class="nav-divider">&nbsp;</div>
				
				<ul class="<?php echo $shop;?>"><li><a href="<?=base_url();?>admin/shop"><b>Shop</b><!--[if IE 7]><!--></a><!--<![endif]-->
				<!--[if lte IE 6]><table><tr><td><![endif]-->
				<div class="select_sub">
					<ul class="sub">
						<li><a href="<?=base_url();?>admin/shop/categories/">Categories and Category Products</a></li>
						<li><a href="<?=base_url();?>admin/shop/standards_formatting/">Standards and Formats</a></li>
						<li><a href="<?=base_url();?>admin/shop/transactions/">User Transactions</a></li>
					</ul>
				</div>
				<!--[if lte IE 6]></td></tr></table></a><![endif]-->
				</li>
				</ul>
			<?php endif; ?>
		<?php endif;?>
		
		<?php if($forum_module->status != '0') :?>
			<div class="nav-divider">&nbsp;</div>
			
			<ul class="<?php echo $forum;?>"><li><a href="<?=base_url();?>admin/forum"><b>Forum</b><!--[if IE 7]><!--></a><!--<![endif]-->
			<!--[if lte IE 6]><table><tr><td><![endif]-->
			<?php if($role_id<='1'): ?>
			<div class="select_sub">
				<ul class="sub">
					<li><a href="<?=base_url();?>admin/forum/pm/">Personal Messages</a></li>
					<li><a href="<?=base_url();?>admin/forum/shoutbox/">Shoutbox</a></li>
					<li><a href="<?=base_url();?>admin/forum/block/">Blocks</a></li>
					<li><a href="<?=base_url();?>admin/forum/arcade/">Arcade</a></li>
				</ul>
			</div>
			<?php endif; ?>
			<!--[if lte IE 6]></td></tr></table></a><![endif]-->
			</li>
			</ul>
		<?php endif;?>
		
		<?php if($news_module->status != '0') :?>
			<div class="nav-divider">&nbsp;</div>
			
			<ul class="<?php echo $news;?>"><li><a href="<?=base_url();?>admin/news"><b>News</b><!--[if IE 7]><!--></a><!--<![endif]-->		
			</li>
			</ul>
		<?php endif;?>
		
		<?php if($about_module->status != '0') :?>
			<?php if($role_id<='1'): ?> 
				<div class="nav-divider">&nbsp;</div>
				
				<ul class="<?php echo $about;?>"><li><a href="<?=base_url();?>admin/about"><b>About</b><!--[if IE 7]><!--></a><!--<![endif]-->
				</li>
				</ul>
			<?php endif; ?>
		<?php endif;?>
		
		<?php if($faq_module->status != '0') :?>
			<div class="nav-divider">&nbsp;</div>
			
			<ul class="<?php echo $faq;?>"><li><a href="<?=base_url();?>admin/faq"><b>FAQ</b><!--[if IE 7]><!--></a><!--<![endif]-->
			</li>
			</ul>
		<?php endif;?>
		
		<?php if($contact_module->status != '0') :?>
			<div class="nav-divider">&nbsp;</div>
			
			<ul class="<?php echo $contact;?>"><li><a href="<?=base_url();?>admin/contact"><b>Contact</b><!--[if IE 7]><!--></a><!--<![endif]-->
			</li>
			</ul>
		<?php endif;?>
		
		<?php if($schedule_module->status != '0') :?>
			<div class="nav-divider">&nbsp;</div>
			
			<ul class="<?php echo $schedule;?>"><li><a href="<?=base_url();?>admin/schedule"><b>Schedule</b><!--[if IE 7]><!--></a><!--<![endif]-->
			</li>
			</ul>
		<?php endif;?>
		
		<?php if($lists_module->status != '0') :?>
			<div class="nav-divider">&nbsp;</div>
			
			<ul class="<?php echo $lists;?>"><li><a href="<?=base_url();?>admin/lists"><b>Lists</b><!--[if IE 7]><!--></a><!--<![endif]-->
			</li>
			</ul>
		<?php endif;?>
		
		<?php if($role_id<='1'): ?> 
			<div class="nav-divider">&nbsp;</div>
			
			<ul class="<?php echo $manage_users;?>"><li><a href="<?=base_url();?>admin/manage_users"><b>Manage Users</b><!--[if IE 7]><!--></a><!--<![endif]-->
			</li>
			</ul>
		<?php endif; ?> 
		
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
		</div>
		<!--  start nav -->

</div>
<div class="clear"></div>
<!--  start nav-outer -->
</div>
<!--  start nav-outer-repeat................................................... END -->

 <div class="clear"></div>
 
 
 
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1 style="text-transform: capitalize;"><?php $news_blogs_fix = str_replace('_',' ',str_replace('admin/','',uri_string())); echo str_replace('/',' > ',str_replace('news blogs','news & blogs', $news_blogs_fix)); ?></h1>
	</div>
	<!-- end page-heading -->
	
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="<?=base_url();?>assets/admin/images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="<?=base_url();?>assets/admin/images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>

		<div id="content-table-inner">
		
			
			<div id="table-content">
			
				<div id="message-blue">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="blue-left">Welcome back <?php echo $username;?>!. <a href="<?php echo base_url();?>profile/view/<?php echo $user_id;?>">View my account.</a> </td>
					<td class="blue-right"><a class="close-blue"><img src="<?=base_url();?>assets/admin/images/table/icon_close_blue.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>
				
				<?php if($new_messages!=0) : ?>
					<?php 
					if($new_messages != 1) { 
						$plural = "s"; 
					} 
					else { 
						$plural = ""; 
					}
					
					$link_contents = 'You have <strong>'.$new_messages.'</strong> new message'.$plural.'.'; ?>
					
					<div id="message-yellow">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="yellow-left"><?php echo $link_contents;?> <a href="<?php echo base_url();?>forum/pm/">Go to Inbox.</a></td>
						<td class="yellow-right"><a class="close-yellow"><img src="<?php echo base_url();?>assets/admin/images/table/icon_close_yellow.gif"   alt="" /></a></td>
					</tr>
					</table>
					</div>					
		
				<?php endif; ?>					
			