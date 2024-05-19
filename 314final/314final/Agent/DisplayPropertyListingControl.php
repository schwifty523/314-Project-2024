<?php
// DisplayPropertyListingControl.php
include("connectdb.php");
//include('PropertyListingEntity.php');

class DisplayPropertyListingControl {
    private $entity;

    public function __construct($conn) {
        $this->entity = new PropertyListing($conn);
    }

    public function getPropertyListings() {
        // Get property listings from the entity
        return $this->entity->getPropertyListings();
    }
}
//mysqli_close($conn);
?>
