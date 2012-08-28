
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/dashboard/chat/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/dashboard/chat/from">From</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/dashboard/chat/to">To</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/dashboard/chat/message">Message</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/dashboard/chat/sent">Date Sent</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/dashboard/chat/">Options</a></th>
				</tr>
					<?php if($chat->num_rows() > 0):
						$count = 1;
						foreach($chat->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->from;?></td>
								<td><?php echo $row->to;?></td>
								<td><?php echo $row->message;?></td>
								<td><?php echo  substr($row->sent, 8 , 2) . "/". substr($row->sent, 5 , 2) . "/". substr($row->sent, 0 , 4 ); ?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/dashboard/chat_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
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
			
			


