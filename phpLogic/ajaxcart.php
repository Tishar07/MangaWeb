<?php
session_start();
include("../db_connect.php"); //php/db_connect.php

if (!isset($_SESSION['UserID'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit();
}

$userId = $_SESSION['UserID'];
$action = $_POST['action'] ?? '';
$mangaId = isset($_POST['manga_id']) ? intval($_POST['manga_id']) : 0;

if ($action === 'add') {
    $quantity = 1;

    $stmt = $conn->prepare("SELECT Quantity FROM cart_items WHERE UserID = ? AND MangaID = ?");
    $stmt->bind_param("ii", $userId, $mangaId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $newQuantity = $row['Quantity'] + 1;
        $updateStmt = $conn->prepare("UPDATE cart_items SET Quantity = ? WHERE UserID = ? AND MangaID = ?");
        $updateStmt->bind_param("iii", $newQuantity, $userId, $mangaId);
        $updateStmt->execute();
    } else {

        $insertStmt = $conn->prepare("INSERT INTO cart_items (UserID, MangaID, Quantity) VALUES (?, ?, ?)");
        $insertStmt->bind_param("iii", $userId, $mangaId, $quantity);
        $insertStmt->execute();
    }
    
} elseif ($action === 'update') {
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    if ($quantity > 0) {
        $stmt = $conn->prepare("UPDATE cart_items SET Quantity = ? WHERE UserID = ? AND MangaID = ?");
        $stmt->bind_param("iii", $quantity, $userId, $mangaId);
        $stmt->execute();
    }
    
} elseif ($action === 'remove') {
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE UserID = ? AND MangaID = ?");
    $stmt->bind_param("ii", $userId, $mangaId);
    $stmt->execute();
    
}


$total = 0;
$sql = "SELECT SUM(m.Price * ci.Quantity) as total
        FROM cart_items ci
        JOIN manga m ON ci.MangaID = m.MangaID
        WHERE ci.UserID = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $total = $result['total'] ?? 0;
}

$count = 0;
$sql = "SELECT SUM(Quantity) as count FROM cart_items WHERE UserID = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $count = $result['count'] ?? 0;
}

echo json_encode([
    'status' => 'success',
    'cart_count' => $count,
    'total' => $total
]);

$conn->close();