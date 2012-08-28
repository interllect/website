<h3>Welcome to our interllegence center</h3>
<p style="float: left; max-width: 400px;">
	<?php echo anchor('forum','Main Forum');?>
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

	<?php echo anchor('forum/members/','View Members');?> | <?php echo anchor('forum/arcade/','Arcade');?>  
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
	<strong>Shoutbox</strong>

		<!--[if IE]>
		<div class="container thin" style="height: 150px !important; overflow: auto;">
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
		<![endif]-->
		
		<![if !IE]>
		<iframe class="container thin" src="<?php echo base_url();?>/forum/shoutbox" height="168" width="879"></iframe>
		<![endif]>
		
		<div class="container thin">
			<?php echo form_open('forum/add_shout');?>
				<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
				<input type="hidden" name="username" value="<?php echo $username;?>">
				<input style="float: left; width: 770px !important;" type="text" name="message" class="input_long">
				<input style="float: right;" type="submit" value="Post Shout" class="button"/>
			</form>	
		</div>
	</div>
	<div class="spacer"></div>
	
		<?php if($forum_sections->num_rows() > 0):?>
				<?php foreach($forum->result() as $block): ?>
					<div class="container thin">
					<strong style="text-transform: capitalize;"><?php echo bad_words($block->block_name);?></strong>
						
						<?php if($forum_sections->num_rows() > 0):?>
							<?php foreach($forum_sections->result() as $row): ?>
								<?php if($row->block == $block->section_block):?>
									<div class="container thin">
										<span class="left">
											<strong><a href="<?php echo "forum/thread/".$row->id."/".$offset;?>"><?php echo bad_words($row->section_name);?></a></strong>
											<br/>
											<small><?php echo bad_words($row->section_description);?></small>
										</span>
										<span class="right" style="text-align: right;">
										<?php if(($role_id <= "1" )||($row->owner_id == $user_id)):?>
											<input type="submit" style="float: right;" id="<?php echo "toggle_section_".$row->id;?>" value="Edit" class="button" name="<?php echo "toggle_".$row->id;?>">
											<a href="<?php echo base_url().'forum/delete_section/'.$row->id;?>" style="float: none;" class="button" onclick="return delete_section();">Delete</a> 
											<br/>
										<?php endif;?>
										
											<?php 
											$section_id = $row->id;
											$this->db->where('section_id', $section_id);
											$this->db->from('forum_threads');
											echo "Number of threads in this section are <strong>" . $this->db->count_all_results() . "</strong>"; ?>
											
											<?php if($user_profiles->num_rows() > 0):?>
												<?php foreach($user_profiles->result() as $item): ?>
													<?php if($row->owner_id == $item->user_id):?>
														<?php $profile_id = $item->user_id; ?>
													<?php endif; ?>
												<?php endforeach; ?>
											<?php endif; ?>
											
											<?php if($row->owned_by != ""): echo "<p>owned by <a href='".base_url()."profile/view/".$profile_id."'><strong>".$row->owned_by."</strong></a></p>"; endif;?>
										</span>
									</div>
									
									<script type="text/javascript">
									//<![CDATA[
										$(document).ready(function() {
											$('#toggle_section_<?php echo $row->id;?>').click(function(){
												$('div.section_<?php echo $row->id;?>').toggle();
											});
										});
										
										function delete_section()
										{
											var answer = confirm("Delete Entire Section? (doing this will result in the loss of all threads and posts within this section)")
											if (answer){
												document.section.submit();
											}
											
											return false;  
										} 	
									//]]>
									</script>
									<div style="display: none;" class="container thin <?php echo "section_".$row->id;?>">
										<p><strong>Edit Section:</strong></p>
										<?php echo form_open('forum/edit_section/'.$row->id);?>
											<label for="editor1">Associated Block:</label>
											<select type="text" name="block" class="input_long">
											<?php if($forum->num_rows() > 0):?>
												<?php foreach($forum->result() as $block_edit_top): ?>
													<?php if($row->block == $block_edit_top->id):?>
														<option value="<?php echo $block_edit_top->id;?>"><?php echo $block_edit_top->block_name;?></option>
													<?php endif; ?> 
												<?php endforeach; ?>
												<?php foreach($forum->result() as $block_edit): ?>
													<?php if($row->block != $block_edit->id):?>
														<option value="<?php echo $block_edit->id;?>"><?php echo $block_edit->block_name;?></option>
													<?php endif; ?> 
												<?php endforeach; ?>
											<?php endif; ?> 
											</select>
											<br/>
											<label for="editor1">Owned By:</label>
											<select type="text" name="owned_by" class="input_long">
											<option value="<?php echo $row->owner_id;?>"><?php echo $row->owned_by;?></option>
											<?php if($owner->num_rows() > 0):?>
												<?php foreach($owner->result() as $owner_edit): ?>
													<?php if($row->owner_id != $owner_edit->id):?>
														<option value="<?php echo $owner_edit->id;?>"><?php echo $owner_edit->username;?></option>
													<?php endif;?>
												<?php endforeach; ?>
											<?php endif; ?> 
											</select>
											<label for="editor1">Title:</label>
											<input type="text" name="section_name" class="input_long" value="<?php echo $row->section_name;?>">
											<br/>
											<label for="editor1">Description:</label>
											<textarea cols="80" id="editor_section_<?php echo $row->id;?>" name="section_description" rows="10"><?php echo str_replace('<style>','',str_replace('<script>','',str_replace('</style>','',str_replace('</script>','',bad_words(set_value('section_description', $row->section_description))))));?></textarea>
											<script type="text/javascript">
											//<![CDATA[

												CKEDITOR.replace( 'editor_section_<?php echo $row->id;?>', {
													removePlugins : 'resize',
													extraPlugins : 'bbcode',
													extraPlugins : 'youtube',
													toolbar :
													[

														['Source'],
					
														['Cut','Copy','Paste','PasteText','PasteFromWord','-','SpellChecker', 'Scayt'],
											 
														['Undo','Redo','Find','Replace','-','SelectAll','RemoveFormat'],
												
														['Image','Flash','Youtube','Table','HorizontalRule','Smiley','SpecialChar'],
												
														['Maximize', 'ShowBlocks'],
											 
														'/',
												
														['Format'],
												
														['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
												
														['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
												
														['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiRtl','BidiLtr'],
											   
														['Link','Unlink','Anchor','LinkToNode', 'LinkToMenu'],
												
														['DrupalBreak', 'DrupalPageBreak']
													
													]							
												});

											//]]>
											</script>
											<input type="submit" value="Edit Section" class="button"/>
										</form>	
									</div>
									
								<div class="spacer"></div>
								<?php endif; ?> 	
							<?php endforeach; ?>
						<?php endif; ?> 					
						
					</div>		
					<div class="spacer"></div>
				<?php endforeach; ?>
		<?php endif; ?> 	
		
			<?php if($role_id<='1'):?>
				<div class="container thin">
					<p><strong>New Section:</strong></p>
					<?php echo $alert_msg;?>
					<?php echo form_open('forum/add_section');?>
						<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
						<input type="hidden" name="username" value="<?php echo $username;?>">
						<label for="editor1">Associated Block:</label>
						<select type="text" name="block" class="input_long">
						<?php if($forum->num_rows() > 0):?>
							<?php foreach($forum->result() as $row): ?>
								<option value="<?php echo $row->id;?>"><?php echo $row->block_name;?></option>
							<?php endforeach; ?>
						<?php endif; ?> 
						</select>
						<br/>
						<label for="editor1">Owned By:</label>
						<select type="text" name="owned_by" class="input_long">
						<?php if($owner->num_rows() > 0):?>
							<?php foreach($owner->result() as $row): ?>
								<?php if($row->role_id<='2'):?>
								<option value="<?php echo $row->id;?>"><?php echo $row->username;?></option>
								<?php endif;?>
							<?php endforeach; ?>
						<?php endif; ?> 
						</select>
						<br/>
						<label for="editor1">Title:</label>
						<input type="text" name="section_name" class="input_long">
						<br/>
						<label for="editor1">Description:</label>
						<textarea cols="80" id="editor1" name="section_description" rows="10"></textarea>
						<script type="text/javascript">
						//<![CDATA[

							CKEDITOR.replace( 'editor1', {
								removePlugins : 'resize',
								extraPlugins : 'bbcode',
								toolbar :
								[

								]								
							});

						//]]>
						</script>
						<input type="submit" value="Add Post" class="button"/>
					</form>	
				</div>
				<div class="spacer"></div>
			<?php endif;?>	
		
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