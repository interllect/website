	<h3>Photo Gallery</h3>
		
		<?php echo $pagination; ?> 
		<br/>
		<?php if($image->num_rows() > 0):?>
			<?php foreach($image->result() as $row): ?>
				<div style="margin: 5px 10px; width: 200px !important; height: 200px !important; overflow: hidden; display: inline-block;">
					<div style="margin: 0px;">
						<div style="max-height: 200px !important; max-width: 200px !important; height: 200px !important; width: 200px !important; text-align: center; display: table-cell; vertical-align: middle; background: silver;">
							<a href="<?php echo base_url(); ?>/uploads/media/<?php echo $row->image; ?>" rel="prettyPhoto[gallery1]">
								<img src="<?php echo base_url(); ?>/uploads/media/<?php echo $row->image; ?>" alt="<?php echo $row->title; ?>" style="width: auto; max-width: 200px; height:auto; max-height: 200px;" />
							</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?> 
		<br/>
		<?php echo $pagination; ?> 
		
	</div>
	
	<div class="content_plain">
	
		<div class="container left" style="width: 420px">
		<h3>Audio Gallery</h3>
			<div class="container thin" style="height: 200px !important; overflow: auto;">
				<script type="text/javascript">
					AudioPlayer.setup("<?=base_url();?>assets/js/player.swf", {
						width: 375,
						transparentpagebg: "yes", 
						pagebg: "no"
					});
				</script>
				<?php if($audio->num_rows() > 0):?>
					<?php foreach($audio->result() as $row): ?>
						<div class="container thin">
						<p><strong><?php echo $row->title; ?></strong></p>
						<p id="audioplayer_<?php echo $row->id; ?>">Alternative content</p>
						<script type="text/javascript">
						AudioPlayer.embed("audioplayer_<?php echo $row->id; ?>", {
							soundFile: "<?php echo base_url(); ?>/uploads/media/<?php echo $row->audio; ?>",
							titles: "<?php echo str_replace('.mp3','',str_replace('_',' ',$row->audio)); ?>"/*,
						   artists: "<?php echo $artists; ?>"  */
						});
						</script>
						</div>
						<div class="spacer"></div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>		
		</div>
		
		<div class="container right" style="width: 420px">
		<h3>Video Gallery</h3>
			<div id="video">
			<span id="video_left" class="arrow_left"></span>
			<span id="video_right" class="arrow_right"></span>
				<ul>
				<?php if($video->num_rows() > 0):?>
					<?php foreach($video->result() as $row): ?>
					<li class="rounded" style="margin: 10px; height: 200px; background: black !important;">
					
					<a href="<?php echo $row->video; ?>" rel="prettyPhoto" title=""><div class="shine"></div><img src="http://i.ytimg.com/vi/<?php echo str_replace("http://www.youtube.com/watch?v=","",$row->video); ?>/default.jpg" alt="<?php echo $row->title; ?>" style="height:auto;" width="200" /></a>

					<br/>
						<span style="text-indent: 15px">
							<p><strong><?php echo $row->title; ?></strong></p>
							<p><?php echo $row->description; ?></p>
						</span>
					</li>
					<?php endforeach; ?>
				<?php endif; ?> 
				</ul>
			</div>
		</div>
		
		<script type="text/javascript">
			$(document).ready( function(){
				$('#video').jCarouselLite({
					scroll: 1,
					visible: 2,
					btnNext: "#video #video_left",
					btnPrev: "#video #video_right"
				}); 
			});
		</script>		