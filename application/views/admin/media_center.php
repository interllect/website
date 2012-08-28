
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/media_center/media/id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/media_center/media/title">Title</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/media_center/media/description">Description</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/media_center/media/image">Image</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/media_center/media/audio">Audio</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/media_center/media/video">Video</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/media_center/media/date">Date</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/media_center/media/">Options</a></th>
				</tr>
					<?php if($media->num_rows() > 0):
						$count = 1;
						foreach($media->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>						
								<td><?php echo $row->id;?></td>
								<td><?php echo $row->title;?></td>
								<td><?php echo $row->description;?></td>
								<td>
								<?php if($row->image != ""): ?>
								<div style="margin: 10px; width: 200px !important; height: 200px !important; overflow: hidden;">
									<div style="margin: 5px 10px; display: inline-block;">
										<div style="max-height: 200px !important; max-width: 200px !important; height: 200px !important; width: 200px !important; text-align: center; display: table-cell; vertical-align: middle; background: silver;">
											<a href="<?php echo base_url(); ?>/uploads/media/<?php echo $row->image; ?>" rel="prettyPhoto">
												<img src="<?php echo base_url(); ?>/uploads/media/<?php echo $row->image; ?>" alt="<?php echo $row->title; ?>" style="width: auto; max-width: 200px; height:auto; max-height: 200px;" />
											</a>
										</div>
									</div>
								</div>
								<?php endif;?>
								</td>
								<td>
								<?php if($row->audio != ""): ?>
								<div style="margin: 10px; width: 200px !important; height: 200px !important;">
									<script type="text/javascript">
										AudioPlayer.setup("<?=base_url();?>assets/js/player.swf", {
											width: 200,
											transparentpagebg: "yes", 
											pagebg: "no"
										});
									</script>
									<p><strong><?php echo $row->audio; ?></strong></p>
									<p id="audioplayer_<?php echo $row->id; ?>">
										<embed type="application/x-shockwave-flash" flashvars="audioUrl=<?php echo base_url(); ?>/uploads/media/<?php echo $row->audio; ?>" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="200" height="27" quality="best"></embed>
									</p>
									<script type="text/javascript">
									AudioPlayer.embed("audioplayer_<?php echo $row->id; ?>", {
										soundFile: "<?php echo base_url(); ?>/uploads/media/<?php echo $row->audio; ?>",
										titles: "<?php echo str_replace('.mp3','',str_replace('_',' ',$row->audio)); ?>"/*,
									   artists: "<?php echo $artists; ?>"  */
									});
									</script>
									<br/>
								</div>	
								<?php endif;?>
								</td>
								<td>
								<?php if($row->video != ""): ?>
								<div class="rounded"  style="margin: 10px; width: 200px !important; height: 200px !important; background: black !important;">
									<a href="<?php echo $row->video; ?>" rel="prettyPhoto" title=""><img src="http://i.ytimg.com/vi/<?php echo str_replace("http://www.youtube.com/watch?v=","",$row->video); ?>/default.jpg" alt="<?php echo $row->title; ?>" style="height:auto;" width="200" /></a>
									<br/>
									<span style="text-indent: 15px">
										<p><strong><?php echo $row->title; ?></strong></p>
										<p><?php echo $row->description; ?></p>
									</span>
								</div>
								<?php endif;?>
								</td>
								<td><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></td>
								<td class="options-width">
								<a href="<?php echo base_url();?>admin/media_center/media_edit/<?php echo $row->id;?>" title="Edit" class="icon-1 info-tooltip"></a>
								<a href="<?php echo base_url();?>admin/media_center/media_delete/<?php echo $row->id;?>" title="Delete" class="icon-2 info-tooltip"></a>
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
					<a href="<?php echo base_url();?>admin/media_center/media_add/" class="action-edit">Add</a>
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
			
			



			

			
			
	
			
			


