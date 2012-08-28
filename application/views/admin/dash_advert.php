
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/dashboard/advert/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/dashboard/advert/advert_link">Link</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/dashboard/advert/">Image</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/dashboard/advert/">Options</a></th>
				</tr>
					<?php if($advert->num_rows() > 0):
						$count = 1;
						foreach($advert->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><a href="<?php if((strpos($row->advert_link,'http') !== true)||(strpos($row->advert_link,'https') !== true)):?><?php echo base_url();?><?php endif;?><?php echo $row->advert_link;?>"><?php echo $row->advert_link;?></a></td>
								<td>
								<a href='<?php echo base_url();?>uploads/corner_advert/large.jpg' rel="prettyPhoto">
									<img src='<?php echo base_url();?>uploads/corner_advert/large.jpg' width='300' style='height: auto;'/>
								</a>
								</td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/dashboard/advert_edit/<?php echo $row->id;?>" title="Edit" class="icon-1 info-tooltip"></a>
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
			
			


