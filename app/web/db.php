<?php

	//Variables for connecting to your database.
	//These variable values come from your hosting account.
	$hostname = "###############################";
	$username = "#####";
	$dbname = "#####";
	//These variable values need to be changed by you before deploying
	$password = "##########";

	//Connecting to your database
	mysql_connect($hostname, $username, $password) OR DIE ("Unable to
	connect to database! Please try again later.");
	mysql_select_db($dbname);

?>