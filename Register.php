<?php
include("php/db_connect.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
                <button type="button" id="goBackBtn" style="background-color: rgb(0, 0, 0);">Go Back</button>
                <Button type = "submit" name="register">Register</Button>
            </div>
        </form>
    </div>

</body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form"); 

    const fields = [
        { id: "FirstName", name: "First Name" },
        { id: "LastName", name: "Last Name" },
        { id: "ContactNumber", name: "Contact Number" },
        { id: "City", name: "City" },
        { id: "Street", name: "Street" },
        { id: "Email", name: "Email" },
        { id: "password", name: "Password" }
    ];


    fields.forEach(field => {
        const input = form.querySelector(`input[name="${field.id}"]`);
        if (input) {
            const error = document.createElement("span");
            error.className = "error-message";
            error.style.color = "red";
            error.style.fontSize = "0.9em";
            input.parentNode.insertBefore(error, input.nextSibling); 
            field.error = error;
        }
    });


    form.addEventListener("submit", function(e) {
        let hasError = false;

        fields.forEach(field => {
            const input = form.querySelector(`input[name="${field.id}"]`);
            field.error.textContent = "";
            if (input.value.trim() === "") {
                field.error.textContent = `${field.name} cannot be empty`;
                input.style.border = "2px solid red";
                hasError = true;
            } else {
                input.style.border = "";
            }
        });

        if (hasError) e.preventDefault();
    });

    
    fields.forEach(field => {
        const input = form.querySelector(`input[name="${field.id}"]`);
        input.addEventListener("input", () => {
            field.error.textContent = "";
            input.style.border = "";
        });
    });
});

document.getElementById("goBackBtn").addEventListener("click", function() {
    window.location.href = "Login.php";
});
</script>



<?php



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