<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>America Saraswata Sangha</title>
<link rel="stylesheet" type="text/css" href="../css/default.css" />
<script type="text/javascript" src="../script/maindev.js"></script>
<script type="text/javascript" src="../script/sidemenus.js"></script>
<script type="text/javascript" src="../script/selectyear.js"></script>



</head>
<body>
<div class="wrap">
<div align="center">

<table border="0" width="1004" cellpadding="0" cellspacing="0" >
  <tr>
	<td width="1004" height="20" >
	</td>
  </tr>
</table>
<table border="0" width="1004" cellpadding="0" cellspacing="0" class="tabletop" >
  <tr>
      <td width="2" height="2" align="left" valign="middle" background="../images/pglt.gif">
    </td>
    <td colspan="3" align="left" valign="middle" width="1000" height="2" background="../images/pght.gif">
    </td>
    <td width="2" height="2" align="left" valign="middle" background="../images/pgrt.gif">
    </td>
  </tr>
  
  <tr height="125">
      <td width="2" align="left" valign="middle" background="../images/pgvl.gif" >
    </td>

    <td colspan="3" align="left" valign="middle" width="1000" height="125" background="../images/logohd.gif">
    </td>
    <td width="2" align="left" valign="middle" background="../images/pgvr.gif" >
    </td>
  </tr>
 

<!-- title bar --> 
  <tr>
    <td align="left" valign="middle" background="../images/pgvl.gif" width="2" height="30" >
    </td>
    <td colspan="3" align="center" valign="top" width="1000" height="30" background="../images/ttlbar.gif">
<!-- menu -->
<script type="text/javascript">
topmenu();
</script>


<script type="text/javascript">
cssdropdown.startchrome("chromemenu")
</script>

<!-- menu -->
    </td>
    <td align="left" valign="middle" background="../images/pgvr.gif" width="2" height="30" >
    </td>

  </tr>
<!-- title bar -->

</table>

<table border="0" width="1004" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

  
  
  <tr>
    <td align="left" valign="middle" width="2" background="../images/pgvl.gif">
    </td>

    <td width="275" height="25" valign="top" class="traces">
		 <script type="text/javascript" src="../script/MPBackLinks.js"></script> 

    </td>
    <td width="725" valign="top" rowspan="3" >
	  <!-- Body content -->
      <table border="0" width="100%" cellpadding="0" cellspacing="0" >
	    <tr>
		  <td width="100%" align="center" ><img src="../images/membbanr.gif" width="725" height="160"/>
		  </td>
		</tr>
	    <tr>
		  <td width="100%" valign="top" class="bodytext"><h1>Sastrapatha & Mahila Sangha Puja</h1>
			<div style="padding-left: 460px; padding-right: 40px;"><a href="#sastra">Sastrapatha</a> ... ... <a href="#mahila">Mahila Sangha Puja</a>
		  </td>
		</tr>
	    <tr>
		  <td width="100%" valign="top" ><div style="overflow:hidden; width:725px; height: 600px;">

		  <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%" class="tabtext">
		  <tr height="150">
		    <td width="100%" class="bodytext"><a name="sastra"><h2>Sastrapatha</h2></a>
			<p>Sastrapatha sessions were being held every Sunday by all devotees to discuss teaching and ideology of ShriShriThakura. Programs were published a day or two before each Sunday. <p>Since January 2008, the Sastrapatha sessions have been discontinued and replaced by Sangha Puja. 
			<br/><br/><b>Programs</b></p>
  		    </td>
		  </tr>
		  <tr>
		    <td width="100%" valign="top" style="padding-left: 45px; height: 450px;" class="bodytext">
			<?php
			  // get most recent 3 programs
			  //$root_dir=$_SERVER['DOCUMENT_ROOT'] . "/Members";
			  $root_dir="./";
			  $puja_dir="/sastra/programs";
			  if ($dir_list = opendir($root_dir.$puja_dir)) {
			  $count = 0;
			  while(($filename = readdir($dir_list)) != false) {
				if (($filename != ".") && ($filename != "..") && ($filename != "index.html")) {
				  $year = substr($filename, -6, -4);
				  $month = substr($filename, -12, -10);
				  $day = substr($filename, -9, -7);
				  $year = $year + 2000;
				  $puja_years[$count] = $year;
				  $puja_date = date_create($year."-".$month."-".$day);
				  $puja_dates[$count] = date_format($puja_date, "Ymd");
				  $puja_files[$count] = $puja_dir."/".$filename;
				  $count = $count + 1;
			    }
			  }
			  closedir($dir_list);
			  }
			  else echo("invalid directory  ".$root_dir.$puja_dir);
			  
			  $prog_array = array_combine($puja_dates,$puja_files);
			  krsort($prog_array,SORT_NUMERIC);
			  $uniq_years = array_unique($puja_years);
			  arsort($uniq_years);
			  $count = 0;
			  $syear = 0;
			  foreach ($prog_array as $key => $val) {
			      $year = substr($key, 0, 4);
				  $month = substr($key, 4, 2);
				  $day = substr($key, -2);
				  if($syear != $year) {echo"</br>".$year."</br>"; $syear = $year; $count=0;}
				  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\".".$val."\">".$month."-".$day."-".$year."</a>";
				$count = $count + 1;
				if ($count>=7) {echo "<br/>"; $count=0;}
			  }
			  $puja_years = "";
			  $puja_dates = "";
			  $puja_files = "";
			?>
		    </td>
		  </tr>
  		  <tr height="170">
		    <td width="100%" class="bodytext"><a name="mahila"><h2>Mahila Sangha Puja</h2></a>
			<p>Mahila (women) Sangha Puja sessions led by women devotees. Since January 2008, Mahila Puja sessions are integrated to the sangha puja sessions and are held on the first week of every month.  
			<br/><b>Programs</b></p>
  		    </td>
		  </tr>
		  <tr>
		    <td width="100%" valign="top"  style="padding-left: 45px; height: 430px;" class="bodytext">
			<?php
			  // get all programs
			  $root_dir="./";
			  $puja_dir="/mahila_puja/programs";
			  if ($dir_list = opendir($root_dir.$puja_dir)) {
			  $count = 0;
			  while(($filename = readdir($dir_list)) != false) {
				if (($filename != ".") && ($filename != "..") && ($filename != "index.html")) {
				  $year = substr($filename, -6, -4);
				  $month = substr($filename, -12, -10);
				  $day = substr($filename, -9, -7);
				  $year = $year + 2000;
				  $puja_years[$count] = $year;
				  $puja_date = date_create($year."-".$month."-".$day);
				  $puja_dates[$count] = date_format($puja_date, "Ymd");
				  $puja_files[$count] = $puja_dir."/".$filename;
				  $count = $count + 1;
			    }
			  }
			  closedir($dir_list);
			  }
			  else echo("invalid directory  ".$root_dir.$puja_dir);
			  
			  $prog_array = array_combine($puja_dates,$puja_files);
			  krsort($prog_array,SORT_NUMERIC);
			  $uniq_years = array_unique($puja_years);
			  arsort($uniq_years);
			  $count = 0;
			  foreach ($prog_array as $key => $val) {
			      $year = substr($key, 0, 4);
				  $month = substr($key, 4, 2);
				  $day = substr($key, -2);
				  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\".".$val."\">".$month."-".$day."-".$year."</a>";
				$count = $count + 1;
				if ($count>=7) {echo "<br/>"; $count=0;}
			  }
			  $puja_years = "";
			  $puja_dates = "";
			  $puja_files = "";
			?>
			<br/><br/><br/><br/><b>Bibaranis</b><br/>
			<?php
			  // get all programs
			  $root_dir="./";
			  $puja_dir="/mahila_puja/bibaranis";
			  if ($dir_list = opendir($root_dir.$puja_dir)) {
			  $count = 0;
			  while(($filename = readdir($dir_list)) != false) {
				if (($filename != ".") && ($filename != "..") && ($filename != "index.html")) {
				  $year = substr($filename, -6, -4);
				  $month = substr($filename, -12, -10);
				  $day = substr($filename, -9, -7);
				  $year = $year + 2000;
				  $puja_years[$count] = $year;
				  $puja_date = date_create($year."-".$month."-".$day);
				  $puja_dates[$count] = date_format($puja_date, "Ymd");
				  $puja_files[$count] = $puja_dir."/".$filename;
				  $count = $count + 1;
			    }
			  }
			  closedir($dir_list);
			  }
			  else echo("invalid directory  ".$root_dir.$puja_dir);
			  
			  $prog_array = array_combine($puja_dates,$puja_files);
			  krsort($prog_array,SORT_NUMERIC);
			  $uniq_years = array_unique($puja_years);
			  arsort($uniq_years);
			  $count = 0;
			  foreach ($prog_array as $key => $val) {
			      $year = substr($key, 0, 4);
				  $month = substr($key, 4, 2);
				  $day = substr($key, -2);
				  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\".".$val."\">".$month."-".$day."-".$year."</a>";
				$count = $count + 1;
				if ($count>=7) {echo "<br/>"; $count=0;}
			  }
			  $puja_years = "";
			  $puja_dates = "";
			  $puja_files = "";
			?>
  		    </td>
		  </tr>
		  </table>
		  </div>
		  </td>
		</tr>
	  </table>
	  <!-- Body content ends -->
      </td>


  <td align="left" valign="middle" width="2" background="../images/pgvr.gif">
    </td>
  </tr>


  
  <tr>
    <td align="left" valign="middle" width="2" background="../images/pgvl.gif">
    </td>

	   <td width="275" height="580" valign="top" bgcolor="#ffffff" >
<!--  Side Menu options start -->	   
		   
<div class="sidemenu" >
  <script type="text/javascript" >runAccordion(5);</script> <!-- replace this index with folder index -->
<div id="AccordionContainer" class="AccordionContainer">
  <script type="text/javascript" >    defineMenu();  </script>

</div>
</div>

<!--  Side Menu options end -->	   
      </td>


    <td align="left" valign="middle" width="2" background="../images/pgvr.gif">
    </td>
  </tr>


  
  <tr>
    <td align="left" valign="middle" width="2" background="../images/pgvl.gif">
    </td>

    <td width="275" valign="top" > <!--bgcolor="#c7fe94" >-->
	  <!-- Additional Page Information start -->
      <table border="0" width="275" cellpadding="0" cellspacing="0" >
      <tr>
          <td width="100%" height="30" align="center" valign="top" class="sidetexts" ><img src="../images/underline.gif" height="18" width="106"/>
          </td>
	  </tr>
      <tr>
	    <td width="100%" valign="top" class="sidetexts"><p>Members have approbated SriSriThakura Nigamananda Saraswati Deva as their only <i>Guru</i> and <i>Ista</i> (diety); and asseverated to govern an ideal household life by acknowledging <i>Jayaguru</i> as the <i>SiddhaMantra</i> (hymn/intonation in Hinduism).	</p>
		  <img src="../images/evtad.gif" width="270" height="180" alt="America Sammilani 2009"/><br/><h2>Parichaya Patra - <i>The Identity</i></h2>
		</td>
	  </tr>
	</table>
	  <!-- Additional Page Information end -->
    </td>

    <td align="left" valign="middle" width="2" background="../images/pgvr.gif">
    </td> 
	</tr>
  
</table>

<!-- bottom row table -->
<table border="0" width="1004" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
  <tr>
      <td width="2" height="29" align="left" valign="middle" background="../images/pgvl.gif">
    </td>
    <td align="center" valign="bottom" width="1000" height="29" background="../images/ftrbar.gif" >
    	  <script type="text/javascript" >    copyRight();  </script>
    </td>
    <td width="2" height="29" align="left" valign="middle" background="../images/pgvr.gif">
    </td>
  </tr>
  <tr>
      <td width="2" height="2" align="left" valign="middle" background="../images/pglb.gif">
    </td>
    <td align="left" valign="middle" width="1000" height="2" background="../images/pghb.gif">
    </td>
    <td width="2" height="2" align="left" valign="middle" background="../images/pgrb.gif">
    </td>
  </tr>
</table>
</div> <!-- center-->
</div> <!-- wrap -->
<div id="footer">
<div align="center">
<div class="footcenter">
	  <script type="text/javascript" >    footCenter();  </script>
</div> <!-- footcenter-->
</div> <!-- center-->
</div> <!-- footer-->
</body>
</html>
