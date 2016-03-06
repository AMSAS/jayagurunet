<?php
include_once "templates/base.php";
session_start();
//Save the URI to redirect to post login
if(!isset($_SESSION['redirect_uri'])){
	$_SESSION['redirect_uri'] = "http://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
}
include 'db.php';

if(isset($_POST['email']) && isset($_POST['password'])){
	$select_query = "select * from Devotee where EmailId='" . $_POST['email'] . "' and Share_security='". $_POST['password']."'";
	$user_results = mysql_query($select_query);
	if($user_results){
		while($user_row = mysql_fetch_array($user_results)) {
			$_SESSION['display_name'] = $user_row['Pref_name'];
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['PID']=$user_row['Devotee_id'];
			$_SESSION['SANGHA_ID']=$user_row['Sangha_id'];
			$_SESSION['ROLE']=$user_row['Roles'];
			$_SESSION['FAM_PRI_CONTACT']=$user_row['Fam_Pri_contact'];
		}
	}
}
if (!isset($_SESSION['email'])) {
	require_once realpath(dirname(__FILE__) . '/../autoload.php');

	$client_id = '897609852685-u4ch2pnjnt3bnpuhas42canr1svclafc.apps.googleusercontent.com';
	$client_secret = 'GJHc08_u05oQR3jLqbdOdDM4';
	$redirect_uri = 'http://jayaguru.net/app/web/loginredirect.php';

	$client = new Google_Client();
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);
	$client->setScopes("openid email profile");



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
<?php
if (isset($authUrl)) {
?>

<div style="text-align:center">
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
	</style>
  <a class='login' href='<?php echo $authUrl; ?>'><img src='sign-in-with-google.png' alt='Click here to login Via Google'/></a><br>
  <br>
  <br>
  <br>
  <h1 style="font-size:30px">OR</h1>
  <br>
  <br>
  <table class='calendar'>
	  <form method='POST'>
		  <tr><td colspan='2'>Login with your <a href='changepassword.php'>jayaguru.net account</a></td></tr>
		  <tr><td>User Id:</td><td><input size='50' name='email' type='email'/></td></tr>
		  <tr><td>Password:</td><td><input size='50' name='password' type='password'/></td></tr>
		  <tr><td colspan='2' align='right'><input value='Submit' type='Submit'/></td></tr>
	  </form>
  </table>  
</div>
<?php
}else{
	$user_query = "select * from Devotee where EmailId='" . $_SESSION['email'] . "'";
	$user_results = mysql_query($user_query);
	if($user_results){
		$user_exists = false;
		if($user_results){
			while($user_row = mysql_fetch_array($user_results)) {
				$_SESSION['PID']=$user_row['Devotee_id'];
				$_SESSION['SANGHA_ID']=$user_row['Sangha_id'];
				$_SESSION['ROLE']=$user_row['Roles'];
				$_SESSION['FAM_PRI_CONTACT']=$user_row['Fam_Pri_contact'];
				$_SESSION['PP_MEMBER']=$user_row['PP_member'];
				$user_exists = true;
			}
		}
		if($user_exists){
			$temp_uri=$_SESSION['redirect_uri'];
			unset($_SESSION['redirect_uri']);
			header("Location: ".$temp_uri);
		}else{
			echo ("Welcome:");
			echo ($_SESSION['display_name']);
			echo ("<br>");
			echo "We know who you are, Please contact admin@jayaguru.net for access with your Email ID:"+$_SESSION['email'];
		}
	}else{
			echo ("Welcome:");
			echo ($_SESSION['display_name']);
			echo ("<br>");
			echo ("Database is unreachable. Please try again later or contact admin@jayaguru.net");
	}
}
?>