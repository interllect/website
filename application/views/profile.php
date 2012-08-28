	<?php 
		$this->db->where('id', '1');
		$settings = $this->db->get('settings')->row();
	?>

<h3>My Profile</h3>
<?php if($profile_id == ""):?>
	<?php redirect(base_url().'profile/view/'.$user_id); ?>
<?php endif; ?>
</div>

<div class="content_plain">
<?php if($user_id == $profile_id):?>
	<div class="container left">
		<div class="container thin" style="width: 415px;">
<?php else: ?>
	<div class="container" style="text-align: center;">
		<div class="container thin">
<?php endif; ?>
		<h3>Profile Info</h3>
			<?php if($user_profiles->num_rows() > 0):?>
				<?php foreach($user_profiles->result() as $row): ?>
					<?php echo "<strong>Avatar:</strong> <br/><img src='".base_url()."uploads/user_profiles/avatars/".$row->image."' style='max-height: 300px; max-width: 300px; height: auto; width: auto;' alt='avatar'></img>";?>
					<br/><br/>
					<?php echo "<strong>Country:</strong> <br/>".$row->country;?>
					<br/><br/>
					<?php echo "<strong>Website:</strong> <br/>".anchor($row->website,$row->website);?> 	
					<br/><br/>
					<?php echo "<strong>Biography:</strong> <br/>".bad_words($row->bio);?> 	
					<br/><br/>
					<?php echo "<strong>Signature:</strong> <br/>".bad_words($row->signature);?>
					<?php if($row->facebook != ""):?>
						<div style="text-align: center; width: 340px; margin: 0px auto;">
							<br/><br/>
							<?php echo "<strong>Facebook Page:</strong> <br/>";?>
							<div class="fb-like-box" data-href="<?php echo $row->facebook;?>" data-width="340" data-colorscheme="<?php echo $settings->fb_color_scheme;?>" data-show-faces="false" data-stream="true" data-header="false"></div>
						</div>
					<?php endif;?>
					<?php if($row->twitter != ""):?>
						<div style="text-align: center; width: 340px; margin: 0px auto;">
							<br/><br/>
							<?php echo "<strong>Twitter:</strong> <br/>";?>
							<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
							<script>
							new TWTR.Widget({
							  version: 2,
							  type: 'profile',
							  rpp: 4,
							  interval: 30000,
							  width: 340,
							  height: 300,
							  theme: {
								shell: {
									background: '<?php echo $settings->color_1;?>',
									color: '<?php echo $settings->all_text_color;?>'
								},
								tweets: {
									background: '<?php echo $settings->color_2;?>',
									color: '<?php echo $settings->link_normal_visited_color;?>',
									links: '<?php echo $settings->link_hover_active_color;?>'
								}
							  },
							  features: {
								scrollbar: false,
								loop: false,
								live: false,
								behavior: 'all'
							  }
							}).render().setUser('<?php echo str_replace("https://twitter.com/#!/","@",$row->twitter);?>').start();
							</script>
						</div>
					<?php endif;?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<div class="spacer"></div>
		
		<div class="container thin">
		<h3>Account Credentials</h3>
			<?php if($users->num_rows() > 0):?>
				<?php foreach($users->result() as $row): ?>
					<?php echo "<strong>Username:</strong> <br/>".$row->username;?>
					<br/><br/>
					<?php if($user_id == $profile_id):?>
						<strong>Current Password:</strong> <br/>********  - (<?php echo anchor('auth/change_password', "<small>Change Password</small>");?>)
						<br/><br/>
					<?php endif; ?>
					<?php if(($user_id == $profile_id)||($role_id <= '3')):?><?php echo "<strong>Email:</strong> <br/>";?><?php echo safe_mailto($row->email, 'Click Here to Contact Me');?><?php endif; ?> <?php if($user_id == $profile_id):?> - (<?php echo anchor('auth/change_email', "<small>Change Email</small>");?>)<?php endif; ?>
					<?php if(($user_id == $profile_id)||($role_id <= '2')):?><br/><br/><?php endif; ?>
					<?php echo "<strong>Last login:</strong> <br/>";?> <?php echo  substr($row->last_login, 8 , 2) . "/". substr($row->last_login, 5 , 2) . "/". substr($row->last_login, 0 , 4 ); ?>
					<br/><br/>
					<?php echo "<strong>Joined:</strong> <br/>";?> <?php echo  substr($row->created, 8 , 2) . "/". substr($row->created, 5 , 2) . "/". substr($row->created, 0 , 4 ); ?>
					<br/>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>	
	</div>
	
	<?php if($user_id == $profile_id):?>
	<div class="container right">
		<div class="container thin" style="width: 415px;">
		<span style="float: right;">
			<?php echo anchor('forum/pm/','Personal Messages');?> 
		</span>
		<br/>
		
		<h3>Edit Profile Info</h3>
		<?php echo $alert_msg;?>
		<?php echo form_open_multipart('profile/update_info/'.$user_id);?>
			<label for="editor1">My Avatar:</label>
			<?php echo "<img src='".base_url()."uploads/user_profiles/avatars/".$profile->image."' style='max-height: 400px; max-width: 400px; height: auto; width: auto;' alt='avatar'></img>";?>
			<br/>
			<input type="file" name="image" size="20" value="<?php echo $profile->image;?>" class="input_long"/>
			<br/>
			<small>
				<strong>Accepted format(s):</strong> JPG/JPEG, PNG and GIF 
				<br/> 
				<strong>Max image size:</strong> 900 X 900 (pixels) 
				<br/> 
				<strong>Max file size:</strong> 10MB
			</small>
			<br/>
			<label for="editor1">Country:</label>
			<input type="text" name="country" value="<?php echo $profile->country;?>" class="input_long">
			<br/>
			<label for="editor1">Website:</label>
			<input type="text" name="website" value="<?php echo $profile->website;?>" class="input_long">
			<br/>
			<label for="editor1">Bio:</label>
			<textarea name="bio" class="input_long"><?php echo $profile->bio;?></textarea>
			<br/>
			<label for="editor2">Signature:</label>
			<textarea name="signature" id="editor2" class="input_long"><?php echo $profile->signature;?></textarea>
			<script type="text/javascript">
			//<![CDATA[

				CKEDITOR.replace( 'editor2', {
					removePlugins : 'resize',
					extraPlugins : 'bbcode',
					toolbar :
					[

					]								
				});

			//]]>
			</script>
			<br/>
			<label for="editor1">Facebook:</label>
			<input type="text" name="facebook" value="<?php echo $profile->facebook;?>" class="input_long">
			<br/>
			<label for="editor1">Twitter:</label>
			<input type="text" name="twitter" value="<?php echo $profile->twitter;?>" class="input_long">
			<br/>
			<input type="submit" value="Change Info" class="button"/>
		</form>	
			
		</div>
	</div>
	<?php endif; ?>