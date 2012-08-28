
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/dashboard/modules/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/dashboard/modules/module_name">Module Name</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/dashboard/modules/">Options</a></th>
				</tr>
					<?php if($modules->num_rows() > 0):
						$count = 1;
						foreach($modules->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->module_name;?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/dashboard/modules_toggle/<?php echo $row->id;?>" title="Toggle" class="icon-3 info-tooltip"></a>
								<?php if($row->status == "0"){
										$toggle_msg = "Disabled";
									}elseif($row->status == "1"){
										$toggle_msg = "Enabled";
									}
								?>
								<b><?php echo $toggle_msg;?>
								</b>
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
			
			


