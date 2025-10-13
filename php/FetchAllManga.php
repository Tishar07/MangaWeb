<?php


$sql = "SELECT m.MangaID, m.MangaName, m.FrontCover, m.MangaDescription, m.Price, g.GenreName
        FROM Manga m
        JOIN Manga_Genre x ON m.MangaID = x.MangaID
        JOIN Genre g ON x.GenreID = g.GenreID
        LIMIT 6";

$result = mysqli_query($conn, $sql);

$MangaData = [];

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['MangaID'];
    if (!isset($MangaData[$id])) {
        $MangaData[$id] = [
            'MangaID' => $id,
            'MangaName' => $row['MangaName'],
            'FrontCover' => $row['FrontCover'],
            'MangaDescription' => $row['MangaDescription'],
            'Price' => $row['Price'],
            'Genres' => []
        ];
    }
    $MangaData[$id]['Genres'][] = $row['GenreName'];
}

echo json_encode(array_values($MangaData));
