<?php

include __DIR__ . '/Seller/connectdb.php';



// Entity Class
class PropertyListing {
    private $conn;


    
    public function __construct($conn) {
        $this->conn = $conn;
    }



    public function insertPropertyListing($title, $address, $price, $developer, $propertyType, $viewCount, $shortlistCount) {
        // Perform database operation to insert property listing
        $sql = "INSERT INTO property_table (title, address, price, developer, propertyType, viewCount, shortlistCount)
                VALUES ('$title', '$address', '$price', '$developer', '$propertyType', $viewCount, $shortlistCount)";

        return mysqli_query($this->conn, $sql);
    }




    public function getPropertyListings() {
        $listings = [];
        // Query to fetch data from the property_table
        $sql = "SELECT propertyListingID, title, address, price, developer, propertyType FROM property_table";
        $result = mysqli_query($this->conn, $sql);

        // Check if there are any rows in the result
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $listings[] = $row;
            }
        }
        return $listings;
    }  




    public function deletePropertyListing($propertyListingID) {
        // Perform database operation to delete property listing
        $sql = "DELETE FROM property_table WHERE propertyListingID = $propertyListingID";
        return mysqli_query($this->conn, $sql);
    }


    

    public function modifyPropertyListing($propertyListingID, $title, $address, $price, $developer, $propertyType) {
        // Prepare SQL statement
        $sql = "UPDATE property_table SET title = ?, address = ?, price = ?, developer = ?, propertyType = ? WHERE propertyListingID = ?";
        
        // Prepare the statement
        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            // Handle error if preparation fails
            return false;
        }
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssdssi", $title, $address, $price, $developer, $propertyType, $propertyListingID);
        
        // Execute the statement
        $result = mysqli_stmt_execute($stmt);
        
        // Check for errors
        if ($result === false) {
            // Handle error if execution fails
            return false;
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        return true; // Return true if modification was successful
    }
    



    public function searchPropertyListings($searchQuery) {
        // Initialize an empty array to store the resulting property listings
        $listings = [];

        // Construct the SQL query to select specific columns from the property_table
        // where the title or address matches the search query
        $sql = "SELECT propertyListingID, title, address, price, developer, propertyType 
                FROM property_table 
                WHERE title LIKE ? OR address LIKE ?";

        // Prepare the SQL statement
        $stmt = mysqli_prepare($this->conn, $sql);
        // If preparation of the statement fails, return an empty array
        if (!$stmt) {
            return $listings;
        }

        // Add '%' symbols to the search query to perform partial matches
        $searchQuery = '%' . $searchQuery . '%';
        // Bind the search query parameters to the SQL statement
        mysqli_stmt_bind_param($stmt, "ss", $searchQuery, $searchQuery);
        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Get the result set
        $result = mysqli_stmt_get_result($stmt);
        // If there are results and the number of rows is greater than zero
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch each row and add it to the $listings array
            while ($row = mysqli_fetch_assoc($result)) {
                $listings[] = $row;
            }
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
        // Return the array of listings
        return $listings;
    }







// For Seller 
    // New method to get listings with view count
    public function getPropertyListingsViewCount() {
        $listings = [];
        $sql = "SELECT propertyListingID, title, address, price, developer, propertyType, viewCount FROM property_table";
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $listings[] = $row;
            }
        }
        return $listings;
    }




    // Method to retrieve shortlist count from the database
    public function getShortlistCount($propertyListingID) {
        $sql = "SELECT shortlistCount FROM property_table WHERE propertyListingID = $propertyListingID";
        $result = mysqli_query($this->conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['shortlistCount'];
        } else {
            return 0; // Default to 0 if no shortlist count found
        }
    }








}









// mysqli_close($conn);

?>