
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/lists/groups/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/lists/groups/list_title">List Title</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/lists/groups/option_1_header">Header 1</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/lists/groups/option_2_header">Header 2</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/lists/groups/">Options</a></th>
				</tr>
					<?php if($list_groups->num_rows() > 0):
						$count = 1;
						foreach($list_groups->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->list_title;?></td>
								<td><?php echo $row->option_1_header;?></td>
								<td><?php echo $row->option_2_header;?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/lists/groups_edit/<?php echo $row->id;?>" title="Edit" class="icon-1 info-tooltip"></a>
								<a href="<?php echo base_url();?>admin/lists/groups_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
								<?php echo anchor('admin/lists/items/id/0/'.$row->id,'Manage List Items');?>
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
					<a href="<?php echo base_url();?>admin/lists/groups_add/" class="action-edit">Add</a>
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