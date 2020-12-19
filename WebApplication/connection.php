<?php

    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "rental_cars";
    
    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $conn = mysqli_connect($dbhost,$dbuser,$dbpass,$db);
    
    if(!$conn){
    	die("failed:" . mysqli_connect_error());
    }
  
	

?>


