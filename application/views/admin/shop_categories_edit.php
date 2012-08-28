<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/shop/categories_edit/'.$id);?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Category:</th>
			<td><input type="text" value="<?php echo $shop_categories_edit->category;?>" class="inp-form-error" name="category"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th>Image:</th>
			<td>
				<a href='<?php echo base_url();?>uploads/shop/categories/<?php echo $shop_categories_edit->image;?>' rel="prettyPhoto">
					<img src='<?php echo base_url();?>uploads/shop/categories/<?php echo $shop_categories_edit->image;?>' width='300' style='height: auto;'/>
				</a>
			</td>
			<td></td>
		</tr>
		<tr>
		<th>&nbsp;</th>
		<td>
			<input type="file" value="<?php echo $shop_categories_edit->image;?>" class="file_1" name="image"/>
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