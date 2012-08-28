	<?php 
		$this->db->where('id', '1');
		$settings = $this->db->get('settings')->row();

		$this->db->where('module_name', 'about');
		$about_module = $this->db->get('modules')->row();

		$this->db->where('module_name', 'forum');
		$forum_module = $this->db->get('modules')->row();

		$this->db->where('module_name', 'media_center');
		$media_center_module = $this->db->get('modules')->row();

		$this->db->where('module_name', 'shop');
		$shop_module = $this->db->get('modules')->row();

		$this->db->where('module_name', 'news_blogs');
		$news_blogs_module = $this->db->get('modules')->row();

		$this->db->where('module_name', 'facebook');
		$facebook_module = $this->db->get('modules')->row();

		$this->db->where('module_name', 'twitter');
		$twitter_module = $this->db->get('modules')->row();
	?>
	
	<div class="slider-wrapper theme-default">
        <div class="ribbon"></div>
            <div id="slider" class="nivoSlider">
			<?php if($splash->num_rows() > 0):?>
				<?php foreach($splash->result() as $row): ?>
                <a href="<?php echo $row->link;?>"><img src="<?=base_url();?>uploads/slides/<?php echo $row->image;?>" alt="<?php echo $row->title;?>" title="#htmlcaption<?php echo $row->id;?>" data-transition="slideInLeft"/></a>
				<?php endforeach;?>
			<?php endif;?>
			</div>
		<?php if($splash->num_rows() > 0):?>
			<?php foreach($splash->result() as $row): ?>
			<div id="htmlcaption<?php echo $row->id;?>" class="nivo-html-caption">
				<a href="<?php echo $row->link;?>"><h3><?php echo $row->title;?></h3></a>
				<p><?php echo $row->description;?></p>
			</div>
			<?php endforeach;?>
		<?php endif;?>
    </div>
	<br clear="both"/>
	</div>
	
	<div class="content_plain">
	
		<?php if($about_module->status != '0') :?>
			<div class="container across">
				<?php if($about->num_rows() > 0):?>
					<?php foreach($about->result() as $row): ?>
						<h3><a href="<?php echo "about/";?>"><?php echo $row->title; ?></a></h3>
						<p><?php echo $row->description; ?></p>
					<?php endforeach; ?>
				<?php endif; ?> 
			</div>
			<div class="spacer"></div>
		<?php endif; ?>
		
		<?php if($forum_module->status != '0') :?>
			<?php if($media_center_module->status == '0') :?>
				<div class="container across">
			<?php else: ?>
				<div class="container left" style="width: 420px">
			<?php endif; ?>
			<h3><?php echo anchor('forum','Latest Forum Threads'); ?></h3>
			<?php if($forum_threads->num_rows() > 0):?>
				<?php foreach($forum_threads->result() as $row): ?>
						<div class="container thin">
							<span class="left" style="min-width:150px !important;  text-align: left;">
								<strong><a href="<?php echo "forum/post/".$row->section_id;?>"><?php echo bad_words($row->thread_name);?></a></strong>
								<br/>
								<p><?php echo $row->thread_description;?></p>
							</span>
							<span class="right" style="min-width:150px !important; text-align: right;">	
								<p style="font-size: 11px;"><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></p>
								<?php if($row->username != ""): echo "<p>posted by <strong>".anchor('profile/view/'.$row->user_id, $row->username)."</strong></p>"; endif;?>
							</span>
						</div>
					<div class="spacer"></div>
				<?php endforeach; ?>
			<?php endif; ?> 
			</div>
		<?php endif; ?>
		
		
		<?php if($media_center_module->status != '0') :?>
			<?php if($forum_module->status == '0') :?>
				<div class="container across">
			<?php else: ?>
				<div class="container right" style="width: 420px">
			<?php endif; ?>
			<h3><?php echo anchor('media_center','Latest Media'); ?></h3>
				<div id='media'>
				<span id="media_left" class="arrow_left"></span>
				<span id="media_right" class="arrow_right"></span>
					<ul>
					
					<?php if($image->num_rows() > 0):?>
						<?php foreach($image->result() as $row): ?>
							<li style="margin: 10px; width: 200px !important; height: 200px !important; overflow: hidden;">
								<div style="margin: 5px 10px; display: inline-block;">
									<div style="max-height: 200px !important; max-width: 200px !important; height: 200px !important; width: 200px !important; text-align: center; display: table-cell; vertical-align: middle; background: silver;">
										<a href="<?php echo base_url(); ?>/uploads/media/<?php echo $row->image; ?>" rel="prettyPhoto">
											<img src="<?php echo base_url(); ?>/uploads/media/<?php echo $row->image; ?>" alt="<?php echo $row->title; ?>" style="width: auto; max-width: 200px; height:auto; max-height: 200px;" />
										</a>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
					
					<?php if($audio->num_rows() > 0):?>
						<?php foreach($audio->result() as $row): ?>
							<li style="margin: 10px; width: 200px !important; height: 200px !important;">
								<script type="text/javascript">
									AudioPlayer.setup("<?=base_url();?>assets/js/player.swf", {
										width: 200,
										transparentpagebg: "yes", 
										pagebg: "no"
									});
								</script>
								<p><strong><?php echo $row->title; ?></strong></p>
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
							</li>	
						<?php endforeach; ?>
					<?php endif; ?> 
					
					<?php if($video->num_rows() > 0):?>
						<?php foreach($video->result() as $row): ?>
							<li class="rounded"  style="margin: 10px; width: 200px !important; height: 200px !important; background: black !important;">
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
			<div class="spacer"></div>
		<?php endif; ?> 
		
		<?php if($shop_module->status != '0') :?>
		<div class="container across">
		<h3><?php echo anchor('shop','Latest Products'); ?></h3>
			<div id='shop'>
			<span id="shop_left" class="arrow_left"></span>
			<span id="shop_right" class="arrow_right"></span>
				<ul>
				
				<?php if($shop_products->num_rows() > 0):?>
					<?php foreach($shop_products->result() as $row): ?>
						<li style="margin: 10px; width: 200px !important; height: 300px !important; overflow: hidden;">
							<div style="margin: 5px 10px; display: inline-block;">
								<div style="max-height: 200px !important; max-width: 200px !important; height: 200px !important; width: 200px !important; text-align: center; display: table-cell; vertical-align: middle; background: silver; overflow: hidden;">
									<a href="<?php echo base_url(); ?>uploads/shop/products/<?php echo $row->image; ?>" rel="prettyPhoto">
										<img src="<?php echo base_url(); ?>uploads/shop/products/<?php echo $row->image; ?>" alt="<?php echo $row->product_name; ?>" style="width: auto; max-width: 200px; height:auto; max-height: 200px;" />
									</a>
								</div>
							</div>
								<?php
									//formatting & standards
									$this->db->where('shop_standards_formatting.id', 1);
									$this->db->join('shop_currency', 'shop_currency.id = shop_standards_formatting.currency_standard');
									$this->db->join('shop_measurement', 'shop_measurement.id = shop_standards_formatting.measurement_standard'); 
									$f_s = $this->db->get('shop_standards_formatting');
								?>
							<strong><a href="<?php echo base_url(); ?>shop/product/<?php echo $row->category_id; ?>/<?php echo $row->id; ?>"><?php echo $row->product_name; ?> - <?php foreach($f_s->result() as $item){echo $item->html;}?><?php echo $row->price; ?></a></strong>
							<div style="overflow: auto; height: 35px;">
								<p><?php echo $row->product_description; ?></p>
							</div>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
				
				</ul>
			</div>
		</div>
		<div class="spacer"></div>
		<?php endif; ?> 
		
		<?php if($news_blogs_module->status != '0') :?>
			<?php if(($twitter_module->status == '0')&&($facebook_module->status == '0')) :?>
				<div class="container across">
			<?php else:?>
				<div class="container left"  style="width: 420px">
			<?php endif;?>
				<h3><?php echo anchor('news_blogs','Latest News'); ?></h3>
				<div class="container thin" style="width: 415px">
					<?php if($news->num_rows() > 0):?>
						<?php foreach($news->result() as $row): ?>
							<?php if($row->video != ""): ?>
								<a href="<?php echo $row->video; ?>" rel="prettyPhoto" title="">
									<img class="cloudcarousel" src="http://i.ytimg.com/vi/<?php echo str_replace("http://www.youtube.com/watch?v=","",$row->video); ?>/0.jpg" title="<?php echo $row->title; ?>" style="width:auto;" height="310" />
								</a>
							<?php else:?>
								<a href="<?php echo base_url();?>uploads/news/<?php echo $row->image;?>" rel="prettyPhoto">
									<img class="cloudcarousel" src="<?php echo base_url();?>uploads/news/<?php echo $row->image;?>" alt="<?php echo $row->description;?>" title="<?php echo $row->title;?>" style="width:auto;" height="310" />
								</a>
							<?php endif;?>
						<?php endforeach; ?>
					<?php endif; ?> 
				</div>
				<br/>
				<h3><?php echo anchor('news_blogs','Latest Blogs'); ?></h3>
					<?php if($blogs->num_rows() > 0):?>
						<?php foreach($blogs->result() as $row): ?>
								<div class="container thin" <?php if(($twitter_module->status == '0')&&($facebook_module->status == '0')) :?><?php else:?>style="max-width: 415px;<?php endif;?>">
									<span class="left" style="min-width:150px !important;  text-align: left;">
										<strong><a href="<?php echo "news_blogs/post/".$row->id;?>"><?php echo $row->title;?></a></strong>
										<br/>
										<p><?php echo $row->description;?></p>
									</span>
									<span class="right" style="min-width:150px !important; text-align: right;">	
										<p style="font-size: 11px;"><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></p>
										<?php if($row->username != ""): echo "<p>posted by <strong>".anchor('profile/view/'.$row->user_id, $row->username)."</strong></p>"; endif;?>
									</span>
								</div>
							<div class="spacer"></div>	
						<?php endforeach; ?>
					<?php endif; ?> 	
				</div>
		<?php endif;?>
		
		<?php if(($twitter_module->status == '0')&&($facebook_module->status == '0')) :?>
		<?php else:?>
		<?php if($news_blogs_module->status == '0') :?>
			<div class="container across" style="text-align: center;">
		<?php else:?>
			<div class="container right" style="width: 420px">
		<?php endif;?>
			<?php if($facebook_module->status != '0') :?>
				<h3><?php echo anchor($settings->facebook,'Facebook Feed'); ?></h3>
				<div class="fb-like-box" data-href="<?php echo $settings->facebook;?>" data-width="435" data-colorscheme="<?php echo $settings->fb_color_scheme;?>" data-show-faces="false" data-stream="true" data-header="false"></div>
				<br/>
			<?php endif;?>
			<?php if($twitter_module->status != '0') :?>
			<h3><?php echo anchor(str_replace("@","https://twitter.com/#!/",$settings->twitter),'Twitter Feed'); ?></h3>
				<div class="twitter">
				<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
				<script>
				new TWTR.Widget({
				version: 2,
				type: 'profile',
				rpp: 4,
				interval: 30000,
				width: 435,
				height: 300,
				theme: {
					shell: {
						background: '<?php echo $settings->color_1;?>',
						color: '<?php echo $settings->all_text_color;?>'
					},
							tweets: {
								background: '<?php echo $settings->color_2;?>',
								color: '<?php echo $settings->link_normal_visited_color;?>',
								links: '<?php echo $settings->link_hover_active_color;?>'
							}
				},
					features: {
					scrollbar: false,
					loop: false,
					live: false,
					behavior: 'all'
					}
				}).render().setUser('<?php echo str_replace("https://twitter.com/#!/","@",$settings->twitter);?>').start();
				</script>
				</div>
			<?php endif;?>
			</div>
		<?php endif;?>
		
		<script type="text/javascript">
			$(document).ready( function(){
				$('#media').jCarouselLite({
					scroll: 1,
					visible: <?php if($forum_module->status != '0') { echo '2';} else{ echo '4';};?>,
					btnNext: "#media #media_left",
					btnPrev: "#media #media_right"
				}); 
				
				$('#shop').jCarouselLite({
					scroll: 1,
					visible: 4,
					btnNext: "#shop #shop_left",
					btnPrev: "#shop #shop_right"
				}); 
				
			});
		</script>		