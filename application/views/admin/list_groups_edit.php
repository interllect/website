<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/lists/groups_edit/'.$id);?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">List Title:</th>
			<td><input type="text" value="<?php echo $list_groups_edit->list_title;?>" class="inp-form-error" name="list_title"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">List Header 1:</th>
			<td><input type="text" value="<?php echo $list_groups_edit->option_1_header;?>" class="inp-form-error" name="option_1_header"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">List Header 2:</th>
			<td><input type="text" value="<?php echo $list_groups_edit->option_2_header;?>" class="inp-form" name="option_2_header"/></td>
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