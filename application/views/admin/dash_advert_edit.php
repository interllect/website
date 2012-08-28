<script type="text/javascript">
function reloadPage()
  {
	window.location.reload()
  }
</script>

<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/dashboard/advert_edit/'.$id);?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Link:</th>
			<td><input type="text" value="<?php echo $advert_edit->advert_link;?>" class="inp-form-error" name="advert_link"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th>Image:</th>
			<td>
				<a href='<?php echo base_url();?>uploads/corner_advert/large.jpg' rel="prettyPhoto">
					<img src='<?php echo base_url();?>uploads/corner_advert/large.jpg' width='300' style='height: auto;'/>
				</a>
			</td>
			<td></td>
		</tr>
		<tr>
		<th>&nbsp;</th>
		<td>
			<input type="file" value="<?php echo $advert_edit->image;?>" class="file_1" name="image"/>
		</td>
		<td style="padding: 0px 95px 10px;">
			<div class="bubble-left"></div>
			<div class="bubble-inner">JPEG 5MB max per image</div>
			<div class="bubble-right"></div>
		</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td valign="top">
				<input type="submit" value="" class="form-submit" onclick="reloadPage()"/>
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