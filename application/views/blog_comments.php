		

		<?php if($blogs->num_rows() > 0):?>
			<?php foreach($blogs->result() as $row): ?>
				<?php if($row->id == $this->uri->segment(3)): ?>
					<h3>Viewing Blog: <?php echo $row->title;?></h3>
						<div class="container thin">
							<div class="container thin">
								<span class="left">
									<strong><?php echo $row->title;?></strong>
									<br/>
									<p><?php echo $row->description;?></p>
								</span>
								<span class="right" style="min-width:300px !important; text-align: right;">
								<p style="font-size: 11px;">Date posted: <strong><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></strong></p>
								<br/>
								
								<?php if(($role_id <= "2" )||($row->user_id == $user_id)):?>
									<input type="submit" style="float: right;" id="<?php echo "toggle_blog_".$row->id;?>" value="Edit" class="button" name="<?php echo "toggle_".$row->id;?>">
									<a href="<?php echo base_url().'news_blogs/delete_blog/'.$row->id;?>" style="float: none;" class="button" onclick="return delete_blog();">Delete</a> 
									<br/>
								<?php endif;?>
								
									<?php 
									$this->db->where('blog_id', $row->id);
									$data['blog_comments'] = $this->db->get('blog_comments');
									?>
								
											<?php if($user_profiles->num_rows() > 0):?>
												<?php foreach($user_profiles->result() as $item): ?>
													<?php if($row->user_id == $item->user_id):?>
														<?php 
															$profile_id = $item->user_id;
														?>
													<?php endif; ?>
												<?php endforeach; ?>
											<?php endif; ?>
											
									<?php if($row->username != ""): echo "<p>posted by: <a href='".base_url()."profile/view/".$profile_id."'><strong>".$row->username."</a></strong></p>"; endif;?>
								</span>
							</div>
						</div>
					
						<script type="text/javascript">
						//<![CDATA[
							$(document).ready(function() {
								$('#toggle_blog_<?php echo $row->id;?>').click(function(){
									$('div.blog_<?php echo $row->id;?>').toggle();
								});
							});
										
							function delete_blog()
							{
								var answer = confirm("Delete Entire Blog? (doing this will result in the loss of all posts within this blog)")
								if (answer){
									document.blog.submit();
								}
											
								return false;  
							} 	
						//]]>
						</script>
						<div style="display: none;" class="container thin <?php echo "blog_".$row->id;?>">
							<p><strong>Edit Blogs:</strong></p>
							<?php echo form_open('news_blogs/edit_blog/'.$row->id);?>
								<input type="hidden" name="id" value="<?php echo $row->id;?>">
								<input type="hidden" name="user_id" value="<?php echo $row->user_id;?>">
								<input type="hidden" name="username" value="<?php echo $row->username;?>">
								<label for="editor1">Title:</label>
								<input type="text" name="title" class="input_long" value="<?php echo $row->title;?>">
								<br/>
								<label for="editor1">Description:</label>
								<textarea cols="80" id="editor_blog_<?php echo $row->id;?>" name="description" rows="10"><?php echo str_replace('<style>','',str_replace('<script>','',str_replace('</style>','',str_replace('</script>','',bad_words(set_value('description', $row->description))))));?></textarea>
								<script type="text/javascript">
								//<![CDATA[

									CKEDITOR.replace( 'editor_blog_<?php echo $row->id;?>', {
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
								<input type="submit" value="Edit Blog" class="button"/>
							</form>	
						</div>
				<div class="spacer"></div>
				<?php elseif($row->id == ""): 
				redirect('/news_blogs');?>
							
				<?php endif; ?> 
			<?php endforeach; ?>
		<?php endif; ?> 	
		
		
		<h3>Blog's Comments</h3>
		<?php echo $pagination; ?> 
		<br/>
		<?php if($blog_comments->num_rows() > 0):?>
			<?php foreach($blog_comments->result() as $row): ?>
				<?php if($row->blog_id == $this->uri->segment(3)):?>
					<div class="container thin">
						<span class="left">
							<?php if($row->title != ""):?>
							<strong><?php echo $row->title;?></strong>
							<br/>
							<?php endif; ?> 
							<p><?php echo bad_words($row->description);?></p>
						</span>
						<span class="right" style="text-align: right;">	
						<?php if(($role_id <= "2" )||($row->user_id == $user_id)):?>
							<input type="submit" style="float: right;" id="<?php echo "toggle_post_".$row->id;?>" value="Edit" class="button" name="<?php echo "toggle_".$row->id;?>">
							<a href="<?php echo base_url().'news_blogs/delete_post/'.$row->blog_id.'/'.$row->id;?>" style="float: none;" class="button" onclick="return delete_post();">Delete</a> 
							<br/>
						<?php endif;?>
										
										<?php if($user_profiles->num_rows() > 0):?>
											<?php foreach($user_profiles->result() as $item): ?>
												<?php if($row->user_id == $item->user_id):?>
													<?php 
														$profile_id = $item->user_id;
													?>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
										
							<p style="font-size: 11px;"><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></p>
							<?php if($row->username != ""): echo "<p>posted by: <a href='".base_url()."profile/view/".$profile_id."'><strong>".$row->username."</a></strong></p>"; endif;?>
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
						<?php echo form_open('news_blogs/edit_post/'.$row->id);?>
							<input type="hidden" name="user_id" value="<?php echo $row->user_id;?>">
							<input type="hidden" name="username" value="<?php echo $row->username;?>">
							<label for="editor1">Title:</label>
							<input type="text" name="title" class="input_long" value="<?php echo $row->title;?>">
							<br/>
							<label for="editor1">Description:</label>
							<textarea cols="80" id="editor_post_<?php echo $row->id;?>" name="description" rows="10"><?php echo str_replace('<style>','',str_replace('<script>','',str_replace('</style>','',str_replace('</script>','',bad_words(set_value('description', $row->description))))));?></textarea>
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
		<div class="spacer"></div>
					
		<div class="container thin">	
			<p><strong>Quick Reply:</strong></p>
			<?php echo $alert_msg;?>
			<?php echo form_open('news_blogs/add_post');?>
				<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
				<input type="hidden" name="username" value="<?php echo $username;?>">
				<input type="hidden" name="blog_id" value="<?php echo $blog_id;?>">
				<label for="editor1">Title:</label>
				<input type="text" name="title" class="input_long">
				<br/>
				<label for="editor1">Description:</label>
				<textarea cols="80" id="editor1" name="description" rows="10"><?php echo str_replace('<style>','',str_replace('<script>','',str_replace('</style>','',str_replace('</script>','',bad_words(set_value('description'))))));?></textarea>
				<script type="text/javascript">
				//<![CDATA[
					CKEDITOR.replace( 'editor1', {
						removePlugins : 'resize',
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


