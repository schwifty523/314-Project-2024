<?php
session_start(); 

include("connectdb.php");

// Database connection parameters
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "314db";

// Create database connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
die("Connection failed: " . $e->getMessage());
}


class Buyer {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Display User Accounts
    public function displayUserAccounts() {
        $query = "SELECT * FROM PropertyListing";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewRatings() {
        try {
            $stmt = $this->conn->prepare("SELECT UserID, Rating, Comment FROM Ratings");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Logout
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ../Login/login.php'); 
        exit;
    }
}

// Instantiate Admin class using the database connection
$buyer = new Buyer($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snowstorm - Real Estate </title>
    <link rel="stylesheet" href="buyer.css">
    
</head>
<body onload="document.getElementById('defaultOpen').click();">

<div class="header">
    <h1>Snowstorm - Real Estate</h1>
</div>

<div class="tab">
    <button class="tablinks" id="defaultOpen" onclick="openTab(event, 'DisplayBuyerPropertyListing')">Display Listings</button>
    <button class="tablinks" onclick="openTab(event, 'view_ratings')">View Ratings</button>
    <a href="../Login/logout.php" class="tablinks">Logout</a>

</div>

<div id="display_listing" class="tabcontent">
    <h2>Display Listing</h2>
    <div class="search-container">
        <input type="text" placeholder="Search Listing..." id="searchListing">
        <button onclick="searchListing('display_listing', 'searchListing')">Search</button>
    </div>
    <?php
    // Display User Accounts
    $userAccounts = $buyer->displayUserAccounts();
    echo "<table id='userAccountsTable' border='1'>";
    echo "<tr><th>Property ID</th><th>Title</th><th>Address</th><th>Price</th><th>Developer</th><th>Property Type</th><th>Status</th></tr>";
    foreach ($userAccounts as $listing) {
        echo "<tr>";
        echo "<td>{$listing['PropertyListingID']}</td>";
        echo "<td>{$listing['Title']}</td>";
        echo "<td>{$listing['Address']}</td>";
        echo "<td>{$listing['Price']}</td>";
        echo "<td>{$listing['Developer']}</td>";
        echo "<td>{$listing['PropertyType']}</td>";
        echo "<td>{$listing['Status']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
</div>

<script>
    
    function searchListing(tableId, inputId) {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById(inputId);
    filter = input.value.toUpperCase();
    table = document.getElementById(tableId);

    if (!table || !input) {
        console.error("Table or input element not found.");
        return;
    }

    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        tr[i].style.display = "";

        for (j = 0; j < tr[i].cells.length; j++) {
            td = tr[i].cells[j];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break; 
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}
</script>
<div id="DisplayBuyerPropertyListing" class="tabcontent" style="display: block;">
    <?php
    include("DisplayBuyerPropertyListing.php");
    ?>
</div>

<div id="view_ratings" class="tabcontent">
                <h2>View Ratings</h2>
                        <?php
                        $ratings = $buyer->viewRatings();
                        echo "<table id='userRatingTable' border='1'>";
                        echo "<tr><th>User ID</th><th>Rating</th><th>Comment</th></tr>";
                        foreach ($ratings as $rating) {
                            echo "<tr>";
                            echo "<td>{$rating['UserID']}</td>";
                            echo "<td>{$rating['Rating']}</td>";
                            echo "<td>{$rating['Comment']}</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        
                        ?>
            </div>
        </div>

        <div id="saved_property" class="tabcontent">
                <h2>Saved Property</h2>
                        <?php
                        $ratings = $buyer->viewRatings();
                        echo "<table id='userRatingTable' border='1'>";
                        echo "<tr><th>User ID</th><th>Rating</th><th>Comment</th></tr>";
                        foreach ($ratings as $rating) {
                            echo "<tr>";
                            echo "<td>{$rating['UserID']}</td>";
                            echo "<td>{$rating['Rating']}</td>";
                            echo "<td>{$rating['Comment']}</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        
                        ?>
            </div>
        </div>

<script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    window.onclick = function(event) {
        var userModal = document.getElementById('modifyUserModal');
        var profileModal = document.getElementById('modifyProfileModal');
        if (event.target == userModal) {
            userModal.style.display = "none";
        }
        if (event.target == profileModal) {
            profileModal.style.display = "none";
        }
    }
</script>
</body>
</html>