<h1><?php echo $list_group_titles->list_title;?></h1>
<br/>
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/lists/items/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/lists/items/option_1"><?php echo $list_group_titles->option_1_header;?></a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/lists/items/option_2"><?php echo $list_group_titles->option_2_header;?></a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/lists/items/link">Link</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/lists/items/">Options</a></th>
				</tr>
					<?php if($list_items->num_rows() > 0):
						$count = 1;
						foreach($list_items->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->option_1;?></td>
								<td><?php echo $row->option_2;?></td>
								<td><?php if($row->link == ""):?><?php else:?><?php echo anchor($row->link, $row->link);?><?php endif;?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/lists/items_edit/<?php echo $row->id;?>/<?php echo $row->group_id;?>" title="Edit" class="icon-1 info-tooltip"></a>
								<a href="<?php echo base_url();?>admin/lists/items_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
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
					<a href="<?php echo base_url();?>admin/lists/items_add/<?php echo $this->uri->segment(6);?>" class="action-edit">Add</a>
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