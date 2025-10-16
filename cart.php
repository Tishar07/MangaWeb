<?php
include("php/db_connect.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userID = $_SESSION['UserID'];

$stmt = $conn->prepare("
    SELECT m.MangaID, m.MangaName, m.Price, m.FrontCover
    FROM cart_items c
    JOIN manga m ON c.MangaID = m.MangaID
    WHERE c.UserID = ?
");


$stmt->bind_param("i",$userID);
$stmt->execute();
$result = $stmt->get_result();
$cartData = $result->fetch_all(MYSQLI_ASSOC);
?>




<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Your Cart</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="icon" href="Assets/favicon.png" type="image/x-icon">
<link rel="stylesheet" href="CSS/cart_page.css">

</head>
<body>
    <?php include("Navbar.php");?>
    

    <div class="cart-container">
        <h2>Your Cart</h2>
        <ul id="cart-list">
        <?php if(!empty($cartData)): ?>
            <?php foreach($cartData as $item): ?>
                <li data-id="<?= $item['MangaID'] ?>">
                    <div class="cart-item">
                        <img src="<?= htmlspecialchars($item['FrontCover']) ?>" alt="<?= htmlspecialchars($item['MangaName']) ?>">
                        <div class="cart-item-info">
                            <span class="title" style="color:white;"><?= htmlspecialchars($item['MangaName']) ?></span>
                            <span class="price" style="color:white;">Rs <?= $item['Price'] ?></span>
                        </div>
                    </div>
                    <button class="remove-from-cart">Remove</button>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li style="color:white;">Your cart is empty.</li>
        <?php endif; ?>
        </ul>

        <div class="cart-total" style="color:white;">
            Total: Rs <span id="cart-total">0</span>
        </div>

        <form action="Payment.php" method="POST">
            <button type="submit" class="pay-btn">Proceed to Pay</button>
        </form>

    </div>
    <?php include("Footer.php");?>

<script>
$(document).ready(function(){

    function updateCartTotal(){
        let total = 0;
        $("#cart-list li").each(function(){
            const priceMatch = $(this).find(".price").text().match(/Rs\s*(\d+)/);
            if(priceMatch) total += parseFloat(priceMatch[1]);
        });
        $("#cart-total").text(total.toFixed(2));
    }

    updateCartTotal();

    $(document).on("click", ".remove-from-cart", function(){
        const li = $(this).closest("li");
        const mangaID = li.data("id");

        $.ajax({
            url: "php/cart_actions.php",
            type: "POST",
            data: { action: "remove", MangaID: mangaID },
            success: function(response){
                const data = JSON.parse(response);
                li.remove();
                updateCartTotal();
            }
        });
    });

});
</script>

</body>
</html>
