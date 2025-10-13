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
</head>
<body>
    
    <div class="form-container">
        <p>Login</p><br>
        <form action="Login.php" method ="POST">
            <label for="Email">Email </label>
            <input type="text" name ="Email"><br>
            <label for="password">Password</label>
            <input type="password" name ="password"><br>
            <div class="BtnLog">
                <Button type = "submit" name="GoRegister">Register</Button>
                <button type ="submit" name = "login">Login</button>
            </div>
        </form>
    </div>

</body>
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