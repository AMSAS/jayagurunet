<?php
	session_start();
	include 'db.php';
	$AmYear = new DateTime('NOW');
	$AmYear->add(new DateInterval('P1M'));
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
		  <a href="index.php"><img src="/images/orgnz.gif"/></a><br>
		  <h4>Seva Applicants <?php echo $AmYear->format("Y"); ?></h4>
		<?php
			if (isset($_SESSION['PID'])) {
				$report_query="SELECT IFNULL( GROUP_CONCAT(DISTINCT Seva_master.Seva_cat ORDER BY Seva_master.Seva_cat SEPARATOR ',' ) , '' ) Seva_cat,Seva_master.Seva_name,
							GROUP_CONCAT( IF(Pref_name Not Like '%Maa' And Pref_name Not Like '%Bhai',concat('<br>',Pref_name),'') SEPARATOR '' ) YA,
							GROUP_CONCAT( IF(Pref_name Like '%Maa',concat('<br>',Pref_name),'') SEPARATOR '' ) Sevikas,
							GROUP_CONCAT( IF(Pref_name Like '%Bhai',concat('<br>',Pref_name),'') SEPARATOR '' ) Sevakas,
							GROUP_CONCAT( IF( Seba_mukhya = 'Y', Pref_name, NULL ) SEPARATOR ',' ) Mukhyas
							FROM Seva_xn  JOIN Devotee ON ( Devotee.Devotee_id = Seva_xn.Devotee_id AND Seva_xn.Sammilani_year = YEAR( CURDATE() + INTERVAL 1 MONTH ) )
							RIGHT OUTER JOIN Seva_master ON (Seva_master.Seva_id = Seva_xn.Seva_id )
							GROUP BY Seva_master.Seva_name
							ORDER BY Seva_master.Seva_cat,Seva_master.Seva_id,Seva_master.Seva_name";

				//echo $user_query."<br>\n";
				$report_results = mysql_query($report_query);
				if($report_results){
		?>

					<table class='alignCenter' cellspacing='0' cellpadding='0'>
					<tr><td><b>Seva Cat</b></td><td><b>Seva Name</b></td><td><b>Mukhyas</b></td><td><b>YAs</b></td><td><b>Sevakas</b></td><td><b>Sevikas</b></td></tr>

		<?php
			while($report_row = mysql_fetch_assoc($report_results)) {
		?>
						<tr><td><?php echo $report_row['Seva_cat']; ?></td><td><?php echo $report_row['Seva_name']; ?></td><td><?php echo $report_row['Mukhyas']; ?></td><td><?php echo $report_row['YA']; ?></td><td><?php echo $report_row['Sevakas']; ?></td><td><?php echo $report_row['Sevikas']; ?></td></tr>

		<?php
					}
		?>
					</table>
		<?php
				}
			}else{
		?>
		  		<a href='index.php'>[Session Expired] Visit Landing Page</a>
		<?php
			}
		?>
		</div>
	</body>
</html>