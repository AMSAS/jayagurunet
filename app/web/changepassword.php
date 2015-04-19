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
  <table class='calendar'>
	  <form name='change_pwd' method='POST'>
	  
	  <?php
			include_once "templates/base.php";
			session_start();
			
			if (isset($_POST['email'])) {
				include 'db.php';
				if (isset($_POST['forgot'])) {
					$headers = "From: admin@jayaguru.net\r\n";
					$headers.= "Reply-To: admin@jayaguru.net\r\n";
					$headers.= "MIME-Version: 1.0\r\n";
					$headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					$select_query = "select * from Devotee where EmailId='" . $_POST['email'] . "'";
					$user_results = mysql_query($select_query);
					if($user_results){
						while($user_row = mysql_fetch_array($user_results)) {
							mail($_POST['email'],$user_row['Share_security'],'Subject line is your jayaguru.net password',$headers);
							?>
							<tr><td colspan='2'><a href='index.php'>Check your mailbox and login</a></td></tr>
							<?php
						}
					}else{
						?>
						<tr><td colspan='2'>Something went wrong contact admin@jayaguru.net</td></tr>
						<?php
					}
				}else{
					if(strlen($_POST['new_password'])>=8 && $_POST['new_password']==$_POST['vfy_password']){
						$user_query = "update Devotee set Share_security='" . $_POST['new_password'] . "' where EmailId='" . $_POST['email'] . "' and Share_security='" . $_POST['old_password'] . "'";
						$user_results = mysql_query($user_query);
						if($user_results){
						?>
							<tr><td colspan='2'><a href='index.php'>Password changed login with your new password</a></td></tr>
						<?php	
						}
					}else{
						?>
						<tr><td colspan='2'>Passwords does not match or less than 8 characters</td></tr>
						<?php
					}
				}
			}
		?>

		  <tr><td>User Id:</td><td><input size='50' name='email' type='email'/></td></tr>		  
		  <tr><td>Forgot Password:</td><td><input type='checkbox' name='forgot' value='forgot'/></td></tr>
		  <tr><td>Old Password:</td><td><input size='50' name='old_password' type='password'/></td></tr>
		  <tr><td>New Password:</td><td><input size='50' name='new_password' type='password'/></td></tr>
		  <tr><td>Verify Password:</td><td><input size='50' name='vfy_password' type='password'/></td></tr>
		  <tr><td colspan='2' align='right'><input value='Submit' type='Submit'/></td></tr>
	  </form>
  </table>
</div>
</body>
</html>