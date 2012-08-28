<?php 
	$this->db->where('id', '1');
	$settings = $this->db->get('settings')->row();
?>

<style>
table.calendar { 
	border-left:<?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?> ; 
	<?php if($settings->layout_type != '2') :?>
		-moz-border-radius: <?php echo $settings->corner_radius;?>px !important;
		border-radius: <?php echo $settings->corner_radius;?>px !important;
	<?php endif;?>
}

tr.calendar-row {  
}

td.calendar-day  { 
	min-height:80px; 
	font-size:11px; 
	position:relative; 
}
 
/* html div.calendar-day { height:80px; }*/

td.calendar-day:hover  { 
	background: <?php echo $settings->color_1;?>; 
	<?php if (($settings->color_2 != '')||($settings->color_3 != '')):?>
		background: -moz-linear-gradient(top,  <?php echo $settings->color_1;?> 0%, <?php echo $settings->color_2;?> 50%, <?php echo $settings->color_3;?> 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $settings->color_1;?>), color-stop(50%,<?php echo $settings->color_2;?>), color-stop(100%,<?php echo $settings->color_3;?>));
		background: -webkit-linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
		background: -o-linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
		background: -ms-linear-gradient(top, <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
		background: linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $settings->color_1;?>', endColorstr='<?php echo $settings->color_3;?>',GradientType=0 );
	<?php endif;?> 
}

td.calendar-day-np  { 
	background: <?php echo $settings->color_1;?>; 
	<?php if (($settings->color_2 != '')||($settings->color_3 != '')):?>
		background: -moz-linear-gradient(top,  <?php echo $settings->color_1;?> 0%, <?php echo $settings->color_2;?> 50%, <?php echo $settings->color_3;?> 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $settings->color_1;?>), color-stop(50%,<?php echo $settings->color_2;?>), color-stop(100%,<?php echo $settings->color_3;?>));
		background: -webkit-linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
		background: -o-linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
		background: -ms-linear-gradient(top, <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
		background: linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $settings->color_1;?>', endColorstr='<?php echo $settings->color_3;?>',GradientType=0 );
	<?php endif;?>
	min-height:80px; 
} 

/* html div.calendar-day-np { height:80px; }*/

td.calendar-day-head { 
	background:<?php echo $settings->color_2;?>; 
	font-weight:bold;
	text-align:center; 
	width:120px; 
	padding:5px; 
	border-bottom:<?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?>; 
	border-top:<?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?>; 
	border-right:<?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?>; 
}

div.event{
	background: <?php echo $settings->container_color_1;?>;
	<?php if (($settings->container_color_2 != '')||($settings->container_color_3 != '')):?>
		background: -moz-linear-gradient(top,  <?php echo $settings->container_color_1;?> 0%, <?php echo $settings->container_color_2;?> 50%, <?php echo $settings->container_color_3;?> 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $settings->container_color_1;?>), color-stop(50%,<?php echo $settings->container_color_2;?>), color-stop(100%,<?php echo $settings->color_3;?>));
		background: -webkit-linear-gradient(top,  <?php echo $settings->container_color_1;?> 0%,<?php echo $settings->container_color_2;?> 50%,<?php echo $settings->container_color_3;?> 100%); 
		background: -o-linear-gradient(top,  <?php echo $settings->container_color_1;?> 0%,<?php echo $settings->container_color_2;?> 50%,<?php echo $settings->container_color_3;?> 100%); 
		background: -ms-linear-gradient(top, <?php echo $settings->container_color_1;?> 0%,<?php echo $settings->container_color_2;?> 50%,<?php echo $settings->container_color_3;?> 100%); 
		background: linear-gradient(top,  <?php echo $settings->container_color_1;?> 0%,<?php echo $settings->container_color_2;?> 50%,<?php echo $settings->container_color_3;?> 100%); 
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $settings->container_color_1;?>', endColorstr='<?php echo $settings->container_color_3;?>',GradientType=0 );
	<?php endif;?>
	color: <?php echo $settings->all_text_color;?>;
	padding: 5px;
	cursor: pointer;
	margin-bottom: 5px;
	border-bottom:<?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?>; 
	overflow: hidden;
	<?php if($settings->layout_type != '2') :?>
		-moz-border-radius: <?php echo $settings->corner_radius;?>px !important;
		border-radius: <?php echo $settings->corner_radius;?>px !important;
	<?php endif;?>
}

div.event:hover {
	background: <?php echo $settings->color_1;?>; 
	<?php if (($settings->color_2 != '')||($settings->color_3 != '')):?>
		background: -moz-linear-gradient(top,  <?php echo $settings->color_1;?> 0%, <?php echo $settings->color_2;?> 50%, <?php echo $settings->color_3;?> 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $settings->color_1;?>), color-stop(50%,<?php echo $settings->color_2;?>), color-stop(100%,<?php echo $settings->color_3;?>));
		background: -webkit-linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
		background: -o-linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
		background: -ms-linear-gradient(top, <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
		background: linear-gradient(top,  <?php echo $settings->color_1;?> 0%,<?php echo $settings->color_2;?> 50%,<?php echo $settings->color_3;?> 100%); 
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $settings->color_1;?>', endColorstr='<?php echo $settings->color_3;?>',GradientType=0 );
	<?php endif;?>
	color: <?php echo $settings->container_color_1;?>;
}

div.day-number	 { 
	background:<?php echo $settings->color_1;?>; 
	position:absolute; 
	z-index:2; 
	top:-5px; 
	right:-25px; 
	padding:5px; 
	color:<?php echo $settings->all_text_color;?>; 
	font-weight:bold; 
	width:20px; 
	text-align:center; 
	<?php if($settings->layout_type != '2') :?>
		-moz-border-radius: <?php echo $settings->corner_radius;?>px !important;
		border-radius: <?php echo $settings->corner_radius;?>px !important;
	<?php endif;?>
}
td.calendar-day, td.calendar-day-np { 
	width:120px; 
	padding:5px 25px 5px 5px; 
	border-bottom:<?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?>; 
	border-right:<?php echo $settings->border_size;?>px <?php echo $settings->border_style;?> <?php echo $settings->border_color;?>; 
}

</style>

<?php
$con = mysql_connect("localhost", "asaph", "vuUPUPrbMP7ytWeN");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

$db_selected = mysql_select_db("adawg_09_03_1986",$con);



/* draws a calendar */
function draw_calendar($month,$year,$events = array()){
	
	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day"><div style="position:relative;height:100px;">';
			/* add in the day number */
			if($month <= '9'){
				$early_month = '0';
			}else{
				$early_month = '';
			}
			
			if($list_day <= '9'){
				$early_day = '0';
			}else{
				$early_day = '';
			}
			
			$event_day_url = $year.'-'.$early_month.''.$month.'-'.$early_day.''.$list_day;
			
			$event_day = $year.'-'.$early_month.''.$month.'-'.$list_day;
			
			$calendar.= '<div class="day-number"><a href="'.base_url().'schedule/day_time/'.$event_day_url.'">'.$list_day.'</a></div>';
			
			if(isset($events[$event_day])) {
				$calendar.='<div style="height: 100px; overflow: auto;">';
				foreach($events[$event_day] as $event) {
				?>
					<script type="text/javascript">
						function newPopup(url) 
						{
							popupWindow = window.open(
								url,'Event','height=400,width=400,left=10,top=10,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=no'
							)
						}
					</script>
				<?
					$calendar.= '<a href="JavaScript:newPopup(&#39;'.base_url().'schedule/event/'.$event['Id'].'&#39;);"><div class="event">'.substr($event['StartTime'], 11 , 2) .':'.substr($event['StartTime'], 14 , 2).' - '.substr($event['Subject'], 0 , 5).'</div></a>';
				}
				$calendar.= '</div>';
			}
			else {
				$calendar.= str_repeat('<p>&nbsp;</p>',2);
			}
		$calendar.= '</div></td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';
	

	/* end the table */
	$calendar.= '</table>';

	/** DEBUG **/
	$calendar = str_replace('</td>','</td>'."\n",$calendar);
	$calendar = str_replace('</tr>','</tr>'."\n",$calendar);
	
	/* all done, return result */
	return $calendar;
}

function random_number() {
	srand(time());
	return (rand() % 7);
}

/* date settings */
$month = (int) ($_GET['month'] ? $_GET['month'] : date('m'));
$year = (int)  ($_GET['year'] ? $_GET['year'] : date('Y'));

/* select month control */
$select_month_control = '<select name="month" id="month">';
for($x = 1; $x <= 12; $x++) {
	$select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
}
$select_month_control.= '</select>';

/* select year control */
$year_range = 7;
$select_year_control = '<select name="year" id="year">';
for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
	$select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
}
$select_year_control.= '</select>';

/* "next month" control */
$next_month_link = '<a href="schedule?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control">Next Month &gt;&gt;</a>';

/* "previous month" control */
$previous_month_link = '<a href="schedule?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control">&lt;&lt; 	Previous Month</a>';


$current_link = '<a href="schedule?month='.date('m').'&year='.date('Y').'" class="control">Current Month</a>';

/* bringing the controls together */
$controls = '<form method="get">'.$select_month_control.$select_year_control.'&nbsp;<input type="submit" name="submit" value="Go" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$previous_month_link.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$current_link.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$next_month_link.' </form>';

if($month <= '9'){
	$early_month = '0';
}else{
	$early_month = '';
}

$year_month = $year."-".$early_month."".$month;

$events = array();

$query = "SELECT *, DATE_FORMAT(StartTime,'%Y-%m-%e') AS StartDate FROM jqcalendar WHERE StartTime LIKE '".$year_month."%'";
$result = mysql_query($query,$con) or die(mysql_error());
while($row = mysql_fetch_assoc($result)):
	//echo $row['StartDate'];
	//echo '<div>'.$row['Subject'].'-'.$row['StartDate'].' to '.$row['EndTime'].'</div>';
	$events[$row['StartDate']][] = $row;
endwhile;

echo '<h3 style="float:left; padding-right:30px;">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</h3>';
echo '<div style="float:left;">'.$controls.'</div>';
echo '<div style="clear:both;"></div>';
echo draw_calendar($month,$year,$events);
echo '<br /><br />';

?>
</div>
<div class="content_plain">