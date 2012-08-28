<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/shop/products_add/'.$category_id);?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Product Name:</th>
			<td><input type="text" value="" class="inp-form-error" name="product_name"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>	
		<tr>
			<th valign="top">Product Description:</th>
			<td>
			<textarea cols="80" class="form-textarea" id="editor1" name="product_description" rows="10"></textarea>
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
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>	
		<tr>
			<th>Image:</th>
			<td>
				<input type="file" value="" class="file_1" name="image"/>
			</td>
			<td style="padding: 0px 95px 10px;">
				<div class="bubble-left"></div>
				<div class="bubble-inner">PNG, JPEG, GIF 5MB max per image</div>
				<div class="bubble-right"></div>
			</td>
		</tr>
		<tr>
			<th valign="top">SKU Number:</th>
			<td><input type="text" value="" class="inp-form-error" name="sku_number"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>	
		<tr>
			<th valign="top">Quantity:</th>
			<td><input type="text" value="" class="inp-form-error" name="quantity"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<?php
			//formatting & standards
			$this->db->where('shop_standards_formatting.id', 1);
			$this->db->join('shop_currency', 'shop_currency.id = shop_standards_formatting.currency_standard');
			$this->db->join('shop_measurement', 'shop_measurement.id = shop_standards_formatting.measurement_standard'); 
			$f_s = $this->db->get('shop_standards_formatting');
		?>
		<tr>
			<th valign="top">Product Height (<?php foreach($f_s->result() as $item){echo $item->diameter_small;}?>):</th>
			<td><input type="text" value="" class="inp-form" name="product_height"/></td>
		</tr>	
		<tr>
			<th valign="top">Product Width (<?php foreach($f_s->result() as $item){echo $item->diameter_small;}?>):</th>
			<td><input type="text" value="" class="inp-form name="product_width"/></td>
		</tr>	
		<tr>
			<th valign="top">Product Breadth (<?php foreach($f_s->result() as $item){echo $item->diameter_small;}?>):</th>
			<td><input type="text" value="" class="inp-form" name="product_breadth"/></td>
		</tr>	
		<tr>
			<th valign="top">Product Weight (<?php foreach($f_s->result() as $item){echo $item->weight_large;}?>):</th>
			<td><input type="text" value="" class="inp-form" name="product_weight"/></td>
		</tr>	
		<tr>
			<th valign="top">Price (<?php foreach($f_s->result() as $item){echo $item->currency_name;}?>):</th>
			<td><input type="text" value="" class="inp-form-error" name="price"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>	
		<tr>
			<th valign="top">Discount Amount (<?php foreach($f_s->result() as $item){echo $item->currency_name;}?>):</th>
			<td><input type="text" value="" class="inp-form" name="discount_amount"/></td>
		</tr>	
		<tr>
			<th valign="top">Discount Rate (%):</th>
			<td><input type="text" value="" class="inp-form" name="discount_rate"/></td>
		</tr>	
		<tr>
			<th valign="top">Shipping (<?php foreach($f_s->result() as $item){echo $item->currency_name;}?>):</th>
			<td><input type="text" value="" class="inp-form" name="shipping"/></td>
		</tr>	
		<tr>
			<th valign="top">Availability:</th>
			<td>	
			<select  name="availability" class="styledselect_form_1">
				<option value='1'>Available</option> 
				<option value='0'>Not Available</option> 
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