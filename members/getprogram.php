<?php
  $syear = $_GET["syear"];
  $smonth = $_GET["smon"];
  $ssel = $_GET["ssel"];
  // ($ssel = 1)  for program dates
  // ($ssel = 2)  for Sadharana sangha bibarani dates
  // ($ssel = 3)  for young aspirants program dates
  // ($ssel = 4)  for young aspirants bibarani dates (reserved)
  // ($ssel = 5)  for mahila program dates
  // ($ssel = 6)  for mahila bibarani dates
  // ($ssel = 7)  for sastrapatha pogram dates
  // ($ssel = 8)  for sastrapatha bibarani dates 9reserved)
  // ($ssel = 9)  for Bhakta list with city,state

  // Get Sangha puja program date
  if (($ssel == "1") || ($ssel == "2") || ($ssel == "3")) {
	// Directories where Puja and Bibarani files are stored
	$root_dir="./";
	if ($ssel == "1") {
	  $puja_dir="/sangha/programs";
	  echo "&nbsp;&nbsp;<b>Program Dates:</b>";
	}
	if ($ssel == "2") {
	  $puja_dir="/sangha/bibaranis";
	  echo "&nbsp;&nbsp;<b>Bibarani Dates:</b>";
	}
	if ($ssel == "3") {
	  $puja_dir="/youngasp_puja/programs";
	  echo "&nbsp;&nbsp;<b>Program Dates:</b>";
	}
	if ($dir_list = opendir($root_dir.$puja_dir)) {
	$count = 0;
	  while(($filename = readdir($dir_list)) != false) {
	  if (($filename != ".") && ($filename != "..") && ($filename != "index.html")) {
		$year = substr($filename, -6, -4);
		$month = substr($filename, -12, -10);
		$day = substr($filename, -9, -7);
		$year = $year + 2000;
		$puja_date = date_create($year."-".$month."-".$day);
		$puja_dates[$count] = date_format($puja_date, "Ymd");
		$puja_files[$count] = $puja_dir."/".$filename;
		$count = $count + 1;
	  }
	  }
	  closedir($dir_list);
	}
	else echo("invalid directory  ".$root_dir.$puja_dir);
	// sort array and get dates from array
	$prog_array = array_combine($puja_dates,$puja_files);
    krsort($prog_array,SORT_NUMERIC);
	$count = 0;
	$mmon = 'N';
	$chmonth = "";
	$chyear = "";
	if ($syear == "9999") {
	  foreach ($prog_array as $key => $val) {
        $year = substr($key, 0, 4);
	    $month = substr($key, 4, 2);
        $day = substr($key, -2);
	    $yyr = substr($year, 2, 2);
	    if ($chyear != $year) {
	      $chyear = $year;
		  $chmonth = $month;
		  echo "<br/>&nbsp;&nbsp;&nbsp;<b>" . $year . "</b><br/>";
	    }
	    if ($chmonth != $month) {
		  echo "<br/>" ;
		  $chmonth = $month;
	    }
	    echo "&nbsp;&nbsp;&nbsp;<a href=\".".$val."\">".$month."/".$day."/".$yyr."</a>";
	  }
	}
	else
	{
  	  foreach ($prog_array as $key => $val) {
	    $year = substr($key, 0, 4);
	    $month = substr($key, 4, 2);
	    if (($syear == $year) && (($smonth == $month) || ($smonth == "99"))) {
	      $day = substr($key, -2);
		  $yyr = substr($year, 2, 2);
		  if ($chmonth != $month) {
		    echo "<br/>" ;
		    $chmonth = $month;
		  }
		  echo "&nbsp;&nbsp;&nbsp;<a href=\".".$val."\">".$month."/".$day."/".$yyr."</a>";
		  $mmon = 'Y';
	    }
	    else 
	    if ($mmon == 'Y') break;
	  }
	}
  }


  // 5 = Get Mahila puja program date
  // 6 = Get Mahila puja bibarani date
  if (($ssel == "5") || ($ssel == "6")) {
  
  // Directories where Puja and Bibarani files are stored
  $root_dir="./";
  if ($ssel == "5") {
	$puja_dir="/mahila_puja/programs";
	echo "&nbsp;&nbsp;&nbsp;Program Dates:<br/>";
  }
  if ($ssel == "6") {
	$puja_dir="/mahila_puja/bibarani";
	echo "&nbsp;&nbsp;&nbsp;Bibarani Dates:<br/>";
  }
  if ($dir_list = opendir($root_dir.$puja_dir)) {
	$count = 0;
	while(($filename = readdir($dir_list)) !== false) {
	  if (($filename !== ".") and ($filename !== "..") && ($filename != "index.html")) {
		$year = substr($filename, -6, -4);
		$month = substr($filename, -12, -10);
		$day = substr($filename, -9, -7);
		$year = $year + 2000;
		$puja_date = date_create($year."-".$month."-".$day);
		$puja_years[$count] = $year;
		$puja_dates[$count] = date_format($puja_date, "Ymd");
		$puja_files[$count] = $puja_dir."/".$filename;
		$count = $count + 1;
	  }
	}
	closedir($dir_list);
  }
  $prog_array = array_combine($puja_dates,$puja_files);
  krsort($prog_array,SORT_NUMERIC);
  $uniq_years = array_unique($puja_years);
  arsort($uniq_years);
  $count = 0;
  foreach ($prog_array as $key => $val) {
	$year = substr($key, 0, 4);
	$month = substr($key, 4, 2);
	$day = substr($key, -2);
	//if ($syear == $year) {
	  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\".".$val."\">".$month."-".$day."-".$year."</a>";
	  $count = $count + 1;
	//}
	if ($count==8) { echo "<br/>"; $count = 0;  }
  }
    //echo "<br/>"; $count = 0;
  }
  
  // 7 = Get Sastrapatha program date
  if ($ssel == "7") {
  echo "&nbsp;&nbsp;&nbsp;Program Dates:<br/>";
  
  // Directories where Puja and Bibarani files are stored
  $root_dir="./";
  $puja_dir="/Sastra/Program";
  if ($dir_list = opendir($root_dir.$puja_dir)) {
	$count = 0;
	while(($filename = readdir($dir_list)) !== false) {
	  if (($filename !== ".") and ($filename !== "..") && ($filename != "index.html")) {
		$year = substr($filename, -6, -4);
		$month = substr($filename, -12, -10);
		$day = substr($filename, -9, -7);
		$year = $year + 2000;
		$puja_date = date_create($year."-".$month."-".$day);
		$puja_years[$count] = $year;
		$puja_dates[$count] = date_format($puja_date, "Ymd");
		$puja_files[$count] = $puja_dir."/".$filename;
		$count = $count + 1;
	  }
	}
	closedir($dir_list);
  }
  $prog_array = array_combine($puja_dates,$puja_files);
  krsort($prog_array,SORT_NUMERIC);
  $uniq_years = array_unique($puja_years);
  arsort($uniq_years);
  $count = 0;
  foreach ($prog_array as $key => $val) {
	$year = substr($key, 0, 4);
	$month = substr($key, 4, 2);
	$day = substr($key, -2);
	if ($syear == $year) {
	  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\".".$val."\">".$month."-".$day."-".$year."</a>";
	  $count = $count + 1;
	}
	if ($count==7) { echo "<br/>"; $count = 0;  }
  }
  }

  
  // 9 = Get Bhakta list by city,state
  if ($ssel == "9") {
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" width=\"630\" class=\"tabtext\" >";
	if (file_exists('bhaktalist.xml'))  {
	  $xml = simplexml_load_file("bhaktalist.xml");
	  if (!$xml){
		echo "< Oops! The file input is malformed! >";
	  }
	}
	else {	exit('< File existance Error. >');
	}
	foreach($xml->children() as $child) {
	  echo "<tr>";
	  echo "<td width=\"200\">";
	  $ct = trim($child->city);
	  if ($ct == "")
	    echo $child->state ;
	  else echo $ct . ", " . $child->state;
	  echo "</td >";
	  echo "<td >";
	  echo $child->name;
	  echo "</td >";
  	  echo "</tr>";
	}
    echo "</table>";
  }

  // 10 = Get Special Puja Program
  if ($ssel == "10") {
	  // $syear gets year as ALL (9999)
	  // $smonth gets directory
	  // $ssel gets selectione $_GET["ssel"];
	// Janma Utsava text  
	if ($smonth == "janma") {
	  echo "<h2 style=\"text-align: center; font : 18px Calibri; font-weight: bold; color: #e7660c;\">Janma Utsava</h2>";
	  echo "<p style=\"padding-left: 15px; text-indent: 40px; font : 14px Calibri; line-height: 16pt; color: #303030;\">Janmostava i.e. Birthday of ShriShriThakura coincides with Hindu festival Rakshya Bandhan. On this day of Lunar calander ShriShriThakura was born 
			  to a virtuous bramhin couple at Qutabpur in Nadia district (now in Bangladesh). Nilachala Saraswata Sangha, 
			  Puri, along with it's branches, Asana Mandiras, and all devotees at their home, celebrate this auspicious 
			  day as grand festival. </p>";
	  echo "<FORM METHOD=\"POST\" ACTION=\"Inaccessible\" style=\"padding-left: 15px; font : 14px Calibri; color: #303030;\">";
	  echo "The Programs for Janmotsava, sangha puja session: &nbsp;&nbsp;&nbsp;";
	  echo "<SELECT NAME=\"program\" style=\"font : 13px Calibri; color: #d55d0b;\">";
	  //echo "<OPTION SELECTED VALUE=\"#\">Select Year";
	}
	
	// Raasa Purnima text  
	if ($smonth == "raasa") {
	  echo "<h2 style=\"text-align: center; font : 18px Calibri; font-weight: bold; color: #e7660c;\">Raasa Purnima</h2>";
	  echo "<p style=\"padding-left: 15px; text-indent: 40px; font : 14px Calibri; line-height: 16pt; color: #303030;\">'Raasa-Utsava' has been derived from 'Raasa leela' of ShriKrishna; is being celebrated by Nilachala 
			  Saraswata Sangha, Puri on auspicious month of 'Kartik' in the Hindu calendar. The 'Raasa Purnima' which 
			  is named by 'Raasa leela' of ShriKrishna comes in month of Sarat, a month before Kartik. </p>";
	  echo "<FORM METHOD=\"POST\" ACTION=\"Inaccessible\" style=\"padding-left: 15px; font : 14px Calibri; color: #303030;\">";
	  echo "The Programs for Raasa Purnima, sangha puja session: &nbsp;&nbsp;&nbsp;";
	  echo "<SELECT NAME=\"program\" style=\"font : 13px Calibri; color: #d55d0b;\">";
	  //echo "<OPTION SELECTED VALUE=\"#\">Select Year";
	}
	
	// Sangha Annual Day text  
	if ($smonth == "annual") {
	  echo "<h2 style=\"text-align: center; font : 18px Calibri; font-weight: bold; color: #e7660c;\">Sangha Annual Day</h2>";
	  echo "<p style=\"padding-left: 15px; text-indent: 40px; font : 14px Calibri; line-height: 16pt; color: #303030;\">
	        Nilachala Saraswata Sangha, Puri, President and Parichalak (Adminster), Shri Shyam Sunder Dash, approved 'America Saraswata Pathachakra' as 'America Saraswata Sangha' in Sept 2003, . 
			The first session of the Sangha was held on the day of Pousa Purnima of lunar calander (7th day of January) in year 2004.<br/>
	        Pousa Purnima is celebrated as Annual Day of America Saraswata Sangha. </p>";
	  echo "<FORM METHOD=\"POST\" ACTION=\"Inaccessible\" style=\"padding-left: 15px; font : 14px Calibri; color: #303030;\">";
	  echo "The special puja programs for the Annual Day of Sangha: &nbsp;&nbsp;&nbsp;";
	  echo "<SELECT NAME=\"program\" style=\"font : 13px Calibri; color: #d55d0b;\">";
	  //echo "<OPTION SELECTED VALUE=\"#\">Select Year";
	}
	
	// Akhi Trutiya text  
	if ($smonth == "akhi") {
	  echo "<h2 style=\"text-align: center; font : 18px Calibri; font-weight: bold; color: #e7660c;\">Akhi Trutiya</h2>";
	  echo "<p style=\"padding-left: 15px; text-indent: 40px; font : 14px Calibri; line-height: 16pt; color: #303030;\">'Akhi Trutiya' is also known as <i>Akhaya Trutiya</i>; combination of two words <i>Akhaya</i> and <i>Trutiya</i>. Akhaya - imperishable i.e. never diminishes; Trutiya - third day of waxing moon, in lunar calendar. <br/><br/>
			Per Hindu religion this day marks the beginning of the 'Satya Yuga'; the first of the four Yugas. The age when truth and honesty was 
			truly existing and prevailing in society. </p>";
	  echo "<FORM METHOD=\"POST\" ACTION=\"Inaccessible\" style=\"padding-left: 15px; font : 14px Calibri; color: #303030;\">";
	  echo "The special puja programs for Akhi Trutiya, sangha puja session: &nbsp;&nbsp;&nbsp;";
	  echo "<SELECT NAME=\"program\" style=\"font : 13px Calibri; color: #d55d0b;\">";
	  //echo "<OPTION SELECTED VALUE=\"#\">Select Year";
	}
	
	  // Directories where Puja program files are stored
					$root_dir="./";
					$puja_dir="/".$smonth."/programs";
					if ($dir_list = opendir($root_dir.$puja_dir)) {
					$count = 0;
					while(($filename = readdir($dir_list)) !== false) {
					  if (($filename != ".") and ($filename != "..") and ($filename != "index.html")) {
						$year = substr($filename, 0, 4);
						$puja_dates[$count] = $year;
						$puja_files[$count] = $puja_dir."/".$filename;
						$count = $count + 1;
					  }
					}
					closedir($dir_list);
					}
					$prog_array = array_combine($puja_dates,$puja_files);
					krsort($prog_array,SORT_NUMERIC);
					$count = 0;
					foreach ($prog_array as $key => $val) {
					  echo "<OPTION VALUE=\"." . $val . "\">" . $key;
					}
                    $puja_dates = "";
                    $puja_files = "";
                    $prog_array = "";
					
	  echo "</SELECT> &nbsp;&nbsp;<INPUT type=\"button\" value=\"Get\" onclick=\"parent.location.href=program.options[program.selectedIndex].value;\"/>	</FORM>";
	  
	
  }

  
?>
