<?php
// read the post from PayPal system and add 'cmd'
$req = 'cmd=' . urlencode('_notify-validate');
 
foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.paypal.com/cgi-bin/webscr');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www.paypal.com'));
$res = curl_exec($ch);
curl_close($ch);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$mc_gross = $_POST['amount'];
$quantity = $_POST['quantity'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['business'];
 
if (strcmp ($res, "VERIFIED") == 0) {
	// check the payment_status is Completed
	// check that txn_id has not been previously processed
	// check that receiver_email is your Primary PayPal email
	// check that payment_amount/payment_currency are correct
	// process payment
}
else if (strcmp ($res, "INVALID") == 0) {
	// log for manual investigation
}
?>

<?php 
	$this->db->where('id', '1');
	$settings = $this->db->get('settings')->row();
?>

<h3>My Shopping Basket</h3>
<table>
<tr>
	<th>Product Image</th>
	<th>Poduct Details</th>
	<th>Actions</th>
</tr>
<?php if($basket_products->num_rows() > 0):?>
	<?php foreach($basket_products->result() as $row): ?>
		<?php if($row->user_id == $user_id):?>
			<tr>
				<td>
				<a href="<?php echo base_url(); ?>/uploads/shop/products/<?php echo $row->image; ?>" rel="prettyPhoto[gallery1]">
					<img src="<?php echo base_url();?>uploads/shop/products/<?php echo $row->image; ?>" width="200" style="height: auto;" />
				</a>
				<br/>
				</td>
				<td>
				<h3><?php echo $row->product_name; ?></h3>
				<p><strong>Description:</strong> <br /><?php echo $row->product_description; ?></p>
				<br/>
				<?php
					//formatting & standards
					$this->db->where('shop_standards_formatting.id', 1);
					$this->db->join('shop_currency', 'shop_currency.id = shop_standards_formatting.currency_standard');
					$this->db->join('shop_measurement', 'shop_measurement.id = shop_standards_formatting.measurement_standard'); 
					$f_s = $this->db->get('shop_standards_formatting');
				?>
				<p><strong>Price(<?php foreach($f_s->result() as $item){echo $item->currency_name;}?>):</strong> <?php foreach($f_s->result() as $item){echo $item->html;}?><?php echo $row->price; ?></p>
				<p><strong>Discount (%):</strong> -<?php echo $row->discount_rate; ?>%</p>
				<p><strong>Discount Amount:</strong> -<?php foreach($f_s->result() as $item){echo $item->html;}?><?php echo $row->discount_amount; ?></p>
				<p><strong>Height:</strong> <?php echo $row->product_height; ?><?php foreach($f_s->result() as $item){echo $item->diameter_small;}?> 
				X 
				<strong>Width:</strong> <?php echo $row->product_width; ?><?php foreach($f_s->result() as $item){echo $item->diameter_small;}?> 
				X 
				<strong>Breadth:</strong> <?php echo $row->product_breadth; ?><?php foreach($f_s->result() as $item){echo $item->diameter_small;}?></p>
				<p><strong>Weight(<?php foreach($f_s->result() as $item){echo $item->weight_large;}?>):</strong> <?php echo $row->product_weight; ?><?php foreach($f_s->result() as $item){echo $item->weight_large;}?></p>
				<p><strong>SKU:</strong> <?php echo $row->sku_number; ?></p>
				<p><strong>Shipping Fee:</strong> -<?php foreach($f_s->result() as $item){echo $item->html;}?><?php echo $row->shipping; ?>%</p>
				<p><strong>Date added:</strong> <span style="font-size: 11px;"><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></span></p>
				</td>
				<td>
				<?php if($row->transaction_type == "1"):?>
					<?php if($row->availability == "1"):?>
						<?php if($row->quantity != "0"):?>
						<!--
						<form name="_xclick" target="paypal" action="https://www.paypal.com" method="post">
							<input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="business" value="bad_man_234@hotmail.com">
							<input type="hidden" name="currency_code" value="USD">
							<input type="hidden" name="item_name" value="HTML book">
							<input type="hidden" name="amount" value="24.99">
							<input type="image" src="http://www.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
							<input type="hidden" name="add" value="1">
						</form>
						
						<form name="_xclick" target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="business" value="bad_man_234@hotmail.com">
							<input type="hidden" name="currency_code" value="USD">
							<input type="hidden" name="item_name" value="HTML book">
							<input type="hidden" name="amount" value="24.99">
							<input type="image" src="https://www.paypal.com/en_US/i/btn/view_cart_new.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
							<input type="hidden" name="display" value="1">
						</form>-->
						
							<form name="_xclick" target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
								<input type="hidden" name="cmd" value="_xclick">
								<input type="hidden" name="business" value="<?php echo $settings->paypal_email;?>">
								<input type="hidden" name="item_name" value="<?php echo $row->product_name; ?>">
								<input type="hidden" name="item_number" value="<?php echo $row->sku_number; ?>">
								<input type="hidden" name="amount" value="<?php echo $row->price; ?>">
								<input type="hidden" name="discount_amount" value="<?php echo $row->discount_amount; ?>">
								<input type="hidden" name="discount_rate" value="<?php echo $row->discount_rate; ?>">
								<input type="hidden" name="shipping" value="<?php echo $row->shipping; ?>">
								<label><strong>Qty:</strong></label>
								<select name="quantity">
									<?php
										$max = $row->quantity;
										$i=0;
										do
										{
											$i++;
											echo "<option value='". $i ."'> " . $i . "</option>";
										}
										while ($i<$max);
									?>
								</select> 
								<input type="hidden" name="currency_code" value="<?php foreach($f_s->result() as $item){echo $item->currency_name;}?>">
								<input type="hidden" name="return" value="<?php echo base_url();?>shop/success">
								<input type="hidden" name="cancel_return" value="<?php echo base_url();?>shop/cancelled">
								<br/>
								<input type="submit" value="Buy Now" class="button" name="submit">
							</form>
						<?php else: ?> 	
							<strong>None in Stock!</strong>
							<br />
						<?php endif; ?> 
					<?php else: ?> 	
						<strong>None Available</strong>
						<br />
					<?php endif; ?> 
						<a class="button" style="padding: 1px 5px;" href="<?php echo base_url(); ?>shop/remove_from_basket/<?php echo $row->category_id; ?>/<?php echo $row->product_id; ?>">Remove</a>
						<br/>
				<?php elseif($row->transaction_type == "2"): ?>
					<strong>You have purchased this item</strong>
					<br />
				<?php endif; ?> 
					<script type="text/javascript">
						function myPopup2() {
							window.open( "<?php echo base_url(); ?>shop/comment/<?php echo $row->category_id; ?>/<?php echo $row->product_id; ?>", "Product Review - <?php echo $row->product_name; ?>", "status = 1, height = 750, width = 700, resizable = 0" )
						}
					</script>
					<a onClick="myPopup2()" class="button" style="padding: 1px 5px; cursor: pointer;" >Make a review</a>
				</td>
			</tr>
		<?php else: ?>
		
		<span>You have no items in your basket, please go to the <strong><a href="<?php echo base_url(); ?>shop/">shop</a></strong> and add some :)</span>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
</table>
</div>
<div class="content_plain">