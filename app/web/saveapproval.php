<html>
<head>
</head>
	<body>
	<?php
		session_start();
		include 'db.php';
		if (isset($_SESSION['PID']) && isAllowed($GLOBALS[ROLE_SA])) {
			//var_dump($_POST);
			if(isset($_REQUEST['Devotee_id'])){
				$query= updateDevotee();
				//echo $query;
				$results=mysql_query($query);
				if($results){
					echo $_REQUEST['Devotee_id'].$_REQUEST['current_op'].$_REQUEST['Devotee_id'];
				}
			}
		}
		function updateDevotee(){
			$updateQuery="";
			if($_REQUEST['current_op']=='Approve'){
				$updateQuery = "update Seva_xn set Status='APPROVED',Reviewer_id=".$_SESSION['PID']." where Sammilani_year=YEAR(CURDATE() + INTERVAL 1 MONTH) and Devotee_id=".$_REQUEST['Devotee_id']." and Seva_id=".$_REQUEST['Seva_id'];
			}else{
				$updateQuery = "update Seva_xn set Status='DENIED',Reviewer_id=".$_SESSION['PID']." where Sammilani_year=YEAR(CURDATE() + INTERVAL 1 MONTH) and Devotee_id=".$_REQUEST['Devotee_id']." and Seva_id=".$_REQUEST['Seva_id'];
			}
			return $updateQuery;
		}
	?>
	</body>
</html>