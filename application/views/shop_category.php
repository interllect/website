<h3>Category</h3>
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
</p>
<br/>

<p>Please select one of the provided "products" of your selected "category" listed below:</p>
<?php if($shop_products->num_rows() > 0):?>
	<?php foreach($shop_products->result() as $row): ?>
			<div style="margin: 5px 10px; width: 200px !important; height: 300px !important; overflow: hidden; display: inline-block;">
				<div style="margin: 0px;">
					<div style="max-height: 200px !important; max-width: 200px !important; height: 200px !important; width: 200px !important; text-align: center; display: table-cell; vertical-align: middle; background: silver;">
						<a href="<?php echo base_url(); ?>shop/product/<?php echo $row->category_id; ?>/<?php echo $row->id; ?>">
							<img src="<?php echo base_url(); ?>uploads/shop/products/<?php echo $row->image; ?>" alt="<?php echo $row->product_name; ?>" style="width: auto; max-width: 200px; height:auto; max-height: 200px;" />
						</a>
					</div>
				</div>
				<?php
					//formatting & standards
					$this->db->where('shop_standards_formatting.id', 1);
					$this->db->join('shop_currency', 'shop_currency.id = shop_standards_formatting.currency_standard');
					$this->db->join('shop_measurement', 'shop_measurement.id = shop_standards_formatting.measurement_standard'); 
					$f_s = $this->db->get('shop_standards_formatting');
				?>
				<strong><a href="<?php echo base_url(); ?>shop/product/<?php echo $row->category_id; ?>/<?php echo $row->id; ?>"><?php echo $row->product_name; ?> - <?php foreach($f_s->result() as $item){echo $item->html;}?><?php echo $row->price; ?></a></strong>
				<?php if($row->availability == "0"):?><br/><small><i>(None Available)</i></small><?php else:?><br/><small><i>(Available)</i></small><?php endif;?>
				<div style="overflow: auto; height: 35px;">
					<p><?php echo $row->product_description; ?></p>
				</div>
			</div>
	<?php endforeach; ?>
<?php endif; ?>
</div>
<div class="content_plain">