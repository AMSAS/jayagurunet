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
				if($_POST['program_type']=='weekly'){
					$bibaranis = strpos($_FILES["file"]["name"], "Bibarani");
					if($bibaranis !==false){
						move_uploaded_file($_FILES["file"]["tmp_name"],
						  "/home/content/17/11832717/html/members/sangha/bibaranis/" . $_FILES["file"]["name"]);
						echo "Stored in: " . "/home/content/17/11832717/html/members/sangha/bibaranis/" . $_FILES["file"]["name"];
					}
				
					$yasession = strpos($_FILES["file"]["name"], "Session");
					if($yasession !==false){
						move_uploaded_file($_FILES["file"]["tmp_name"],
						  "/home/content/17/11832717/html/members/youngasp_puja/programs/" . $_FILES["file"]["name"]);
					  echo "Stored in: " . "/home/content/17/11832717/html/members/youngasp_puja/programs/" . $_FILES["file"]["name"];
					}
				
					$program = strpos($_FILES["file"]["name"], "Program");
					if($program !==false){
						move_uploaded_file($_FILES["file"]["tmp_name"],
						  "/home/content/17/11832717/html/members/sangha/programs/" . $_FILES["file"]["name"]);
						  echo "Stored in: " . "/home/content/17/11832717/html/members/sangha/programs/" . $_FILES["file"]["name"];
					}
				} else if($_POST['program_type']=='samilani'){
					$target_directory = "/home/content/17/11832717/html/events/".date("Y")."/";
					
					move_uploaded_file($_FILES["file"]["tmp_name"],
					$target_directory . $_FILES["file"]["name"]);
					echo "Stored in: " . $target_directory . $_FILES["file"]["name"];
					
				} else {
					$target_directory = "/home/content/17/11832717/html/members/".$_POST['program_type']."/programs/";
					
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