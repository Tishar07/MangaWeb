<?php 
    include("db_connect.php"); 
    session_start();

    $sql = "SELECT MangaName, FrontCover FROM manga";
    $result = mysqli_query($conn, $sql);

    $MangaData = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $MangaData[] = [
                'MangaName' => $row['MangaName'],
                'FrontCover' => $row['FrontCover']
            ];
        }

        $_SESSION['MangaData'] = $MangaData;
    } else {
        echo "Query failed: " . mysqli_error($conn);
    }
?>
