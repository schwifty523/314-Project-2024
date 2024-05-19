<?php

    // Check if $conn is not already defined
    if (!isset($conn)) {
        $servername = "localhost:3307";
        $username = "root";
        $password = "";
        $dbname = "314db";
    }   
        // Create database connection
    // Create database connection
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

/*
$db_server = "localhost:3307";
$db_username = "root";
$db_password = "";
$db_name = "314db";

// Create database connection
try {
    $conn = new PDO("mysql:host=$db_server;dbname=$db_username", $db_password, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
*/
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


