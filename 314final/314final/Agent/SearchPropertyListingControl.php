<?php




class SearchPropertyListingControl {
    private $entity;

    public function __construct($conn) {
        $this->entity = new PropertyListing($conn);
    }

    public function getSearchResults($searchQuery) {
        return $this->entity->searchPropertyListings($searchQuery);
    }
}
?>
