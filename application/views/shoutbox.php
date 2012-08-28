<html>
<head>
	<meta http-equiv="refresh" content="1">
	
	<base href="<?=base_url();?>" />
	
	<?php 
		$this->db->where('id', '1');
		$settings = $this->db->get('settings')->row();
	?>
	
	<style>
		body, p{
			color: <?php echo $settings->all_text_color;?>;
			/*background-image:url('<?=base_url();?>/assets/images/<?php echo $settings->container_image;?>');*/
		}
		
		a{
			color: <?php echo $settings->link_normal_visited_color;?>;
			text-decoration: none;
		}
		
		a:hover{
			color: <?php echo $settings->link_hover_active_color;?>;
		}
		
		container{
			padding: 10px;
			background-image:url('<?=base_url();?>/assets/images/<?php echo $settings->container_image;?>');
			-moz-border-radius: 15px;
			border-radius: 15px;
			overflow: auto;
			height: auto;
			min-height: 125px;
			margin: 0px 0px;
		}
			.spacer{
				width: 100%; 
				height: 10px; 
				float: left;
			}
			
			.across{
				float: left;
				min-width: 900px;
			}

			.left{
				float: left;
				min-width: 435px;
			}

			.right{
				float: right;
				min-width: 435px;
			}
			
			.thin{
				min-height: 0px;
			}
	</style>
</head>
<body>
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
	?>
	
		<div class="container thin" style="overflow: auto;">
		<?php if($forum_shoutbox->num_rows() > 0):?>
			<?php foreach($forum_shoutbox->result() as $row): ?>
			
				<?php if($user_profiles->num_rows() > 0):?>
					<?php foreach($user_profiles->result() as $item): ?>
						<?php if($row->user_id == $item->user_id):?>
							<?php $profile_id_shout = $item->user_id; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			
					<div class="spacer"></div>
					<span style="float: left; margin-right: 20px;">
						<strong><?php echo anchor(base_url()."profile/view/".$profile_id_shout, $row->username, array('target' => '_blank')); ?></strong>
						<p style="font-size: 11px;"><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></p>
					</span>
					<span style="float: left;">
						<?php echo bad_words($row->message); ?>
					</span>
					<div class="spacer" style="border-bottom: 1px solid silver;"></div>	
			<?php endforeach; ?>
		<?php endif; ?> 
		</div>
		<div class="spacer"></div>
</body>
</html>