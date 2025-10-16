<?php
session_start();
include("db_connect.php");
if (!isset($_SESSION['UserID'])) {
    header("Location: ../login.php");
    exit;
}

$userID = $_SESSION['UserID'];
$fname = $_POST['FirstName'];
$lname = $_POST['LastName'];
$email = $_POST['Email'];
$contact = $_POST['ContactNumber'];
$street = $_POST['Street'];
$city = $_POST['City'];
$password = $_POST['password'];

if (!empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE users SET FirstName='$fname', LastName='$lname', Email='$email', ContactNumber='$contact', Street='$street', City='$city', password='$password' WHERE UserID='$userID'";
} else {
    $query = "UPDATE users SET FirstName='$fname', LastName='$lname', Email='$email', ContactNumber='$contact', Street='$street', City='$city' WHERE UserID='$userID'";
}

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Account updated successfully!'); window.location.href='../account.php';</script>";
} else {
    echo "<script>alert('Error updating account.'); window.location.href='../account.php';</script>";
}

?>
