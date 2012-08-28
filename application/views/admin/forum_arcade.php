
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/forum/arcade/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/forum/arcade/title">Title</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/forum/arcade/description">Description</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/forum/arcade/game">Game</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/forum/arcade/genre">genre</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/forum/arcade/">Options</a></th>
				</tr>
					<?php if($arcade->num_rows() > 0):
						$count = 1;
						foreach($arcade->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->title;?></td>
								<td><?php echo $row->description;?></td>
								<td><?php echo $row->game;?></td>
								<td><?php echo $row->genre;?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/forum/arcade_edit/<?php echo $row->id;?>" title="Edit" class="icon-1 info-tooltip"></a>
								<a href="<?php echo base_url();?>admin/forum/arcade_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
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
					<a href="<?php echo base_url();?>admin/forum/arcade_add" class="action-edit">Add</a>
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
			
			


