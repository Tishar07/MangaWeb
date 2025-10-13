<?php
require_once 'cart_functions.php';

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    header('Location: login.php');
    exit;
}

$userID = $_SESSION['UserID'];
$cartItems = getCartItems($userID);
$cartTotal = getCartTotal($userID);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Manga4u</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
        }
        
        .navbar {
            background-color: #000;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #333;
        }
        
        .logo {
            color: #ff4444;
            font-size: 28px;
            font-weight: bold;
        }
        
        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }
        
        .nav-links a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .nav-links a:hover {
            color: #ff4444;
        }
        
        .cart-badge {
            background: #ff4444;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
        
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        h1 {
            margin-bottom: 30px;
            font-size: 32px;
        }
        
        .cart-empty {
            text-align: center;
            padding: 60px 20px;
            background: #1a1a1a;
            border-radius: 8px;
        }
        
        .cart-empty h2 {
            margin-bottom: 20px;
            color: #888;
        }
        
        .btn {
            background: #ff4444;
            color: #fff;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn:hover {
            background: #cc3333;
        }
        
        .cart-items {
            background: #1a1a1a;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .cart-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid #333;
            align-items: center;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .item-image {
            width: 100px;
            height: 140px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-title {
            font-size: 20px;
            margin-bottom: 10px;
        }
        
        .item-price {
            color: #ff4444;
            font-size: 18px;
            font-weight: bold;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .qty-btn {
            background: #333;
            color: #fff;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 18px;
        }
        
        .qty-btn:hover {
            background: #444;
        }
        
        .qty-input {
            width: 60px;
            text-align: center;
            padding: 8px;
            background: #222;
            border: 1px solid #444;
            color: #fff;
            border-radius: 4px;
        }
        
        .remove-btn {
            background: #cc0000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        
        .remove-btn:hover {
            background: #990000;
        }
        
        .cart-summary {
            background: #1a1a1a;
            border-radius: 8px;
            padding: 30px;
            max-width: 400px;
            margin-left: auto;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #333;
        }
        
        .summary-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .summary-total {
            font-size: 24px;
            font-weight: bold;
            color: #ff4444;
        }
        
        .checkout-btn {
            width: 100%;
            margin-top: 20px;
        }
        
        .clear-cart-btn {
            background: #444;
            margin-top: 10px;
            width: 100%;
        }
        
        .clear-cart-btn:hover {
            background: #555;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }
        
        .alert-success {
            background: #00cc44;
            color: #fff;
        }
        
        .alert-error {
            background: #cc0000;
            color: #fff;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">Manga4u</div>
        <div class="nav-links">
            <a href="index.php">🏠 Home</a>
            <a href="manga-list.php">📚 Manga List</a>
            <a href="cart.php">
                🛒 Cart 
                <span class="cart-badge" id="cartCount"><?php echo getCartCount($userID); ?></span>
            </a>
            <a href="account.php">👤 Account</a>
        </div>
    </nav>

    <div class="container">
        <h1>Shopping Cart</h1>
        
        <div id="alertBox" class="alert"></div>
        
        <?php if ($cartItems->num_rows === 0): ?>
            <div class="cart-empty">
                <h2>Your cart is empty</h2>
                <p style="margin-bottom: 20px; color: #888;">Add some manga to get started!</p>
                <a href="manga-list.php" class="btn">Browse Manga</a>
            </div>
        <?php else: ?>
            <div class="cart-items">
                <?php while ($item = $cartItems->fetch_assoc()): ?>
                    <div class="cart-item" data-cart-id="<?php echo $item['CartID']; ?>">
                        <img src="<?php echo htmlspecialchars($item['Image'] ?? 'placeholder.jpg'); ?>" 
                            alt="<?php echo htmlspecialchars($item['Title']); ?>" 
                            class="item-image">
                        
                        <div class="item-details">
                            <div class="item-title"><?php echo htmlspecialchars($item['Title']); ?></div>
                            <div class="item-price">$<?php echo number_format($item['Price'], 2); ?></div>
                            <div style="margin-top: 10px; color: #888;">
                                Stock: <?php echo $item['Stock']; ?>
                            </div>
                        </div>
                        
                        <div class="quantity-control">
                            <button class="qty-btn" onclick="updateQuantity(<?php echo $item['CartID']; ?>, -1)">-</button>
                            <input type="number" 
                                class="qty-input" 
                                value="<?php echo $item['Quantity']; ?>" 
                                min="1" 
                                max="<?php echo $item['Stock']; ?>"
                                onchange="updateQuantityDirect(<?php echo $item['CartID']; ?>, this.value)">
                            <button class="qty-btn" onclick="updateQuantity(<?php echo $item['CartID']; ?>, 1)">+</button>
                        </div>
                        
                        <div style="text-align: right; min-width: 100px;">
                            <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">
                                $<span class="item-subtotal"><?php echo number_format($item['Subtotal'], 2); ?></span>
                            </div>
                            <button class="remove-btn" onclick="removeItem(<?php echo $item['CartID']; ?>)">Remove</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>$<span id="cartSubtotal"><?php echo number_format($cartTotal, 2); ?></span></span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span>$5.00</span>
                </div>
                <div class="summary-row">
                    <span class="summary-total">Total:</span>
                    <span class="summary-total">$<span id="cartTotal"><?php echo number_format($cartTotal + 5, 2); ?></span></span>
                </div>
                
                <button class="btn checkout-btn" onclick="checkout()">Proceed to Checkout</button>
                <button class="btn clear-cart-btn" onclick="clearCart()">Clear Cart</button>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function showAlert(message, type) {
            const alertBox = document.getElementById('alertBox');
            alertBox.textContent = message;
            alertBox.className = 'alert alert-' + type;
            alertBox.style.display = 'block';
            
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 3000);
        }
        
        function updateQuantity(cartID, change) {
            const item = document.querySelector(`[data-cart-id="${cartID}"]`);
            const input = item.querySelector('.qty-input');
            const newQty = parseInt(input.value) + change;
            
            if (newQty < 1) return;
            
            updateQuantityDirect(cartID, newQty);
        }
        
        function updateQuantityDirect(cartID, quantity) {
            quantity = parseInt(quantity);
            if (quantity < 1) return;
            
            fetch('cart_ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=update&cartID=${cartID}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => {
                showAlert('Error updating cart', 'error');
                console.error(error);
            });
        }
        
        function removeItem(cartID) {
            if (!confirm('Remove this item from cart?')) return;
            
            fetch('cart_ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=remove&cartID=${cartID}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => {
                showAlert('Error removing item', 'error');
                console.error(error);
            });
        }
        
        function clearCart() {
            if (!confirm('Clear all items from cart?')) return;
            
            fetch('cart_ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=clear'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => {
                showAlert('Error clearing cart', 'error');
                console.error(error);
            });
        }
        
        function checkout() {
            window.location.href = 'checkout.php';
        }
    </script>
</body>
</html>