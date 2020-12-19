
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
                    <li><a href="Vehicles.php">VEHICLES</a></li>
                    <li><a href="Revenue.php" class ="active">REVENUE</a></li>
                </ul>
            </nav>
            <h1 class="space" id="heading">Grad Rental Company</h1>
        </div>
        
        <?php
            // define variables and set to empty values
            $location_revenue = "";
            $location_revenueErr = "";

            //Check user input with test function
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
                if(isset($_POST['revenue_submit'])){
                    if (empty($_POST["location_revenue"])) {
                        $location_revenueErr = "Selection a Location";
                    
                    }
                    else $location_revenue = test_input($_POST["location_revenue"]);
                    
                }
                else if(isset($_POST['revenue_all_submit'])){
                    
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

        <!--Generate location revenue form-->
        <form name="rental_webapp" id="rental_webapp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">          
            <fieldset>
                <h3>Revenue</h3>
                <p>Click below button to check revenue at all locations</p>
                <input type="submit" id="revenue_all_submit" name="revenue_all_submit" value="Check Revenue" class="button">
                <br><br><br>
                <p>Select a location to check current revenue</p>
                <label for="location_revenue" class = "labels">Location:</label> 
                <select name="location_revenue" id="location_revenue">
                    <option value="">Select a branch</option>
                    <option value="100010" <?php echo (isset($_POST['location_revenue']) && $_POST['location_revenue'] =='100010') ? 'selected="selected"' : '';?>>Mankato, Minnesota</option>
                    <option value="100011" <?php echo (isset($_POST['location_revenue']) && $_POST['location_revenue'] =='100011') ? 'selected="selected"' : '';?>>Apple Valley, Minnesota</option>
                    <option value="100012" <?php echo (isset($_POST['location_revenue']) && $_POST['location_revenue'] =='100012') ? 'selected="selected"' : '';?>>Saint Paul, Minnesota</option>
                    <option value="100013" <?php echo (isset($_POST['location_revenue']) && $_POST['location_revenue'] =='100013') ? 'selected="selected"' : '';?>>Burnsville, Minnesota</option>
                    <option value="100014" <?php echo (isset($_POST['location_revenue']) && $_POST['location_revenue'] =='100014') ? 'selected="selected"' : '';?>>Shakopee, Minnesota</option>
                    <option value="100015" <?php echo (isset($_POST['location_revenue']) && $_POST['location_revenue'] =='100015') ? 'selected="selected"' : '';?>>Rochester, Minnesota</option>
                    <option value="100016" <?php echo (isset($_POST['location_revenue']) && $_POST['location_revenue'] =='100016') ? 'selected="selected"' : '';?>>Delta, Wisconsin</option>
                    <option value="100017" <?php echo (isset($_POST['location_revenue']) && $_POST['location_revenue'] =='100017') ? 'selected="selected"' : '';?>>Star, Florida</option>
                </select>
                <span class="error">* <?php echo $location_revenueErr;?></span>
                <br><br>    
                <input type="submit" id="revenue_submit" name = "revenue_submit" value="Submit" class="button">
                
                <!--<output name="branch_revenue" for="revenue"></output>-->
            </fieldset>
        </form>

         <div class="result">
            <?php
                
             if ($_SERVER["REQUEST_METHOD"] == "POST"){
                
                if(isset($_POST['revenue_submit'])){
                     
                $sql = "select location.Location_ID, location.Location_Street, location.Location_City, location.Location_State,         location.Location_Zip_Code,
                        SUM(rental.Rental_Charge) AS Revenue_Collected_In_Dollars FROM rental
                        INNER JOIN location
                        ON rental.Pickup_Location_ID = location.Location_ID
                        GROUP BY location.Location_ID, location.Location_Street, location.Location_City, location.Location_State, location.Location_Zip_Code
                        HAVING location.Location_ID = '$location_revenue'";
             
             
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                
                if($resultCheck > 0){
                    
                    if($row = mysqli_fetch_assoc($result)){
                        echo "<h4>Location Address:</h4>";
                        echo "<p>Location ID: " . $row['Location_ID'] . "</p>";
                        echo "<p>" . $row['Location_Street'] . "</p>";
                        echo "<p>" . $row['Location_City'] . "</p>";                     
                        echo "<p>" . $row['Location_State'] . ", " . $row['Location_Zip_Code'] . "</p><br>";
                        echo "<p><b>Total Revenue Collected: <b>" . "$" .$row['Revenue_Collected_In_Dollars'] . "</p>";
                        
                        
                        }
                    }
                }
                 
                else if(isset($_POST['revenue_all_submit'])){
                
                 
                $revenue_all = "select location.Location_ID, location.Location_Street, location.Location_City, location.Location_State, location.Location_Zip_Code,
                        SUM(rental.Rental_Charge) AS Revenue_Collected_In_Dollars FROM rental
                        INNER JOIN location
                        ON rental.Pickup_Location_ID = location.Location_ID
                        GROUP BY location.Location_ID, location.Location_Street, location.Location_City, location.Location_State, location.Location_Zip_Code";
             
                $result2 = mysqli_query($conn, $revenue_all);
                $resultCheck2 = mysqli_num_rows($result2);
                
                if($resultCheck2 > 0){
                    
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>Location ID</th>";
                        echo "<th>Address</th>";
                        echo "<th>Total Revenue</th>";
                        echo "</tr>";
                    
                        while($row2 = mysqli_fetch_assoc($result2)){
                        
                            echo "<tr>";
                            echo "<td>" . $row2['Location_ID'] . "</td>";
                            echo "<td>" . $row2['Location_Street'] . ", " . $row2['Location_City'] . ", " . $row2['Location_State'] . ", " . $row2['Location_Zip_Code'] . "</td>";
                            echo "<td>" . "$" . $row2['Revenue_Collected_In_Dollars'] . "</td>";
                            echo "</tr>";
                        }
                    
                        echo "</table>";
                    }
                }
             }
             
            ?>
        </div>
        
    </main>
</body>
</html>