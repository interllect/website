<h3>Welcome to our interllegence center</h3>
<p style="float: left; max-width: 400px;">
	<?php echo anchor('forum','Main Forum');?> 
	>
	<?php if($forum_sections->num_rows() > 0):?>
		<?php foreach($forum_sections->result() as $row): ?>
			<?php if($row->id == $this->uri->segment(3)):?>
				<?php echo anchor('forum/thread/'.$this->uri->segment(3),$row->section_name);?> 
			<?php endif; ?> 	
		<?php endforeach; ?>
	<?php endif; ?>
	> 
	<?php if($forum_threads->num_rows() > 0):?>
		<?php foreach($forum_threads->result() as $row): ?>
			<?php if(($row->section_id == $this->uri->segment(3))&&($row->id == $this->uri->segment(4))):?>
				<?php echo anchor('forum/post/'.$this->uri->segment(3).'/'.$this->uri->segment(4),$row->thread_name);?> 
			<?php endif; ?> 	
		<?php endforeach; ?>
	<?php endif; ?>
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
				
					<?php if($forum_threads->num_rows() > 0):?>
						<?php foreach($forum_threads->result() as $row): ?>
							<?php if(($row->section_id == $this->uri->segment(3))&&($row->id == $this->uri->segment(4))): $section_id = $row->section_id;?>
								<div class="container thin">
									<div class="container thin">
										<span class="left" style="min-height: 300px;">
											<strong><?php echo bad_words($row->thread_name);?></strong>
											<br/>
											<p><?php echo bad_words($row->thread_description);?></p>
										</span>
										<span class="right" style="min-width:300px !important; text-align: right;">
										<p style="font-size: 11px;">Date posted: <strong><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></strong></p>
										<br/>
										
										<?php if(($role_id <= "2" )||($row->user_id == $user_id)):?>
											<input type="submit" style="float: right;" id="<?php echo "toggle_thread_".$row->id;?>" value="Edit" class="button" name="<?php echo "toggle_".$row->id;?>">
											<a href="<?php echo base_url().'forum/delete_thread/'.$row->id;?>" style="float: none;" class="button" onclick="return delete_thread();">Delete</a> 
											<br/>
										<?php endif;?>
											
											<?php 
											$this->db->where('thread_id', $row->id);
											$data['forum_posts'] = $this->db->get('forum_posts');
											?>
											
											<?php if($user_profiles->num_rows() > 0):?>
												<?php foreach($user_profiles->result() as $item): ?>
													<?php if($row->user_id == $item->user_id):?>
														<?php 
															$profile_id_main = $item->user_id; 
															$profile_image_main = $item->image;
														?>
													<?php endif; ?>
												<?php endforeach; ?>
											<?php endif; ?>
											
											<br/>
											<?php echo "<a href='".base_url()."profile/view/".$profile_id_main."'><img src='".base_url()."uploads/user_profiles/avatars/".$profile_image_main."' style='max-height: 200px; max-width: 200px; height: auto; width: auto;' alt='avatar'/></a>";?>
											
											<br/>
											<?php 
											$this->db->where('user_id', $row->user_id);
											$this->db->from('forum_posts');
											echo "Total posts: <strong>" . $this->db->count_all_results() . "</strong>"; ?>
											
											<br/>
											<?php 
											$this->db->where('user_id', $row->user_id);
											$this->db->from('forum_threads');
											echo "Total threads started: <strong>" . $this->db->count_all_results() . "</strong>"; ?>
											
											<?php if($row->username != ""): echo "<p>posted by: <a href='".base_url()."profile/view/".$profile_id_main."'><strong>".$row->username."</a></strong></p>"; endif;?>
										</span>
										<span class="left thin" style="width: 100%;">
											<?php if($user_profiles->num_rows() > 0):?>
												<?php foreach($user_profiles->result() as $item): ?>
													<?php if($row->user_id == $item->user_id):?>
													<hr/>
													<p>Signature:</p>
													<p><?php echo bad_words($item->signature);?></p>
													<?php endif; ?>
												<?php endforeach; ?>
											<?php endif; ?>
										</span>
									</div>
									
									<script type="text/javascript">
									//<![CDATA[
										$(document).ready(function() {
											$('#toggle_thread_<?php echo $row->id;?>').click(function(){
												$('div.thread_<?php echo $row->id;?>').toggle();
											});
										});
										
										function delete_thread()
										{
											var answer = confirm("Delete Entire Thread? (doing this will result in the loss of all posts within this thread)")
											if (answer){
												document.thread.submit();
											}
											
											return false;  
										} 	
									//]]>
									</script>
									<div style="display: none;" class="container thin <?php echo "thread_".$row->id;?>">
										<p><strong>Edit Thread:</strong></p>
										<?php echo form_open('forum/edit_thread/'.$row->section_id."/".$row->id);?>
											<input type="hidden" name="section_id" value="<?php echo $row->section_id;?>">
											<input type="hidden" name="user_id" value="<?php echo $row->user_id;?>">
											<input type="hidden" name="username" value="<?php echo $row->username;?>">
											<label for="editor1">Title:</label>
											<input type="text" name="thread_name" class="input_long" value="<?php echo $row->thread_name;?>">
											<br/>
											<label for="editor1">Description:</label>
											<textarea cols="80" id="editor_thread_<?php echo $row->id;?>" name="thread_description" rows="10"><?php echo str_replace('<style>','',str_replace('<script>','',str_replace('</style>','',str_replace('</script>','',bad_words(set_value('thread_description', $row->thread_description))))));?></textarea>
											<script type="text/javascript">
											//<![CDATA[

												CKEDITOR.replace( 'editor_thread_<?php echo $row->id;?>', {
													removePlugins : 'resize',
													extraPlugins : 'bbcode',
													extraPlugins : 'youtube',
													toolbar :
													[

														<?php if($role_id <= "2" ): ?>['Source'],<?php endif;?>
					
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
											<input type="submit" value="Edit Post" class="button"/>
										</form>	
									</div>
									
								</div>
							<div class="spacer"></div>
							<?php elseif(($row->section_id == "")||($row->id == "")): 
							redirect('/forum');?>
							
							<?php endif; ?> 	
						<?php endforeach; ?>
					<?php endif; ?>
					
 					<?php echo $pagination; ?> 
					<br/>
					<?php if($forum_posts->num_rows() > 0):?>
						<?php foreach($forum_posts->result() as $row): ?>
							<?php if($row->thread_id == $this->uri->segment(4)):?>
								<div class="container thin">
									<span class="left" style="min-height: 300px;">
										<?php if($row->post_name != ""):?>
										<strong><?php echo bad_words($row->post_name);?></strong>
										<br/>
										<?php endif; ?> 
										<p><?php echo bad_words($row->post_description);?></p>
									</span>
									<span class="right" style="min-width:300px !important; text-align: right;">
									<p style="font-size: 11px;">Date posted: <strong><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></strong></p>
									<br/>
									
									<?php if(($role_id <= "2" )||($row->user_id == $user_id)):?>
										<input type="submit" style="float: right;" id="<?php echo "toggle_post_".$row->id;?>" value="Edit" class="button" name="<?php echo "toggle_".$row->id;?>">
										<a href="<?php echo base_url().'forum/delete_post/'.$row->id;?>" style="float: none;" class="button" onclick="return delete_post();">Delete</a> 
										<br/>
									<?php endif;?>
										
										<?php if($user_profiles->num_rows() > 0):?>
											<?php foreach($user_profiles->result() as $item): ?>
												<?php if($row->user_id == $item->user_id):?>
													<?php 
														$profile_id = $item->user_id; 
														$profile_image = $item->image;
													?>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
										
										<br/>
										<?php echo "<a href='".base_url()."profile/view/".$profile_id."'><img src='".base_url()."uploads/user_profiles/avatars/".$profile_image."' style='max-height: 200px; max-width: 200px; height: auto; width: auto;' alt='avatar'></img></a>";?>
										
										<br/>
										<?php 
										$this->db->where('user_id', $row->user_id);
										$this->db->from('forum_posts');
										echo "Total posts: <strong>" . $this->db->count_all_results() . "</strong>"; ?>
										
										<br/>
										<?php 
										$this->db->where('user_id', $row->user_id);
										$this->db->from('forum_threads');
										echo "Total threads started: <strong>" . $this->db->count_all_results() . "</strong>"; ?>
										
										<?php if($row->username != ""): echo "<p>posted by: <a href='".base_url()."profile/view/".$profile_id."'><strong>".$row->username."</a></strong></p>"; endif;?>
									</span>
									<span class="left thin" style="width: 100%;">
										<?php if($user_profiles->num_rows() > 0):?>
											<?php foreach($user_profiles->result() as $item): ?>
												<?php if($row->user_id == $item->user_id):?>
												<hr/>
												<p>Signature:</p>
												<p><?php echo bad_words($item->signature);?></p>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
									</span>
								</div>
								
								<script type="text/javascript">
								//<![CDATA[
									$(document).ready(function() {
										$('#toggle_post_<?php echo $row->id;?>').click(function(){
											$('div.post_<?php echo $row->id;?>').toggle();
										});
									});
									
									function delete_post()
										{
											var answer = confirm("Delete This Post?")
											if (answer){
												document.post.submit();
											}
											
											return false;  
										} 	
								//]]>
								</script>
								<div style="display: none;" class="container thin <?php echo "post_".$row->id;?>">
									<p><strong>Edit Post:</strong></p>
									<?php echo form_open('forum/edit_post/'.$section_id.'/'.$row->thread_id.'/'.$row->id);?>
										<input type="hidden" name="section_id" value="<?php echo $this->uri->segment(3);?>">
										<input type="hidden" name="thread_id" value="<?php echo $row->thread_id;?>">
										<input type="hidden" name="user_id" value="<?php echo $row->user_id;?>">
										<input type="hidden" name="username" value="<?php echo $row->username;?>">
										<label for="editor1">Title:</label>
										<input type="text" name="post_name" class="input_long" value="<?php echo $row->post_name;?>">
										<br/>
										<label for="editor1">Description:</label>
										<textarea cols="80" id="editor_post_<?php echo $row->id;?>" name="post_description" rows="10"><?php echo str_replace('<style>','',str_replace('<script>','',str_replace('</style>','',str_replace('</script>','',bad_words(set_value('post_description', $row->post_description))))));?></textarea>
										<script type="text/javascript">
										//<![CDATA[

											CKEDITOR.replace( 'editor_post_<?php echo $row->id;?>', {
												removePlugins : 'resize',
												extraPlugins : 'bbcode',
												extraPlugins : 'youtube',
												toolbar :
												[

													<?php if($role_id <= "2" ): ?>['Source'],<?php endif;?>
				
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
										<input type="submit" value="Edit Post" class="button"/>
									</form>	
								</div>
								
							<div class="spacer"></div>
							<?php endif; ?> 	
						<?php endforeach; ?>
					<?php endif; ?> 					
					<?php echo $pagination; ?> 
					
					<p><strong>Quik Reply:</strong></p>
					<?php echo $alert_msg;?>
					<?php echo form_open('forum/add_post');?>
						<input type="hidden" name="section_id" value="<?php echo $this->uri->segment(3);?>">
						<input type="hidden" name="thread_id" value="<?php echo $this->uri->segment(4);?>">
						<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
						<input type="hidden" name="username" value="<?php echo $username;?>">
						<label for="editor1">Title:</label>
						<input type="text" name="post_name" class="input_long">
						<br/>
						<label for="editor1">Description:</label>
						<textarea cols="80" id="editor1" name="post_description" rows="10"><?php echo str_replace('<style>','',str_replace('<script>','',str_replace('</style>','',str_replace('</script>','',bad_words(set_value('post_description'))))));?></textarea>
						<script type="text/javascript">
						//<![CDATA[

							CKEDITOR.replace( 'editor1', {
								removePlugins : 'resize',
								extraPlugins : 'bbcode',
								extraPlugins : 'youtube',
								toolbar :
								[

									<?php if($role_id <= "2" ): ?>['Source'],<?php endif;?>
    
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
						<input type="submit" value="Add Post" class="button"/>
					</form>	
		
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
		</p>  
	</div>

