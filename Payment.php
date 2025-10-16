<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="CSS/Payment.css">
<link rel="icon" href="Assets/favicon.png" type="image/x-icon">
<title>Payment</title>
</head>
<body>

<div class="payment-container">
    <h2>Checkout</h2>

    <form action="php/ProcessPay.php" method="POST">
        <label for="name">Cardholder Name</label>
        <input type="text" id="name" name="name" placeholder="John Doe" required>

        <label for="cardnumber">Card Number</label>
        <input type="text" id="cardnumber" name="cardnumber" placeholder="1234 5678 9012 3456" required>

        <label for="expiry">Expiry Date</label>
        <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>

        <label for="cvv">CVV</label>
        <input type="password" id="cvv" name="cvv" placeholder="123" required>

        <button type="submit" class="pay-btn">Pay Now</button>
    </form>

</div>

</body>
</html>

