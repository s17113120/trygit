<?php


	$hostname = "localhost";
	$username = "root";
	$password = "";

	$mysqli = mysqli_connect($hostname , $username , $password , "endwork");
	if(mysqli_connect_error()){
		echo mysqli_connnect_error();
	}

	$mysqli->set_charset("utf8");

?>