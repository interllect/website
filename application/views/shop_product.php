<h3>Product</h3>

<p>
	<?php echo anchor('shop','All Categories');?>
	>
	<?php if($shop_categories->num_rows() > 0):?>
		<?php foreach($shop_categories->result() as $row): ?>
			<?php if($row->id == $this->uri->segment(3)):?>
				<?php echo anchor('shop/category/'.$this->uri->segment(3),$row->category);?> 
			<?php endif; ?> 	
		<?php endforeach; ?>
	<?php endif; ?>
	> 
	<?php if($shop_products->num_rows() > 0):?>
		<?php foreach($shop_products->result() as $row): ?>
			<?php if(($row->category_id == $this->uri->segment(3))&&($row->id == $this->uri->segment(4))):?>
				<?php echo anchor('shop/product/'.$this->uri->segment(3).'/'.$this->uri->segment(4),$row->product_name);?> 
			<?php endif; ?> 	
		<?php endforeach; ?>
	<?php endif; ?>
</p>
<br/>

<table>
<tr>
	<th>Product Image</th>
	<th>Poduct Details</th>
	<th>Actions</th>
</tr>

<?php if($shop_products->num_rows() > 0):?>
	<?php foreach($shop_products->result() as $row): ?>
		<?php if(($row->category_id == $category_id)&&($row->id == $product_id)):?>
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
				<?php error_reporting(0); if($basket->num_rows() > 0):?>
					<?php foreach($basket->result() as $item): ?>
						<?php if(($item->user_id == $user_id)||($item->product_id == $product_id)):?>
							<strong>Already In basket</strong>
							<?php $button_style = 'display: none;'; ?>
						<?php else: ?>
							<?php $button_style = ''; ?>
						<?php endif;?>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<span style="<?php echo $button_style; ?>">
				<a class="button" style="padding: 1px 5px;" href="<?php echo base_url(); ?>shop/add_to_basket/<?php echo $row->category_id; ?>/<?php echo $row->id; ?>">Add to basket</a>
				</span>
				<br/>
					<script type="text/javascript">
						function myPopup2() {
							window.open( "<?php echo base_url(); ?>shop/comment/<?php echo $row->category_id; ?>/<?php echo $row->id; ?>", "Product Review - <?php echo $row->product_name; ?>", "status = 1, height = 750, width = 700, resizable = 0" )
						}
					</script>
					<a onClick="myPopup2()" class="button" style="padding: 1px 5px; cursor: pointer;" >Make a review</a>
				</td>
			</tr>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
</table>
</div>
<div class="content_plain">