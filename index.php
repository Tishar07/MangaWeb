<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("php/db_connect.php");
if (!isset($_SESSION['UserID'])) {
  header('Location: Login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Manga4U</title>
  <link rel="icon" href="Assets/favicon.png" type="image/x-icon">
  
  <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>
    
  <script src="js/cart.js"></script>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <link rel="stylesheet" href="CSS/base.css" />
  <link rel="stylesheet" href="CSS/slider.css" />
  <link rel="stylesheet" href="CSS/sections.css" />
  <link rel="stylesheet" href="CSS/responsive.css" />
  <link rel="stylesheet" href="CSS/ReviewSlider.css">
  
</head>

<body>
  <?php include("Navbar.php"); ?>


  <section id="slider">
    <?php include("SliderHome.php"); ?>
  </section>

  <section class="popular-section">
    <?php include("php/PopularHome.php"); ?>
  </section>

  <section class="ranking-section">
    <?php include("RankingHome.php"); ?>
  </section>

  <section class="promotion-section">
    <?php include("promotion.php"); ?>
  </section>


  <?php include("Comments.php"); ?>

  <section class="faq-section"> 
    <?php include("FAQ.php"); ?>
  </section>

  <?php include("Footer.php"); ?>
  <script src ="js/ReviewSlider.js"></script>
</body>

</html>