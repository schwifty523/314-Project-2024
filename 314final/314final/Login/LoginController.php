<?php
// Database connection details
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "314db";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the database '314db'";
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form (sanitize inputs)
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Prepare SQL statement with prepared statement to prevent SQL injection
    $sql = "SELECT UserType FROM User WHERE Username = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Authentication successful, fetch user role
        $user = $result->fetch_assoc();
        
        // Redirect user based on role
        switch ($user['UserType']) {
            case 'System Administrator':
                header("Location: ../Admin/admin.php");
                exit;
            case 'Real Estate Agent':
                header("Location: ../Agent/AgentDashboard.html");
                exit;
            case 'Buyer':
                header("Location: ../Buyer/BuyerDashboard.html");
                exit;
            case 'Seller':
                header("Location: ../Seller/SellerDashboard.html");
                exit;
            default:
                // Log unknown role
                error_log("Unknown role: " . $user['UserType']);
                header("Location: login.php?error=1");
                exit;
        }
    } else {
        // Authentication failed, redirect back to login page with error
        header("Location: login.php?error=1");
        exit;
    }
}

// Close prepared statement and database connection
$stmt->close();
$conn->close();
?>
