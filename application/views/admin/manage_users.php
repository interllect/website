				<?php 
				foreach($super_users->result() as $row):
				if($super_users->num_rows() <= 0):?>
				<div id='message-red'>
					<table border='0' width='100%' cellpadding='0' cellspacing='0'>
						<tr>
							<td class='red-left'>There is no 'Super Admin' assigned!!!, please contact the system developer for support</strong></td>
							<td class='red-right'><a class='close-red'><img src='<?php echo base_url();?>assets/admin/images/table/icon_close_red.gif' alt='' /></a></td>
						</tr>
					</table>
				</div>
				<?php endif;
				endforeach;
				?>

				<div id='message-green'>
					<table border='0' width='100%' cellpadding='0' cellspacing='0'>
						<tr>
							<td class='green-left'><strong><?php echo anchor('admin/manage_users/session_clear','Clear All Sessions!');?></strong> | <strong><?php echo anchor('admin/manage_users/autologin_clear','Clear All Auto-Login!');?></strong></td>
							<td class='green-right'><a class='close-green'><img src='<?php echo base_url();?>assets/admin/images/table/icon_close_green.gif' alt='' /></a></td>
						</tr>
					</table>
				</div>
				
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/manage_users/user_list/user_id">ID</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="<?php echo base_url();?>admin/manage_users/user_list/role_id">Role</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/username">Username</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/email">Email</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/activated">Activated</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/banned">Banned</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/last_ip">Last I.P</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/image">Avatar</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/country">Country</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/website">Website</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/bio">Bio</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/signature">Signature</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/facebook">Facebook</a></th>
					<th class="table-header-repeat line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/twitter">Twitter</a></th>
					<th class="table-header-options line-left"><a href="<?php echo base_url();?>admin/manage_users/user_list/">Options</a></th>
				</tr>
					<?php if($users->num_rows() > 0):
						$count = 1;
						foreach($users->result() as $row):
							if($count <= 1):?>
							<tr class="alternate-row">
							<?php else: $count=0;?>
							<tr>						
							<?php endif;?>	
								<td><?php echo $row->user_id;?></td>
								<td>
								<?php 
								if($row->role_id == "1"){
									echo "Admin";
								} elseif ($row->role_id == "2"){
									echo "Moderator";
								} elseif($row->role_id == "3"){
									echo "User";
								}elseif(($row->role_id == "")||($row->role_id == "0")){
									echo "Super Admin";
								}
								?>
								</td>
								<td><?php echo $row->username;?></td>
								<td><?php echo safe_mailto($row->email, $row->email);?></td>
								<td>
								<?php 
								if($row->activated == "1"){
									echo "<a href='".base_url()."admin/manage_users/user_toggle/".$row->user_id."'  class='icon-5 info-tooltip'></a>";
								} elseif ($row->activated == "0"){
									echo "<a href='".base_url()."admin/manage_users/user_toggle/".$row->user_id."' class='icon-2 info-tooltip'></a>";
								}
								?>
								</td>
								<td>
								<?php 
								if($row->banned == "1"){
									echo "<a href='".base_url()."admin/manage_users/user_toggle/".$row->user_id."' class='icon-5 info-tooltip'></a>";
								} elseif ($row->banned == "0"){
									echo "<a href='".base_url()."admin/manage_users/user_toggle/".$row->user_id."' class='icon-2 info-tooltip'></a>";
								}
								?>
								</td>
								<td><?php echo $row->last_ip;?></td>
								<td>
								<a href='<?php echo base_url();?>uploads/user_profiles/avatars/<?php echo $row->image;?>' rel="prettyPhoto">
									<img src='<?php echo base_url();?>uploads/user_profiles/avatars/<?php echo $row->image;?>' width='150' style='height: auto;'/>
								</a>
								</td>
								<td><?php echo $row->country;?></td>
								<td><a href="<?php if((strpos($row->website,'http') !== true)||(strpos($row->website,'https') !== true)):?><?php echo base_url();?><?php endif;?><?php echo $row->website;?>"><?php echo $row->website;?></a></td>
								<td><?php echo $row->bio;?></td>
								<td><?php echo str_replace('[img]','<img src="',str_replace('[/img]','" width="150" style="height: auto;"></img>',$row->signature));?></td>
								<td><?php echo $row->facebook;?></td>
								<td><?php echo str_replace("https://twitter.com/#!/","@",$row->twitter);?></td>
								<td class="options-width">
								<?php if($row->role_id >= $role_id):?>
									<a href="<?php echo base_url();?>admin/manage_users/user_edit/<?php echo $row->user_id;?>" title="Edit" class="icon-1 info-tooltip"></a>
									<a href="<?php echo base_url();?>admin/manage_users/user_delete/<?php echo $row->user_id;?>" title="Delete" class="icon-2 info-tooltip"></a>
								<?php endif;?>
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
					<a href="<?php echo base_url();?>admin/manage_users/email_all" class="action-edit">Email All</a>
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
			
			


