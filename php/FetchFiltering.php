<?php
include("db_connect.php");


$sqlBase = "
    SELECT m.MangaID, m.MangaName, m.MangaDescription, m.FrontCover, m.Price,
           GROUP_CONCAT(DISTINCT g.GenreName SEPARATOR ', ') AS Genres
    FROM Manga m
    JOIN Manga_Genre mg ON m.MangaID = mg.MangaID
    JOIN Genre g ON mg.GenreID = g.GenreID
";


if (isset($_POST['genres']) && !empty($_POST['genres'])) {
    $genres = $_POST['genres'];
    $escapedGenres = array_map(function($g) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $g) . "'";
    }, $genres);
    $genreList = implode(",", $escapedGenres);
    $sqlBase .= " WHERE g.GenreName IN ($genreList)";
}

$sqlBase .= " GROUP BY m.MangaID";

// Sorting options
if (isset($_POST['sort']) && !empty($_POST['sort'])) {
    $sort = $_POST['sort'];
    switch ($sort) {
        case 'Default':
            $sqlBase .= "";
            break;
        case 'Ascending Price':
            $sqlBase .= " ORDER BY m.Price ASC";
            break;
        case 'Descending Price':
            $sqlBase .= " ORDER BY m.Price DESC";
            break;
        case 'Ascending Alphabetics':
            $sqlBase .= " ORDER BY m.MangaName ASC";
            break;
        case 'Descending Alphabetics':
            $sqlBase .= " ORDER BY m.MangaName DESC";
            break;
    }
}

$result = mysqli_query($conn, $sqlBase);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="manga-card">
                <p>' . htmlspecialchars($row['MangaName']) . '</p>
                <img src="' . htmlspecialchars($row['FrontCover']) . '" alt="Manga Cover">
                <h3 class="Genre">' . htmlspecialchars($row['Genres']) . '</h3>
                <h4 class="Description">' . htmlspecialchars($row['MangaDescription']) . '</h4>
                <h3 class="Price">Rs ' . htmlspecialchars($row['Price']) . '</h3>
              </div>';
    }
} else {
    echo "<p>No manga found for selected filters.</p>";
}
?>
