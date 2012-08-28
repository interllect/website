<?php echo $alert_msg;?> 

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td>

	
	<!-- start id-form -->
	<?php echo form_open_multipart('admin/manage_users/user_edit/'.$id);?>
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Role:</th>
			<td>
			<select  name="role_id" class="styledselect_form_1">
			<?php if($users_edit->role_id == "1"):?>
				<?php if($users_edit->role_id >= $role_id):?><option value='1'>Admin</option><option value='2'>Moderator</option><option value='3'>User</option><?php else:?><option value='0'>Super Admin</option><?php endif;?> <?php if(($role_id == "")||($role_id == "0")):?><option value='0'>Super Admin</option><?php endif;?>  
			<?php elseif($users_edit->role_id == "2"):?>
				<?php if($users_edit->role_id >= $role_id):?><option value='2'>Moderator</option><option value='1'>Admin</option><option value='3'>User</option><?php else:?><option value='0'>Super Admin</option><?php endif;?> <?php if(($role_id == "")||($role_id == "0")):?><option value='0'>Super Admin</option><?php endif;?> 
			<?php elseif($users_edit->role_id == "3"):?>
				<?php if($users_edit->role_id >= $role_id):?><option value='3'>User</option><option value='1'>Admin</option><option value='2'>Moderator</option><?php else:?><option value='0'>Super Admin</option><?php endif;?> <?php if(($role_id == "")||($role_id == "0")):?><option value='0'>Super Admin</option><?php endif;?>
			<?php elseif(($users_edit->role_id == "")||($users_edit->role_id == "0")):?>
				<?php if(($role_id == "")||($role_id == "0")):?><option value='0'>Super Admin</option><?php endif;?> <?php if($users_edit->role_id >= $role_id):?><option value='3'>User</option><option value='1'>Admin</option><option value='2'>Moderator</option><?php else:?><option value='0'>Super Admin</option><?php endif;?>	
			<?php endif;?>
			</select>
			</td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Username:</th>
			<td><input type="text" value="<?php echo $users_edit->username;?>" class="inp-form-error" name="username"/></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th valign="top">Email:</th>
			<td><input type="text" <?php if($role_id >= $users_edit->role_id):?>readonly="readonly" disabled="disabled"<?php endif;?> value="<?php echo $users_edit->email;?>" class="inp-form-error" name="email"></td>
			<td>
			<div class="error-left"></div>
			<div class="error-inner">This field is required.</div>
			</td>
		</tr>
		<tr>
			<th>Image:</th>
			<td>
				<a href='<?php echo base_url();?>uploads/user_profiles/avatars/<?php echo $user_profiles_edit->image;?>' rel="prettyPhoto">
					<img src='<?php echo base_url();?>uploads/user_profiles/avatars/<?php echo $user_profiles_edit->image;?>' width='300' style='height: auto;'/>
				</a>
			</td>
			<td></td>
		</tr>
		<tr>
		<th>&nbsp;</th>
		<td>
			<input type="file" value="<?php echo $user_profiles_edit->image;?>" class="file_1" name="image"/>
		</td>
		<td style="padding: 0px 95px 10px;">
			<div class="bubble-left"></div>
			<div class="bubble-inner">PNG, JPEG, GIF 5MB max per image</div>
			<div class="bubble-right"></div>
		</td>
		</tr>
		<tr>
			<th valign="top">Country:</th>
			<td><input type="text" value="<?php echo $user_profiles_edit->country;?>" class="inp-form" name="country"/></td>
		</tr>
		<tr>
			<th valign="top">Website:</th>
			<td><input type="text" value="<?php echo $user_profiles_edit->website;?>" class="inp-form" name="website"/></td>
		</tr>
		<tr>
			<th valign="top">Bio:</th>
			<td><textarea cols="80" class="form-textarea" name="bio" rows="10"><?php echo $user_profiles_edit->bio;?></textarea></td>
		</tr>
		<tr>
			<th valign="top">Signature:</th>
			<td>
			<textarea cols="80" class="form-textarea" id="editor1" name="signature" rows="10"><?php echo $user_profiles_edit->signature;?></textarea>
			<script type="text/javascript">
			//<![CDATA[

				CKEDITOR.replace( 'editor1', {
					removePlugins : 'resize',
					extraPlugins : 'bbcode',
					toolbar :
					[

					]								
				});

			//]]>
			</script>
			
			</td>
		</tr>
		<tr>
			<th valign="top">Facebook:</th>
			<td>
			<input type="text" value="<?php echo $user_profiles_edit->facebook;?>" class="inp-form" name="facebook"/>
			<?php if($user_profiles_edit->facebook != ""): ?>
			<br/><br/>
			<div class="fb-like-box" data-href="<?php echo $user_profiles_edit->facebook;?>" data-width="340" data-colorscheme="light" data-show-faces="false" data-stream="true" data-header="false"></div>	
			<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th valign="top">Twitter:</th>
			<td>
			<input type="text" value="<?php echo $user_profiles_edit->twitter;?>" class="inp-form" name="twitter"/>
			<?php if($user_profiles_edit->twitter != ""): ?>
			<br/><br/>
				<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
				<script>
				new TWTR.Widget({
				  version: 2,
				  type: 'profile',
				  rpp: 4,
				  interval: 30000,
				  width: 340,
				  height: 300,
				  theme: {
					shell: {
					  background: '#333333',
					  color: '#ffffff'
					},
					tweets: {
					  background: '#000000',
					  color: '#ffffff',
					  links: '#4aed05'
					}
				  },
				  features: {
					scrollbar: false,
					loop: false,
					live: false,
					behavior: 'all'
				  }
				}).render().setUser('<?php echo str_replace("https://twitter.com/#!/","@",$user_profiles_edit->twitter);?>').start();
				</script>
			<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td valign="top">
				<input type="submit" value="" class="form-submit" />
				<!-- <input type="reset" value="" class="form-reset"  /> -->
			</td>
			<td></td>
		</tr>
	</table>
	</form>
	<!-- end id-form  -->

	</td>

</tr>
<tr>
<td><img src="<?=base_url();?>assets/admin/images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>