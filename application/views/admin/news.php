
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/news/news_articles/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/news/news_articles/title">Title</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/news/news_articles/description">Description</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/news/news_articles/video">Video</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/news/news_articles/image">Image</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/news/news_articles/date">Date</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/news/news_articles/">Options</a></th>
				</tr>
					<?php if($news->num_rows() > 0):
						$count = 1;
						foreach($news->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->title;?></td>
								<td><?php echo $row->description;?></td>
								<td>
								<?php if($row->video != ""): ?>
								<div class="rounded"  style="overflow: hidden; margin: 10px; width: 200px !important; height: 200px !important; background: black !important;">
									<a href="<?php echo $row->video; ?>" rel="prettyPhoto" title=""><img src="http://i.ytimg.com/vi/<?php echo str_replace("http://www.youtube.com/watch?v=","",$row->video); ?>/default.jpg" alt="<?php echo $row->title; ?>" style="height:auto;" width="200" /></a>
									<br/>
									<span style="text-indent: 15px">
										<p><strong><?php echo $row->title; ?></strong></p>
										<p><?php echo $row->description; ?></p>
									</span>
								</div>
								<?php endif;?>
								</td>
								<td>
								<a href='<?php echo base_url();?>uploads/news/<?php echo $row->image;?>' rel="prettyPhoto">
									<img src='<?php echo base_url();?>uploads/news/<?php echo $row->image;?>' width='300' style='height: auto;'/>
								</a>
								</td>
								<td><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/news/news_edit/<?php echo $row->id;?>" title="Edit" class="icon-1 info-tooltip"></a>
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
			
			


