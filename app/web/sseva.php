<?php
	session_start();
	include 'db.php';
?>
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
input[type="number"] {
    width: 100px;
}
select{
    width: 100px;
}
</style>

</head>
	<body width="100%">
		<div style="text-align:center">
		  <h2><a href="http://jayaguru.net/">America Saraswata Sangha</a></h2>
		  <h4>Sammilani Seva Application <?php echo date("Y"); ?></h4>
		<?php
			if (isset($_SESSION['PID'])) {
				if(isset($_POST['Seva'])){					
					//Delete existing records
					$query="delete from Seva_xn where ";
					$query.="Sammilani_year=YEAR(CURDATE()) ";
					$query.="and Devotee_id in (select Devotee_id from Devotee where Family_id=(select Family_id from Devotee where Devotee_id=".$_SESSION['PID']."))";
					//echo $query."<br>\n";
					$results=mysql_query($query);
					
					foreach( $_POST['Seva'] as $D_id ) {
						$position = strpos($D_id,"_");
						$Seva_id = substr($D_id,0,$position);
						$Devotee_id = substr($D_id,$position+1);
						$query="insert into Seva_xn(Sammilani_year,Seva_id,Devotee_id) values(YEAR(CURDATE()),".$Seva_id.",".$Devotee_id.")";
						$results=mysql_query($query);
						//echo $query."<br>\n";
					}
					echo "<h4>Seva Application Saved</h4>\n";
				}
				$logged_in_id = $_SESSION['PID'];
				//$logged_in_id = 1;
				$user_query= "select fm.Devotee_id,fm.Pref_name,sm.*,xn.Devotee_id xn_devotee FROM Seva_master as sm ";
				$user_query.= "join Devotee as fm ";
				$user_query.= "left outer join Seva_xn as xn on (sm.Seva_id=xn.Seva_id and xn.Devotee_id=fm.Devotee_id and xn.Sammilani_year=YEAR(CURDATE())) ";
				$user_query.= "where fm.Family_id=(select ind.Family_id from Devotee as ind where ind.Devotee_id=".$logged_in_id.") ";
				$user_query.= "order by sm.Seva_id,fm.Devotee_id ";
		
				//echo $user_query."<br>\n";
				
				$user_results = mysql_query($user_query);
				$submit_button='Submit';
				$app_count = 0;
				if($user_results){
					echo "<table class='alignCenter' cellspacing='0' cellpadding='0'>";
					echo "<form action='sseva.php' method='post'>\n";
					echo "<tr><td><b>Seva Name</b></td>";
					$app_count = 0;
					$prev_seva_id = -1;
					while($user_row = mysql_fetch_assoc($user_results)) {
						if($prev_seva_id == -1 || $prev_seva_id==$user_row['Seva_id']){
							$prev_seva_id= $user_row['Seva_id'];
							$app_count=$app_count+1;
							echo "<td><b>".$user_row['Pref_name']."</b></td>";
							continue;
						}
						break;
					}
					echo "</tr>";
					
					mysql_data_seek($user_results, 0);
					$prev_seva_id = -1;
					while($user_row = mysql_fetch_assoc($user_results)) {
						if($prev_seva_id==-1){
							echo "<tr><td><b>".$user_row['Seva_name']."</b></td>";
						}else if($user_row['Seva_id']<>$prev_seva_id){
							echo "</tr>\n<tr><td><b>".$user_row['Seva_name']."</b></td>";
						}
						$xn_devotee = $user_row['xn_devotee'];
						if(isset($xn_devotee)){
							echo "\n<td><input type='checkbox' name='Seva"."[]' value='".$user_row['Seva_id']."_".$user_row['Devotee_id']."' checked></td>";
						}else{
							echo "\n<td><input type='checkbox' name='Seva"."[]' value='".$user_row['Seva_id']."_".$user_row['Devotee_id']."'></td>";
						}
						$prev_seva_id = $user_row['Seva_id'];
					}
					echo "</tr>\n";
					echo "<tr><td colspan='1'><a href='sseva_report.php'>Applicants</a> ";
					if(isAllowed($GLOBALS[ROLE_SA])) echo "<a href='sseva_report_upd.php'>Mukhya(s)</a>";
					echo "</td><td colspan='".$app_count."'><input type='submit' value='Save'></input></td><tr>\n";
					echo "</form>\n";
					echo "</table>";
				}
			}else{
		  		echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
			}
		?>
		</div>
	</body>
</html>