<?php
// Include the database connection script
include'connectdb.php';
include_once("../PropertyListingEntity.php");


// ModifyPropertyListingControl.php

class ModifyPropertyListingControl {
    private $entity;

    public function __construct($conn) {
        $this->entity = new PropertyListing($conn);
    }

    public function modifyPropertyListing($propertyListingID, $title, $address, $price, $developer, $propertyType) {
        return $this->entity->modifyPropertyListing($propertyListingID, $title, $address, $price, $developer, $propertyType);
    }
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $propertyListingID = $_POST["propertyListingID"];
    $title = $_POST["title"];
    $address = $_POST["address"];
    $price = $_POST["price"];
    $developer = $_POST["developer"];
    $propertyType = $_POST["propertyType"];

    // Create an instance of ModifyPropertyListingControl
    $control = new ModifyPropertyListingControl($conn);

    // Call the modifyPropertyListing method
    $success = $control->modifyPropertyListing($propertyListingID, $title, $address, $price, $developer, $propertyType);

    // Redirect user based on success or failure
    if ($success) {
        // Modification successful, redirect to listing page
        header("Location: DisplayAgentPropertyListing.php");
        exit;
    } else {
        // Modification failed, handle error
        echo "Modification failed.";
    }
}

?>
