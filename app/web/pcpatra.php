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
	background: #17D654;
}

input {
	display: block;
}
</style>

<style>
* {
	font-family: Arial, "Times New Roman", Times, serif;
	font-size: 12px;
}

table {
	border-collapse: collapse;
}

table,td,th {
	border: 1px solid black;
}

.alignCenter {
	margin-left: auto;
	margin-right: auto;
}

td.alignRight {
	text-align: right;
}

input[type="text"] {
	width: 100px;
}

input[type="number"] {
	width: 100px;
}

select {
	width: 100px;
}
</style>

</head>
<body width="100%">
	<div style="text-align: center">
        <a href="index.php"><img src="/images/orgnz.gif"/></a><br>
		<?php
		session_start();
		setlocale(LC_MONETARY,"en_US");
		include 'db.php';

		$AmYear = new DateTime('NOW');
		$AmYear->add(new DateInterval('P1M'));
		?>
		<h4>
			Parichaya Patra Application
			<?=$AmYear->format("Y")?>
		</h4>

		<?php
		if (isset($_SESSION['PID'])) {
			//var_dump($_SERVER);
			if(isset($_POST['Parichaya_patra'])){
				$index=0;
				foreach( $_POST['Devotee_id'] as $D_id ) {
					$query="delete from Parichaya_patra where Devotee_id=".$D_id. " and PP_year=".$_POST['PP_year'][$index];
					//echo $query."<br>\n";
					$results=mysql_query($query);
					$index=$index+1;
				}
			?>
  		  	<div class="container">
			  <div class="well">
			  		Grihasana Renewal(if applicable): <a href='https://docs.google.com/document/d/1WSviDCsqFsg13AHTEwJp8hXuAJaXz8_7LVIGvALdjrE/copy?ts=58ab042d&title=<?=$_SESSION['display_name']?>_<?=$AmYear->format("Y")?>_Grihasana' target='_new'><strong>Submit</strong></a>
			  		OR <a href='https://docs.google.com' target='_new'> <strong>Edit</strong> (if already created) </a> the application and share it with Secretary/President.
   			  </div>
			</div>
			<ul style="list-style-type:none">
			<?php
				$printpage="pcpatraalt.html";
				/*if (strpos($_SERVER['HTTP_USER_AGENT'],'Windows NT 6.1') !== false) {
				 $printpage="pcpatraweb.htm";
				}*/
				$index=0;
				$totalAmount = 0.00;
				foreach( $_POST['Devotee_id'] as $D_id ) {
					$query=insertPPQuery($index);
					//echo $query."<br>\n";
					$results=mysql_query($query);
					if($results){
						$applicant = mysql_query("select First_name,Last_name from Devotee where Devotee_id=".$D_id);
						if($applicant){
							while($one_applicant = mysql_fetch_assoc($applicant)) {
								if($_POST['Parichaya_patra'][$index]!='0'){
									echo "<li><a target='Devotee".$D_id."' href='".$printpage."?First_name=".urlencode($one_applicant['First_name'])."&Last_name=".$one_applicant['Last_name'];
									echo "&A11=".$_POST['Musti_Bhikhyaa'][$index].".00";
									echo "&A12=".$_POST['Gruhaasana'][$index].".00";
									echo "&A13=".$_POST['Janmotsaba'][$index].".00";
									echo "&A14=".$_POST['Kendra_Unnayana'][$index].".00";
									echo "&A15=".$_POST['Nirmana'][$index].".00";
									echo "&A16=".$_POST['Aabaahaka'][$index].".00";
									echo "&A17=".$_POST['Sammilani_Daily_seba'][$index].".00";
									echo "&A18=".$_POST['Misc_pranami'][$index].".00";
									echo "'><span class='glyphicon glyphicon-print'> ".$one_applicant['First_name']." ".$one_applicant['Last_name']."=".money_format('%.2n',floatval($_POST['PP_Total'][$index]))."</span></a></li>";
								}else{
									echo "<li><span class='glyphicon glyphicon-print'> ".$one_applicant['First_name']." ".$one_applicant['Last_name']."=".money_format('%.2n',floatval($_POST['PP_Total'][$index]))."</span></li>";
								}
								$totalAmount = $totalAmount + $_POST['PP_Total'][$index];
							}
						}
					}
					$index=$index+1;
				}

				echo "</ul><h4>TOTAL AMOUNT DUE: $".round($totalAmount).".00</h4>";
				echo "<hr>";
			}
			$POPULATE_YEAR=$AmYear->format("Y");
			if(isset($_GET['autofill'])){
			$POPULATE_YEAR=$_GET['autofill'];
		}
		$user_query= "SELECT Devotee.Devotee_id LT_Devotee_id,Gender,First_name,Value Exch_Rate,Parichaya_patra.*
					FROM Devotee JOIN Exchange_rate ON Exchange_rate.PP_year=".$AmYear->format("Y")."
					LEFT OUTER JOIN Parichaya_patra ON Devotee.Devotee_id=Parichaya_patra.Devotee_id and Parichaya_patra.PP_year=".$POPULATE_YEAR."
					WHERE Devotee.Family_id=(select Family_id from Devotee where Devotee_id=".$_SESSION['PID'].") order by Fam_Pri_contact desc,First_name asc";
		//$user_query.= "where Devotee.Family_id=(select Family_id from Devotee where Devotee_id=1) order by Fam_Pri_contact desc,First_name asc";
		//echo $user_query;
		$user_results = mysql_query($user_query);
		$submit_button='Submit';
		if($user_results){
			?>

		<table class='alignCenter' cellspacing='0' cellpadding='0'>
			<form class='validate-form' onsubmit='javascript:subTotal(event)'
				action='pcpatra.php' method='post'>
				<tr>
					<td><b>Name</b>
					</td>
					<?php
					$app_count = 0;
					$Exch_Rate = 0.00;
					while($user_row = mysql_fetch_assoc($user_results)) {
			?>
					<td><input type='hidden' name='Exch_Rate[]'
						value='<?=($Exch_Rate=$user_row['Exch_Rate'])?>' disabled /> <input
						type='hidden' name='Devotee_id[]'
						value='<?=$user_row['LT_Devotee_id']?>' /> <input type='hidden'
						name='PP_year[]' value='<?=$AmYear->format("Y")?>'/> <b><?=$user_row['First_name']?>
					</b>
					</td>
					<?php
					$app_count=$app_count+1;
			}
			?>
				</tr>

				<tr>
					<td>Parichaya Patra (&#x20B9 0/110)</td>

					<?php
					mysql_data_seek($user_results, 0);
					while($user_row = mysql_fetch_assoc($user_results)) {
			?>
					<td><input required pattern='0|110' type='text'
						title='Enter 110 OR 0 if not applying' name='Parichaya_patra[]'
						value='<?=$user_row['Parichaya_patra']?>'></input>
					</td>

					<?php
			}
			?>
				</tr>

				<tr>
					<td>Aabaahaka (&#x20B9 126)</td>

					<?php
					mysql_data_seek($user_results, 0);
					while($user_row = mysql_fetch_assoc($user_results)) {
			?>
					<td><input required pattern='0|126' type='text'
						title='Enter 0 or 126' name='Aabaahaka[]'
						value='<?=$user_row['Aabaahaka']?>'></input>
					</td>

					<?php
			}
			?>
				</tr>
				<tr>
					<td>Sammilani Daily Sebaa (&#x20B9 1101)</td>

					<?php
					mysql_data_seek($user_results, 0);
					while($user_row = mysql_fetch_assoc($user_results)) {
			?>
					<td><input required pattern='0|1101' type='text'
						title='Enter 0 or 1101' name='Sammilani_Daily_seba[]'
						value='<?=$user_row['Sammilani_Daily_seba']?>'></input>
					</td>

					<?php } ?>
				</tr>

				<tr>
					<td>Kutira Pali (Maa's) (&#x20B9)</td>

					<?php
					mysql_data_seek($user_results, 0);
					while($user_row = mysql_fetch_assoc($user_results)) {
				if($user_row['Gender']=="M"){ ?>
					<td><input type='text' name='Kutira_pali[]' value='0' readonly></input>
					</td>
					<?php
				}else{
				?>
					<td><select name='Kutira_pali[]'>
							<option value='0'
							<?=$user_row['Kutira_pali']=="0"?'selected':''?>>NA</option>
							<option value='151'
							<?=$user_row['Kutira_pali']=="151"?'selected':''?>>151 Weekly
								Recurring</option>
							<option value='252'
							<?=$user_row['Kutira_pali']=="252"?'selected':''?>>252 Weekly
								New</option>
							<option value='501'
							<?=$user_row['Kutira_pali']=="501"?'selected':''?>>501 Monthly
								Recurring</option>
							<option value='602'
							<?=$user_row['Kutira_pali']=="602"?'selected':''?>>602 Monthly
								New</option>
					</select>
					</td>
					<?php
				}
			}
			?>
				</tr>
				<tr>
					<td>Sangha Sebaka ($ 20)</td>

					<?php
					mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
					<td><input required pattern='0|20' type='text'
						title='Enter 0 or 20' name='Sangha_sebaka[]'
						value='<?=$user_row['Sangha_sebaka']?>'></input>
					</td>
					<?php }
					?>
				</tr>

				<tr>
					<td>Musti Bhikhyaa ($ 25)</td>

					<?php
					mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
					<td><input required pattern='0|25' type='text'
						title='Enter 0 or 25' name='Musti_Bhikhyaa[]'
						value='<?=$user_row['Musti_Bhikhyaa']?>'></input>
					</td>

					<?php }
					?>
				</tr>

				<tr>
					<td>Gruhaasana ($)</td>

					<?php
					mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
					<td><input required min='0' max='9999' type='number'
						name='Gruhaasana[]' value='<?=$user_row['Gruhaasana']?>'></input>
					</td>
					<?php }
					?>
				</tr>

				<tr>
					<td>Janmotsaba ($)</td>

					<?php
					mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
					<td><input required min='0' max='9999' type='number'
						name='Janmotsaba[]' value='<?=$user_row['Janmotsaba']?>'></input>
					</td>
					<?php }
					?>
				</tr>

				<tr>
					<td>Kendra Unnayana ($)</td>

					<?php
					mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
					<td><input required min='0' max='9999' type='number'
						name='Kendra_Unnayana[]' value='<?=$user_row['Kendra_Unnayana']?>'></input>
					</td>
					<?php }
					?>
				</tr>

				<tr>
					<td>NirmaaNa ($)</td>

					<?php
					mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) {?>
					<td><input required min='0' max='9999' type='number'
						name='Nirmana[]' value='<?=$user_row['Nirmana']?>'></input>
					</td>

					<?php }
					?>
				</tr>
				<tr>
					<td>Sammilani Saahaajya ($)</td>

					<?php
					mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
					<td><input required min='0' max='9999' type='number'
						name='Sammilani_sahajya[]'
						value='<?=$user_row['Sammilani_sahajya']?>'></input>
					</td>

					<?php }
					?>
				</tr>

				<tr>
					<td>Naaraayana Sebaa ($)</td>

					<?php
					mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
					<td><input required min='0' max='9999' type='number'
						name='Narayana_sebaa[]' value='<?=$user_row['Narayana_sebaa']?>'></input>
					</td>

					<?php }
					?>
				</tr>

				<tr>
					<td>Webcast ($)</td>

					<?php
					mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
					<td><input required min='0' max='9999' type='number'
						name='Webcast[]' value='<?=$user_row['Webcast']?>'></input>
					</td>

					<?php }
					?>
				</tr>

				<tr>
					<td>Nitya Pujaa ($)</td>

					<?php
					mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
					<td><input required min='0' max='9999' type='number'
						name='Nitya_Puja[]' value='<?=$user_row['Nitya_Puja']?>'></input>
					</td>

					<?php }
					?>
				</tr>

				<tr>
					<td>Bidyaa Nidhi ($)</td>

					<?php
					mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
					<td><input required min='0' max='9999' type='number'
						name='Bidhyaa_nidhi[]' value='<?=$user_row['Bidhyaa_nidhi']?>'></input>
					</td>

					<?php
			}
			?>
				</tr>

				<tr>
					<td>Swaasthya Sebaa ($)</td>

					<?php
					mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
					<td><input required min='0' max='9999' type='number'
						name='Swaasthya_seba[]' value='<?=$user_row['Swaasthya_seba']?>'></input>
					</td>

					<?php }
					?>
				</tr>

			<tr>
				<td>Sammilani Baalya ($)</td>

				<?php
				mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
				<td><input required min='0' max='9999' type='number' maxlength='4'
					name='Sammilani_Baalya[]'
					value='<?=$user_row['Sammilani_Baalya']?>'></input>
				</td>

				<?php }
				?>
			</tr>

			<tr>
				<td>NSS Centenary ($)</td>

				<?php
				mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
				<td><input required min='0' max='9999' type='number' maxlength='4'
					name='Misc_Fund1[]' value='<?=$user_row['Misc_Fund1']?>'></input>
				</td>

				<?php }
				?>
			</tr>

			<tr>
				<td>Nirbikalpa Devl ($)</td>

				<?php
				mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
				<td><input required min='0' max='9999' type='number' maxlength='4'
					name='Misc_Fund2[]' value='<?=$user_row['Misc_Fund2']?>'></input>
				</td>

				<?php }
				?>
			</tr>

			<tr>
				<td>Misc pranaami ($)</td>

				<?php
				mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
				<td><input required min='0' max='9999' type='number' maxlength='4'
					name='Misc_pranami[]' value='<?=$user_row['Misc_pranami']?>'></input>
				</td>

				<?php }
				?>
			</tr>

			<tr>
				<td>PP Total ($)</td>

				<?php
				mysql_data_seek($user_results, 0);
			while($user_row = mysql_fetch_assoc($user_results)) { ?>
				<td><input type='hidden' name='Round_up[]' value='0' /><input
					required min='0' max='9999' type='number' maxlength='4'
					name='PP_Total[]' value='<?=$user_row['PP_Total']?>' readonly></input>
				</td>

				<?php }
				?>
			</tr>

			<tr>
				<td colspan='1'><div
						title='Prepopulate previous year(s) information'>
						<a href='pcpatra.php?autofill=<?=$AmYear->format("Y")-2?>'><?=$AmYear->format("Y")-2?></a> &nbsp;
						<a href='pcpatra.php?autofill=<?=$AmYear->format("Y")-1?>'><?=$AmYear->format("Y")-1?></a> &nbsp;
						<?php if(isset($_GET['autofill'])){ ?>
						<a href='pcpatra.php' title='Prepopulate with current year information(if any saved earlier)'>Current</a>
						<?php } ?>
						</div>
				</td>
				<td colspan='<?=$app_count?>'>
					 	<input class="btn btn-primary btn-xs" type='submit' value='Save & Print (1 USD = <?= $Exch_Rate ?> INR)'<?=($AmYear->format("m")-1)<3?'':' disabled'?>></input>
				</td>
			<tr>


			</form>

		</table>
		<?php
		}
		}else{
			include 'loginredirect.php';
	}

	function insertPPQuery($index){
		$keys= array();
		$values== array();

		foreach($_POST as $key => $value) {
			  $keys[]=$key;
			  $values[]=$value[$index];
		}
		$insertQuery = "insert into Parichaya_patra(Audit_Time,".implode(', ',$keys).") values (NOW(),".implode(', ',$values).")";
		return $insertQuery;
	}
	?>
	</div>
	<script
		src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
	<script>
function hasHtml5Validation () {
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
function subTotal(myEvent){
	var myEl = myEvent.currentTarget.elements;
	var exchRates = myEl.namedItem("Exch_Rate[]");

		//alert(exchRates);
	if(exchRates.length){
		//alert("if");
		processMultiple(myEl,exchRates);
	}else{
		//alert("else");
		processSingle(myEl,exchRates);
	}
}
function processMultiple(myEl,exchRates){
	var famTotal=0.0;
	for(var index=0;index<exchRates.length;index++){
		var pmTot = 0.0;
		var exchRate = exchRates[index].value;
		pmTot=pmTot+parseInt(myEl.namedItem("Parichaya_patra[]")[index].value)/exchRate;
		pmTot=pmTot+parseInt(myEl.namedItem("Aabaahaka[]")[index].value)/exchRate;
		pmTot=pmTot+parseInt(myEl.namedItem("Sammilani_Daily_seba[]")[index].value)/exchRate;
		pmTot=pmTot+parseInt(myEl.namedItem("Kutira_pali[]")[index].value)/exchRate;
		pmTot=pmTot+parseInt(myEl.namedItem("Sangha_sebaka[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Musti_Bhikhyaa[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Gruhaasana[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Janmotsaba[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Kendra_Unnayana[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Nirmana[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Sammilani_sahajya[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Narayana_sebaa[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Webcast[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Nitya_Puja[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Bidhyaa_nidhi[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Swaasthya_seba[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Sammilani_Baalya[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Misc_Fund1[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Misc_Fund2[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Misc_pranami[]")[index].value);
		myEl.namedItem("Round_up[]")[index].value=0;
		myEl.namedItem("PP_Total[]")[index].value=pmTot;
		famTotal = famTotal+ pmTot;
	}
	var leftOver = Math.ceil(famTotal)-famTotal;
	myEl.namedItem("Round_up[]")[0].value = leftOver;
	myEl.namedItem("PP_Total[]")[0].value=parseFloat(myEl.namedItem("PP_Total[]")[0].value)+leftOver;
}

function processSingle(myEl,exchRates){
	var pmTot = 0.0;
	var exchRate = exchRates.value;
	pmTot=pmTot+parseInt(myEl.namedItem("Parichaya_patra[]").value)/exchRate;
	pmTot=pmTot+parseInt(myEl.namedItem("Aabaahaka[]").value)/exchRate;
	pmTot=pmTot+parseInt(myEl.namedItem("Sammilani_Daily_seba[]").value)/exchRate;
	pmTot=pmTot+parseInt(myEl.namedItem("Kutira_pali[]").value)/exchRate;
	pmTot=pmTot+parseInt(myEl.namedItem("Sangha_sebaka[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Musti_Bhikhyaa[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Gruhaasana[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Janmotsaba[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Kendra_Unnayana[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Nirmana[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Sammilani_sahajya[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Narayana_sebaa[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Webcast[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Nitya_Puja[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Bidhyaa_nidhi[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Swaasthya_seba[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Sammilani_Baalya[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Misc_Fund1[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Misc_Fund2[]").value);
	pmTot=pmTot+parseInt(myEl.namedItem("Misc_pranami[]").value);
	myEl.namedItem("Round_up[]").value = Math.ceil(pmTot)-pmTot;
	myEl.namedItem("PP_Total[]").value=Math.ceil(pmTot);
}
</script>
</body>
</html>
