<p>Please find all of our available listings below:</p>
<?php if($list_groups->num_rows() > 0):?>
	<?php foreach($list_groups->result() as $section): ?>
		<div class="container thin">
		<h3 style="text-transform: capitalize;"><?php echo $section->list_title; ?></h3>
		<table  style="text-transform: capitalize;">
			<tr style="font-size: 15px;">
				<th><?php echo $section->option_1_header; ?></th>
				<th><?php echo $section->option_2_header; ?></th>
				<th>Link</th>
			</tr>

			<?php if($list_items->num_rows() > 0):?>
				<?php foreach($list_items->result() as $row): ?>
					<?php if($section->id == $row->group_id):?>
					<tr>
						<td><div class="container left thin" style="min-width: 230px;"><?php echo $row->option_1; ?></div></td>
						<td><div class="container right thin" style="min-width: 230px;"><?php echo $row->option_2; ?></div></td>
						<td><div class="container right thin" style="min-width: 130px;"><?php if($row->link == ""):?><?php else:?><?php echo anchor($row->link, $row->link);?><?php endif;?></div></td>
					</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?> 			
		</table>
		</div>
		<div class="spacer"></div>
	<?php endforeach; ?>
<?php endif; ?> 
</div>
<div class="content_plain">