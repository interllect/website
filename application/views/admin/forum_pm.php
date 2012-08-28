
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/forum/pm/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/forum/pm/sender_id">Sender Id</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/forum/pm/sender">Sender</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/forum/pm/reciever_id">Reciever Id</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/forum/pm/reciever">Reciever</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/forum/pm/title">Title</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/forum/pm/message">Message</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/forum/pm/date">Date</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/forum/pm/">Options</a></th>
				</tr>
					<?php if($pm->num_rows() > 0):
						$count = 1;
						foreach($pm->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->sender_id;?></td>
								<td><?php echo $row->sender;?></td>
								<td><?php echo $row->reciever_id;?></td>
								<td><?php echo $row->reciever;?></td>
								<td><?php echo $row->title;?></td>
								<td><?php echo $row->message;?></td>
								<td><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/forum/pm_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
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
			
			


