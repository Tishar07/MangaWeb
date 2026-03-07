<?php
session_start();
include("db_connect.php");

header("Content-Type: text/xml; charset=UTF-8");

if (!isset($_SESSION['UserID'])) {
  echo '<?xml version="1.0" encoding="UTF-8"?>';
  echo '<UserAccount><Error>Not logged in</Error></UserAccount>';
  exit;
}

$userID = $_SESSION['UserID'];
$res = mysqli_query($conn, "SELECT * FROM Users WHERE UserID='$userID'");
$user = mysqli_fetch_assoc($res);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<UserAccount>
  <FirstName><?= htmlspecialchars($user['FirstName']) ?></FirstName>
  <LastName><?= htmlspecialchars($user['LastName']) ?></LastName>
  <Email><?= htmlspecialchars($user['Email']) ?></Email>
  <ContactNumber><?= htmlspecialchars($user['ContactNumber']) ?></ContactNumber>
  <Street><?= htmlspecialchars($user['Street']) ?></Street>
  <City><?= htmlspecialchars($user['City']) ?></City>
</UserAccount>