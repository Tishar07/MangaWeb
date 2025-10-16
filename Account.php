<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account</title>
  <link rel="icon" href="Assets/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="CSS/Navbar.css">
  <link rel="stylesheet" href="CSS/Footer.css">
  <link rel="stylesheet" href="CSS/Account.css">
</head>

<body>
  <?php include("Navbar.php"); ?>

  <div class="account-container">
    <h2>My Account</h2>

    <?php
    
    include("php/db_connect.php");

    if (!isset($_SESSION['UserID'])) {
        echo "<p>Please <a href='login.php' style='color:#ff5555;'>login</a> to view your account.</p>";
        exit;
    }

    $userID = $_SESSION['UserID'];
    $query = "SELECT * FROM Users WHERE UserID = '$userID'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    ?>

    <form class="account-card" action="php/update_user.php" method="POST">
      <label for="fname">First Name</label>
      <input type="text" id="fname" name="FirstName" value="<?= htmlspecialchars($user['FirstName']) ?>" required>

      <label for="lname">Last Name</label>
      <input type="text" id="lname" name="LastName" value="<?= htmlspecialchars($user['LastName']) ?>" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="Email" value="<?= htmlspecialchars($user['Email']) ?>" required>

      <label for="ContactNumber">Contact Number</label>
      <input type="text" id="ContactNumber" name="ContactNumber" value="<?= htmlspecialchars($user['ContactNumber']) ?>">

      <label for="street">Street</label>
      <input type="text" id="street" name="Street" value="<?= htmlspecialchars($user['Street']) ?>">

      <label for="city">City</label>
      <input type="text" id="city" name="City" value="<?= htmlspecialchars($user['City']) ?>">

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter new password">

      <button type="submit" class="save-btn">Save Changes</button>
    </form>

    <a href="logout.php" class="logout-link">Logout</a>
  </div>

  <?php include("Footer.php"); ?>
</body>

</html>
