<?php
require_once 'cart_functions.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in first']);
    exit;
}

$userID = $_SESSION['UserID'];
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $mangaID = intval($_POST['mangaID']);
        $quantity = intval($_POST['quantity'] ?? 1);
        
        if (addToCart($userID, $mangaID, $quantity)) {
            echo json_encode([
                'success' => true,
                'message' => 'Item added to cart',
                'cartCount' => getCartCount($userID)
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add item']);
        }
        break;
    
    case 'update':
        $cartID = intval($_POST['cartID']);
        $quantity = intval($_POST['quantity']);
        
        if (updateCartQuantity($cartID, $quantity)) {
            echo json_encode([
                'success' => true,
                'message' => 'Cart updated',
                'cartCount' => getCartCount($userID),
                'cartTotal' => getCartTotal($userID)
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
        }
        break;
    
    case 'remove':
        $cartID = intval($_POST['cartID']);
        
        if (removeFromCart($cartID)) {
            echo json_encode([
                'success' => true,
                'message' => 'Item removed from cart',
                'cartCount' => getCartCount($userID),
                'cartTotal' => getCartTotal($userID)
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to remove item']);
        }
        break;
    
    case 'clear':
        if (clearCart($userID)) {
            echo json_encode([
                'success' => true,
                'message' => 'Cart cleared',
                'cartCount' => 0
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to clear cart']);
        }
        break;
    
    case 'get':
        $items = getCartItems($userID);
        $cartData = [];
        
        while ($row = $items->fetch_assoc()) {
            $cartData[] = $row;
        }
        
        echo json_encode([
            'success' => true,
            'items' => $cartData,
            'total' => getCartTotal($userID),
            'count' => getCartCount($userID)
        ]);
        break;
    
    case 'count':
        echo json_encode([
            'success' => true,
            'count' => getCartCount($userID)
        ]);
        break;
    
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
?>