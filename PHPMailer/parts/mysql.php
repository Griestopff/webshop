<?php
 
	$host = "localhost";
	$name = "shxrt";
	#$user = "admin";      
	#$passwort = "VY4lbxPhVlEIS7J4";
	#$user = "root";
	#$passwort = "";
	$user = "debian-sys-maint";
	$passwort = "dTXPDXLQvxDcsN8F";
	
	try{
		$mysql = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
	} catch (PDOException $e){
		echo "SQL Error: ".$e->getMessage();
	}
	
	
	
	
 ?>