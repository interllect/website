<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/lists/items_edit/'.$id."/".$group_id);?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top"><?php echo $list_group_titles->option_1_header;?>:</th>
			<td><input type="text" value="<?php echo $list_items_edit->option_1;?>" class="inp-form-error" name="option_1"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top"><?php echo $list_group_titles->option_2_header;?>:</th>
			<td><input type="text" value="<?php echo $list_items_edit->option_2;?>" class="inp-form" name="option_2"/></td>
		</tr>
		<tr>
			<th valign="top">Link:</th>
			<td><input type="text" value="<?php echo $list_items_edit->link;?>" class="inp-form" name="link"/></td>
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