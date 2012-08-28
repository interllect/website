
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/shop/review/id/<?php if($shop_review->num_rows() > 0): echo $offset;?>/<?php echo $shop_review_edit->product_id; endif;?>">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/shop/review/user_id/<?php if($shop_review->num_rows() > 0): echo $offset;?>/<?php echo $shop_review_edit->product_id; endif;?>">User Id</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/review/username/<?php if($shop_review->num_rows() > 0): echo $offset;?>/<?php echo $shop_review_edit->product_id; endif;?>">Username</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/shop/review/product_id/<?php if($shop_review->num_rows() > 0): echo $offset;?>/<?php echo $shop_review_edit->product_id; endif;?>">Product Id</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/review/product_name/<?php if($shop_review->num_rows() > 0): echo $offset;?>/<?php echo $shop_review_edit->product_id; endif;?>">Product Name</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/review/review/<?php if($shop_review->num_rows() > 0): echo $offset;?>/<?php echo $shop_review_edit->product_id; endif;?>">Review</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/review/date/<?php if($shop_review->num_rows() > 0): echo $offset;?>/<?php echo $shop_review_edit->product_id; endif;?>">Date</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/shop/review/id/<?php if($shop_review->num_rows() > 0): echo $offset;?>/<?php echo $shop_review_edit->product_id; endif;?>">Options</a></th>
				</tr>
					<?php if($shop_review->num_rows() > 0):
						$count = 1;
						foreach($shop_review->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->user_id;?></td>
								<td><?php echo $row->username;?></td>
								<td><?php echo $row->product_id;?></td>
								<td><?php echo $row->product_name;?></td>
								<td><?php echo $row->review;?></td>
								<td><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/shop/review_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
								</td>
							</tr>
							<? 	$count++;
						endforeach;
					endif;?>
				</table>
				
				</form>
			</div>
			
			<table border="0" cellpadding="0" cellspacing="0" id="paging-table">
			<tr>
			<td>
				<?php echo $pagination; ?>
			</td>
			</tr>
			</table>
			
			


