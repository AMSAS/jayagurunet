<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles/media-detect.css">
		<meta name="viewport" content="width=480">
		<style>
			* {
				font-family: Arial, "Times New Roman", Times, serif;
				font-size:12px;
			}
			table {
				border-collapse: collapse;
			}
			table, td, th {
				border: 1px solid black;
			}
			/* calendar */
			table.calendar		{ border-left:1px solid #999; margin-left: auto; margin-right: auto;  }
			tr.calendar-row	{  }
			td.calendar-day	{ min-height:40px; font-size:11px; position:relative; } * html div.calendar-day { height:40px; }
			td.calendar-day:hover	{ background:#eceff5; }
			td.calendar-day-np	{ background:#eee; min-height:40px; } * html div.calendar-day-np { height:40px; }
			td.calendar-day-head { background:#ccc; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
			div.day-number		{ background:#999; padding:5px; color:#fff; font-weight:bold; float:right; margin:-5px -5px 0 0; width:20px; text-align:center; }
			/* shared */
			td.calendar-day, td.calendar-day-np { width:120px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; }
		</style>
	</head>
<body width="100%">
<div style="text-align:center">
  <img src="/images/orgnz.gif"/><br>
<?php
session_start();
include 'db.php';

if (isset($_SESSION['PID'])) {
			$today = getdate();
			if(isset($_GET['mon'],$_GET['year'])){
				echo draw_calendar($_GET['mon'],$_GET['year']);
			}else{
				echo draw_calendar($today['mon'],$today['year']);
			}?>
			<a href="sseva.php?Seva_cat=Guest&PP_member=N">Guest</a> |
			<a href="sseva.php?Seva_cat=Annual&PP_member=Y">Member</a> |
			<a href="sseva.php?Seva_cat=Sammilani&PP_member=YN">Sammilani</a> |	
			<a href="pcpatra.php">Parichaya Patra</a> |		
			<?php
			if(isAllowed($GLOBALS[ROLE_UPPROGRAM])){
			?>
			<a href="fileuploader.html">Upload Program</a> |
			<?php }
			if(isAllowed($GLOBALS[ROLE_SA])){
			?>	
			<a href="adddevotee.php">Add Devotee</a> | 
			<a href="managedevotee.php">Approve</a> | 
			<a href="sseva_report.php">Report</a> |
			<a href='sseva_report_upd.php'>Seva Mukhya(s)</a> |
			<?php }?>			
			<a href="preferences.php">Preferences</a> |
			<a href="logout.php">Logout</a>
			<?php 
}else{
	include 'loginredirect.php';
}
/* draws a calendar */
function draw_calendar($month,$year){
	$months=array('January', 'February', 'March' , 'April' , 'May' , 'June' , 'July' , 'August' , 'September' , 'October' , 'November' , 'December');
	$prevm=0;
	$prevy=0;
	$nextm=0;
	$nexty=0;
	if($month==1){
		$prevm=12;
		$nextm=2;
		$prevy=$year-1;
		$nexty=$year;
	}else if($month==12){
		$prevm=11;
		$nextm=1;
		$prevy=$year;
		$nexty=$year+1;
	}else{
		$prevm=$month-1;
		$nextm=$month+1;
		$prevy=$year;
		$nexty=$year;
	}

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
	$calendar.='<tr><td style="text-align:center;background:#ccc; font-weight:bold;" colspan="7">Dinalipi Calendar<br>'.$_SESSION['display_name'].'</td></tr>';
	$calendar.= '<tr><td class="calendar-day-head"><a href="?mon='.$prevm.'&year='.$prevy.'">&lt;-</a></td>';
	$calendar.= '<td class="calendar-day-head" colspan="3"><a href="report.php?mon='.$month.'&year='.$year.'">'.$months[$month-1].'-'.$year.'</a></td>';
	$calendar.= '<td class="calendar-day-head" colspan="2">';
	$calendar.= '</td>';
	$calendar.= '<td class="calendar-day-head"><a href="?mon='.$nextm.'&year='.$nexty.'">-&gt;</a></td></tr>';

	/* table headings */
	$headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
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
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day">';
			/* add in the day number */
			$calendar.= '<a href="dinalipi.php?Date='.$year.'-'.$month.'-'.$list_day.'">'.$list_day.'</a>';

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			$calendar.= str_repeat('<p> </p>',2);

		$calendar.= '</td>';
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
	if($running_day!=0 && $days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';

	/* all done, return result */
	return $calendar;
}
?>
</div>
</body>
</html>