
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/shop/standards_formatting/">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/shop/standards_formatting/currency_standard">Currency Standard</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/shop/standards_formatting/measurement_standard">Measurement Standard</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/shop/standards_formatting/">Options</a></th>
				</tr>
					<?php if($shop_standards_formatting->num_rows() > 0):
						$count = 1;
						foreach($shop_standards_formatting->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td>
								<?php if($shop_standards_formatting_id->num_rows() > 0):
									foreach($shop_standards_formatting_id->result() as $row1):
									?>
										<?php echo $row1->id;?>
									<?endforeach;
								endif;?>
								</td>
								<td><?php echo $row->currency_name;?></td>
								<td><?php echo $row->measurement_name;?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/shop/standards_formatting_edit/<?php if($shop_standards_formatting_id->num_rows() > 0): foreach($shop_standards_formatting_id->result() as $row1):?><?php echo $row1->id;?><?endforeach; endif;?>" title="Edit" class="icon-1 info-tooltip"></a>
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
			
			


