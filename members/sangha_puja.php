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
<script type="text/javascript">
var accordion=function(){
	var tm=sp=10;
	function slider(n){this.nm=n; this.arr=[]}
	slider.prototype.init=function(t,c,k){
		var a,h,s,l,i; a=document.getElementById(t); this.sl=k?k:'';
		h=a.getElementsByTagName('dt'); s=a.getElementsByTagName('dd'); this.l=h.length;
		for(i=0;i<this.l;i++){var d=h[i]; this.arr[i]=d; d.onclick=new Function(this.nm+'.pro(this)'); if(c==i){d.className=this.sl}}
		l=s.length;
		for(i=0;i<l;i++){var d=s[i]; d.mh=d.offsetHeight; if(c!=i){d.style.height=0; d.style.display='none'}}
	}
	slider.prototype.pro=function(d){
		for(var i=0;i<this.l;i++){
			var h=this.arr[i], s=h.nextSibling; s=s.nodeType!=1?s.nextSibling:s; clearInterval(s.tm);
			if(h==d&&s.style.display=='none'){s.style.display=''; su(s,1); h.className=this.sl}
			else if(s.style.display==''){su(s,-1); h.className=''}
		}
	}
	function su(c,f){c.tm=setInterval(function(){sl(c,f)},tm)}
	function sl(c,f){
		var h=c.offsetHeight, m=c.mh, d=f==1?m-h:h; c.style.height=h+(Math.ceil(d/sp)*f)+'px';
		c.style.opacity=h/m; c.style.filter='alpha(opacity='+h*100/m+')';
		if(f==1&&h>=m){clearInterval(c.tm)}else if(f!=1&&h==1){c.style.display='none'; clearInterval(c.tm)}
	}
	return{slider:slider}
}();
</script>


</head>
<body>
<div class="wrap">
<div align="center">

<?php
include '../header.php';
?>

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
		  <td width="100%" valign="top" class="bodytext"><h1>Sangha Puja</h1>
			<p>ShriShriThakura Nigamananda Saraswati Deva has instructed his disciples to form a Sangha wherever at least three members are present. He has directed that this Sangha should meet at least once a week 	and discuss His discourses, express and learn from each others’ spiritual feelings and experiences.</p>
		  </td>
		</tr>
	    <tr>
		  <td width="100%" valign="top" >
			  <dl class="accordion2" id="slider2">
			  <dt>Brief History</dt>
		      <dd>
			    <span>The very first pathachakra puja was held on Saturday, the 4th of August of 2001. Seven families had attended this 30 minute session. The monthly pathachakra puja was held on the first Sunday of the month starting with the month of September 2001. The pathachakra puja held on the first and third Sunday of the month starting with January 2003. The President of Nilachala Saraswata Sangha, Puri, Shri Shyama Sundar Das gave the permission to change America Saraswata Pathachakra to America Saraswata Sangha during his visit to the US for 2nd Annual Sammilani of America Saraswat Sangha. Sangha Puja was conducted on first and third Sunday of every month starting with January 2004. Sastra Patha sessions were held on the other Sundays of the month. Mahila Puja was held every three months on the first Sunday of the quarter. Starting with January 2008, Sangha Puja is held on every Sunday of the month. The first Sangha Puja of the month is considered as Mahila Puja and Saticharita Mala is read during the second session. We have been having the opportunity of having a representative from our parent sangha join our Sangha Puja on the last Sunday of the month starting with January 2008.
				</span>
			  </dd>
			  </dl>
			<script type="text/javascript">var slider2=new accordion.slider("slider2");slider2.init("slider2");</script>
		  </td>
		</tr>
	    <tr>
		  <td width="100%" valign="top" class="bodytext">		

		  <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%" class="bodytext">
		  <tr>
		    <td width="50%" style="padding-left: 45px;" ><br/><b>Recent Programs</b><br/>
			<?php
			  // get most recent 3 programs
			  //$root_dir=$_SERVER['DOCUMENT_ROOT'] . "/Members";
			  $root_dir="./";
			  $puja_dir="/sangha/programs";
			  $bibarani_dir="/sangha/bibaranis";
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
				if ($count>=3) break;
			  }
			?>
			</td>
		    <td width="50%"><br/>&nbsp;&nbsp;<b>Recent Bibarani</b><br/>
			<?php
			  // get most recent 3 bibarani
			  if ($dir_list = opendir($root_dir.$bibarani_dir)) {
			  $count = 0;
			  while(($filename = readdir($dir_list)) != false) {
				if (($filename != ".") and ($filename != "..") && ($filename != "index.html")) {
				  $year = substr($filename, -6, -4);
				  $month = substr($filename, -12, -10);
				  $day = substr($filename, -9, -7);
				  $year = $year + 2000;
				  $bibarani_date = date_create($year."-".$month."-".$day);
				  $bibarani_dates[$count] = date_format($bibarani_date, "Ymd");
				  $bibarani_files[$count] = $bibarani_dir."/".$filename;
				  $count = $count + 1;
			    }
			  }
			  closedir($dir_list);
			  }
			  $bibarani_array = array_combine($bibarani_dates,$bibarani_files);
			  krsort($bibarani_array,SORT_NUMERIC);
			  $count = 0;
			  foreach ($bibarani_array as $key => $val) {
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

		  <tr valign="top">
			<td width="50%">
			  <FORM METHOD="POST" onReset="history.go(0)">
			  <br/><b>Archived Programs</b><br/>
		        Select:&nbsp;
				<SELECT NAME="syear" onchange="validDate(this.value, smonth.value, '1');">
				  <?php
					echo "<OPTION SELECTED VALUE=\"#\">Year";
					echo "<OPTION VALUE=\"9999\">All";
					foreach ($uniq_years as $i => $value) {echo "<OPTION VALUE=\"".$uniq_years[$i]."\">".$uniq_years[$i];}
				  ?>
				</SELECT>&nbsp;&nbsp;&nbsp;
				<SELECT NAME="smonth"  onclick="showPrograms(syear.value, this.value, '1');">
				  <script language=javascript>getProgMonths();</script>
				</SELECT>
		        &nbsp;&nbsp;<INPUT type="button" value="Get" onclick="showPrograms(syear.value, smonth.value, '1');"/>
                <br/>
			</td>
			<td width="50%">
			  <br/>&nbsp;&nbsp;<b>Archived Bibarani</b><br/>
		        &nbsp;&nbsp;Select:&nbsp;
			    <SELECT NAME="byear" onchange="validDate(this.value, bmonth.value, '2');">
				  <?php
					echo "<OPTION SELECTED VALUE=\"#\">Year";
					echo "<OPTION VALUE=\"9999\">All";
					foreach ($uniq_years as $i => $value) {echo "<OPTION VALUE=\"".$uniq_years[$i]."\">".$uniq_years[$i];}
				  ?>
				</SELECT>&nbsp;&nbsp;&nbsp;
				<SELECT NAME="bmonth" onclick="showPrograms(byear.value, this.value, '2');">
				  <script language=javascript>getProgMonths();</script>
				</SELECT>
		        &nbsp;&nbsp;<INPUT type="button" value="Get" onclick="showPrograms(byear.value, bmonth.value, '2');"/>
                <br/>
			</td>
		  </tr>
		  <tr>
			<td width="100%" height="10" align="center" colspan="2">
			<INPUT TYPE="Reset" />
			  </FORM>
			</td>
		  </tr>
		  <tr>
		    <td width="100%" height="20" valign="top" style="padding-left:45px;" colspan="2" >
			<a href="https://docs.google.com/spreadsheet/ccc?key=0AmUoUlSi_UXgdDBpRVdma2tWMWRMYTFYbjV4cWxidWc#gid=0">
Sangha Puja Attendance</a>
			</td>
		  </tr>
		  </table>

		  </td>
		</tr>
		<tr>
		  <td width="100%" valign="top" class="tabtext">		
		   <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%" class="tabtext">
		    <tr valign="top" >
			<td width="350" >
				<div id="programList" style="overflow:auto; height:250px; padding-left: 40px;">
				</div>
			</td>
			<td width="350" >
				<div id="bibaraniList" style="overflow:auto; height:250px;">
				</div>
			</td>
		    </tr>
		    <tr valign="top" >
			<td width="100% colspan="2" height="10">
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
