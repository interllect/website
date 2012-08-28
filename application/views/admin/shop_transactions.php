
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/shop/transactions/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/shop/transactions/user_id">User Id</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/transactions/username">Username</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/shop/transactions/product_id">Product Id</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/transactions/product_name">Product Name</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/transactions/transaction_type">Transaction Type</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/transactions/transaction_date">Transaction Date</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/transactions/date">Date</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/shop/transactions/">Options</a></th>
				</tr>
					<?php if($shop_transactions->num_rows() > 0):
						$count = 1;
						foreach($shop_transactions->result() as $row):
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
								<td>
								<?php if($row->transaction_type == '1'):?>
									<?php echo "In Basket";?>
								<?php elseif($row->transaction_type == '2'):?>
									<?php echo "Purchased";?>
								<?php endif;?>
								</td>
								<td><?php echo  substr($row->transaction_date, 8 , 2) . "/". substr($row->transaction_date, 5 , 2) . "/". substr($row->transaction_date, 0 , 4 ); ?></td>
								<td><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/shop/transactions_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
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
			
			


