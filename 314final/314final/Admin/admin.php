<?php
session_start(); 

// Database connection parameters
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "314db";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the database '314db'";
}



class Admin {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Create User Account with Profile
    public function createUserWithProfile($username, $password, $userType, $firstName, $lastName, $email, $phone, $address, $city, $state, $zipCode) {
        $queryUser = $this->conn->prepare("INSERT INTO User (Username, Password, UserType, AccountStatus) VALUES (?, ?, ?, 'Active')");
        $queryUser->bind_param("sss", $username, $password, $userType);
        $queryUser->execute();
        $userId = $this->conn->insert_id;
        $queryProfile = $this->conn->prepare("INSERT INTO UserProfile (UserID, FirstName, LastName, Email, Phone, Address, City, State, ZipCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $queryProfile->bind_param("issssssss", $userId, $firstName, $lastName, $email, $phone, $address, $city, $state, $zipCode);
    
        return $queryProfile->execute();
    }
    

    // Display User Accounts
    public function displayUserAccounts() {
        $query = "SELECT * FROM User";
        $result = $this->conn->query($query);   
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Display User Profiles
    public function displayUserProfiles() {
        $query = "SELECT * FROM UserProfile";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Modify User Account
    public function modifyUserAccount($userId, $newUsername, $newPassword, $newUserType, $newAccountStatus) {
        $query = "UPDATE User SET Username=?, Password=?, UserType=?, AccountStatus=? WHERE UserID=?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$newUsername, $newPassword, $newUserType, $newAccountStatus, $userId]);

        // Update corresponding fields in UserProfile
        $queryProfile = "UPDATE UserProfile 
                         SET FirstName=?, LastName=?, Email=?, Phone=?, Address=?, City=?, State=?, ZipCode=?, AccountStatus=?
                         WHERE UserID=?";
        $stmtProfile = $this->conn->prepare($queryProfile);
        return $stmtProfile->execute([$newFirstName, $newLastName, $newEmail, $newPhone, $newAddress, $newCity, $newState, $newZipCode, $newAccountStatus, $userId]);

        
    }
    
    public function modifyUserProfile($userId, $newFirstName, $newLastName, $newEmail, $newPhone, $newAddress, $newCity, $newState, $newZipCode, $newAccountStatus) {
        $query = "UPDATE UserProfile 
                  SET FirstName=?, LastName=?, Email=?, Phone=?, Address=?, City=?, State=?, ZipCode=?, AccountStatus=?
                  WHERE UserID=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$newFirstName, $newLastName, $newEmail, $newPhone, $newAddress, $newCity, $newState, $newZipCode, $newAccountStatus, $userId]);

        // Update corresponding fields in User table
        $queryUser = "UPDATE User 
                      SET AccountStatus=?
                      WHERE UserID=?";
        $stmtUser = $this->conn->prepare($queryUser);
        return $stmtUser->execute([$newAccountStatus, $userId]);

        echo "<script>window.location.href = 'admin.php#userProfiles';</script>";
    exit();
    }

    
    // Login
    public function login($username, $password) {
        $query = $this->conn->prepare("SELECT * FROM User WHERE Username = ?");
        $query->bind_param("s", $username);
        $query->execute();
        $result = $query->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['Password'])) {
            $_SESSION['user'] = $user;
            return true;
        }

        return false;
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
$admin = new Admin($conn);

// Handle form submissions and user actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle user creation form submission
    if (isset($_POST['create_user'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $userType = $_POST['userType'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zipCode = $_POST['zip_code'];
       
        $result = $admin->createUserWithProfile($username, $password, $userType, $firstName, $lastName, $email, $phone, $address, $city, $state, $zipCode,$newAccountStatus);
        if ($result) {
            echo "User account created successfully!";
        } else {
            echo "Failed to create user account.";
        }
    }

    // Handle modify user form submission
    if (isset($_POST['modify_user'])) {
        $userId = $_POST['user_id'];
        $newUsername = $_POST['new_username'];
        $newPassword = $_POST['new_password'];
        $newUserType = $_POST['new_user_type'];
        $newAccountStatus = $_POST['new_account_status'];

        $result = $admin->modifyUserAccount($userId, $newUsername, $newPassword, $newUserType, $newAccountStatus);
        if ($result) {
            echo "User account modified successfully!";
        } else {
            echo "Failed to modify user account.";
        }
    }

    // Handle modify profile form submission
    if (isset($_POST['modify_profile'])) {
        $userId = $_POST['profile_user_id'];
        $firstName = $_POST['new_first_name'];
        $lastName = $_POST['new_last_name'];
        $email = $_POST['new_email'];
        $phone = $_POST['new_phone'];
        $address = $_POST['new_address'];
        $city = $_POST['new_city'];
        $state = $_POST['new_state'];
        $zipCode = $_POST['new_zip_code'];
        $newAccountStatus = $_POST['new_account_status'];

        $result = $admin->modifyUserProfile($userId, $firstName, $lastName, $email, $phone, $address, $city, $state, $zipCode,$newAccountStatus);
        if ($result) {
            echo "User profile modified successfully!";
        } else {
            echo "Failed to modify user profile.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snowstorm - Real Estate </title>
    <link rel="stylesheet" href="admin.css">
    <style>
    
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .tab a.tablinks {
            color: white;
            background-color: #f44336;
            border: none;
            padding: 14px 16px;
            cursor: pointer;
            float: right;
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }


    </style>
</head>
<body onload="document.getElementById('defaultOpen').click();">

<div class="header">
    <h1>Snowstorm - Real Estate</h1>
</div>

<div class="tab">
    <button class="tablinks" id="defaultOpen" onclick="openTab(event, 'userAccounts')">User Accounts</button>
    <button class="tablinks" onclick="openTab(event, 'userProfiles')">User Profiles</button>
    <button class="tablinks" onclick="openTab(event, 'createUser')">Create User</button>
    <a href="../Login/logout.php" class="tablinks">Logout</a>
</div>

<div id="userAccounts" class="tabcontent">
    <h2>User Accounts</h2>
    <div class="search-container">
        <input type="text" placeholder="Search User Accounts..." id="searchAccountsInput">
        <button onclick="searchUsers('userAccountsTable', 'searchAccountsInput')">Search</button>
    </div>
    <?php
    $userAccounts = $admin->displayUserAccounts();
    echo "<table id='userAccountsTable'>";
    echo "<tr><th>UserID</th><th>Username</th><th>UserType</th><th>AccountStatus</th></tr>";
    foreach ($userAccounts as $account) {
        echo "<tr>";
        echo "<td>{$account['UserID']}</td>";
        echo "<td>{$account['Username']}</td>";
        //echo "<td>{$account['Password']}</td>";
        echo "<td>{$account['UserType']}</td>";
        echo "<td>{$account['AccountStatus']}</td>";
        echo "<td><button onclick=\"openModifyUserModal('{$account['UserID']}', '{$account['Username']}', '{$account['Password']}', '{$account['UserType']}', '{$account['AccountStatus']}')\">Modify</button></td>"; // Modify button
        echo "</tr>"; }
    echo "</table>";
    ?>
</div>

<div id="userProfiles" class="tabcontent">
    <h2>User Profiles</h2>
    <div class="search-container">
        <input type="text" placeholder="Search User Profiles..." id="searchProfilesInput">
        <button onclick="searchUsers('userProfilesTable', 'searchProfilesInput')">Search</button>
    </div>
    <?php
    $userProfiles = $admin->displayUserProfiles();
    echo "<table id='userProfilesTable'>";
    echo "<tr><th>UserID</th><th>FirstName</th><th>LastName</th><th>Email</th><th>Phone</th><th>Address</th><th>City</th><th>State</th><th>ZipCode</th><th>AccountStatus</th></tr>";

    foreach ($userProfiles as $profile) {
        echo "<tr>";
        echo "<td>{$profile['UserID']}</td>";
        echo "<td>{$profile['FirstName']}</td>";
        echo "<td>{$profile['LastName']}</td>";
        echo "<td>{$profile['Email']}</td>";
        echo "<td>{$profile['Phone']}</td>";
        echo "<td>{$profile['Address']}</td>";
        echo "<td>{$profile['City']}</td>";
        echo "<td>{$profile['State']}</td>";
        echo "<td>{$profile['ZipCode']}</td>";
        echo "<td>{$profile['AccountStatus']}</td>";
        echo "<td><button onclick=\"openModifyProfileModal('{$profile['UserID']}', '{$profile['FirstName']}', '{$profile['LastName']}','{$profile['Email']}', '{$profile['Phone']}', '{$profile['Address']}', '{$profile['City']}', '{$profile['State']}', '{$profile['ZipCode']}', '{$profile['AccountStatus']}')\">Modify</button></td>"; // Modify button
        echo "</tr>";}
    echo "</table>";
    
    ?>
</div>

<div id="createUser" class="tabcontent">
    <h2>Create User</h2>
    <form method="post">
        <table>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td>First Name:</td>
                <td><input type="text" name="first_name"required></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="last_name" required></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="text" name="email"required></td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td><input type="text" name="phone"required></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><input type="text" name="address"required></td>
            </tr>
            <tr>
                <td>City:</td>
                <td><input type="text" name="city"required></td>
            </tr>
            <tr>
                <td>State:</td>
                <td><input type="text" name="state"required></td>
            </tr>
            <tr>
                <td>Zip Code:</td>
                <td><input type="text" name="zip_code"required></td>
            </tr>
            <tr>
                <td>User Type:</td>
                <td><select type="text" id="userType" name="userType" required>
          <option value="" disabled selected>Select User Type</option>
          <option value="System Administrator">System Administrator</option>
          <option value="Real Estate Agent">Real Estate Agent</option>
          <option value="Buyer">Buyer</option>
          <option value="Seller">Seller</option>
        </select>
      </td>
            </tr>
        </table>
        <input type="submit" name="create_user" value="Create User">
    </form>
</div>


<div id="modifyUserModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModifyUserModal()">&times;</span>
        <h2>Modify User Account</h2>
        <form method="post">
            <input type="hidden" id="modifyUserId" name="user_id">
            <table>
                <tr>
                    <td>New Username:</td>
                    <td><input type="text" id="modifyUsername" name="new_username"></td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td><input type="password" id="modifyPassword" name="new_password"></td>
                </tr>
                <tr>
                    <td>New User Type:</td>
                    <td><select type="text" id="modifyUserType" name="new_user_type">
                     <option value="System Administrator">System Administrator</option>
                    <option value="Real Estate Agent">Real Estate Agent</option>
                     <option value="Buyer">Buyer</option>
                    <option value="Seller">Seller</option>
                     </select></td>
                </tr>
                <tr>
                    <td>New Account Status:</td>
                    <td><select type="text" id="modifyAccountStatus" name="new_account_status">
                        <option value = "Active"> Active </option>
                        <option value = "Suspended"> Suspended </option>
                </select>
                    </td>
                
                </tr>
            </table>
            <input type="submit" name="modify_user" value="Modify User">
        </form>
    </div>
</div>

<!-- Modify User Profile Modal -->
<div id="modifyProfileModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModifyProfileModal()">&times;</span>
        <h2>Modify User Profile</h2>
        <form method="post">
            <input type="hidden" id="modifyProfileUserId" name="profile_user_id">
            <table>
                <tr>
                    <td>First Name:</td>
                    <td><input type="text" id="modifyFirstName" name="new_first_name"></td>
                </tr>
                <tr>
                    <td>Last Name:</td>
                    <td><input type="text" id="modifyLastName" name="new_last_name"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" id="modifyEmail" name="new_email"></td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td><input type="text" id="modifyPhone" name="new_phone"></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><input type="text" id="modifyAddress" name="new_address"></td>
                </tr>
                <tr>
                    <td>City:</td>
                    <td><input type="text" id="modifyCity" name="new_city"></td>
                </tr>
                <tr>
                    <td>State:</td>
                    <td><input type="text" id="modifyState" name="new_state"></td>
                </tr>
                <tr>
                    <td>Zip Code:</td>
                    <td><input type="text" id="modifyZipCode" name="new_zip_code"></td>
                    </tr>
                <tr>
                <td>New Account Status:</td>
                    <td><select type="text" id="modifyAccountStatus" name="new_account_status">
                        <option value = "Active"> Active </option>
                        <option value = "Suspended"> Suspended </option>
                
                </select>
                    </td>   
                </tr>
            </table>
            <input type="submit" name="modify_profile" value="Modify Profile">
        </form>
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

function openModifyUserModal(userID, username,password, userType, accountStatus) 
{
    document.getElementById('modifyUserId').value = userID;
        document.getElementById('modifyUsername').value = username;
        document.getElementById('modifyPassword').value = password;
        document.getElementById('modifyUserType').value = userType;
        document.getElementById('modifyAccountStatus').value = accountStatus;
        document.getElementById('modifyUserModal').style.display = "block";
    }

    function closeModifyUserModal() {
        document.getElementById('modifyUserModal').style.display = "none";
    }

    function openModifyProfileModal(userID, firstName, lastName, email, phone, address, city, state, zipCode, accountStatus) {
        document.getElementById('modifyProfileUserId').value = userID;
        document.getElementById('modifyFirstName').value = firstName;
        document.getElementById('modifyLastName').value = lastName;
        document.getElementById('modifyEmail').value = email;
        document.getElementById('modifyPhone').value = phone;
        document.getElementById('modifyAddress').value = address;
        document.getElementById('modifyCity').value = city;
        document.getElementById('modifyState').value = state;
        document.getElementById('modifyZipCode').value = zipCode;
        document.getElementById('modifyAccountStatus').value = accountStatus;
        document.getElementById('modifyProfileModal').style.display = "block";
    }

    function closeModifyProfileModal() {
        document.getElementById('modifyProfileModal').style.display = "none";
    }
    


function searchUsers(tableId, inputId) {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById(inputId);
    filter = input.value.toUpperCase();
    table = document.getElementById(tableId);
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = "none";
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}
</script>



</body>
</html>
