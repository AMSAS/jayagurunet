<?
require_once("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Password</title>
<script type="text/javascript" src="js/main.js"></script>
<style type="text/css">
	@import url(css/style.css);
</style>
</head>
<body>

<form action="update.php" name="form1" method="post" onsubmit="return ck();">
<table>
<?
echo "<p>Jayaguru <b>{$_SERVER['REMOTE_USER']}.</b></p>";
?>
<tr>
<td>Old Passwd</td>
<td>
<input type="hidden" id="username" name="username" value='<?
echo "{$_SERVER['REMOTE_USER']}";
?>'/>

<input type="password" id="old_passwd" name="old_passwd">*</td>
</tr>
<tr>
<td>New Passwd</td>
<td><input type="password" id="new_passwd" name="new_passwd">*</td>
</tr>
<tr>
<td>Reenter Passwd</td>
<td><input type="password" id="r_new_passwd" name="r_new_passwd">*</td>
</tr>
</table>

<input type="submit" name="submit" value="Update Passwd" onclick="document.all.form1.submit();"/>
</form>
</body>
</html>

