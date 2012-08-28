<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/media_center/media_edit/'.$id);?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Title:</th>
			<td><input type="text" value="<?php echo $media_edit->title;?>" class="inp-form-error" name="title"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Description:</th>
			<td><input type="text" value="<?php echo $media_edit->description;?>" class="inp-form-error" name="description"></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th>Media:</th>
			<td>
				<?php if($media_edit->image != ""): ?>
				<div style="margin: 10px; width: 200px !important; height: 200px !important; overflow: hidden;">
					<div style="margin: 5px 10px; display: inline-block;">
						<div style="max-height: 200px !important; max-width: 200px !important; height: 200px !important; width: 200px !important; text-align: center; display: table-cell; vertical-align: middle; background: silver;">
							<a href="<?php echo base_url(); ?>/uploads/media/<?php echo $media_edit->image; ?>" rel="prettyPhoto">
								<img src="<?php echo base_url(); ?>/uploads/media/<?php echo $media_edit->image; ?>" alt="<?php echo $media_edit->title; ?>" style="width: auto; max-width: 200px; height:auto; max-height: 200px;" />
							</a>
						</div>
					</div>
				</div>
				<?php endif;?>
				
				<?php if($media_edit->audio != ""): ?>
				<div style="margin: 10px; width: 200px !important;">
					<script type="text/javascript">
						AudioPlayer.setup("<?=base_url();?>assets/js/player.swf", {
							width: 200,
							transparentpagebg: "yes", 
							pagebg: "no"
						});
					</script>
					<p><strong><?php echo $media_edit->audio; ?></strong></p>
					<p id="audioplayer_<?php echo $media_edit->id; ?>">
						<embed type="application/x-shockwave-flash" flashvars="audioUrl=<?php echo base_url(); ?>/uploads/media/<?php echo $media_edit->audio; ?>" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="200" height="27" quality="best"></embed>
					</p>
					<script type="text/javascript">
					AudioPlayer.embed("audioplayer_<?php echo $media_edit->id; ?>", {
						soundFile: "<?php echo base_url(); ?>/uploads/media/<?php echo $media_edit->audio; ?>",
						titles: "<?php echo str_replace('.mp3','',str_replace('_',' ',$media_edit->audio)); ?>"/*,
						artists: "<?php echo $artists; ?>"  */
					});
					</script>
					<br/>
				</div>	
				<?php endif;?>
			</td>
			<td></td>
		</tr>
		<tr>
		<th>&nbsp;</th>
		<td>
			<input type="file" value="" class="file_1" name="media"/>
		</td>
		<td style="padding: 0px 95px 10px;">
			<div class="bubble-left"></div>
			<div class="bubble-inner">PNG, JPEG, GIF or MP3 10MB max per media type</div>
			<div class="bubble-right"></div>
		</td>
		<tr>
			<th valign="top">Video:</th>
			<td>
				<?php if($media_edit->video != ""): ?>
				<div class="rounded"  style="margin: 10px; width: 200px !important; height: 200px !important; background: black !important;">
					<a href="<?php echo $media_edit->video; ?>" rel="prettyPhoto" title=""><img src="http://i.ytimg.com/vi/<?php echo str_replace("http://www.youtube.com/watch?v=","",$media_edit->video); ?>/default.jpg" alt="<?php echo $media_edit->title; ?>" style="height:auto;" width="200" /></a>
					<br/>
					<span style="text-indent: 15px">
						<p><strong><?php echo $media_edit->title; ?></strong></p>
						<p><?php echo $media_edit->description; ?></p>
					</span>
				</div>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th valign="top">&nbsp;</th>
			<td><input type="text" value="<?php echo $media_edit->video;?>" class="inp-form" name="video"></td>
			<td style="padding: 0px 95px 10px;">
				<div class="bubble-left"></div>
				<div class="bubble-inner">Youtube videos only</div>
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