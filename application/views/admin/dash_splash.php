
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/dashboard/splash/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/dashboard/splash/title">Title</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/dashboard/splash/description">Description</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/dashboard/splash/image">Image</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/dashboard/splash/link">Link</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/dashboard/splash/date">Date</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/dashboard/splash/">Options</a></th>
				</tr>
					<?php if($splash->num_rows() > 0):
						$count = 1;
						foreach($splash->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->title;?></td>
								<td><?php echo $row->description;?></td>
								<td>
								<a href='<?php echo base_url();?>uploads/slides/<?php echo $row->image;?>' rel="prettyPhoto">
									<img src='<?php echo base_url();?>uploads/slides/<?php echo $row->image;?>' width='300' style='height: auto;'/>
								</a>
								</td>
								<td><a href="<?php if((strpos($row->link,'http') !== true)||(strpos($row->link,'https') !== true)):?><?php echo base_url();?><?php endif;?><?php echo $row->link;?>"><?php echo $row->link;?></a></td>
								<td><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/dashboard/splash_edit/<?php echo $row->id;?>" title="Edit" class="icon-1 info-tooltip"></a>
								<a href="<?php echo base_url();?>admin/dashboard/splash_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
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
					<a href="<?php echo base_url();?>admin/dashboard/splash_add" class="action-edit">Add</a>
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
			
			


