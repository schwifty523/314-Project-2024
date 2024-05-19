<?php
// Include the database connection script
//include("connectdb.php");
include("../PropertyListingEntity.php");
//include("DisplayPropertyListingControl.php");

// DeletePropertyListingControl.php

class DeletePropertyListingControl {
    private $entity;

    public function __construct($conn) {
        $this->entity = new PropertyListing($conn);
    }

    public function deletePropertyListing($propertyListingID) {
        return $this->entity->deletePropertyListing($propertyListingID);
    }




}

if (isset($_POST['delete'])) {
    $propertyListingID = $_POST['propertyListingID'];
    $control = new DeletePropertyListingControl($conn);
    
    if ($control->deletePropertyListing($propertyListingID)) {
        header("Location: DisplayAgentPropertyListing.php?success=1");
        exit();
    } else {
        header("Location: DisplayAgentPropertyListing.php?error=1");
        exit();
    }
}

?>
