	
	<?php if($about->num_rows() > 0):?>
		<?php foreach($about->result() as $row): ?>
			<h3><?php echo $row->title; ?></h3>
			<p><?php echo $row->description; ?></p>
		<?php endforeach; ?>
	<?php endif; ?> 
</div>
<div class="content_plain">