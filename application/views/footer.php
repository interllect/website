	<?php
		$this->db->where('module_name', 'facebook');
		$facebook_module = $this->db->get('modules')->row();
	?>
	
	<?php
		$this->db->where('module_name', 'twitter');
		$twitter_module = $this->db->get('modules')->row();
	?>
	
	<?php
		$this->db->where('module_name', 'chat');
		$chat_module = $this->db->get('modules')->row();
	?>
	
	<?php if($chat_module->status != '0') :?>
		<?php if($this->tank_auth->is_logged_in()):?>
			<div class="container whois" style="width: 150px; float: left; position: fixed; left: 0; top: 0; z-index: 100;">
					<h3>Whos Online</h3>
					<? $this->db->distinct('ip_address');
						$this->db->where('user_data !=', "");
						$query = $this->db->get('ci_sessions');
					if($this->tank_auth->is_logged_in()):?>
						<?php if($query->num_rows() > 0):
							$count = 0;?>
							<div id="whos-online">
								<ul style="overflow: auto; height: auto;">
									<?php foreach($query->result() as $row): ?>
										<?php  
											$contents = unserialize($row->user_data);				
											if(array_key_exists('username', $contents)):
												if($contents['username'] !== $this->session->userdata('username') AND $role_id <= 3):
												$count++;
										?>
													<li class="container thin" style="margin-bottom: 5px; padding: 0px; text-align: center; list-style: none; font-weight: bolder;"><a href="javascript:void(0)" onclick="javascript:chatWith('<?php echo $contents['username'];?>')"><?php echo $contents['username'];?></a></li>

										<?php		endif;
											endif;?>
										
									<?php endforeach; ?>
								</ul>
							<?php if($count == 0):?>
								<p  class="container thin" style="margin: 0px auto; font-size: 1.1em; text-align: center;">nobody is online</p>
							<?php endif;?>
							</div>
						<?php endif;?>
					<?php endif;?>
			</div>
		<?php endif;?>
	<?php endif?>
	
	</div>
	
	<?php 
		$this->db->where('id', '1');
		$settings = $this->db->get('settings')->row();
	?>
	
	<div id="footer">
		<?php if($facebook_module->status != '0') :?>
			<div class="left">
				<div class="fb-like" data-href="<?php echo $settings->facebook;?>" data-send="false" data-width="450" data-show-faces="false" data-font="verdana"></div>
			</div>
		<?php endif;?>	
		<?php if($twitter_module->status != '0') :?>
		<div  class="right" style="text-align: right;">
			<a href="<?php echo str_replace("@","https://twitter.com/",str_replace("https://twitter.com/#!/","https://twitter.com/",$settings->twitter));?>" class="twitter-follow-button" data-show-count="false">Follow @interllect</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		<?php endif;?>	
	</div>
	
	<div id="footer" class="site_map">
	<strong>Sitemap</strong>
	<hr/>
		<div class="thin" style="text-align: center; text-transform: capitalize; font-weight: bolder;">
			<?php
				//header("Content-type: text/xhtml,text/xml");
				echo '<?xml version=\'1.0\' encoding=\'UTF-8\'?>';
				echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

				$this->db->order_by('id','asc');
				$sitemap = $this->db->get('modules');
				
				$count = 0;
				
				foreach($sitemap->result() as $row): 
			?>
			
			<?php if(($row->status != '0')&&($row->module_name != "chat")&&($row->module_name != "facebook")&&($row->module_name != "twitter")&&($row->module_name != "advert")&&($row->module_name != "search")&&($row->module_name != "profile")&&($row->module_name != "mp3player")&&($row->module_name != "terms_conditions")):?>	
				<?php '<url><loc>'.base_url().''.$row->module_name.'</loc></url>';?>
				<?php echo ' | '.anchor(base_url().''.$row->module_name, str_replace('news blogs','news and blogs',str_replace('_',' ',$row->module_name))).' | ';?>
			<?php endif;?>
			
			<?php if($count < '5'):
				$count++;
				else:
					echo '<br/>';
				$count = 0;
				endif;
			?>
			
			<?php endforeach; 
				echo '</urlset>';
			?>
			
			<br/><br/><br/>
			
			<?php foreach($sitemap->result() as $row): ?>
			
				<?php if(($row->status != '0')&&($row->module_name == "terms_conditions")):?>	
					<?php echo anchor(base_url().''.$row->module_name, str_replace('_',' ',$row->module_name));?>
				<?php endif;?>
			
			<?php endforeach;?>
		</div>
	</div>
	<div class="spacer_top"></div>
	
	<script type="text/javascript" charset="utf-8">
	  $(document).ready(function(){
		$("a[rel^='prettyPhoto']").prettyPhoto();
	  });
	</script>
	</body>
</html>