<?php if($schedule_events->num_rows() > 0):?>
<div class="container thin">
	<h3 style="text-transform: capitalize;"><?php echo $date; ?></h3>
	<table  style="text-transform: capitalize;">
		<tr style="font-size: 15px;">
			<th>Start Time</th>
			<th></th>
			<th>End Time</th>
			<th></th>
			<th>Event</th>
		</tr>
		<?php foreach($schedule_events->result() as $row): ?>
			<tr>
				<td><div class="container left thin" style="min-width: 100px;"><?php echo substr($row->StartTime, 11 , 2).':'.substr($row->StartTime, 14 , 2);?></div></td>
				<td><div class="container left thin" style="min-width: 10px;">to</div></td>
				<td><div class="container left thin" style="min-width: 100px;"><?php echo substr($row->EndTime, 11 , 2).':'.substr($row->EndTime, 14 , 2);?></div></td>
				<td><div class="container left thin" style="min-width: 10px;">-</div></td>
				<td><div class="container left thin" style="min-width: 200px;"><?php echo '<strong><a href="JavaScript:newPopup(&#39;'.base_url().'schedule/event/'.$row->Id.'&#39;);">'.$row->Subject.'</a></strong>'; ?><br/><?php echo $row->Location; ?><br/><?php echo $row->Description; ?></div></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>
<?php else: ?>
<div class="container thin">
	<h3 style="text-transform: capitalize;"><?php echo $date; ?></h3>
	<p>No Events on this date</p>
</div>
<?php endif; ?>

<script type="text/javascript">
	function newPopup(url) 
	{
		popupWindow = window.open(
			url,'Event','height=400,width=400,left=10,top=10,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=no'
		)
	}
</script>

</div>
<div class="content_plain">