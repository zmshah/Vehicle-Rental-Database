<?php
    
    include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Home.css">
    <link rel = "stylesheet" href = "normalize.css">
    <title>Grad Rental Company</title>
</head>
<body>
    <main>
        <div id = "headersection">
            <!--Navigation bar--> 
            <nav id="navigation_bar">
                <ul id="navigation_bar_ul">
                    <li><a href="CarRental.php">CUSTOMERS</a></li>
                    <li><a href="Vehicles.php" class="active" class = "actove">VEHICLES</a></li>
                    <li><a href="Revenue.php">REVENUE</a></li>
                </ul>
            </nav>
            <h1 class="space" id="heading">Grad Rental Company</h1>
        </div>
        
        <?php
            // define variables and set to empty values
            $vehicle_type = "";
            $availabilityErr = "";
            $location_id = "";
            $location_Err = "";

            //Check user input with test function
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["vehicle_type"])) {
                    $availabilityErr = "Selection is required";
                    
                }
                else {
                    $vehicle_type = test_input($_POST["vehicle_type"]);
                }
                
                if(empty($_POST["location_id"])){
                    $location_Err = "Select Location ID";
                    
                }
                else {
                    $location_id = test_input($_POST["location_id"]);
                    
                    
            
                }
            }
            //Validate input
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>     

        <!--Generate vehicle availability form-->
        <form name="rental_webapp" id="rental_webapp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">           
            <fieldset>
                <h3>Vehicle Availability</h3>
                <p>Select a vehicle type to check availability</p>
                <label for="vehicle_type" class = "labels">Vehicle:</label> 
                <select name="vehicle_type" id="vehicle_type">
                    <option value="">Select a vehicle</option>
                    <option value="SUV"<?php echo (isset($_POST['vehicle_type']) && $_POST['vehicle_type'] == 'SUV') ? 'selected="selected"' : '';?>>SUV</option>
                    <option value="Sedan" <?php echo (isset($_POST['vehicle_type']) && $_POST['vehicle_type'] =='Sedan') ? 'selected="selected"' : '';?>>Sedan</option>
                    <option value="Hatchback" <?php echo (isset($_POST['vehicle_type']) && $_POST['vehicle_type'] =='Hatchback') ? 'selected="selected"' : '';?>>Hatchback</option>
                    <option value="Truck" <?php echo (isset($_POST['vehicle_type']) && $_POST['vehicle_type'] =='Truck') ? 'selected="selected"' : '';?>>Truck</option>
                </select>
                <span class="error">* <?php echo $availabilityErr;?></span>
                <br><br>
                <label for="location_id" class="labels">Location ID:</label>
                <select name="location_id" id="location_id">
                    <option value="">Select a Location</option>
                    <option value="100010" <?php echo (isset($_POST['location_id']) && $_POST['location_id'] =='100010') ? 'selected="selected"' : '';?>>Mankato, Minnesota</option>
                    <option value="100011" <?php echo (isset($_POST['location_id']) && $_POST['location_id'] =='100011') ? 'selected="selected"' : '';?>>Apple Valley, Minnesota</option>
                    <option value="100012" <?php echo (isset($_POST['location_id']) && $_POST['location_id'] =='100012') ? 'selected="selected"' : '';?>>Saint Paul, Minnesota</option>
                    <option value="100013" <?php echo (isset($_POST['location_id']) && $_POST['location_id'] =='100013') ? 'selected="selected"' : '';?>>Burnsville, Minnesota</option>
                    <option value="100014" <?php echo (isset($_POST['location_id']) && $_POST['location_id'] =='100014') ? 'selected="selected"' : '';?>>Shakopee, Minnesota</option>
                    <option value="100015" <?php echo (isset($_POST['location_id']) && $_POST['location_id'] =='100015') ? 'selected="selected"' : '';?>>Rochester, Minnesota</option>
                    <option value="100016" <?php echo (isset($_POST['location_id']) && $_POST['location_id'] =='100016') ? 'selected="selected"' : '';?>>Delta, Wisconsin</option>
                    <option value="100017" <?php echo (isset($_POST['location_id']) && $_POST['location_id'] =='100017') ? 'selected="selected"' : '';?>>Star, Florida</option>
                </select>  
                <span class="error">* <?php echo $location_Err;?></span>
                <br><br>
                <input type="submit" id="availability_submit" value="Submit" class="button">
                <!--<output name="branch_revenue" for="revenue"></output>-->
            </fieldset>
        </form>
        
           <div class="result">
            <?php
                
                $not_rented = "Not Rented";
                //$sql = "select * from vehicle where Vehicle_Type = '$vehicle_type' and Location_ID = '$location_id'";
                $sql = "SELECT L.Location_ID, L.Location_City, L.Location_State, V.Vehicle_ID, V.Vehicle_Color, V.Vehicle_Type, 
                               V.Vehicle_Model, V.Vehicle_Year, V.Vehicle_Number_Of_Seats, V.Vehicle_Current_Mileage, V.Vehicle_Rental_Rate
                        FROM Location AS L
                        INNER JOIN Vehicle AS V on L.Location_ID = V.Location_ID
                        WHERE V.Vehicle_Type = '$vehicle_type' AND L.Location_ID = '$location_id' AND V.Vehicle_Rental_Status = '$not_rented'";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
               
               $sql2 = "SELECT Location_City, Location_State from Location WHERE Location_ID = '$location_id'";
               $result2 = mysqli_query($conn, $sql2);
               $resultCheck2 = mysqli_num_rows($result2);
               
               
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    
                    if($resultCheck2 > 0){
                    
                    $fetch_result2 = mysqli_fetch_assoc($result2);
                    echo "<h4>Location: " . $fetch_result2['Location_City'] . ", " . $fetch_result2['Location_State'] . "</h4>";
                   
               }
                    if($resultCheck > 0){
                        echo "<table>";
                        echo "<tr>
                             <th>Vehicle ID</th>
                             <th>Vehicle Type</th>
                             <th>Model</th>
                             <th>Year</th>
                             <th>Color</th>
                             <th>Current Mileage</th>
                             <th>No. of Seats</th>
                             <th>Charge Per Day</th>
                             </tr>";
                             
                        while($row = mysqli_fetch_assoc($result)){
                            
                            echo "<tr>";
                            echo "<td>" . $row['Vehicle_ID'] . "</td>";
                            echo "<td>" . $row['Vehicle_Type'] . "</td>";
                            echo "<td>" . $row['Vehicle_Model'] . "</td>";
                            echo "<td>" . $row['Vehicle_Year'] . "</td>";
                            echo "<td>" . $row['Vehicle_Color'] . "</td>";
                            echo "<td>" . $row['Vehicle_Current_Mileage'] . "</td>";
                            echo "<td>" . $row['Vehicle_Number_Of_Seats'] . "</td>";
                            echo "<td> $" . $row['Vehicle_Rental_Rate'] . "</td>";
                            echo "</tr>";
                            
                        
                        }
                        echo "</table";
                    }
                    else echo "<h4>No cars avaialable</h4>";
                }
            ?>
        </div>
   
    </main>
</body>
</html>