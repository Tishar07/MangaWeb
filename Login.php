<?php
include("php/db_connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/FormLog.css">
    <link rel="stylesheet" href="CSS/base.css">
    <title>LogIn</title>
    <link rel="icon" href="Assets/favicon.png" type="image/x-icon">
  
</head>
<body>
    
    <div class="form-container" id="login-form-container">
        <p>Login</p>
        <form id="login-form" action="Login.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="Email" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>
            <div class="BtnLog">
                <button type="submit" id="register-btn" name="GoRegister">Register</button>
                <button type="submit" id="login-btn" name="login">Login</button>
            </div>
        </form>
    </div>


</body>
<script>


</script>
</html>


<?php
if (isset($_POST['GoRegister'])){
    header("Location:Register.php");
}


if (isset($_POST['login'])){
    $Email = $_POST["Email"];
    $Password = $_POST["password"];


    $secureQ = $conn -> prepare ("SELECT UserID,password
            FROM users
            WHERE Email = ? ");


    $secureQ -> bind_param("s",$Email);
    $secureQ -> execute();
    $result = $secureQ -> get_result();

    
    if ($row=mysqli_num_rows($result)===1){
        $row = $result -> fetch_assoc();
        if($Password === $row['password']){
            session_start();
            $_SESSION['UserID'] = $row ['UserID']; 
            header("Location:index.php");
            exit;
        }
    }else{
        echo "Password or Email Invalid";
    }
}
?>