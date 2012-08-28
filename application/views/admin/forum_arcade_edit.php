<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/forum/arcade_edit/'.$id);?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Title:</th>
			<td><input type="text" value="<?php echo $arcade_edit->title;?>" class="inp-form-error" name="title"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Description:</th>
			<td>
			<textarea cols="80" class="form-textarea" id="editor1" name="description" rows="10"><?php echo $arcade_edit->description;?></textarea>
			<script type="text/javascript">
			//<![CDATA[

				CKEDITOR.replace( 'editor1', {
					removePlugins : 'resize',
					toolbar :
					[

					]								
				});

			//]]>
			</script>
			</td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Genre:</th>
			<td><input type="text" value="<?php echo $arcade_edit->genre;?>" class="inp-form-error" name="genre"></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th>Game:</th>
			<td>
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="325" height="225" id="game_<?php echo $arcade_edit->id;?>" align="middle">
					<param name="movie" value="<?php echo base_url();?>uploads/games/<?php echo $arcade_edit->game;?>" />
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
					<object type="application/x-shockwave-flash" data="<?php echo base_url();?>uploads/games/<?php echo $arcade_edit->game;?>" width="325" height="225">
					  <param name="movie" value="<?php echo base_url();?>uploads/games/<?php echo $arcade_edit->game;?>" />
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
			</td>
			<td></td>
		</tr>
		<tr>
		<th>&nbsp;</th>
		<td>
			<input type="file" value="<?php echo $arcade_edit->game;?>" class="file_1" name="game"/>
		</td>
		<td style="padding: 0px 95px 10px;">
			<div class="bubble-left"></div>
			<div class="bubble-inner">SWF 5MB max per flash game</div>
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