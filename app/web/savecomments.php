<html>
<head>
<link rel="stylesheet" type="text/css" href="styles/media-detect.css">
<meta name="viewport" content="width=480">
<style class="cp-pen-styles">

.invalid input:invalid {
    background: #BE4C54;
}

.invalid input:valid {
    background: #17D654 ;
}

input {
  display: block;
}
</style>

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
.alignCenter {
 margin-left: auto; margin-right: auto;
}

td.alignRight {
 text-align:right;
}

input[type="text"] {
    width: 100px;
}
input[type="email"] {
    width: 200px;
}
</style>

</head>
<body width="100%">
<div style="text-align:center">
  <a href="index.php"><img src="/images/orgnz.gif"/></a><br>
<?php
	session_start();
	include 'db.php';
	if (isset($_SESSION['PID'])) {
		//var_dump($_POST);
		if(isset($_GET['Comment'])){
			$query=addComments();
			//echo $query;
			$results=mysql_query($query);
			echo "<h4>";
			if($results){
				echo "Comment saved successfully";
			}else{
				$query=updateComments();
				//echo $query;
				$results=mysql_query($query);
				if($results){
					echo "Comment updated successfully";
				}else{
					echo "Error updating comment";
				}
			}
			echo "</h4>";
		}
	}else{
  		echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
	}

	function addComments(){
		$insertQuery = "insert into Monthly_comment(Devotee_id,Xn_month,Comment)";
		$insertQuery.= " values('".$_SESSION['PID']."','".$_GET['Xn_month']."','".$_GET['Comment']."')";
		return $insertQuery;
	}

	function updateComments(){
		$updateQuery = "update Monthly_comment set Comment='".$_GET['Comment']."' where Devotee_id='".$_SESSION['PID']."' and Xn_month='".$_GET['Xn_month']."' ";
		return $updateQuery;
	}
?>
</div>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
<script>function hasHtml5Validation () {
  return typeof document.createElement('input').checkValidity === 'function';
}

if (hasHtml5Validation()) {
  $('.validate-form').submit(function (e) {
    if (!this.checkValidity()) {
      e.preventDefault();
      $(this).addClass('invalid');
    } else {
      $(this).removeClass('invalid');
    }
  });
}
</script>
</body>
</html>