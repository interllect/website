<h3>Welcome to our interllegence center</h3>
<p style="float: left; max-width: 400px;">
	<?php echo anchor('forum','Main Forum');?>
	>
	<?php echo anchor('forum/arcade/','Arcade');?> 
</p>

<span style="float: right;">
	<?php 
	// pm message detector
		$this->db->select('*');
		$this->db->where('read', 0);
		$this->db->where('reciever_id', $user_id);
		$this->db->from('pm');
		$new_messages = $this->db->count_all_results();
	?>

	<?php echo anchor('forum/members/','View Members');?>
	<?php if($new_messages!=0) : ?>
					<?php if($new_messages != 1) { 
						$plural = "s"; 
					} 
					else { 
						$plural = ""; 
					}
						$link_contents = 'You have <strong>'.$new_messages.'</strong> new message'.$plural.'.'; 
					?>
						| <i id="new-messages" style="text-decoration: blink;"><?php echo anchor('forum/pm/', $link_contents);?></i>
	<?php else: ?>		
		| <?php echo anchor('forum/pm/','Personal Messages');?> 
	<?php endif; ?>
</span>

</div>

<div class="content_plain" style="overflow: hidden;">
	
	<div class="container thin">
		<div style="margin: 0px auto; width: 650px;">
			<?php if($game->num_rows() > 0):?>
				<?php foreach($game->result() as $row): ?>
				<h3><?php echo $row->title;?></h3>
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="650" height="450" id="game_<?php echo $row->id;?>" align="middle">
					<param name="movie" value="<?php echo base_url();?>uploads/games/<?php echo $row->game;?>" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#FFFFFF" />
					<param name="play" value="false" />
					<param name="loop" value="true" />
					<param name="wmode" value="transparent" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="true" />
					<param name="salign" value="" />
					<param name="allowScriptAccess" value="sameDomain" />
					<!--[if !IE]>-->
					<object type="application/x-shockwave-flash" data="<?php echo base_url();?>uploads/games/<?php echo $row->game;?>" width="650" height="450">
					  <param name="movie" value="<?php echo base_url();?>uploads/games/<?php echo $row->game;?>" />
					  <param name="quality" value="high" />
					  <param name="bgcolor" value="#000000" />
					  <param name="play" value="true" />
					  <param name="loop" value="true" />
					  <param name="wmode" value="transparent" />
					  <param name="scale" value="showall" />
					  <param name="menu" value="true" />
					  <param name="devicefont" value="true" />
					  <param name="salign" value="" />
					  <param name="allowScriptAccess" value="sameDomain" />
					  <!--<![endif]-->
					  <a href="http://www.adobe.com/go/getflash">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
					  </a>
					  <!--[if !IE]>-->
					</object>
					<!--<![endif]-->
				</object>
				<?php endforeach;?>
			<?php else:?>
				<h3>No Game Chosen</h3>
				<div style="width:650px; height:450px; background-color: black; text-align: center;">
					<img height="200" alt="Game" style="width: auto; margin:125px auto 0px;" src="<?php echo base_url();?>assets/images/logo.png">
					<p><strong>(Please Choose a game from the list below)</strong></p>
				</div>
			<?php endif;?>
		</div>
	</div>
	<div class="spacer"></div>
	
	<div class="container thin">
		<h3>Game List</h3>
		<?php if($games_list->num_rows() > 0):?>
			<div class="container thin" style="font-size: 16px;">
				<span style="float: left; width: 285px; text-align: center;">				
					<strong>Title</strong>
				</span>
				<span style="float: left; width: 285px; text-align: center;">
					<strong>Description</strong>
				</span>
				<span style="float: left; width: 285px; text-align: center;">
					<strong>Genre</strong>
				</span>
			</div>
			<div class="spacer"></div>
			<?php foreach($games_list->result() as $row): ?>
				<?php if($row->id == $id):?>
				<div class="container thin" style="background-color: gold !important;">
					<span style="float: left; width: 285px; text-align: center;">	
						<strong><?php echo anchor(base_url().'forum/arcade/'.$row->id, $row->title);?></strong>
					</span>
					<span style="float: left; width: 285px; text-align: center;">
						<p><?php echo $row->description;?></p>
					</span>
					<span style="float: left; width: 285px; text-align: center;">
						<p><?php echo $row->genre;?></p>
					</span>
				</div>
				<div class="spacer"></div>
				<?php else:?>
				<div class="container thin">
					<span style="float: left; width: 285px; text-align: center;">	
						<strong><?php echo anchor(base_url().'forum/arcade/'.$row->id, $row->title);?></strong>
					</span>
					<span style="float: left; width: 285px; text-align: center;">
						<p><?php echo $row->description;?></p>
					</span>
					<span style="float: left; width: 285px; text-align: center;">
						<p><?php echo $row->genre;?></p>
					</span>
				</div>
				<div class="spacer"></div>
				<?php endif;?>
			<?php endforeach;?>
		<?php endif;?>
	</div>
	<div class="spacer"></div>
	
	<div class="container thin">
		<p>Members online now: 
		<?php foreach($online->result() as $user_online): ?>
		  <?php $user_data = $this->session->_unserialize($user_online->user_data); ?>
			<?php if($user_data==""):?>
				<strong>guest,</strong>
			<?php else:?>
				<strong><?php echo anchor('profile/view/'.$user_data['user_id'], $user_data['username']); ?>,</strong>
			<?php endif;?>	
		<?php endforeach; ?>  		
		</p>
		<p>Members online within the last 24hours: 
		<?php if($last_24->num_rows() > 0):?>
			<?php foreach($last_24->result() as $row): ?>
				<strong><?php echo anchor('profile/view/'.$row->id, $row->username);?></strong>, 
			<?php endforeach; ?>
		<?php endif; ?> 
		</p>
		<p>Newest Member is: 
		<?php if($newest->num_rows() > 0):?>
			<?php foreach($newest->result() as $row): ?>
				<strong><?php echo anchor('profile/view/'.$row->id, $row->username);?></strong>, 
			<?php endforeach; ?>
		<?php endif; ?> 
	</div>