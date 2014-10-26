<?php
include_once "templates/base.php";
session_start();
if (!isset($_SESSION['email'])) {
	require_once realpath(dirname(__FILE__) . '/../autoload.php');

	$client_id = '897609852685-u4ch2pnjnt3bnpuhas42canr1svclafc.apps.googleusercontent.com';
	$client_secret = 'GJHc08_u05oQR3jLqbdOdDM4';
	$redirect_uri = 'http://jayaguru.net/app/web/index.php';

	$client = new Google_Client();
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);
	$client->setScopes("openid email profile");

	if (isset($_REQUEST['logout'])) {
	  unset($_SESSION['access_token']);
	}

	if (isset($_GET['code'])) {
	  $client->authenticate($_GET['code']);
	  $_SESSION['access_token'] = $client->getAccessToken();
	  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	}

	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	  $client->setAccessToken($_SESSION['access_token']);
	} else {
	  $authUrl = $client->createAuthUrl();
	}

	if ($client->getAccessToken()) {
		$_SESSION['access_token'] = $client->getAccessToken();
		$plus = new Google_Service_Plus($client);
		$person = $plus->people->get('me');
		//echo ($person->displayName);
		//echo ($person->emails[0]['value']);
		$_SESSION['display_name'] = $person->displayName;
		$_SESSION['email'] = $person->emails[0]['value'];
	}
}
?>
<html>
	<head>
		<style>
			/* calendar */
			table.calendar		{ border-left:1px solid #999; }
			tr.calendar-row	{  }
			td.calendar-day	{ min-height:80px; font-size:11px; position:relative; } * html div.calendar-day { height:80px; }
			td.calendar-day:hover	{ background:#eceff5; }
			td.calendar-day-np	{ background:#eee; min-height:80px; } * html div.calendar-day-np { height:80px; }
			td.calendar-day-head { background:#ccc; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
			div.day-number		{ background:#999; padding:5px; color:#fff; font-weight:bold; float:right; margin:-5px -5px 0 0; width:20px; text-align:center; }
			/* shared */
			td.calendar-day, td.calendar-day-np { width:120px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; }
		</style>
	</head>
<body>
<div class="box">
  <div class="request">
<?php
if (isset($authUrl)) {
  echo "<a class='login' href='" . $authUrl . "'>Click here to login Via Google</a>";
}else{

	include 'db.php';

	$user_query = "select * from Devotee where EmailId='" . $_SESSION['email'] . "'";
	$user_results = mysql_query($user_query);
	if($user_results){
		$user_exists = false;
		if($user_results){
			while($user_row = mysql_fetch_array($user_results)) {
				$_SESSION['PID']=$user_row['Devotee_id'];
				$user_exists = true;
			}
		}
		if($user_exists){
			$today = getdate();
			if(isset($_GET['mon'],$_GET['year'])){
				echo draw_calendar($_GET['mon'],$_GET['year']);
			}else{
				echo draw_calendar($today['mon'],$today['year']);
			}
			//var_dump($_SESSION);
		}else{
			echo ("Welcome:");
			echo ($_SESSION['display_name']);
			echo ("<br>");
			echo "We know who you are, Please contact admin@jayaguru.net for access.";
		}
	}else{
			echo ("Welcome:");
			echo ($_SESSION['display_name']);
			echo ("<br>");
			echo ("Database is unreachable. Please try again later or contact admin@jayaguru.net");
	}
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
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head"><a href="?mon='.$prevm.'&year='.$prevy.'">&lt;-</a></td>';
	$calendar.= '<td class="calendar-day-head" colspan="5">Dinalipi Calendar <br>'.$months[$month-1].'-'.$year.'</td>';
	$calendar.= '<td class="calendar-day-head"><a href="?mon='.$nextm.'&year='.$nexty.'">-&gt;</a></td></tr>';

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
	if($days_in_this_week < 8):
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
</div>
</body>
</html>