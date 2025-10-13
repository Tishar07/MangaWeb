<?php
require_once 'db_config.php';

// Add item to cart
function addToCart($userID, $mangaID, $quantity = 1) {
    global $conn;
    
    // Check if item already exists in cart
    $checkStmt = $conn->prepare("SELECT CartID, Quantity FROM cart WHERE UserID = ? AND MangaID = ?");
    $checkStmt->bind_param("ii", $userID, $mangaID);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        // Update quantity if item exists
        $row = $result->fetch_assoc();
        $newQuantity = $row['Quantity'] + $quantity;
        $updateStmt = $conn->prepare("UPDATE cart SET Quantity = ? WHERE CartID = ?");
        $updateStmt->bind_param("ii", $newQuantity, $row['CartID']);
        return $updateStmt->execute();
    } else {
        // Insert new item
        $insertStmt = $conn->prepare("INSERT INTO cart (UserID, MangaID, Quantity) VALUES (?, ?, ?)");
        $insertStmt->bind_param("iii", $userID, $mangaID, $quantity);
        return $insertStmt->execute();
    }
}

// Get cart items for a user
function getCartItems($userID) {
    global $conn;
    
    $stmt = $conn->prepare("
        SELECT c.CartID, c.MangaID, c.Quantity, c.DateAdded,
            m.Title, m.Price, m.Image, m.Stock,
               (c.Quantity * m.Price) as Subtotal
        FROM cart c
        INNER JOIN manga m ON c.MangaID = m.MangaID
        WHERE c.UserID = ?
        ORDER BY c.DateAdded DESC
    ");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    return $stmt->get_result();
}

// Get cart item count
function getCartCount($userID) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT SUM(Quantity) as total FROM cart WHERE UserID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}

// Update cart item quantity
function updateCartQuantity($cartID, $quantity) {
    global $conn;
    
    if ($quantity <= 0) {
        return removeFromCart($cartID);
    }
    
    $stmt = $conn->prepare("UPDATE cart SET Quantity = ? WHERE CartID = ?");
    $stmt->bind_param("ii", $quantity, $cartID);
    return $stmt->execute();
}

// Remove item from cart
function removeFromCart($cartID) {
    global $conn;
    
    $stmt = $conn->prepare("DELETE FROM cart WHERE CartID = ?");
    $stmt->bind_param("i", $cartID);
    return $stmt->execute();
}

// Clear entire cart for a user
function clearCart($userID) {
    global $conn;
    
    $stmt = $conn->prepare("DELETE FROM cart WHERE UserID = ?");
    $stmt->bind_param("i", $userID);
    return $stmt->execute();
}

// Get cart total
function getCartTotal($userID) {
    global $conn;
    
    $stmt = $conn->prepare("
        SELECT SUM(c.Quantity * m.Price) as total
        FROM cart c
        INNER JOIN manga m ON c.MangaID = m.MangaID
        WHERE c.UserID = ?
    ");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}
?>