<?php
			  // get most recent program
                          $root_dir="./";
			  $puja_dir="/youngasp_puja/programs";
			  $fileref = " ";
			  if ($dir_list = opendir($root_dir.$puja_dir)) {
			  $count = 0;
			  while(($filename = readdir($dir_list)) !== false) {
				if (($filename !== ".") and ($filename !== "..") && ($filename != "index.html")) {
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
			  $prog_array = array_combine($puja_dates,$puja_files);
			  krsort($prog_array,SORT_NUMERIC);
			  foreach ($prog_array as $key => $val) {
			      $year = substr($key, 0, 4);
				  $month = substr($key, 4, 2);
				  $day = substr($key, -2);
				  $fileref = $root_dir."members".$val;
				  //echo $fileref."<br/>";
				  //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\".".$val."\">".$month."-".$day."-".$year."</a>";
				$count = $count + 1;
				break;
			  }
		      header( 'Location:.'.$fileref);
			?>
