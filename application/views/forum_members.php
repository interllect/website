<h3>Welcome to our interllegence center</h3>
<p style="float: left; max-width: 400px;">
	<?php echo anchor('forum','Main Forum');?>
	>
	<?php if(($alphabet == '')||($alphabet == 'all')):?>
		<span style="text-transform: capitalize;"><?php echo anchor('forum/members/','All Members');?></span>
	<?php else:?>
		<?php echo anchor('forum/members/'.$alphabet, '<span style="text-transform: capitalize;">Members Starting With '.$alphabet.'</span>');?>
	<?php endif;?>
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

	<?php echo anchor('forum/arcade/','Arcade');?> 
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
		<?php echo anchor('forum/members/a','A');?> | 
		<?php echo anchor('forum/members/b','B');?> | 
		<?php echo anchor('forum/members/c','C');?> | 
		<?php echo anchor('forum/members/d','D');?> | 
		<?php echo anchor('forum/members/e','E');?> | 
		<?php echo anchor('forum/members/f','F');?> | 
		<?php echo anchor('forum/members/g','G');?> | 
		<?php echo anchor('forum/members/h','H');?> | 
		<?php echo anchor('forum/members/i','I');?> | 
		<?php echo anchor('forum/members/j','J');?> | 
		<?php echo anchor('forum/members/k','K');?> | 
		<?php echo anchor('forum/members/l','L');?> | 
		<?php echo anchor('forum/members/m','M');?> | 
		<?php echo anchor('forum/members/n','N');?> | 
		<?php echo anchor('forum/members/o','O');?> | 
		<?php echo anchor('forum/members/p','P');?> | 
		<?php echo anchor('forum/members/q','Q');?> | 
		<?php echo anchor('forum/members/r','R');?> | 
		<?php echo anchor('forum/members/s','S');?> | 
		<?php echo anchor('forum/members/t','T');?> | 
		<?php echo anchor('forum/members/u','U');?> | 
		<?php echo anchor('forum/members/v','V');?> | 
		<?php echo anchor('forum/members/w','W');?> | 
		<?php echo anchor('forum/members/x','X');?> | 
		<?php echo anchor('forum/members/y','Y');?> | 
		<?php echo anchor('forum/members/z','Z');?> | 
		<?php echo anchor('forum/members/','All');?>
	</div>		
	<div class="spacer"></div>
	
	<div class="container thin">
		<?php if(($alphabet == '')||($alphabet == 'all')):?>
			<h3 style="text-transform: capitalize;">All Members</h3>
		<?php else:?>
			<?php echo '<h3 style="text-transform: capitalize;">Members Starting With '.$alphabet.'</h3>';?>
		<?php endif;?>
	
		<?php if($user->num_rows() > 0):?>
			<div class="container thin" style="font-size: 16px;">
				<span style="float: left; width: 285px; text-align: center;">				
					<strong>Name</strong>
				</span>
				<span style="float: left; width: 285px; text-align: center;">
					<strong>Threads Started</strong>
				</span>
				<span style="float: left; width: 285px; text-align: center;">
					<strong>Number of Posts</strong>
				</span>
			</div>
			<div class="spacer"></div>
			<?php foreach($user->result() as $row): ?>
			<?php $first_char = substr($row->username, 0, 1);?>
				<?php if($first_char == $alphabet):?>
					<div class="container thin">
						<span style="float: left; width: 285px; text-align: center;">				
							<strong><?php echo anchor('profile/view/'.$row->id, $row->username);?></strong>
						</span>
						<span style="float: left; width: 285px; text-align: center;">
						<?php 
							$this->db->where('user_id', $row->id);
							$this->db->from('forum_threads');
							echo "<strong>" . $this->db->count_all_results() . "</strong>"; 
						?>
						</span>
						<span style="float: left; width: 285px; text-align: center;">
						<?php 
							$this->db->where('user_id', $row->id);
							$this->db->from('forum_posts');
							echo "<strong>" . $this->db->count_all_results() . "</strong>"; 
						?>
						</span>
					</div>
					<div class="spacer"></div>
				<?php elseif(($alphabet == '')||($alphabet == 'all')):?>	
					<div class="container thin">
						<span style="float: left; width: 285px; text-align: center;">				
							<strong><?php echo anchor('profile/view/'.$row->id, $row->username);?></strong>
						</span>
						<span style="float: left; width: 285px; text-align: center;">
						<?php 
							$this->db->where('user_id', $row->id);
							$this->db->from('forum_threads');
							echo "<strong>" . $this->db->count_all_results() . "</strong>"; 
						?>
						</span>
						<span style="float: left; width: 285px; text-align: center;">
						<?php 
							$this->db->where('user_id', $row->id);
							$this->db->from('forum_posts');
							echo "<strong>" . $this->db->count_all_results() . "</strong>"; 
						?>
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