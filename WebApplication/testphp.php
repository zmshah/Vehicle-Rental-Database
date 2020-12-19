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

    $sql = "select * from rental ";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
            
                if($resultCheck > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<h4>Details of Rental ID: " . $rentalId . "</h4>";
                        echo "<p>Customer ID: " . $row['Customer_Id'] . "</p>";
                        echo "<p>Drop-off Location ID: " . $row['Dropoff_Location_ID'] . "</p>";
                        echo "<p>Pick-up Location ID: " . $row['Pickup_Location_ID'] . "</p>";
                        echo "<p>Pick-up Date: " . $row['Rental_Pickup_Date'] . "</p>";
                        echo "<p>Drop-off Date: " . $row['Rental_Dropoff_Date'] . "</p>";
                        echo "<p>No. of Days Rented: " . $row['Rental_Days'] . "</p>";                        
                    }                     
                }
                /*else{
                    echo "<h4>No results</h4>";
                }*/
	

?>