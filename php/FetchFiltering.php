<?php
include("db_connect.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sqlBase = "
    SELECT m.MangaID, m.MangaName, m.MangaDescription, m.FrontCover, m.Price,
           GROUP_CONCAT(DISTINCT g.GenreName SEPARATOR ', ') AS Genres
    FROM Manga m
    JOIN Manga_Genre mg ON m.MangaID = mg.MangaID
    JOIN Genre g ON mg.GenreID = g.GenreID
";


$selectedGenres = $_POST['genres'] ?? [];

if (!empty($selectedGenres)) {
 
    $escapedGenres = array_map(function($g) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $g) . "'";
    }, $selectedGenres);

    $genreList = implode(',', $escapedGenres);
    $numSelected = count($selectedGenres);

    $sqlBase .= " WHERE g.GenreName IN ($genreList)
                  GROUP BY m.MangaID
                  HAVING COUNT(DISTINCT g.GenreName) = $numSelected";
} else {
    
    $sqlBase .= " GROUP BY m.MangaID";
}


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

        $genresql = "SELECT g.GenreName
                     FROM Manga m
                     JOIN Manga_Genre x ON m.MangaID = x.MangaID
                     JOIN Genre g ON x.GenreID = g.GenreID
                     WHERE m.MangaID = {$row['MangaID']}";

        $genreResult = mysqli_query($conn, $genresql);
        $GenresArr = [];
        if ($genreResult) {
            while ($g = mysqli_fetch_assoc($genreResult)) {
                $GenresArr[] = $g['GenreName'];
            }
        }
        $GenresStr = implode(', ', $GenresArr);

        echo '
            <a href="manga.php?id=' . $row['MangaID'] . '" class="manga-link">
                <div class="manga-card">
                    <p>' . htmlspecialchars($row['MangaName']) . '</p>
                    <img src="' . htmlspecialchars($row['FrontCover']) . '" alt="Manga Cover">
                    <h3 class="Genre">' . htmlspecialchars($GenresStr) . '</h3>
                    <h4 class="Description">' . htmlspecialchars($row['MangaDescription']) . '</h4>
                    <h3 class="Price">Rs ' . htmlspecialchars($row['Price']) . '</h3>
                </div>
            </a>';
    }
} else {
    echo "<p>No manga found for selected filters.</p>";
}
?>
