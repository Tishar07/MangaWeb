<?php
include 'php/db_connect.php';

$sql = "SELECT 
	m.MangaID,
    m.MangaName, 
    r.Rating, 
    r.Description AS Review, 
    u.FirstName,
    u.LastName
FROM Manga m
JOIN Reviews r ON m.MangaID = r.MangaID
JOIN users u ON u.UserID = r.UserID
LIMIT 9,8;";
        
$result = mysqli_query($conn, $sql);
$recentReviews = array();

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $recentReviews[] = array(
            'MangaID' => $row['MangaID'],
            'MangaName' => $row['MangaName'],
            'Rating' => $row['Rating'],
            'Review' => $row['Review'],
            'UserName' => $row['FirstName'] . ' ' . $row['LastName']
        );
    }
} 

$_SESSION['recentReviews'] = $recentReviews;


?>