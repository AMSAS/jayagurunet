<?php
        //Start session
        session_start();

        //Include database connection details
        define('DB_HOST', 'localhost');
    define('DB_USER', 'webuser');
    define('DB_PASSWORD', '1234');
    define('DB_DATABASE', 'test_login');

//Connect to mysql server
        $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
        if(!$link) {
                die('Failed to connect to server: ' . mysql_error());
        }

        //Select database
        $db = mysql_select_db(DB_DATABASE);
        if(!$db) {
                die("Unable to select database");
        }


if(isset($_GET['Register'])) //Register Block
{
  $user = User::createUser($_GET['name'], $_GET['password']);
  $user->save();
  echo "Registered!";
}
else if(isset($_GET['Challenge']))  //Challenge Block
{
  $_SESSION['challenge'] = mt_rand()."".mt_rand();
  echo $_SESSION['challenge'];
}
else  //Login Block
{
  $user = Database::getUser($_GET['name']);
  if(strtolower(sha1($user->Password.$_SESSION['challenge']))
       == strtolower($_GET['password'])
  {
    echo "Yay!";
  }
  else
  {
    echo "No!";
  }
}
echo "No! :(";
?>
