	<?php echo bad_words($result_msg);?>
	<div style="padding:0px 20px;">
	
	<?php 
		
		$context = new StdClass(); //StdClass is an empty class
		$context->importantString = $keyword;

		function highlight($word, $context){
			
			$plainWords = array($context, ' ');
			$highlightedWith = array('<span style="border:1px solid black; outline-style:solid; outline-color:invert; background-color: gold; color: black;">'.$context.'</span>', ' ');

			$word = str_ireplace($plainWords, $highlightedWith, $word);
			
			return $word;
		}
	?>
	
		<h3>Media</h3>
		<strong>Image(s)</strong>
		<br/>
		<?php $section_empty1 = "There is no result from this section";?>
		<?php if(($media->num_rows() > 0)&&($keyword!="")):?>
			<?php foreach($media->result() as $row): ?>
				<?php if($row->image != ""):?>
					<div class="container thin">
					<?php $mediaid = $row->id-1;?>
						<div style="margin: 10px; width: 200px !important; height: 200px !important; overflow: hidden;">
							<div style="margin: 5px 10px; display: inline-block;">
								<div style="max-height: 200px !important; max-width: 200px !important; height: 200px !important; width: 200px !important; text-align: center; display: table-cell; vertical-align: middle; background: silver;">
									<a href="<?php echo base_url(); ?>/uploads/media/<?php echo $row->image; ?>" rel="prettyPhoto">
										<img src="<?php echo base_url(); ?>/uploads/media/<?php echo $row->image; ?>" alt="<?php echo $row->title; ?>" style="width: auto; max-width: 200px; height:auto; max-height: 200px;" />
									</a>
								</div>
							</div>
						</div>
						<p><strong><a href="<?php echo "media_center/media#prettyPhoto[gallery1]/".$mediaid."/";?>"><?php echo highlight(bad_words($row->title), $keyword);?></a></strong></p>
						<p><?php echo highlight(bad_words($row->description), $keyword);?></p>
					</div>
					<br/>
				<?php $section_empty1 = ""; ?> 
				<?php endif; ?> 
			<?php endforeach; ?>	
		<?php endif; echo $section_empty1;?> 
		<br/><br/>
		
		<strong>Audio(s)</strong>
		<br/>
		<?php $section_empty2 = "There is no result from this section";?>
		<?php if(($media->num_rows() > 0)&&($keyword!="")):?>
			<?php foreach($media->result() as $row): ?>
				<?php if($row->audio != ""):?>
					<div class="container thin">
					<?php $mediaid = $row->id-1;?>
							<div class="rounded">
								<script type="text/javascript">
									AudioPlayer.setup("<?=base_url();?>assets/js/player.swf", {
										width: 840,
										transparentpagebg: "yes", 
										pagebg: "no"
									});
								</script>
								<p><strong><?php echo $row->title; ?></strong></p>
								<p id="audioplayer_<?php echo $row->id; ?>">
									<audio controls="controls">
									  <source src="<?php echo base_url(); ?>/uploads/media/<?php echo $row->audio; ?>" type="audio/mpeg" />
									  Your browser does not support the audio element.
									</audio> 
								</p>
								<script type="text/javascript">
								AudioPlayer.embed("audioplayer_<?php echo $row->id; ?>", {
									soundFile: "<?php echo base_url(); ?>/uploads/media/<?php echo $row->audio; ?>",
									titles: "<?php echo $row->title; ?>"/*,
								   artists: "<?php echo $artists; ?>"  */
								});
								</script>
								<br/>
							</div>
						<p><strong><a href="<?php echo "media_center#audio";?>"><?php echo highlight(bad_words($row->title), $keyword);?></a></strong></p>
						<p><?php echo highlight(bad_words($row->description), $keyword);?></p>
					</div>
					<br/>
				<?php else:	
						$section_empty2 = ""; ?> 
				<?php endif; ?> 
			<?php endforeach; ?>	
		<?php endif; echo $section_empty2;?> 
		<br/><br/>
		
		<strong>Video(s)</strong>
		<br/>
		<?php $section_empty3 = "There is no result from this section";?>
		<?php if(($media->num_rows() > 0)&&($keyword!="")):?>
			<?php foreach($media->result() as $row): ?>
				<?php if($row->video != ""):?>
					<div class="container thin">
					<?php $newsid = $row->id-1;?>
						<div class="rounded"  style="margin: 10px; width: 200px !important; height: 200px !important; background: black !important;">
									<a href="<?php echo $row->video; ?>" rel="prettyPhoto" title=""><img src="http://i.ytimg.com/vi/<?php echo str_replace("http://www.youtube.com/watch?v=","",$row->video); ?>/default.jpg" alt="<?php echo $row->title; ?>" style="height:auto;" width="200" /></a>
									<br/>
									<span style="text-indent: 15px">
										<p><strong><a href="<?php echo "media_center#video";?>"><?php echo highlight(bad_words($row->title), $keyword);?></a></strong></p>
										<p><?php echo highlight(bad_words($row->description), $keyword);?></p>
									</span>
						</div>
					</div>
					<br/>
				<?php else:	
						$section_empty3 = ""; ?> 
				<?php endif; ?> 
			<?php endforeach; ?>	
		<?php endif; echo $section_empty3;?> 
		<hr/>
		
		<h3>Shop</h3>
		<?php if(($shop->num_rows() > 0)&&($keyword!="")):?>
			<?php foreach($shop->result() as $row): ?>
				<div class="container thin">
					<a href="<?php echo base_url(); ?>/uploads/shop/products/<?php echo $row->image; ?>" rel="prettyPhoto[gallery1]">
						<img src="<?php echo base_url();?>uploads/shop/products/<?php echo $row->image; ?>" width="200" style="height: auto;" />
					</a>
					<p><strong><a href="<?php echo base_url(); ?>shop/product/<?php echo $row->category_id; ?>/<?php echo $row->id; ?>"><?php echo highlight(bad_words($row->product_name), $keyword);?></a></strong></p>
					<p><?php echo highlight(bad_words($row->product_description), $keyword);?></p>
				</div>
				<br/>
			<?php endforeach; ?>
		<?php else:	
		echo "There is no result from this section"?> 	
		<?php endif; ?> 
		<hr/>
		
		<h3>News</h3>
		<?php if(($news->num_rows() > 0)&&($keyword!="")):?>
			<?php foreach($news->result() as $row): ?>
				<div class="container thin">
				<?php $newsid = $row->id-1;?>
					<p><strong><a href="<?php echo "news_blogs/blog#prettyPhoto/".$newsid."/";?>"><?php echo highlight(bad_words($row->title), $keyword);?></a></strong></p>
					<p><?php echo highlight(bad_words($row->description), $keyword);?></p>
				</div>
				<br/>
			<?php endforeach; ?>
		<?php else:	
		echo "There is no result from this section"?> 	
		<?php endif; ?> 
		<hr/>
		
		<h3>Blog</h3>
		<?php if(($blogs->num_rows() > 0)&&($keyword!="")):?>
			<?php foreach($blogs->result() as $row): ?>
				<div class="container thin">
					<p><strong><a href="<?php echo "news_blogs/post/".$row->id;?>"><?php echo highlight(bad_words($row->title), $keyword);?></strong></a></p>
					<p><?php echo highlight(bad_words($row->description), $keyword);?></p>
				</div>
				<br/>
			<?php endforeach; ?>
		<?php else:	
		echo "There is no result from this section"?>
		<?php endif; ?> 
		<hr/>
		
		<h3>Forum</h3>
		<?php if(($forum->num_rows() > 0)&&($keyword!="")):?>
			<?php foreach($forum->result() as $row): ?>
				<div class="container thin">
					<p><strong><a href="<?php echo "forum/post/".$row->section_id."/".$row->id;?>"><?php echo highlight(bad_words($row->thread_name), $keyword);?></a></strong></p>
					<p><?php echo highlight(bad_words($row->thread_description), $keyword);?></p>
				</div>
				<br/>
			<?php endforeach; ?>
		<?php else:	
		echo "There is no result from this section"?> 	
		<?php endif; ?> 
		<hr/>
		
	</div>
</div>
<div class="content_plain">