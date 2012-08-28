<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/shop/standards_formatting_edit/'.$id);?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Currency Name:</th>
			<td>	
			<select  name="currency_standard" class="styledselect_form_1">
				<option value='<?php echo $shop_standards_formatting_edit->id;?>'><?php echo $shop_standards_formatting_edit->currency_name;?></option>
				<?php foreach($shop_currency->result() as $row1):
					echo "<option value='".$row1->id."'>".$row1->currency_name."</option>";  
				endforeach;?>
			</select>
			</td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Measurement Name:</th>
			<td>	
			<select  name="measurement_standard" class="styledselect_form_1">
				<option value='<?php echo $shop_standards_formatting_edit->id;?>'><?php echo $shop_standards_formatting_edit->measurement_name;?></option>
				<?php foreach($shop_measurement->result() as $row2):
					echo "<option value='".$row2->id."'>".$row2->measurement_name."</option>";  
				endforeach;?>
			</select>
			</td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
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