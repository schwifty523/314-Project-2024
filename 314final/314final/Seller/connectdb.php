<?php

    // Check if $conn is not already defined
    if (!isset($conn)) {
        $db_server = "localhost:3307";
        $db_username = "root";
        $db_password = "";
        $db_name = "314db";

        // Establish the database connection
        $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

        // Check if connection was successful
        if (!$conn) {
            // Handle connection error if needed
            die("Connection failed: " . mysqli_connect_error());
        }
    }


    // Check if connected or not
    //    if ($conn)
    // {
    //     echo "Connected to database <br>"; 
    // }
    // else
    // {
    //     echo "Failed to connect to database <br>";
    // }
  

?> 


