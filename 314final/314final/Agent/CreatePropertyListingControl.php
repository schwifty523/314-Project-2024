<?php
// Include the database connection script
include("connectdb.php");
include("../PropertyListingEntity.php");


// Control Class
class CreatePropertyListingControl {
    private $entity;

    public function __construct($conn) {
        $this->entity = new PropertyListing($conn);
    }

    public function createPropertyListing($title, $address, $price, $developer, $propertyType) {
        // Generate a pseudo-view count for the property listing (for Seller use case)
        $viewCount = rand(0, 5000);

        // Generate a pseudo-shortlist view count for property listing (for Seller use case)
        $shortlistCount = rand(0, 100);
        
        // Pass data to the entity to create property listing
        return $this->entity->insertPropertyListing($title, $address, $price, $developer, $propertyType, $viewCount, $shortlistCount);

    }
}

// Create an instance of the createPropertyListingControl class
$control = new CreatePropertyListingControl($conn);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST["title"];
    $address = $_POST["address"]; 
    $price = $_POST["price"];
    $developer = $_POST["developer"];
    $propertyType = $_POST["propertyType"];

    // Call the createPropertyListing method of the control class
    $success = $control->createPropertyListing($title, $address, $price, $developer, $propertyType);

    // Return success or failure to the HTML form
    if ($success) {
        echo "success"; // Send success message
    } else {
        echo "failure"; // Send failure message
    }

    // Debugging statement
    // echo "Server-side response: " . ($success ? "success" : "failure");

}

// Close the database connection
//mysqli_close($conn);
?>
