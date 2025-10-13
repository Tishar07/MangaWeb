<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mangastore";

$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
