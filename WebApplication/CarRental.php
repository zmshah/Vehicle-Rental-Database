
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
        <!--Navigation bar-->     
        <div id = "headersection">
            <nav id="navigation_bar">
                <ul id="navigation_bar_ul">
                    <li><a href="CarRental.php" class="active">CUSTOMERS</a></li>
                    <li><a href="Vehicles.php">VEHICLES</a></li>
                    <li><a href="Revenue.php">REVENUE</a></li>
                </ul>
            </nav>
            <h1 class="space" id="heading">Grad Rental Company</h1>
        </div>
        
        <?php
            // define variables and set to empty values
            /*$rental = "";
            $rentalId = "";
            $rentalErr = "";
            $rentalIdErr = "";*/
            $firstName = "";
            $firstNameErr = "";
            $lastName = "";
            $lastNameErr = "";

            //Check user input with test function
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                /*if (empty($_POST["rental"])) {
                    $rentalErr = "Customer name is required";
                }
                else {
                    $rental = test_input($_POST["rental"]);
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$rental)) 
                        $rentalErr = "Only letters and white space allowed"; 
                }
                if (empty($_POST["rentalId"])) {
                    $rentalIdErr = "Rental ID is required";
                }
                else {
                    $rentalId = test_input($_POST["rentalId"]);
                    if (is_numeric($rentalId) == false) 
                        $rentalIdErr = "Only numbers allowed";
                }*/
                if(empty($_POST["firstName"])){
                    $firstNameErr = "Enter First Name";
                }
                else{
                     $firstName = test_input($_POST["firstName"]);
                     if(is_numeric($firstName) == true)
                         $firstNameErr = "No numerics allowed";
                }
                  
                if(empty($_POST["lastName"])){
                    $lastNameErr = "Enter Last Name";
                }
                else{
                     $lastName = test_input($_POST["lastName"]);
                     if(is_numeric($lastName) == true)
                         $lastNameErr = "No numerics allowed";
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

        <!--Generate Rental information form-->
        <form name="rental_webapp" id="rental_webapp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <fieldset>
                <h3>Customer rental details</h3>    
                
              
                <label for="firstName" class="labels">First Name</label><br>
                <input type="text" name="firstName" class="inputs" value="<?php echo $firstName;?>">
                <span class="error">* <?php echo $firstNameErr;?></span>
                <br><br>
                <label for="lastName" class="labels">Last Name</label><br>
                <input type="text" name="lastName" class="inputs" value="<?php echo $lastName;?>">
                <span class="error">* <?php echo $lastNameErr;?></span>
                <br><br>
                <input type="submit" id="rental_submit" value="Submit" class="button">
                <!--<output name="rental_details" for="rental"></output>-->
            </fieldset>            
        </form>
        
        <div class="result">
            
            <?php
                
                $sql = "select Customer_Id from customer where Customer_FName = '$firstName' and Customer_LName = '$lastName'";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
            
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    if($resultCheck > 0){  
                        echo "<h4>Details of Customer:</h4>";
                        while($row = mysqli_fetch_assoc($result)){
                            $customerId = $row['Customer_Id'];
                            
                            $sql = "select * from rental where Customer_Id = '$customerId'";
                            $result = mysqli_query($conn, $sql);
                            $resultCheck = mysqli_num_rows($result);
                            if($resultCheck > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                    
                                    echo "<p>Customer ID: " . $row['Customer_Id'] . "</p>";
                                    $pickup = $row['Pickup_Location_ID'];
                                    $dropoff = $row['Dropoff_Location_ID'];
                                    $sql1 = "select Location_City, Location_State from Location where Location_ID = '$pickup'";
                                    $result1 = mysqli_query($conn, $sql1);
                                    $resultCheck1 = mysqli_num_rows($result1);
                                    if($resultCheck1 > 0){
                                        while($row1 = mysqli_fetch_assoc($result1)){
                                            echo "<p>Pick-up Location : " . $row1['Location_City'] . ", " . $row1['Location_State'] . "</p>";
                                        }
                                    }
                                    $sql2 = "select Location_City, Location_State from Location where Location_ID = '$dropoff'";
                                    $result2 = mysqli_query($conn, $sql2);
                                    $resultCheck2 = mysqli_num_rows($result2);
                                    if($resultCheck2 > 0){
                                        while($row2 = mysqli_fetch_assoc($result2)){
                                            echo "<p>Drop-Off Location : " . $row2['Location_City'] . ", " . $row2['Location_State'] . "</p>";
                                        }
                                    }
                                    
                                    echo "<p>Pick-up Date: " . $row['Rental_Pickup_Date'] . "</p>";
                                    echo "<p>Drop-off Date: " . $row['Rental_Dropoff_Date'] . "</p>";
                                    echo "<p>No. of Days Rented: " . $row['Rental_Days'] . "</p>";
                                }
                            }
                            
                        }                     
                    }
                    else{
                        echo "<h4>No results</h4>";
                    }
            }
            ?>
        </div>
        
    </main>
</body>
</html>