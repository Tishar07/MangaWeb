<?php
include ('db_connect.php');

if (isset($_POST['request'])){
    $request=$_POST['request'];
    $sql = "SELECT m.MangaID, m.MangaName, m.FrontCover, m.MangaDescription, m.Price, g.GenreName
            FROM (
                SELECT * FROM Manga LIMIT 0,6
            ) AS m
            JOIN Manga_Genre x ON m.MangaID = x.MangaID
            JOIN Genre g ON x.GenreID = g.GenreID";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

}
?>


<div class="manga-container">
    <?php 
        $MangaData = $_SESSION['MangaData'] ?? [];
        if (!empty($MangaData)) {
                foreach ($MangaData as $manga): 
        ?>
        <div class="manga-card">
            
            <p><?php echo htmlspecialchars($manga['MangaName']); ?></p>
            <img src="<?php echo $manga['FrontCover']; ?>" alt="Manga Cover">
            
            <h3 class="Genre">
                 <?php 
                    echo htmlspecialchars(implode(', ', $manga['Genres']));
                ?>
            </h3>
            
            <h4 class= "Description">
            <br>
            <?php
                echo htmlspecialchars($manga['MangaDescription']);
            ?>
            </h4>

            <h3 class="Price">
            <br>
                Rs
            <?php
                echo htmlspecialchars($manga['Price']);
            ?>
            </h3>
                    </div>
                <?php endforeach;
            } else {
                echo "<p>No manga Found</p>";
            }
            ?>
 </div>