<?php
session_start();
include("php/db_connect.php");


if (!isset($_SESSION['UserID'])) {
    header('Location: Login.php');
    exit();
}

$userId = $_SESSION['UserID'];
$cartItems = [];
$subtotal = 0;
$shipping = 8.00; 

$sql = "SELECT m.MangaID, m.MangaName, m.Price, m.FrontCover, ci.Quantity 
        FROM cart_items ci 
        JOIN manga m ON ci.MangaID = m.MangaID 
        WHERE ci.UserID = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
        $subtotal += $row['Price'] * $row['Quantity'];
    }
    $stmt->close();
}

$total = $subtotal + $shipping;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bag</title>
    <link rel="stylesheet" href="CSS/base.css">
    <link rel="stylesheet" href="CSS/cart_page.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <?php include("Navbar.php"); ?>

    <main class="cart-container">
        <div class="cart-items">
            <h2>Bag</h2>
            <?php if (empty($cartItems)): ?>
                <p>Your bag is empty.</p>
            <?php else: ?>
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item" data-manga-id="<?php echo $item['MangaID']; ?>">
                        <img src="<?php echo htmlspecialchars($item['FrontCover']); ?>" alt="<?php echo htmlspecialchars($item['MangaName']); ?>">
                        <div class="item-details">
                            <h3><?php echo htmlspecialchars($item['MangaName']); ?></h3>
                            <p>Price: Rs <?php echo number_format($item['Price'], 2); ?></p>
                            <div class="item-actions">
                                <label for="quantity-<?php echo $item['MangaID']; ?>">Quantity:</label>
                                <input type="number" id="quantity-<?php echo $item['MangaID']; ?>" class="quantity-input" value="<?php echo $item['Quantity']; ?>" min="1">
                                <button class="remove-btn">Remove</button>
                            </div>
                        </div>
                        <div class="item-price">
                            <p>Rs <?php echo number_format($item['Price'] * $item['Quantity'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="cart-summary">
            <h2>Summary</h2>
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="subtotal">Rs <?php echo number_format($subtotal, 2); ?></span>
            </div>
            <div class="summary-row">
                <span>Estimated Shipping & Handling</span>
                <span>Rs <?php echo number_format($shipping, 2); ?></span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span id="total">Rs <?php echo number_format($total, 2); ?></span>
            </div>
            <button class="checkout-btn">Checkout</button>
            <button class="paypal-btn">PayPal</button>
        </div>
    </main>

    <?php include("Footer.php"); ?>
    <script src="js/cart.js"></script>
</body>
</html>
