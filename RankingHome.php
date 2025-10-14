<?php

$sql = "SELECT m.MangaID, m.MangaName, m.FrontCover, g.GenreName
        FROM Manga m
        JOIN Manga_Genre x ON m.MangaID = x.MangaID
        JOIN Genre g ON x.GenreID = g.GenreID
        WHERE m.MangaName IN ('Blue Lock', 'Haikyu!!', 'Grand Blue')";

$result = mysqli_query($conn, $sql);
$MangaData = [];

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['MangaID'];
    if (!isset($MangaData[$id])) {
        $MangaData[$id] = [
            'MangaID' => $id,
            'MangaName' => $row['MangaName'],
            'FrontCover' => $row['FrontCover'],
            'Genres' => []
        ];
    }
    $MangaData[$id]['Genres'][] = $row['GenreName'];
}


$ordered = [];
foreach ($MangaData as $manga) {
    if ($manga['MangaName'] === 'Blue Lock') $ordered[1] = $manga;
    elseif ($manga['MangaName'] === 'Haikyu!!') $ordered[2] = $manga;
    elseif ($manga['MangaName'] === 'Grand Blue') $ordered[3] = $manga;
}
ksort($ordered);
?>

<div class="ranking-container">
    <h2 class="ranking-title">Top 3 Best Sellers</h2>
    <div class="podium-layout">
        <?php
        $rankClasses = ['second', 'first', 'third'];
        $rankNumbers = [2, 1, 3];
        $i = 0;
        foreach ($ordered as $rank => $manga) {
            echo '<div class="podium-card ' . $rankClasses[$i] . '">';
            echo '<div class="rank-badge">#' . $rankNumbers[$i] . '</div>';
            echo '<div class="cover-frame">';
            echo '<img src="' . $manga['FrontCover'] . '" alt="' . htmlspecialchars($manga['MangaName']) . '" class="cover-img">';
            echo '</div>';
            echo '<h3 class="manga-title">' . htmlspecialchars($manga['MangaName']) . '</h3>';
            echo '<div class="genre-tags">';
            foreach ($manga['Genres'] as $genre) {
                echo '<span class="genre-badge">' . htmlspecialchars($genre) . '</span>';
            }
            echo '</div>';
            echo '</div>';
            $i++;
        }
        ?>
    </div>
</div>
<link rel="stylesheet" href="CSS/podium.css" />