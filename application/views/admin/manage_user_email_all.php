<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/manage_users/email_all/');?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Sending to:</th>
			<td>
				<textarea cols="80" class="form-textarea" rows="10" readonly="readonly" disabled="disabled">
					<?php foreach($users->result() as $row):?>
						<?php echo $row->email;?>
					<?php endforeach;?>
				</textarea>
			</td>
			</td>
		</tr>
		<tr>
			<th valign="top">Subject:</th>
			<td><input type="text" value="" class="inp-form-error" name="subject"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Message:</th>
			<td>
			<textarea cols="80" class="form-textarea" id="editor1" name="message" rows="10"></textarea>
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