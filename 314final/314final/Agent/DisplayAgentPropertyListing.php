<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Listings</title>





    <style>

        .DisplayAgentPropertyListing {
            margin-left: 220px; /* Adjust this value to create space for the side menu */
            padding-top: 20px; /* Adjust this value to prevent content from being hidden under the side menu */
        }

        .table {
            display: flex;
            flex-direction: column;
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .header {
            display: flex;
            background-color: #f2f2f2;
            border-bottom: 1px solid #ccc;
            font-weight: bold;
        }

        .header > div {
            flex: 1;
            padding: 10px;
        }

        .row {
            display: flex;
            border-bottom: 1px solid #ccc;
        }

        .row > div {
            flex: 1;
            padding: 10px;
        }

        .row .action-buttons button {
            margin-right: 5px;
        }
    </style>




<script>
        function confirmDeletion(event) {
            if (!confirm("Are you sure you want to delete this listing?")) {
                event.preventDefault(); // Prevent the form from being submitted
            }
        }
</script>


</head>
<body>
    <div class="DisplayAgentPropertyListing">
        <form method="GET" action="DisplayAgentPropertyListing.php">
            <input type="text" name="search" placeholder="Search by title or address">
            <button type="submit">Search</button>


    <?php
        include 'connectdb.php';
        


        include 'DisplayPropertyListingControl.php';
        include 'DeletePropertyListingControl.php';
        include 'ModifyPropertyListingControl.php';
        include 'SearchPropertyListingControl.php';

        

        $control = new DisplayPropertyListingControl($conn);
        $listings = $control->getPropertyListings();


        function getSearchQuery() {
            return isset($_GET['search']) ? $_GET['search'] : '';
        }

        $searchQuery = getSearchQuery();

       
        $searchcontrol = new SearchPropertyListingControl($conn);
        $listings = $searchcontrol->getSearchResults($searchQuery);






        if (!empty($listings)) {
            echo "<div class='table'>";
            echo "<div class='header'>";
            echo "<div>PropertyID</div>";
            echo "<div>Title</div>";
            echo "<div>Address</div>";
            echo "<div>Price</div>";
            echo "<div>Developer</div>";
            echo "<div>Property Type</div>";
            echo "<div>Actions</div>"; // New header for actions
            echo "</div>";

            foreach ($listings as $row) {
                echo "<div class='row'>";
                echo "<div>" . $row['propertyListingID'] . "</div>";
                echo "<div>" . $row['title'] . "</div>";
                echo "<div>" . $row['address'] . "</div>";
                echo "<div>" . $row['price'] . "</div>";
                echo "<div>" . $row['developer'] . "</div>";
                echo "<div>" . $row['propertyType'] . "</div>";

                echo "<div class='action-buttons'>";

                echo "<form method='POST' action='DeletePropertyListingControl.php'>";
                echo "<input type='hidden' name='propertyListingID' value='" . $row['propertyListingID'] . "'>";
                // echo "<button type='submit' name='delete'>Delete</button>";
                echo "<button type='submit' name='delete' onclick='confirmDeletion(event)'>Delete</button>";
                echo "</form>";
                
                echo "<form method='GET' action='ModifyPropertyListingForm.php'>";
                echo "<input type='hidden' name='propertyListingID' value='" . $row['propertyListingID'] . "'>";
                echo "<button type='submit' name='modify'>Modify</button>";


                echo "</form>";
                echo "</div>"; // Action buttons
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "No records found";
        }





           
   




        


?>

    </div>
</body>
</html>
