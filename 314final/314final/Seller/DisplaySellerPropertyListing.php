
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Listings</title>





    <style>

        .DisplaySellerPropertyListing {
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

        .action-buttons {
        display: flex;
        align-items: center; /* Align items vertically */
        }

        .row .action-buttons button {
            margin-right: 5px;
        }


        



        .row {
            position: relative;
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .view-count {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 5px;
            border-radius: 3px;
            display: none;
        }

        .row:hover .view-count {
            display: block;
        }
    </style>
</head>




<script>
        function showViewCount(element) {
            const viewCount = element.querySelector('.view-count');
            viewCount.style.display = 'block';
        }

        function hideViewCount(element) {
            const viewCount = element.querySelector('.view-count');
            viewCount.style.display = 'none';
        }
</script>






<body>
    <div class="DisplaySellerPropertyListing">
    <?php
        include 'connectdb.php';
        include 'DisplayListingViewCountControl.php';
        include 'ShortlistCountControl.php';
        

        $viewCountControl = new DisplayListingViewCountControl($conn);
        $listings = $viewCountControl->getPropertyListingsViewCount();

        // Initialize control objects
        $shortlistCountControl = new ShortlistCountControl($conn);

        function handleShortlistCount($shortlistCountControl) {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['shortlistCount'])) {
                $propertyListingID = $_POST['propertyListingID'];
                $shortlistCount = $shortlistCountControl->getShortlistCount($propertyListingID);
                echo "<script>alert('Shortlist Count: $shortlistCount');</script>";
            }
        }

        handleShortlistCount($shortlistCountControl);



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
                echo "<div class='row' onmouseover='showViewCount(this)' onmouseout='hideViewCount(this)'>";
                echo "<div>" . $row['propertyListingID'] . "</div>";
                echo "<div>" . $row['title'] . "</div>";
                echo "<div>" . $row['address'] . "</div>";
                echo "<div>" . $row['price'] . "</div>";
                echo "<div>" . $row['developer'] . "</div>";
                echo "<div>" . $row['propertyType'] . "</div>";
                echo "<div class='view-count' style='display: none;'>" . $row['viewCount'] . " views</div>";
                

                echo "<div class='action-buttons'>";

                echo "<form method='POST'> ";
                echo "<input type='hidden' name='propertyListingID' value='" . $row['propertyListingID'] . "'>";
                echo "<button type='submit' name='shortlistCount'>Shortlist Count</button>";
                echo "</form>";
                
                echo "</div>";
                echo "</div>"; // Action buttons
                
            }
            echo "</div>";
        } else {
            echo "No records found";
        }




        


?>

    </div>
</body>
</html>
