
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/faq/q_a/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/faq/q_a/question">Question</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/faq/q_a/answer">Answer</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/faq/q_a/">Options</a></th>
				</tr>
					<?php if($faq->num_rows() > 0):
						$count = 1;
						foreach($faq->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->question;?></td>
								<td><?php echo $row->answer;?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/faq/q_a_edit/<?php echo $row->id;?>" title="Edit" class="icon-1 info-tooltip"></a>
								<a href="<?php echo base_url();?>admin/faq/q_a_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
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
					<a href="<?php echo base_url();?>admin/faq/q_a_add" class="action-edit">Add</a>
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
			
			


