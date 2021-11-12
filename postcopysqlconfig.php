<?php


	$sqlservername="localhost";
	$sqlusername="root";
	$sqlpassword="<your_db_password>";
	$sqldb="postcopy";
	$conn=new mysqli($sqlservername,$sqlusername,$sqlpassword,$sqldb);
	if($conn->connect_error)
	{
		die("Connection Failed ".$conn->connect_error);
	}



?>