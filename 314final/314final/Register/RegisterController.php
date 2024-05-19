<?php
// Database connection details
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "314db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the registration form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $username = $conn->real_escape_string($_POST['new-username']);
    $password = $conn->real_escape_string($_POST['new-password']);
    $fullName = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $userType = $conn->real_escape_string($_POST['usertype']);

    // Insert into User table
    $insertUserSql = "INSERT INTO User (Username, Password, UserType, AccountStatus) 
                      VALUES ('$username', '$password', '$userType', 'Active')";
    
    if ($conn->query($insertUserSql) === TRUE) {
        // Get the generated UserID for the new user
        $newUserID = $conn->insert_id;

        // Extract first name and last name from full name
        $nameParts = explode(" ", $fullName);
        $firstName = $conn->real_escape_string($nameParts[0]);
        $lastName = $conn->real_escape_string(end($nameParts));

        // Insert into UserProfile table
        $insertUserProfileSql = "INSERT INTO UserProfile (UserID, FirstName, LastName, Email, Address) 
                                 VALUES ('$newUserID', '$firstName', '$lastName', '$email', '$address')";

        if ($conn->query($insertUserProfileSql) === TRUE) {
            // Registration successful, redirect to login page
            header("Location: login.php");
            exit;
        } else {
            echo "Error inserting into UserProfile table: " . $conn->error;
        }
    } else {
        echo "Error inserting into User table: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>