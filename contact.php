<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Form</title>
    <link rel="icon" href="Assets/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/Contact.css">
    <style>
        

    </style>
</head>
<body>
    <?php include("Navbar.php"); ?>

    <div class="form-container">
        <h1>Contact Us</h1>
        <?php
        include("php/db_connect.php"); 

        if (isset($_POST['submit'])) {
            $userID = $_SESSION['UserID'] ?? null; 
            $formData = trim($_POST['message']);

            if ($userID && !empty($formData)) {
                $stmt = $conn->prepare("INSERT INTO FormResponses (UserID, FormData) VALUES (?, ?)");
                $stmt->bind_param("is", $userID, $formData);
                if ($stmt->execute()) {
                    echo '<div class="success">Your message has been sent successfully!</div>';
                } else {
                    echo '<div class="success" style="color:#ff5555;">Error sending message. Try again.</div>';
                }
                $stmt->close();
            } else {
                echo '<div class="success" style="color:#ff5555;">Please fill in the message.</div>';
            }
        }
        ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea name="message" id="message" rows="6" placeholder="Write your message here..."></textarea>
            </div>
            <button type="submit" name="submit" class="submit-btn">Send</button>
        </form>
    </div>

    <?php include("Footer.php"); ?>
</body>
</html>
