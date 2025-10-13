<?php
include("php/db_connect.php");
if (!isset($_SESSION['UserID'])) {
    header('Location:Login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manga4u</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <link rel="stylesheet" href="CSS/base.css"/>
  <link rel="stylesheet" href="CSS/slider.css"/>
  <link rel="stylesheet" href="CSS/sections.css"/>
  <link rel="stylesheet" href="CSS/responsive.css"/>
</head>

<body>
  <?php include("Navbar.php"); ?>

  <div id="slider"></div>
  <section class="popular-section">
    <div id="popular" class="manga-container"></div>
  </section>

  <?php include("Footer.php");?>
  <script src="js/main.js" defer></script>
  <script src="js/slider.js" defer></script>
</body>

</html>