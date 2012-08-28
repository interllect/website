<h3>FAQ</h3>
<ul>
	<?php if($faq->num_rows() > 0):?>
		<?php foreach($faq->result() as $row): ?>
			<li style="list-style: none; margin-bottom: 15px;">
			<strong><?php echo $row->question; ?></strong>
			<p><?php echo $row->answer; ?></p>
			</li>
		<?php endforeach; ?>
	<?php endif; ?> 			
</ul>
</div>
<div class="content_plain">

