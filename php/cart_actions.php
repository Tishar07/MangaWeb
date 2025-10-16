<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("db_connect.php");
$userID = $_SESSION['UserID'];
$action = $_POST['action'] ?? '';
$mangaID = intval($_POST['MangaID'] ?? 0);

if(!$userID || !$mangaID){
    echo json_encode(["message"=>"Invalid request","cart"=>[]]);
    exit;
}


$stmt = $conn->prepare("SELECT MangaName, Price FROM manga WHERE MangaID=?");
$stmt->bind_param("i",$mangaID);
$stmt->execute();
$manga = $stmt->get_result()->fetch_assoc();
if(!$manga){
    echo json_encode(["message"=>"Manga not found","cart"=>[]]);
    exit;
}

if($action==="add"){
    $stmt = $conn->prepare("INSERT INTO cart_items(UserID,MangaID,Quantity) VALUES(?,?,1) ON DUPLICATE KEY UPDATE Quantity=Quantity+1");
    $stmt->bind_param("ii",$userID,$mangaID);
    $stmt->execute();
    $message = "{$manga['MangaName']} added to cart!";
} elseif($action==="remove"){
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE UserID=? AND MangaID=?");
    $stmt->bind_param("ii",$userID,$mangaID);
    $stmt->execute();
    $message = "{$manga['MangaName']} removed from cart.";
}


$stmt = $conn->prepare("SELECT m.MangaName, m.Price FROM cart_items c JOIN manga m ON c.MangaID=m.MangaID WHERE c.UserID=?");
$stmt->bind_param("i",$userID);
$stmt->execute();
$result = $stmt->get_result();
$cart = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode(["message"=>$message,"cart"=>$cart]);
