<?php
$allowedExts = array("pdf","doc","docx");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if (in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
    
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
    
    echo "<br/><a href='/restricted/fileuploader'>Upload more files</a>";
    }
  }
else
  {
  echo "Invalid file";
  }
?> 