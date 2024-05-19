<?php

// ShortlistCountControl.php

include_once("../PropertyListingEntity.php"); // Include the entity class

class ShortlistCountControl {
    private $entity;

    public function __construct($conn) {
        $this->entity = new PropertyListing($conn);
    }

    // Method to get the shortlist count for a property listing
    public function getShortlistCount($propertyListingID) {
        return $this->entity->getShortlistCount($propertyListingID);
    }
}




//mysqli_close($conn);
?>