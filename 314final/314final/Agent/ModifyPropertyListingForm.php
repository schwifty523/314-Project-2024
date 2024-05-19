

<?php
// This file ModifyPropertyListingForm.php is a boundary


$propertyListingID = $_GET['propertyListingID'];

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Property Listing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .PropertyForm {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
        }

        input[type="text"],
        select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>




</head>
<body>
    <div class="PropertyForm">
        <h2>Modify Property Listing</h2>
        <form method="POST" action="ModifyPropertyListingControl.php">
            <input type="hidden" name="propertyListingID" value="<?php echo $propertyListingID; ?>">

            <label for="title">New Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="address">New Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="price">New Price:</label>
            <input type="text" id="price" name="price" required>

            <label for="developer">New Developer:</label>
            <input type="text" id="developer" name="developer" required>

            <label for="propertyType">Property Type:</label>
            <select id="propertyType" name="propertyType" required>
                <option value="">Select Property Type</option>
                <option value="HDB">HDB</option>
                <option value="Apartment">Apartment</option>
                <option value="Condo">Condo</option>
                <option value="Townhouse">Townhouse</option>
                <option value="Terrace">Terrace</option>
            </select>

            <input type="submit" value="Modify">
        </form>
    </div>
</body>
</html>
