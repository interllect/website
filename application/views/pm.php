<h3>Personal Message Box</h3>
</div>

<div class="content_plain">
	<div class="container thin">
		<p><strong>New Message:</strong></p>
		<?php echo $alert_msg;?>
		<?php echo form_open('forum/pm_send');?>
			<input type="hidden" name="sender_id" value="<?php echo $user_id;?>">
			<input type="hidden" name="sender" value="<?php echo $username;?>">
			<label for="editor1">Send to:</label>
			<select type="text" name="reciever_id" class="input_long">
			<?php if($user->num_rows() > 0):?>
				<?php foreach($user->result() as $row): ?>
					<?php if($user_id!=$row->id):?>
					<option value="<?php echo $row->id;?>"><?php echo $row->username;?></option>
					<?php endif;?>
				<?php endforeach; ?>
			<?php endif; ?> 
			</select>
			<br/>
			<label for="editor1">Title:</label>
			<input type="text" name="title" class="input_long">
			<br/>
			<label for="editor1">Message:</label>
			<textarea cols="80" id="editor1" name="message" rows="10"></textarea>
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
			<input type="submit" value="Send Message" class="button"/>
		</form>	
	</div>
	<div class="spacer"></div>
	
	<div class="container left">
	<h3>Inbox</h3>
	<?php if($inbox->num_rows() > 0):?>
		<?php foreach($inbox->result() as $row): ?>
			<?php if($row->read != "1"):?>
				<div class="container thin" style="background: gold !important; color: black;">
					<span style="float: left; width: 248px;">
						<strong><?php echo bad_words($row->title);?></strong>
						<p><?php echo bad_words($row->message);?></p>
					</span>
					<span style="float: right; width: 150px;">
						<p><?php echo "sent by: <strong>". $row->sender. "</strong>";?></p>
						<p style="font-size: 11px;"><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></p>
						<p><strong style="text-decoration: underline;"><a href="<?php echo base_url(); ?>forum/pm_read/<?php echo $row->id; ?>" name="inbox" style="color: black;">Unread</a></strong></p>
					</span>
				</div>	
				<div class="spacer"></div>
			<?php else:?>
				<div class="container thin">
					<span style="float: left; width: 248px;">
						<strong><?php echo bad_words($row->title);?></strong>
						<p><?php echo bad_words($row->message);?></p>
					</span>
					<span style="float: right; width: 150px;">
						<p><?php echo "sent by: <strong>". $row->sender. "</strong>";?></p>
						<p style="font-size: 11px;"><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></p>
						<p><strong>Read</strong></p>
					</span>
				</div>	
				<div class="spacer"></div>
			<?php endif;?>	
		<?php endforeach; ?>
	<?php endif; ?>
	</div>
	
	<div class="container right">
	<h3>Outbox</h3>
	<?php if($outbox->num_rows() > 0):?>
		<?php foreach($outbox->result() as $row): ?>
			<div class="container thin">
				<span style="float: left; width: 248px;">
					<strong><?php echo bad_words($row->title);?></strong>
					<p><?php echo bad_words($row->message);?></p>
				</span>
				<span style="float: right; width: 150px;">
					<p><?php echo "sent to: <strong>". $row->reciever. "</strong>";?></p>
					<p style="font-size: 11px;"><?php echo  substr($row->date, 8 , 2) . "/". substr($row->date, 5 , 2) . "/". substr($row->date, 0 , 4 ); ?></p>
				</span>
			</div>	
			<div class="spacer"></div>
		<?php endforeach; ?>
	<?php endif; ?>
	</div>