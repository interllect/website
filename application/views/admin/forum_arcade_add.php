<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/forum/arcade_add');?>
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
			<td>
			<textarea cols="80" class="form-textarea" id="editor1" name="description" rows="10"></textarea>
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
			<td><input type="text" value="" class="inp-form-error" name="genre"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th>Game:</th>
		<td>
			<input type="file" value="" class="file_1" name="game"/>
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