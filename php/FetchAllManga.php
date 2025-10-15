<?php 
include("php/db_connect.php");
$sql = "SELECT m.MangaID, m.MangaName, m.FrontCover, m.MangaDescription, m.Price, g.GenreName
        FROM (
            SELECT * FROM Manga LIMIT 0,6
        ) AS m
        JOIN Manga_Genre x ON m.MangaID = x.MangaID
        JOIN Genre g ON x.GenreID = g.GenreID";
$result = mysqli_query($conn, $sql);

$MangaData = [];


while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['MangaID'];
    $MangaName = $row['MangaName'];
    $genre = $row['GenreName'];
    $FrontCover = $row['FrontCover'];
    $MangaDescription = $row['MangaDescription'];
    $Price = $row ['Price'];
    if (!isset($MangaData[$id])) {
        $MangaData[$id] = [
            'MangaID' => $id,
            'MangaName' => $MangaName,
            'FrontCover'=> $FrontCover,
            'MangaDescription'=> $MangaDescription,
            'Price' => $Price,
            'Genres' => []
        ];
    }
    $MangaData[$id]['Genres'][] = $genre;
}
$_SESSION['MangaData'] = $MangaData;

?>

