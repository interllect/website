
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/shop/products/id/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/shop/products/category_id/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_name; endif;?>">Category Name</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/product_name/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Title</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/product_Description/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Description</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/image/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Image</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/sku_number/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">SKU Number</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/quantity/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Quantity</a></th>
					<?php
						//formatting & standards
						$this->db->where('shop_standards_formatting.id', 1);
						$this->db->join('shop_currency', 'shop_currency.id = shop_standards_formatting.currency_standard');
						$this->db->join('shop_measurement', 'shop_measurement.id = shop_standards_formatting.measurement_standard'); 
						$f_s = $this->db->get('shop_standards_formatting');
					?>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/product_height/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Product Height (<?php foreach($f_s->result() as $item){echo $item->diameter_small;}?>)</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/product_width/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Product Width (<?php foreach($f_s->result() as $item){echo $item->diameter_small;}?>)</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/product_breadth/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Product Breadth (<?php foreach($f_s->result() as $item){echo $item->diameter_small;}?>)</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/product_weight/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Product Weight (<?php foreach($f_s->result() as $item){echo $item->weight_large;}?>)</a></th>	
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/price/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Price (<?php foreach($f_s->result() as $item){echo $item->currency_name;}?>)</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/discount_amount/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Discount Amount (<?php foreach($f_s->result() as $item){echo $item->currency_name;}?>)</a></th>	
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/discount_rate/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Discount Rate (%)</a></th>	
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/shipping/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Shipping (<?php foreach($f_s->result() as $item){echo $item->currency_name;}?>)</a></th>	
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/date/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Date</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/products/availability/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Availability</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/shop/products/id/<?php if($shop_products->num_rows() > 0): echo $offset;?>/<?php echo $shop_products_edit->category_id; endif;?>">Options</a></th>
				</tr>
					<?php if($shop_products->num_rows() > 0):
						$count = 1;
						foreach($shop_products->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->category_name;?></td>
								<td><?php echo $row->product_name;?></td>
								<td><?php echo $row->product_description;?></td>
								<td>
								<a href='<?php echo base_url();?>uploads/shop/products/<?php echo $row->image;?>' rel="prettyPhoto">
									<img src='<?php echo base_url();?>uploads/shop/products/<?php echo $row->image;?>' width='300' style='height: auto;'/>
								</a>
								</td>
								<td><?php echo $row->sku_number;?></td>
								<td><?php echo $row->quantity;?></td>
								<td><?php echo $row->product_height;?><?php foreach($f_s->result() as $item){echo $item->diameter_small;}?></td>
								<td><?php echo $row->product_width;?><?php foreach($f_s->result() as $item){echo $item->diameter_small;}?></td>
								<td><?php echo $row->product_breadth;?><?php foreach($f_s->result() as $item){echo $item->diameter_small;}?></td>
								<td><?php echo $row->product_weight;?><?php foreach($f_s->result() as $item){echo $item->weight_large;}?></td>
								<td><?php foreach($f_s->result() as $item){echo $item->html;}?><?php echo $row->price;?></td>
								<td><?php foreach($f_s->result() as $item){echo $item->html;}?><?php echo $row->discount_amount;?></td>
								<td><?php echo $row->discount_rate;?>%</td>
								<td><?php foreach($f_s->result() as $item){echo $item->html;}?><?php echo $row->shipping;?></td>
								<td><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></td>
								<td>
								<?php if($row->availability == "1"): 
									echo "Available"; 
								elseif($row->availability == "0"): 
									echo "Not Available"; 
								endif;?>
								</td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/shop/products_edit/<?php echo $row->id;?>/<?php echo $row->category_id;?>" title="Edit" class="icon-1 info-tooltip"></a>
								<a href="<?php echo base_url();?>admin/shop/products_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
								<?php echo anchor('admin/shop/review/id/0/'.$row->id,"Manage This Product's Reviews");?>
								</td>
							</tr>
							<? 	$count++;
						endforeach;
					endif;?>
				</table>
				
				</form>
			</div>
			
			<div id="actions-box">
				<a href="" class="action-slider"></a>
				<div id="actions-box-slider">
					<a href="<?php echo base_url();?>admin/shop/products_add/<?php echo $this->uri->segment(6);?>" class="action-edit">Add</a>
				</div>
				<div class="clear"></div>
			</div>
			
			<table border="0" cellpadding="0" cellspacing="0" id="paging-table">
			<tr>
			<td>
				<?php echo $pagination; ?>
			</td>
			</tr>
			</table>
			
			


