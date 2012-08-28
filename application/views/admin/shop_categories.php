
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/shop/categories/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/shop/categories/category_id">Category</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/categories/image">Image</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/shop/categories/">Options</a></th>
				</tr>
					<?php if($shop_categories->num_rows() > 0):
						$count = 1;
						foreach($shop_categories->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->category;?></td>
								<td>
								<a href='<?php echo base_url();?>uploads/shop/categories/<?php echo $row->image;?>' rel="prettyPhoto">
									<img src='<?php echo base_url();?>uploads/shop/categories/<?php echo $row->image;?>' width='300' style='height: auto;'/>
								</a>
								</td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/shop/categories_edit/<?php echo $row->id;?>" title="Edit" class="icon-1 info-tooltip"></a>
								<a href="<?php echo base_url();?>admin/shop/categories_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
								<?php echo anchor('admin/shop/products/id/0/'.$row->id,'Manage Products');?>
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
					<a href="<?php echo base_url();?>admin/shop/categories_add/" class="action-edit">Add</a>
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
			
			


