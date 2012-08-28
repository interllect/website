<h3>How to contact us</h3>
<p>
To find out more about us, report a bug you have found, make a complaint about any of the services or to simply query us any of the products or issues you find on site. Simply fill in the form below and 
a memeber of staff will email you back as soon as possible. Please note upon submittion you will be sent an automated response to the email address you have registered with confirming 
your query has been submitted to a staff member please allow up to 48 hours for a response.
</p>
				<div class="spacer"></div>
				<div class="container thin">
					<p><strong>New Enquiry:</strong></p>
					<?php echo $alert_msg;?>
					<?php echo form_open('contact/send_message');?>
						<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
						<input type="hidden" name="username" value="<?php echo $username;?>">
						<?php if($users->num_rows() > 0):?>
							<?php foreach($users->result() as $row): ?>
								<?php if($row->id == $user_id):?>
									<?php $email = $row->email;?>
								<?php endif;?>
							<?php endforeach; ?>
						<?php endif; ?>
						<input type="hidden" name="email" value="<?php echo $email;?>">
						<label for="editor1">Enquiry Type:</label>
						<select type="text" name="enquiry_type" class="input_long">
								<option value="General">General</option>
								<option value="Bug Tracking">Bug Tracking</option>
								<option value="Complaint">Complaint</option>
								<option value="Misc">Misc</option>
						</select>
						<br/>
						<label for="editor1">Enquiry:</label>
						<textarea cols="80" id="editor1" name="enquiry" rows="10"></textarea>
						<script type="text/javascript">
						//<![CDATA[

							CKEDITOR.replace( 'editor1', {
								removePlugins : 'resize',
								toolbar :
								[

								]								
							});

						//]]>
						</script>
						<input type="submit" value="Send Enquiry" class="button"/>
					</form>	
				</div>
				<div class="spacer"></div>

<p>Thank you again for visiting <strong><?php echo base_url();?></strong></p>
</div>
<div class="content_plain">

