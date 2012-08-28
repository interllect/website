	<h3>Latest News</h3>
	<script>
	//<![CDATA[
	$(document).ready(function(){
		$("#carousel1").CloudCarousel(		
			{			
				xPos: 450,
				yPos: 50,
				buttonLeft: $("#left-but"),
				buttonRight: $("#right-but"),
				altBox: $("#alt-text"),
				titleBox: $("#title-text"),
				mouseWheel: true,
				autoRotate: 'left',
				autoRotateDelay: 5000,
				bringToFront: true,
				reflHeight: 15,
				reflGap: 3,
				reflOpacity: 0.2
			}
		);
	});
	//]]>
	</script>
	<br/>
        <div id="carousel1" style="margin:0 auto; width:900px; height: 350px; background: transparent; overflow: scroll;">
		<?php if($news->num_rows() > 0):?>
			<?php foreach($news->result() as $row): ?>
				<?php if($row->video != ""): ?>
					<a href="<?php echo $row->video; ?>" rel="prettyPhoto" title="">
						<img class="cloudcarousel" src="http://i.ytimg.com/vi/<?php echo str_replace("http://www.youtube.com/watch?v=","",$row->video); ?>/0.jpg" title="<?php echo $row->title; ?>" style="width:auto;" height="217" />
					</a>
				<?php else:?>
					<a href="<?php echo base_url();?>uploads/news/<?php echo $row->image;?>" rel="prettyPhoto">
						<img class="cloudcarousel" src="<?php echo base_url();?>uploads/news/<?php echo $row->image;?>" alt="<?php echo $row->description;?>" title="<?php echo $row->title;?>" style="width:auto;" height="217" />
					</a>
				<?php endif;?>
			<?php endforeach; ?>
		<?php endif; ?> 	
        </div>
        
        <input id="left-but" class="button left" type="button" value="<" />
        <input id="right-but" class="button right" type="button" value=">" />
        
        <h3 id="title-text"></h3>
        <p id="alt-text"></p>
	</div>
	
	<div class="content_plain">

				<div class="container thin">
					<h3>Blogs</h3>
					<?php echo $pagination; ?> 
					<br/>
					<div class="container thin">
						<?php if($blogs->num_rows() > 0):?>
							<?php foreach($blogs->result() as $row): ?>
									<div class="container thin">
										<span class="left">
											<strong><a href="<?php echo "news_blogs/post/".$row->id;?>"><?php echo $row->title;?></a></strong>
											<br/>
											<p><?php echo bad_words($row->description);?></p>
										</span>
										<span class="right" style="min-width:300px !important; text-align: right;">	
										<?php if(($role_id <= "2" )||($row->user_id == $user_id)):?>
											<input type="submit" style="float: right;" id="<?php echo "toggle_blog_".$row->id;?>" value="Edit" class="button" name="<?php echo "toggle_".$row->id;?>">
											<a href="<?php echo base_url().'news_blogs/delete_blog/'.$row->id;?>" style="float: none;" class="button" onclick="return delete_blog();">Delete</a> 
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
							<?php endforeach; ?>
						<?php endif; ?> 
					</div>	
					<?php echo $pagination; ?> 
					
					<?php if($role_id <= '2'):?>
					<div class="spacer"></div>
					<div class="container thin">	
						<p><strong>New Blog:</strong></p>
						<?php echo $alert_msg;?>
						<?php echo form_open('news_blogs/add_blog');?>
							<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
							<input type="hidden" name="username" value="<?php echo $username;?>">
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
							<input type="submit" value="Add Blog" class="button"/>
						</form>		
					</div>
					<?php endif;?>
				</div>	
				<?php if($role_id=='1'):?>
					<div class="spacer"></div>
				<?php endif;?>
