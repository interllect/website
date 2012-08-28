<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/news/news_edit/'.$id);?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Title:</th>
			<td><input type="text" value="<?php echo $news_edit->title;?>" class="inp-form-error" name="title"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Description:</th>
			<td>
			<textarea cols="80" class="form-textarea" id="editor1" name="description" rows="10"><?php echo $news_edit->description;?></textarea>
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
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Video:</th>
			<td>
				<?php if($news_edit->video != ""): ?>
				<div class="rounded"  style="overflow: hidden; margin: 10px; width: 200px !important; height: 200px !important; background: black !important;">
					<a href="<?php echo $news_edit->video; ?>" rel="prettyPhoto" title=""><img src="http://i.ytimg.com/vi/<?php echo str_replace("http://www.youtube.com/watch?v=","",$news_edit->video); ?>/default.jpg" alt="<?php echo $news_edit->title; ?>" style="height:auto;" width="200" /></a>
					<br/>
					<span style="text-indent: 15px;">
						<p><strong><?php echo $news_edit->title; ?></strong></p>
						<p><?php echo $news_edit->description; ?></p>
					</span>
				</div>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th valign="top">&nbsp;</th>
			<td><input type="text" value="<?php echo $news_edit->video;?>" class="inp-form" name="video"></td>
			<td style="padding: 0px 95px 10px;">
				<div class="bubble-left"></div>
				<div class="bubble-inner">Youtube videos only</div>
				<div class="bubble-right"></div>
			</td>
		</tr>
		<tr>
			<th>Image:</th>
			<td>
				<a href='<?php echo base_url();?>uploads/news/<?php echo $news_edit->image;?>' rel="prettyPhoto">
					<img src='<?php echo base_url();?>uploads/news/<?php echo $news_edit->image;?>' width='300' style='height: auto;'/>
				</a>
			</td>
			<td></td>
		</tr>
		<tr>
		<th>&nbsp;</th>
		<td>
			<input type="file" value="<?php echo $news_edit->image;?>" class="file_1" name="image"/>
		</td>
		<td style="padding: 0px 95px 10px;">
			<div class="bubble-left"></div>
			<div class="bubble-inner">PNG, JPEG, GIF 5MB max per image</div>
			<div class="bubble-right"></div>
		</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td valign="top">
				<input type="submit" value="" class="form-submit" />
				<!-- <input type="reset" value="" class="form-reset"  /> -->
			</td>
			<td></td>
		</tr>
	</table>
	</form>
	<!-- end id-form  -->

	</td>

</tr>
<tr>
<td><img src="<?=base_url();?>assets/admin/images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>