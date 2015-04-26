<?php
	session_start();
	include 'db.php';
	if (isset($_SESSION['PID']) && isAllowed($GLOBALS[ROLE_UPPROGRAM])) {
		$allowedExts = array("pdf","doc","docx");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		if (in_array($extension, $allowedExts))
		  {
		  if ($_FILES["file"]["error"] > 0)
			{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
			}
		  else {
				echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				echo "Type: " . $_FILES["file"]["type"] . "<br>";
				echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
				$target_directory = "/home/content/17/11832717/html/";
				
				if($_POST['program_type']=='weekly'){
					$bibaranis = strpos($_FILES["file"]["name"], "Bibarani");
					if($bibaranis !==false){
						$target_directory.="members/sangha/bibaranis/";
						move_uploaded_file($_FILES["file"]["tmp_name"],
						  $target_directory . $_FILES["file"]["name"]);
						echo "Stored in: " . $target_directory . $_FILES["file"]["name"];
					}
				
					$yasession = strpos($_FILES["file"]["name"], "Session");
					if($yasession !==false){
						$target_directory.="members/youngasp_puja/programs/";
						move_uploaded_file($_FILES["file"]["tmp_name"],
						  $target_directory . $_FILES["file"]["name"]);
					  echo "Stored in: " . $target_directory . $_FILES["file"]["name"];
					}
				
					$program = strpos($_FILES["file"]["name"], "Program");
					if($program !==false){
						$target_directory.="members/sangha/programs/";
						move_uploaded_file($_FILES["file"]["tmp_name"],
						  $target_directory . $_FILES["file"]["name"]);
						  echo "Stored in: " . $target_directory . $_FILES["file"]["name"];
					}
				} else if($_POST['program_type']=='samilani'){
					$target_directory.= "events/".date("Y")."/";
					
					move_uploaded_file($_FILES["file"]["tmp_name"],
					$target_directory . $_FILES["file"]["name"]);
					echo "Stored in: " . $target_directory . $_FILES["file"]["name"];
					
				} else {
					$target_directory.= "members/".$_POST['program_type']."/programs/";
					
					move_uploaded_file($_FILES["file"]["tmp_name"],
					$target_directory . $_FILES["file"]["name"]);
					echo "Stored in: " . $target_directory . $_FILES["file"]["name"];
					
				}
				
				echo "<br/><a href='fileuploader'>Upload more files</a>";
				echo "<br/><a href='index.php'>Go Back To Home</a>";
			}
		  }
		else
		  {
		  	echo "<br/><a href='fileuploader'>Go Back File Format Not Recognized</a>";
			echo "<br/><a href='index.php'>Go Back To Home</a>";
		  }
	}else{
  		echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
	}
?>