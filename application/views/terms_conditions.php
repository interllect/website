<?php if($terms_conditions->num_rows() > 0):?>
	<?php foreach($terms_conditions->result() as $row):?>
		<h3><?php echo $row->title;?></h3>
		<?php echo $row->description;?>
	<?php endforeach;?>
<?php endif;?>
</div>
<div class="content_plain">