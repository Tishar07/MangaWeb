<?php
include("php/db_connect.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/FormLog.css">
    <link rel="stylesheet" href="CSS/base.css">
    <title>Register</title>
    <link rel="icon" href="Assets/favicon.png" type="image/x-icon">
  
</head>
<body>
    
    <div class="form-container">
        <p>Register</p>
        <form action="Register.php" method ="POST">

            <label for="FirstName">First Name</label>
            <input type="text" name ="FirstName">

            <label for="LastName">Last Name</label>
            <input type="text" name ="LastName"><br>

            <label for="ContactNumber">Contact Number</label>
            <input type="text" name ="ContactNumber"><br>

            <label for="City">City</label>
            <input type="text" name ="City"><br>

            <label for="Street">Street</label>
            <input type="text" name ="Street"><br>


            <label for="Email">Email </label>
            <input type="text" name ="Email"><br>

            <label for="password">Password</label>
            <input type="password" name ="password"><br>

            <div class="BtnLog">
                <button type ="submit" name = "GoBack"  style="background-color: rgb(0, 0, 0);">Go Back</button>
                <Button type = "submit" name="register">Register</Button>
            </div>
        </form>
    </div>

</body>
</html>


<?php

if (isset($_POST['GoBack'])){
    header("Location: Login.php");
    exit();
}

if (isset($_POST['register'])){
    $Fname = $_POST['FirstName'];
    $Lname = $_POST['LastName'];
    $Email = $_POST['Email'];
    $ContactNumber = $_POST['ContactNumber'];
    $Street = $_POST['Street'];
    $City = $_POST['City'];
    $password = $_POST['password'];
    
    
    $secureQ = $conn->prepare("
        INSERT INTO Users (FirstName, LastName, Email, ContactNumber, Street, City, Password) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $secureQ->bind_param('sssssss', $Fname, $Lname, $Email, $ContactNumber, $Street, $City, $password);
    
    if ($secureQ->execute()) {
        
        $userID = $conn->insert_id;

        
        $cartQ = $conn->prepare("INSERT INTO cart (UserID) VALUES (?)");
        $cartQ->bind_param('i', $userID);
        $cartQ->execute();
        $cartQ->close();

        echo "User registered successfully!";
        header("Location: Login.php");
        exit();
    } else {
        echo "Error: " . $secureQ->error;
    }
    $secureQ->close();
}




?>