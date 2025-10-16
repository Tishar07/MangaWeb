<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link rel="stylesheet" href="CSS/Navbar.css" />
  <link rel="stylesheet" href="CSS/base.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">


</head>
<body>
  <header>
    <div class="navbar">
      <div class="logo">
        <img src="Assets/Logo.png" alt="Logo Image">
      </div>
      <div class="menu">
        <ul>
          <li><a href="index.php"><i class="fa-solid fa-house"></i> Home</a></li>
          <li><a href="MangaList.php"><i class="fa-solid fa-book-open"></i> Manga List</a></li>
          <li><a href="contact.php"><i class="fa-solid fa-envelope"></i> Contact</a></li>
          <li><a href="Account.php"><i class="fa-solid fa-user"></i> Account</a></li>
          <li>
            <a href="cart.php">
              <i class="fa-solid fa-cart-shopping"></i> Cart 
            </a>
          </li>
        </ul>
      </div>
      <div class="search">
        <form action="search.php" method="GET">
          <input class="srch" type="text" name="query" placeholder="Search Manga..." required />
          <button class="btn" type="submit">Search</button>
        </form>
      </div>
    </div>
  </header>
</body>

</html>
