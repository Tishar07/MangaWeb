<?php

include("php/FetchAllManga.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga4U</title>
    <link rel="stylesheet" href="CSS/MangaList.css">
    <link rel="stylesheet" href="Style/base.css">
</head>
<body>
    <?php include("Navbar.php"); ?>
    <div class="Main-container">
        <div class="Title">
            <h2 >ALL Manga</h2>
        </div>

        <div class ="Filter-container">
            <div class ="Drop-Down-Filter">
                <select id="SortingFilter" name="DropDown">
                    <option value="" class="DropText">Sort By</option>
                    <option value="">Ascending Price</option>
                    <option value="">Descending Price</option>
                    <option value="">Ascending Alphabetics</option>
                    <option value="">Descending Alphabetics</option>
                </select>
            </div>
        </div>
    
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
                echo "<p>No manga data available.</p>";
            }
            ?>
        </div>
    </div>
    <?php include("Footer.php");?>
</body>
</html>
