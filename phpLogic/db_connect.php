<?php
    $server ="localhost";
    $user = "root";
    $password = "";
    $dbName = "mangastore";
    
    $conn = mysqli_connect($server, $user, $password, $dbName);

    if (!$conn){
        die("Connection Failed". mysqli_connect_connect());
    }
?>