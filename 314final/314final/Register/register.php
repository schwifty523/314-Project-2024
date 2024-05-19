<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <link rel="stylesheet" href="register.css">
</head>
<body>
  <div class="registration-container">
    <h2>Registration for new account</h2>
    <!-- Registration form here -->
    <form id="registration-form" method="post" action="registercontroller.php">
      <div class="input-group">
        <label for="new-username">Username:</label>
        <input type="text" id="new-username" name="new-username" required>
      </div>
      <div class="input-group">
        <label for="new-password">Password:</label>
        <input type="password" id="new-password" name="new-password" required>
      </div>
      <div class="input-group">
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" required>
      </div>
      <div class="input-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="input-group">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
      </div>
      <div class="input-group">
        <label for="usertype">User Type:</label>
        <select id="usertype" name="usertype" required>
          <option value="" disabled selected>Select User Type</option>
          <option value="System Administrator">System Administrator</option>
          <option value="Real Estate Agent">Real Estate Agent</option>
          <option value="Buyer">Buyer</option>
          <option value="Seller">Seller</option>
        </select>
      </div>
      <button type="submit">Register</button>
    </form>
  </div>
</body>
</html>