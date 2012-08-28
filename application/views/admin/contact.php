
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/contact/form/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/contact/form/user_id">User id</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/contact/form/username">Username</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/contact/form/email">Email</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/contact/form/enquiry_type">Enquiry Type</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/contact/form/enquiry">Enquiry</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/contact/form/date">Date</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/contact/form/">Options</a></th>
				</tr>
					<?php if($contact->num_rows() > 0):
						$count = 1;
						foreach($contact->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->user_id;?></td>
								<td><?php echo $row->username;?></td>
								<td><?php echo safe_mailto($row->email, $row->email);?></td>
								<td><?php echo $row->enquiry_type;?></td>
								<td><?php echo $row->enquiry;?></td>
								<td><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/contact/form_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
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
			
			


