<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="icon" href="Assets/favicon.png" type="image/x-icon">
</head>
</html>

<?php
include("php/db_connect.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['query'])) {
    $search = mysqli_real_escape_string($conn, $_GET['query']);

    $sql = "SELECT m.MangaID, m.MangaName, m.FrontCover, m.MangaDescription, m.Price,
                   GROUP_CONCAT(g.GenreName SEPARATOR ', ') AS Genres
            FROM Manga m
            JOIN Manga_Genre mg ON m.MangaID = mg.MangaID
            JOIN Genre g ON mg.GenreID = g.GenreID
            WHERE m.MangaName LIKE '%$search%'
            GROUP BY m.MangaID";

    $result = mysqli_query($conn, $sql);
    include('Navbar.php');
    echo'<div Style=padding:30px;> </div>';
    
    echo "<div class='search-results'>";
    echo "<h2>Search Results for: " . htmlspecialchars($search) . "</h2>";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<a href="manga.php?id=' . $row['MangaID'] . '" class="manga-link">';
            echo '<div class="manga-card">';
            echo '  <img src="' . htmlspecialchars($row['FrontCover']) . '" alt="' . htmlspecialchars($row['MangaName']) . '" class="cover-img">';
            echo '  <h3 class="manga-title">' . htmlspecialchars($row['MangaName']) . '</h3>';
            echo '  <p class="manga-genre"><strong>Genres:</strong> ' . htmlspecialchars($row['Genres']) . '</p>';
            echo '  <p class="manga-description"><strong>Description:</strong> ' . htmlspecialchars($row['MangaDescription']) . '</p>';
            echo '  <p class="manga-price"><strong>Price:</strong> Rs ' . htmlspecialchars($row['Price']) . '</p>';
            echo '</div>';
            echo '</a>';
        }
    } else {
        echo "<p class='no-results'>No manga found matching your search.</p>";
    }

    echo "</div>";
}
    include("Footer.php");
?>
<link rel="stylesheet" href="CSS/search.css" />