<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<?php 
		$this->db->where('id', '1');
		$settings = $this->db->get('settings')->row();
	?>
	<meta http-equiv="Content-Type" content="text/xhtml,text/xml; charset=utf-8" />
	<meta name="keywords" content="<?php echo $settings->keywords;?>" />
	<meta name="description" content="<?php echo $settings->description;?>" />
 	<meta property="fb:admins" content="365482783510718" />
	
	<title><?php echo $settings->business_name;?> - <?php echo uri_string(); ?></title>
	<base href="<?=base_url();?>" />
	
	<link rel="shortcut icon" href="<?=base_url();?>assets/images/<?php echo $settings->business_logo;?>" />
	
	<?php if($settings->layout_type == '1') :?>
		<link rel="stylesheet" href="<?=base_url();?>assets/css/all.css" type="text/css" media="screen" />
	<?php elseif($settings->layout_type == '2') :?>
		<link rel="stylesheet" href="<?=base_url();?>assets/css/all_2.css" type="text/css" media="screen" />
	<?php elseif($settings->layout_type == '3') :?>
		<link rel="stylesheet" href="<?=base_url();?>assets/css/all_3.css" type="text/css" media="screen" />
	<?php elseif($settings->layout_type == '4') :?>
		<link rel="stylesheet" href="<?=base_url();?>assets/css/all_4.css" type="text/css" media="screen" />
	<?php elseif($settings->layout_type == '5') :?>
		<link rel="stylesheet" href="<?=base_url();?>assets/css/all_5.css" type="text/css" media="screen" />
	<?php endif;?>
	
	<style>
	html{
		background: <?php echo $settings->color_1;?>; 
		<?php if (($settings->color_2 != '')||($settings->color_3 != '')):?>
			background: -moz-linear-gradient(top,  <?php echo $settings->color_1;?> 0%, <?php echo $settings->color_2;?> 50%, <?php echo $settings->color_3;?> 100%);
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $settings->color_1;?>), color-stop(50%,<?php echo $settings->color_2;?>), color-stop(100%,<?php echo $settings->color_3;?>));
			background: -webkit-linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
			background: -o-linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
			background: -ms-linear-gradient(top, <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
			background: linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $settings->color_1;?>', endColorstr='<?php echo $settings->color_3;?>',GradientType=0 );
		<?php endif;?>
		min-height: 100%;
	}
	
	.nivo-caption{
		background: <?php echo $settings->color_1;?> !important; 
	}
	
	<?php if($settings->layout_type == '2') :?>
	.banner{
		-moz-border-radius: <?php echo $settings->corner_radius;?>px <?php echo $settings->corner_radius;?>px 0px 0px !important;
		border-radius: <?php echo $settings->corner_radius;?>px <?php echo $settings->corner_radius;?>px 0px 0px !important;
	}
	
	#footer{
		-moz-border-radius: 0px;
		border-radius: 0px;
	}

	.site_map{
		-moz-border-radius: 0px 0px <?php echo $settings->corner_radius;?>px <?php echo $settings->corner_radius;?>px !important;
		border-radius: 0px 0px <?php echo $settings->corner_radius;?>px <?php echo $settings->corner_radius;?>px !important;
	}
	<?php endif;?>
	
	.banner, #nav_bar, #nav_bar ul li a:hover, #nav_bar ul li a.active, 
	.content, #footer <?php if($settings->layout_type != '2') :?>, .container<?php endif;?><?php if($settings->layout_type == '2') :?>, .content_plain<?php endif;?>{
		border: <?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?> !important;
		<?php if($settings->layout_type != '2') :?>
			-moz-border-radius: <?php echo $settings->corner_radius;?>px !important;
			border-radius: <?php echo $settings->corner_radius;?>px !important;
		<?php endif;?>
		background: <?php echo $settings->container_color_1;?>;
		<?php if (($settings->container_color_2 != '')||($settings->container_color_3 != '')):?>
			background: -moz-linear-gradient(top,  <?php echo $settings->container_color_1;?> 0%, <?php echo $settings->container_color_2;?> 50%, <?php echo $settings->container_color_3;?> 100%);
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $settings->container_color_1;?>), color-stop(50%,<?php echo $settings->container_color_2;?>), color-stop(100%,<?php echo $settings->color_3;?>));
			background: -webkit-linear-gradient(top,  <?php echo $settings->container_color_1;?> 0%,<?php echo $settings->container_color_2;?> 50%,<?php echo $settings->container_color_3;?> 100%); 
			background: -o-linear-gradient(top,  <?php echo $settings->container_color_1;?> 0%,<?php echo $settings->container_color_2;?> 50%,<?php echo $settings->container_color_3;?> 100%); 
			background: -ms-linear-gradient(top, <?php echo $settings->container_color_1;?> 0%,<?php echo $settings->container_color_2;?> 50%,<?php echo $settings->container_color_3;?> 100%); 
			background: linear-gradient(top,  <?php echo $settings->container_color_1;?> 0%,<?php echo $settings->container_color_2;?> 50%,<?php echo $settings->container_color_3;?> 100%); 
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $settings->container_color_1;?>', endColorstr='<?php echo $settings->container_color_3;?>',GradientType=0 );
		<?php endif;?>
		background-repeat: <?php echo $settings->container_repeat;?> !important;
		background-position: <?php echo $settings->container_position;?> !important;
	}
		.container{
			border: <?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?> !important;
			<?php if($settings->layout_type != '2') :?>
				-moz-border-radius: <?php echo $settings->corner_radius;?>px !important;
				border-radius: <?php echo $settings->corner_radius;?>px !important;
			<?php else:?>
				background:url('<?=base_url();?>assets/images/<?php echo $settings->container_image;?>')!important;
			<?php endif;?>
			background-repeat: <?php echo $settings->container_repeat;?> !important;
			background-position: <?php echo $settings->container_position;?> !important;
		}
	
	
	input[type="text"], input[type="password"]{
		border: <?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?> !important;
		color: <?php echo $settings->all_text_color;?> !important;
		background-color: white;
		-moz-border-radius: <?php echo $settings->corner_radius;?>px !important;
		border-radius: <?php echo $settings->corner_radius;?>px !important;
	}
		input[type="button"], input[type="submit"], input[type="file"]{
			border: <?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?> !important;
			color: <?php echo $settings->link_normal_visited_color;?> !important;
			background-color: <?php echo $settings->container_color_1;?>;
			<?php if (($settings->container_color_2 != '')||($settings->container_color_3 != '')):?>
				background: -moz-linear-gradient(top,  <?php echo $settings->container_color_1;?> 0%, <?php echo $settings->container_color_2;?> 50%, <?php echo $settings->container_color_3;?> 100%);
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $settings->container_color_1;?>), color-stop(50%,<?php echo $settings->container_color_2;?>), color-stop(100%,<?php echo $settings->color_3;?>));
				background: -webkit-linear-gradient(top,  <?php echo $settings->container_color_1;?> 0%,<?php echo $settings->container_color_2;?> 50%,<?php echo $settings->container_color_3;?> 100%); 
				background: -o-linear-gradient(top,  <?php echo $settings->container_color_1;?> 0%,<?php echo $settings->container_color_2;?> 50%,<?php echo $settings->container_color_3;?> 100%); 
				background: -ms-linear-gradient(top, <?php echo $settings->container_color_1;?> 0%,<?php echo $settings->container_color_2;?> 50%,<?php echo $settings->container_color_3;?> 100%); 
				background: linear-gradient(top,  <?php echo $settings->container_color_1;?> 0%,<?php echo $settings->container_color_2;?> 50%,<?php echo $settings->container_color_3;?> 100%); 
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $settings->container_color_1;?>', endColorstr='<?php echo $settings->container_color_3;?>',GradientType=0 );
			<?php endif;?>
			-moz-border-radius: <?php echo $settings->corner_radius;?>px !important;
			border-radius: <?php echo $settings->corner_radius;?>px !important;
		}
	
	hr{
		color: <?php echo $settings->border_color;?>;
	}
	
	body, p{
		color: <?php echo $settings->all_text_color;?> ;
		font-size: <?php echo $settings->all_text_size;?>px ;
		font-family: <?php echo $settings->all_text_type;?> ;
		background-repeat: <?php echo $settings->background_repeat;?> !important;
		background-position: <?php echo $settings->background_position;?> !important;
		scrollbar-face-color:<?php echo $settings->container_color_2;?> ;
		scrollbar-shadow-color:<?php echo $settings->container_color_1;?> ;
		scrollbar-highlight-color: <?php echo $settings->container_color_3;?> ;
		scrollbar-3dlight-color: <?php echo $settings->container_color_1;?> ;
		scrollbar-darkshadow-color: <?php echo $settings->container_color_1;?>;
		scrollbar-track-color: <?php echo $settings->container_color_2;?> ;
		scrollbar-arrow-color: <?php echo $settings->container_color_3;?> ;
	}
	
	h3, h3 a{
		color: <?php echo $settings->header_color;?> !important;
		font-size: <?php echo $settings->header_size;?>px !important;
	}
	
	a, a:visited {
		color: <?php echo $settings->link_normal_visited_color;?> !important;
		font-size: <?php echo $settings->link_size;?>px !important;
	}
	a:hover, a:active {
		color: <?php echo $settings->link_hover_active_color;?> !important;
	}
	
	#nav_bar ul li a:hover, #nav_bar ul li a.active{
		color: <?php echo $settings->link_hover_active_color;?> !important;
		background:url('<?=base_url();?>assets/images/<?php echo $settings->container_image;?>') <?php echo $settings->color_1;?> !important;
		<?php if (($settings->color_2 != '')||($settings->color_3 != '')):?>
			background: -moz-linear-gradient(top,  <?php echo $settings->color_1;?> 0%, <?php echo $settings->color_2;?> 50%, <?php echo $settings->color_3;?> 100%);
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $settings->color_1;?>), color-stop(50%,<?php echo $settings->color_2;?>), color-stop(100%,<?php echo $settings->color_3;?>));
			background: -webkit-linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
			background: -o-linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
			background: -ms-linear-gradient(top, <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
			background: linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $settings->color_1;?>', endColorstr='<?php echo $settings->color_3;?>',GradientType=0 );
		<?php endif;?>
		border: <?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?> !important;
	}
	</style>
	
	<link rel="stylesheet" href="<?=base_url();?>assets/css/nivo/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?=base_url();?>assets/css/nivo/pascal.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?=base_url();?>assets/css//nivo/orman.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?=base_url();?>assets/css/nivo/nivo-slider.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?=base_url();?>assets/css/prettyphoto/prettyPhoto.css" type="text/css" media="screen" />

	<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-1.7.1.min.js"></script>
	
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<?php
		$this->db->where('module_name', 'advert');
		$advert_module = $this->db->get('modules')->row();
	?>
	
	<script type="text/javascript" src="<?=base_url();?>assets/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/ckeditor/_samples/sample.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery.nivo.slider.pack.js"></script>
	<script type="text/javaScript" src="<?=base_url();?>assets/js/jquery.mousewheel.js"></script>
	<script type="text/javaScript" src="<?=base_url();?>assets/js/cloud-carousel.1.0.5.js"></script>
	<script type="text/javaScript" src="<?=base_url();?>assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javaScript" src="<?=base_url();?>assets/js/jquery.carousel.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/js/audio-player.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/js/chat.js"></script>
	<?php if($advert_module->status != '0') :?>
		<script type="text/javascript" src="<?=base_url();?>assets/js/peel.js"></script>
	<?php endif;?>
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider({
			controlNavThumbs:true
		});
    });
	
	function clickclear(thisfield, defaulttext) {
		if (thisfield.value == defaulttext) {
			thisfield.value = "";
		}
	}

	function clickrecall(thisfield, defaulttext) {
		if (thisfield.value == "") {
			thisfield.value = defaulttext;
		}
	}
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

<?php echo $settings->google_analytics;?>	

</head>
<body <?php if(($role_id >= '3')||(!$role_id)):?>oncontextmenu="alert('You may not right click'); return false;"<?php endif;?>>
<div <?php if($mp3player_module->status != '0') :?>style="margin:0px auto !important; height: 100px !important; width: 920px !important; padding: 10px !important;"<?php endif;?> class="spacer_top banner_image_link">
	<div style="float: right;">
		<?php
			$this->db->where('module_name', 'mp3player');
			$mp3player_module = $this->db->get('modules')->row();
		
			$this->db->limit(3);
			$this->db->order_by('id', 'desc');
			$this->db->where('audio !=', '');
			$mp3_playlist = $this->db->get('media');
			
			$this->db->limit(1);
			$this->db->order_by('id', 'desc');
			$this->db->where('audio !=', '');
			$mp3_first = $this->db->get('media')->row();
		?>
		<?php if($mp3player_module->status != '0') :?>
			<object type="application/x-shockwave-flash" data="<?php echo base_url();?>/mp3player/player_mp3_multi.swf" width="200" height="100">
				<param name="movie" value="<?php echo base_url();?>/mp3player/player_mp3_multi.swf" />
				<param name="wmode" value="transparent" />
				<param name="FlashVars" value="mp3=<?php echo base_url().'/uploads/media/'.$mp3_first->audio; foreach($mp3_playlist->result() as $row): if($mp3_first->audio != $row->audio): echo '|'.base_url().'/uploads/media/'.$row->audio; endif; endforeach;?>&amp;bgcolor1=<?php echo str_replace('#','',$settings->container_color_1);?>&amp;bgcolor2=<?php if(($settings->container_color_2 != '')||($settings->container_color_3 != '')): echo str_replace('#','',$settings->container_color_3); else: echo str_replace('#','',$settings->container_color_1); endif;?>&amp;buttoncolor=999999&amp;buttonovercolor=<?php echo str_replace('#','',$settings->link_hover_active_color);?>&amp;slidercolor1=<?php echo str_replace('#','',$settings->container_color_1);?>&amp;slidercolor2=<?php if(($settings->container_color_2 != '')||($settings->container_color_3 != '')): echo str_replace('#','',$settings->container_color_3); else: echo str_replace('#','',$settings->container_color_1); endif;?>&amp;sliderovercolor=<?php echo str_replace('#','',$settings->link_hover_active_color);?>&amp;textcolor=<?php echo str_replace('#','',$settings->link_normal_visited_color);?>&amp;playlistcolor=<?php if(($settings->container_color_2 != '')||($settings->container_color_3 != '')): echo str_replace('#','',$settings->container_color_3); else: echo str_replace('#','',$settings->container_color_1); endif;?>&amp;currentmp3color=<?php echo str_replace('#','',$settings->link_hover_active_color);?>&amp;scrollbarcolor=999999&amp;scrollbarovercolor=0<?php if((uri_string() == "")||(uri_string() == "home")):?>&amp;autoplay=1<?php endif;?>&amp;loop=1" />
				<p>Please Install Flash</p>
			</object>
		<?php endif;?>
	</div>
</div>	
 <!--[if lt IE 7]>
  <div style='border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 75px; position: relative;'>
    <div style='position: absolute; right: 3px; top: 3px; font-family: courier new; font-weight: bold;'><a href='#' onclick='javascript:this.parentNode.parentNode.style.display="none"; return false;'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-cornerx.jpg' style='border: none;' alt='Close this notice'/></a></div>
    <div style='width: 640px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;'>
      <div style='width: 75px; float: left;'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-warning.jpg' alt='Warning!'/></div>
      <div style='width: 275px; float: left; font-family: Arial, sans-serif;'>
        <div style='font-size: 14px; font-weight: bold; margin-top: 12px;'>You are using an outdated browser</div>
        <div style='font-size: 12px; margin-top: 6px; line-height: 12px;'>For a better experience using this site, please upgrade to a modern web browser.</div>
      </div>
      <div style='width: 75px; float: left;'><a href='http://www.firefox.com' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-firefox.jpg' style='border: none;' alt='Get Firefox 3.5'/></a></div>
      <div style='width: 75px; float: left;'><a href='http://www.browserforthebetter.com/download.html' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-ie8.jpg' style='border: none;' alt='Get Internet Explorer 8'/></a></div>
      <div style='width: 73px; float: left;'><a href='http://www.apple.com/safari/download/' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-safari.jpg' style='border: none;' alt='Get Safari 4'/></a></div>
      <div style='float: left;'><a href='http://www.google.com/chrome' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-chrome.jpg' style='border: none;' alt='Get Google Chrome'/></a></div>
    </div>
  </div>
  <![endif]-->
  
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		<?php 
		
			/**
			 * Clear all attempt of Swear words
			 *
			 * @param	string 
			 * @return	string
			 */
			function bad_words($text)
			{
				$swearWords = array('motherfucking', 'motherfucker', 'fucker', 'fuck', 'bitch', 'shit', 'pussy', 'nigger', 'slut', 'cunt', '[img]', '[/img]', 'javascript:', '<script>', '</script>', '<style>', '</style>');

				$replaceWith = array('m****rf*****g', 'm****rf***r', 'f****r', 'f**k', 'b***h', 's**t', 'p***y', 'n****r', 's**t', 'c**t', '<img src="', '" />', '[removed]:', '<s>', '</s>', '<sc>', '</sc>');

				$text = str_ireplace($swearWords, $replaceWith, $text);

				return $text;
			}
		
			$url = uri_string();
			$active_str = 'active';
			$home = $media_center = $shop = $forum = $news_blogs = $about = $faq = $contact = $schedule = $lists = "";
			
			// Home
			if(($url=="home")||($url=="")) { $home = $active_str; }
			$this->db->where('module_name', 'home');
			$home_module = $this->db->get('modules')->row();
			
			// Media Center
			$check = strstr($url,'media_center');
			if($check !== false) { $media_center = $active_str; }
			$this->db->where('module_name', 'media_center');
			$media_center_module = $this->db->get('modules')->row();

			// Shop
			$check = strstr($url,'shop');
			if($check !== false) { $shop = $active_str; }
			$this->db->where('module_name', 'shop');
			$shop_module = $this->db->get('modules')->row();

			// Forum
			$check = strstr($url,'forum');
			if($check !== false) { $forum = $active_str; }
			$this->db->where('module_name', 'forum');
			$forum_module = $this->db->get('modules')->row();
			
			// News & Blogs
			$check = strstr($url,'news_blogs');
			if($check !== false) { $news_blogs = $active_str; }
			$this->db->where('module_name', 'news_blogs');
			$news_blogs_module = $this->db->get('modules')->row();
			
			// About
			$check = strstr($url,'about');
			if($check !== false) { $about = $active_str; }
			$this->db->where('module_name', 'about');
			$about_module = $this->db->get('modules')->row();
			
			// FAQ
			$check = strstr($url,'faq');
			if($check !== false) { $faq = $active_str; }
			$this->db->where('module_name', 'faq');
			$faq_module = $this->db->get('modules')->row();
			
			// Contact
			$check = strstr($url,'contact');
			if($check !== false) { $contact = $active_str; }
			$this->db->where('module_name', 'contact');
			$contact_module = $this->db->get('modules')->row();
			
			// Schedule
			$check = strstr($url,'schedule');
			if($check !== false) { $schedule = $active_str; }
			$this->db->where('module_name', 'schedule');
			$schedule_module = $this->db->get('modules')->row();
			
			// Lists
			$check = strstr($url,'lists');
			if($check !== false) { $lists = $active_str; }
			$this->db->where('module_name', 'lists');
			$lists_module = $this->db->get('modules')->row();
			
			$this->db->where('module_name', 'profile');
			$profile_module = $this->db->get('modules')->row();
			
			$this->db->where('module_name', 'search');
			$search_module = $this->db->get('modules')->row();
			
		?>
		
	<div class="banner">
		<div class="logo left">
			<a href="home">
				<img src="<?=base_url();?>assets/images/logo.png" style="width: auto;" height="50"/>
				<span style="text-transform: capitalize;"><?php echo $settings->business_name;?><span>
			</a>
		</div>
		<div class="right user_cp" style="text-align: right;">
		<?php if (!$this->tank_auth->is_logged_in()):?>
		<p><?php echo anchor('/auth/register/', 'Sign-up'); ?> | <?php echo anchor('/auth/login/', 'Login'); ?></p>
		<?php else:?>
			<?php if($profile_module->status != '0') :?><p>Hi, <strong><?php if($role_id<='3'): echo anchor('profile/view/'.$user_id, $username); endif; ?></strong>! <?php endif;?>
			<?php if($role_id<='1'): echo '| '. anchor('admin/dashboard/', 'AdminCp'); endif; ?> 
			<?php if($role_id=='2'): echo '| '. anchor('admin/media_center/media', 'ModCp'); endif; ?> 
			<?php echo '| '. anchor('/auth/logout/', 'Logout'); ?></p>
			
			<?php if($shop_module->status != '0') :?>
				<?php $this->db->from('user_to_products'); $this->db->where('user_id', $user_id); $this->db->where('transaction_type', "1"); $basket_count = $this->db->count_all_results(); echo 'Items in '.anchor('shop/basket/', 'My Shopping Basket').' (<strong>'.$basket_count.'</strong>)'; ?>
			<?php endif; ?>
			
			<?php if($forum_module->status != '0') :?>
				<?php if($new_messages!=0) : ?>
					<?php if($new_messages != 1) { 
						$plural = "s"; 
					} 
					else { 
						$plural = ""; 
					}
						$link_contents = 'You have <strong>'.$new_messages.'</strong> new message'.$plural.'.'; ?>
						<h4 id="new-messages" style="text-decoration: blink;"><?php echo anchor('forum/pm/', $link_contents);?></h4>
						
						<?php if(($url!="forum/pm")||($url!="forum/pm_read")||($url!="profile")): ?>	
							<script type="text/javascript">

							//Alert message once script- By JavaScript Kit
							//Credit notice must stay intact for use
							//Visit http://javascriptkit.com for this script

							//specify message to alert
							var alertmessage="You have a new message, please chack your Inbox"

							///No editing required beyond here/////

							//Alert only once per browser session (0=no, 1=yes)
							var once_per_session=1


							function get_cookie(Name) {
							  var search = Name + "="
							  var returnvalue = "";
							  if (document.cookie.length > 0) {
								offset = document.cookie.indexOf(search)
								if (offset != -1) { // if cookie exists
								  offset += search.length
								  // set index of beginning of value
								  end = document.cookie.indexOf(";", offset);
								  // set index of end of cookie value
								  if (end == -1)
									 end = document.cookie.length;
								  returnvalue=unescape(document.cookie.substring(offset, end))
								  }
							   }
							  return returnvalue;
							}

							function alertornot(){
							if (get_cookie('alerted')==''){
							loadalert()
							document.cookie="alerted=yes"
							}
							}

							function loadalert(){
							alert(alertmessage)
							}

							if (once_per_session==0)
							loadalert()
							else
							alertornot()

							</script>
						<?php endif; ?>		
				<?php endif; ?>
			<?php endif; ?>
			
		<?php endif;?>
		</div>
	</div>
	
	<div id="nav_bar">
		<?php if($search_module->status != '0') :?>
		<div class="nav_search">
			<?php echo form_open('search');?>
			<input type="text" name="keyword" value="" onclick="clickclear(this, '')" onblur="clickrecall(this,'')"/>
			<input type="submit" value="Search"/>
			</form>
		</div>	
		<?php endif;?>
		<ul>
			<?php if($home_module->status != '0') :?>
			<li>
				<a href="home" class="<?php echo $home;?>">Home</a>
			</li>
			<?php endif;?>
			<?php if($media_center_module->status != '0') :?>
			<li>
				<a href="media_center" class="<?php echo $media_center;?>">Media Center</a>
			</li>
			<?php endif;?>
			<?php if($shop_module->status != '0') :?>
			<li>
				<a href="shop" class="<?php echo $shop;?>">Shop</a>
			</li>
			<?php endif;?>
			<?php if($forum_module->status != '0') :?>
			<li>
				<a href="forum" class="<?php echo $forum;?>">Forum</a>
			</li>
			<?php endif;?>
			<?php if($news_blogs_module->status != '0') :?>
			<li>
				<a href="news_blogs" class="<?php echo $news_blogs;?>">News and Blogs</a>
			</li>
			<?php endif;?>
			<?php if($about_module->status != '0') :?>
			<li>
				<a href="about" class="<?php echo $about;?>">About</a>
			</li>
			<?php endif;?>
			<?php if($faq_module->status != '0') :?>
			<li>
				<a href="faq" class="<?php echo $faq;?>">FAQ</a>
			</li>
			<?php endif;?>
			<?php if($contact_module->status != '0') :?>
			<li>
				<a href="contact" class="<?php echo $contact;?>">Contact</a>
			</li>
			<?php endif;?>
			<?php if($schedule_module->status != '0') :?>
			<li>
				<a href="schedule" class="<?php echo $schedule;?>">Schedule</a>
			</li>
			<?php endif;?>
			<?php if($lists_module->status != '0') :?>
			<li>
				<a href="lists" class="<?php echo $lists;?>">Lists</a>
			</li>
			<?php endif;?>
		</ul>
	</div>

<div class="content">
