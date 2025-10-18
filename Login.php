<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/FormLog.css">
    <link rel="stylesheet" href="CSS/base.css">
    <title>LogIn</title>
    <link rel="icon" href="Assets/favicon.png" type="image/x-icon">
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="form-container" id="login-form-container">
        <p>Login</p>
        <form id="login-form" action="Login.php" method="POST">
            <label for="email">Email</label>
            <input type="text" id="email" name="Email" placeholder="Enter your email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">

            <?php if (!empty($loginError)): ?>
                <span class="error-message"><?= htmlspecialchars($loginError) ?></span>
            <?php endif; ?>

            <div class="BtnLog">
                <button type="button" id="register-btn" name="GoRegister">Register</button>
                <button type="submit" id="login-btn" name="login">Login</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("login-form");
            const emailInput = document.getElementById("email");
            const passwordInput = document.getElementById("password");

            function createErrorSpan(input) {
                const error = document.createElement("span");
                error.className = "error-message";
                input.parentNode.insertBefore(error, input.nextSibling);
                return error;
            }

            const emailError = createErrorSpan(emailInput);
            const passwordError = createErrorSpan(passwordInput);

            form.addEventListener("submit", function(e) {
                let hasError = false;
                emailError.textContent = "";
                passwordError.textContent = "";

                if (emailInput.value.trim() === "") {
                    emailError.textContent = "Email cannot be empty";
                    hasError = true;
                }
                if (passwordInput.value.trim() === "") {
                    passwordError.textContent = "Password cannot be empty";
                    hasError = true;
                }
                if (hasError) e.preventDefault();
            });

            document.getElementById("register-btn").addEventListener("click", () => {
                window.location.href = "Register.php";
            });
        });
    </script>
</body>
</html>




<?php
include("php/db_connect.php");

session_start();

$loginError = ""; 

if (isset($_POST['login'])) {
    $Email = trim($_POST["Email"]);
    $Password = trim($_POST["password"]);

    $secureQ = $conn->prepare("SELECT UserID, password FROM users WHERE Email = ?");
    $secureQ->bind_param("s", $Email);
    $secureQ->execute();
    $result = $secureQ->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($Password === $row['password']) { 
            $_SESSION['UserID'] = $row['UserID'];
            header("Location: index.php");
            exit;
        } else {
            $loginError = "Password or Email Invalid";
        }
    } else {
        $loginError = "Password or Email Invalid";
    }
}
?>
