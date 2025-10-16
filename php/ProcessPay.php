<?php
session_start();
include("db_connect.php"); 

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['UserID'];

$stmt = $conn->prepare("
    SELECT SUM(m.Price) AS Total
    FROM cart_items c
    JOIN manga m ON c.MangaID = m.MangaID
    WHERE c.UserID = ?
");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalPrice = $row['Total'] ?? 0; 
$stmt->close();

$paymentStatus = "Paid";
$stmt = $conn->prepare("INSERT INTO orders (UserID, PaymentStatus, TotalPrice) VALUES (?, ?, ?)");
$stmt->bind_param("isd", $userID, $paymentStatus, $totalPrice);
$stmt->execute();
$orderID = $stmt->insert_id;
$stmt->close();


$stmt = $conn->prepare("
    INSERT INTO order_manga (OrderID, MangaID)
    SELECT ?, MangaID FROM cart_items WHERE UserID = ?
");
$stmt->bind_param("ii", $orderID, $userID);
$stmt->execute();
$stmt->close();


$stmt = $conn->prepare("SELECT MangaID FROM cart_items WHERE UserID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$cartItems = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();


foreach ($cartItems as $item) {
    $stmt = $conn->prepare("UPDATE manga SET UnitsAvailable = UnitsAvailable - 1 WHERE MangaID = ?");
    $stmt->bind_param("i", $item['MangaID']);
    $stmt->execute();
    $stmt->close();
}


$stmt = $conn->prepare("DELETE FROM cart_items WHERE UserID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->close();


header("Location: ../index.php");
exit;
?>
