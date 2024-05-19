<?php
// DisplayListingViewCountControl.php
include("connectdb.php");
include('../PropertyListingEntity.php');

class DisplayListingViewCountControl {
    private $entity;

    public function __construct($conn) {
        $this->entity = new PropertyListing($conn);
    }


    // Method to get listings with view count
    public function getPropertyListingsViewCount() {
        return $this->entity->getPropertyListingsViewCount();
    }
}

//mysqli_close($conn);
?>
