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
		  <td width="100%" valign="top" class="bodytext"><h1>Young Aspirants Sangha Puja</h1>
			<p>The youth of the members of America Saraswat Sangha get together for a Session on the first and third Sundays of every month.  They read a story from teaching and ideals of ShriShriThakura; discuss the moral of the story. The program for the session and the story are archived in this page. </p>
		  </td>
		</tr>
	    <tr>
		  <td width="100%" valign="top" class="bodytext">		

		  <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%" class="bodytext">
		  <tr>
		    <td width="100%" style="padding-left: 45px;" ><br/><b>Recent Programs</b><br/>
			<?php
			  // get most recent 3 programs
			  $root_dir="./";
			  $puja_dir="/youngasp_puja/programs";
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
				  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\".".$val."\">".$month."-".$day."-".$year."</a>";
				$count = $count + 1;
				if ($count>=3) break;
			  }
			?>
		    </td>
		  </tr>
		  </table>

		  <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%" class="bodytext">
		  <tr valign="top">
			<td width="100%">
			  <FORM METHOD="POST" ACTION="Inaccessible" onReset="showPrograms('#', '#', '3');" >
			  <br/><b>Archived Programs</b><br/>
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year:&nbsp;&nbsp;
				<SELECT NAME="syear" onchange="validDate(this.value, smonth.value, '3');">
				  <?php
					echo "<OPTION SELECTED VALUE=\"#\">Select";
					echo "<OPTION VALUE=\"9999\">All";
					foreach ($uniq_years as $i => $value) {echo "<OPTION VALUE=\"".$uniq_years[$i]."\">".$uniq_years[$i];}
				  ?>
				</SELECT>&nbsp;&nbsp;&nbsp;Month:&nbsp;&nbsp; 
				<SELECT NAME="smonth" onclick="showPrograms(syear.value, this.value, '3');">
				  <script language=javascript>getProgMonths();</script>
				</SELECT>
                   &nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="button" value="Get" onclick="showPrograms(syear.value, smonth.value, '3');"/>
		   			&nbsp;&nbsp;&nbsp;<INPUT TYPE="Reset" />
				</FORM>
			</td>
		  </tr>
		  </table>
		  </td>
		</tr>

	    <tr>
		  <td width="100%" valign="top">		
		  <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%" class="bodytext">
		  <tr valign="top">
			<td width="100%">
				<div id="programList" style="overflow:auto; height:450px; padding-left: 40px;">
				</div>
			</td>
		  </tr>
		  </table>
		  
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
