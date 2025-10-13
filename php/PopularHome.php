<?php
include("php/db_connect.php");


$query = "SELECT * FROM manga";
$result = mysqli_query($conn, $query);

$mangaList = [];
if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $genres = isset($row['Genres']) ? json_decode($row['Genres'], true) : [];
    if (!is_array($genres)) {
      $genres = explode(',', $row['Genres']);
    }

    $mangaList[] = [
      'MangaName' => $row['MangaName'],
      'Price' => $row['Price'],
      'FrontCover' => $row['FrontCover'],
      'Genres' => $genres
    ];
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manga4u</title>
  <link rel="stylesheet" href="CSS/sections.css" />

<body>
  <section class="popular-section">
    <h2 class="section-title">Manga</h2>
    <div id="popular" class="manga-container">
      <?php if (!empty($mangaList)): ?>
        <?php foreach ($mangaList as $manga): ?>
          <div class="manga-card">
            <img src="<?= htmlspecialchars($manga['FrontCover']) ?>" alt="<?= htmlspecialchars($manga['MangaName']) ?>" class="manga-cover">
            <h3 class="manga-title"><?= htmlspecialchars($manga['MangaName']) ?></h3>
            <p class="manga-price">₨ <?= htmlspecialchars($manga['Price']) ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No manga available at the moment.</p>
      <?php endif; ?>
    </div>
  </section>
</body>

</html>