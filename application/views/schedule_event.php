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
		color: <?php echo $settings->border_color;?> !important;
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
		color: <?php echo $settings->link_normal_visited_color;?>;
		font-size: <?php echo $settings->link_size;?>px !important;
	}
	a:hover, a:active {
		color: <?php echo $settings->link_hover_active_color;?> !important;
	}
	
	#nav_bar ul li a:hover, #nav_bar ul li a.active{
		color: <?php echo $settings->link_hover_active_color;?> !important;
		background-image:url('<?=base_url();?>assets/images/<?php echo $settings->container_image;?>') !important;
		border: <?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?> !important;
	}
	</style>
	
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
	;?>
</head>
<body>


<?php if($schedule_event->num_rows() > 0):?>
<div class="container">
<h3>Event</h3>
	<div style="overflow: auto; height: 210px; min-height: 210px !important;">
		<?php foreach($schedule_event->result() as $row): ?>
				<div class="container thin">
					<strong>Event Name:</strong> <h2><?php echo $row->Subject; ?></h2>
					<br/>
					<strong>Location:</strong> <?php echo $row->Location; ?>
					<br/>
					<strong>Event Date:</strong> <span style="font-size: 11px;"><?php echo substr($row->StartTime, 8 , 2) . "/". substr($row->StartTime, 5 , 2) . "/". substr($row->StartTime, 0 , 4 ); ?></span>
					<br/>
					<strong>Start Time:</strong> <span style="font-size: 11px;"><?php echo substr($row->StartTime, 11 , 2).':'.substr($row->StartTime, 14 , 2); ?></span>
					<strong>End Time:</strong> <span style="font-size: 11px;"><?php echo substr($row->EndTime, 11 , 2).':'.substr($row->EndTime, 14 , 2); ?></span>
					<p><?php echo bad_words($row->Description); ?></p>
				</div>
				<div class="spacer"></div>
		<?php endforeach; ?>
	</div>
</div>		
<?php endif; ?>

</body>
</html>