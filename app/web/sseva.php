<?php
	session_start();
	include 'db.php';
	$AmYear = new DateTime('NOW');
	$AmYear->add(new DateInterval('P1M'));
	$Seva_cat='Event';
	if (isset($_REQUEST['Seva_cat'])){
		$Seva_cat=$_REQUEST['Seva_cat'];
	}
	$PP_member='YN';
	if (isset($_REQUEST['PP_member'])){
		$PP_member=$_REQUEST['PP_member'];
	}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles/media-detect.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

.APPLIED {
 background-color: #ffff99;
}
.APPROVED {
 background-color: #16e94b;
}
.DENIED {
 background-color: #996633;
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
		  <a href="index.php"><img src="/images/orgnz.gif"/></a><br>
		  <h4><?php echo $Seva_cat; ?> Seva Application <?php echo $AmYear->format("Y"); ?></h4>
		  <?php
			if (isset($_SESSION['PID'])) {
			if($Seva_cat=='Annual'){?>
		  	<div class="container">
			  <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Choose Pali Week(s)</button>
			  <div id="demo" class="collapse">
			    <iframe src="https://docs.google.com/spreadsheets/d/1qyZ0MTck_8zbT6qdSJ3DNdScE6ac_ecZoQIrA9jT1Ug/edit?usp=sharing&ui=2&chrome=false&rm=demo&range=A1:C53#gid=0" style="border-width:0" width="500" height="500" frameborder="0" scrolling="no"></iframe>
			  </div>
			</div>
		  <?php }
				if($_SERVER['REQUEST_METHOD']=='POST'){
					if($Seva_cat!='Sammilani'){
						$query = "insert into Pledge_xn(Pledge_year,Family_id,Pledge_amt) values(YEAR(CURDATE() + INTERVAL 1 MONTH),'".$_POST['Family_id']."',".$_POST['Pledge_amt'].") ON DUPLICATE KEY UPDATE Pledge_amt=".$_POST['Pledge_amt'];
						//echo $query;
						mysql_query($query);
					}

					//Update existing records
					$query="update Seva_xn set transtate=0 where Sammilani_year=YEAR(CURDATE() + INTERVAL 1 MONTH)
							and Seva_id in (select Seva_id from Seva_master where Seva_cat='".$Seva_cat."')
							and Devotee_id in (select fm.Devotee_id from Devotee as fm,Devotee as ind
							where fm.Family_id=ind.Family_id and locate(fm.PP_member,'".$PP_member."')<>0 and ind.Devotee_id=".$_SESSION['PID'].")";
					//echo $query."<br>\n";
					$results=mysql_query($query);

					foreach( $_POST['Seva'] as $D_id ) {
						$position = strpos($D_id,"_");
						$Seva_id = substr($D_id,0,$position);
						$Devotee_id = substr($D_id,$position+1);
						$query="insert into Seva_xn(Sammilani_year,Seva_id,Devotee_id,transtate) values(YEAR(CURDATE() + INTERVAL 1 MONTH),".$Seva_id.",".$Devotee_id.",1)";
						//echo $query."<br>\n";
						$results=mysql_query($query);
						if(!$results){
							$query="update Seva_xn set transtate=1 where Sammilani_year=YEAR(CURDATE() + INTERVAL 1 MONTH)and Seva_id=".$Seva_id." and Devotee_id=".$Devotee_id;
							//echo $query."<br>\n";
							$results=mysql_query($query);
						}
					}


					//Delete records where applicant has unapplied for the Seva(previously applied)
					$query="delete from Seva_xn where transtate=0
							and Sammilani_year=YEAR(CURDATE() + INTERVAL 1 MONTH)
							and Seva_id in (select Seva_id from Seva_master where Seva_cat='".$Seva_cat."')
							and Devotee_id in (select fm.Devotee_id from Devotee as fm,Devotee as ind
							where fm.Family_id=ind.Family_id and locate(fm.PP_member,'".$PP_member."')<>0 and ind.Devotee_id=".$_SESSION['PID'].")";
					//echo $query."<br>\n";
					$results=mysql_query($query);
				}



				$member_query="select fm.* from Devotee as fm,Devotee as ind
								where fm.Family_id=ind.Family_id and locate(fm.PP_member,'".$PP_member."')<>0
								and ind.Devotee_id=".$_SESSION['PID']." and
								exists(select 1 from Seva_xn as xn,Seva_master as sm where sm.Seva_id=xn.Seva_id and sm.Seva_cat='".$Seva_cat."'
								and fm.Devotee_id=xn.Devotee_id and xn.Sammilani_year=YEAR(CURDATE() + INTERVAL 1 MONTH))";

				//echo $member_query."<br>\n";
				$member_results=mysql_query($member_query);
				if($member_results){
					while($member_row = mysql_fetch_assoc($member_results)) {
						echo "<h4>Submitted Application: <a target='_win".$member_row['Devotee_id']."' href='".$Seva_cat.".php?First_name=".$member_row['First_name']."&Last_name=".$member_row['Last_name']."&Seva_cat=".$Seva_cat."&Devotee_id=".$member_row['Devotee_id']."'>".$member_row['Pref_name']."</a></h4>\n";
					}
				}
				$logged_in_id = $_SESSION['PID'];
				//$logged_in_id = 1;
				$user_query= "select fm.Devotee_id,fm.Pref_name,sm.*,xn.Devotee_id xn_devotee,xn.Status xn_status FROM Seva_master as sm
							join Devotee as fm
							join Devotee as ind
							left outer join Seva_xn as xn on (sm.Seva_id=xn.Seva_id and xn.Devotee_id=fm.Devotee_id and xn.Sammilani_year=YEAR(CURDATE() + INTERVAL 1 MONTH))
							where sm.Seva_cat='".$Seva_cat."'
							and fm.Family_id=ind.Family_id and locate(fm.PP_member,'".$PP_member."')<>0 and ind.Devotee_id=".$logged_in_id."
							order by sm.Seva_id,fm.Devotee_id ";

				//echo $user_query."<br>\n";

				$user_results = mysql_query($user_query);

				$pledge_query = "select d.Family_id,p.Pledge_year,p.Pledge_amt from Devotee as d left join Pledge_xn p on d.Family_id=p.Family_id where d.Devotee_id=".$logged_in_id." order by p.Pledge_year desc";

				//echo $pledge_query."<br>\n";
				$pledge_results = mysql_fetch_assoc(mysql_query($pledge_query));

				$submit_button='Submit';
				$app_count = 0;
				if($user_results){?>
					<table class='alignCenter' cellspacing='0' cellpadding='0'>
					<form method='post'>
					<tr><td><b>Seva Name</b></td>
				<?php
					$app_count = 0;
					$prev_seva_id = -1;
					while($user_row = mysql_fetch_assoc($user_results)) {
						if($prev_seva_id == -1 || $prev_seva_id==$user_row['Seva_id']){
							$prev_seva_id= $user_row['Seva_id'];
							$app_count=$app_count+1;?>
							<td><b><?=$user_row['Pref_name']?></b></td>
							<?php
							continue;
						}
						break;
					}?>
					</tr>
					<?php if($Seva_cat!='Sammilani'){?>
					<tr><td><b>Pledge Amount:</b></td><td colspan='<?=$app_count?>'>
					<input type='hidden' name='Family_id' value='<?=$pledge_results['Family_id']?>'/>
					<input type='number' name='Pledge_amt' title='Previously known contribution is automatically populated' value='<?=$pledge_results['Pledge_amt']?>' step=".01" <?=(!isset($pledge_results['Pledge_amt'])||date('n')==12)?'required':'readonly' ?>/>
					</td></tr>
					<?php
					}
					mysql_data_seek($user_results, 0);
					$prev_seva_id = -1;
					while($user_row = mysql_fetch_assoc($user_results)) {
						if($prev_seva_id==-1){
							echo "<tr><td><b>".$user_row['Seva_name']."</b></td>";
						}else if($user_row['Seva_id']<>$prev_seva_id){
							echo "</tr>\n<tr><td><b>".$user_row['Seva_name']."</b></td>";
						}
						$xn_devotee = $user_row['xn_devotee'];
						$xn_readonly = $user_row['Seva_id']==23?'return false':'';
						if(isset($xn_devotee)||$user_row['Seva_id']==23){
							echo "\n<td onclick='".$xn_readonly."' class='".$user_row['xn_status']."'><input type='checkbox' name='Seva"."[]' value='".$user_row['Seva_id']."_".$user_row['Devotee_id']."' checked></td>";
						}else{
							echo "\n<td><input type='checkbox' name='Seva"."[]' value='".$user_row['Seva_id']."_".$user_row['Devotee_id']."'></td>";
						}
						$prev_seva_id = $user_row['Seva_id'];
					}
					echo "</tr>\n";
					echo "<tr><td colspan='".$app_count."'><span class='APPLIED'>applied</span> <span class='APPROVED'>approved</span> <span class='DENIED'>denied</span></td><td colspan='1'><input type='submit' value='Save'></input></td><tr>\n";
					echo "</form>\n";
					echo "</table>";
				}
			}else{
		  		include 'loginredirect.php';
			}
		?>
		</div>
	</body>
</html>