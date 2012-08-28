
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/about/info/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/about/info/title">Title</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/about/info/description">Description</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/about/info/">Options</a></th>
				</tr>
					<?php if($about->num_rows() > 0):
						$count = 1;
						foreach($about->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->title;?></td>
								<td><?php echo $row->description;?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/about/info_edit/<?php echo $row->id;?>" title="Edit" class="icon-1 info-tooltip"></a>
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
			
			


