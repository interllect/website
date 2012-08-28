<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/media_center/media_add/');?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Title:</th>
			<td><input type="text" value="" class="inp-form-error" name="title"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Description:</th>
			<td><input type="text" value="" class="inp-form-error" name="description"></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th>Media:</th>
			<td><input type="file" value="" class="file_1" name="media"/></td>
			<td style="padding: 0px 95px 10px;">
				<div class="bubble-left"></div>
				<div class="bubble-inner">PNG, JPEG, GIF or MP3 10MB max per media type</div>
				<div class="bubble-right"></div>
			</td>
		</tr>
		<tr>
			<th valign="top">Video</th>
			<td><input type="text" value="" class="inp-form" name="video"></td>
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