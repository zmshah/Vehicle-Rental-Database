<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Home.css">
    <link rel = "stylesheet" href = "normalize.css">
    <title>TestMySQL</title>
</head>
<body>
    <main>
    <?php
        $servername = "localhost:3306";
        $username = "root";
        $password = "zawaad18@USA";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully";
    ?> 
    </main>
</body>
</html>