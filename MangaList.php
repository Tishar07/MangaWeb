<?php
include("php/db_connect.php");
include("php/FetchAllManga.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga4U</title>
    
    <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

    <link rel="stylesheet" href="CSS/MangaList.css">
    <link rel="stylesheet" href="Style/base.css">
</head>
<body>
    <?php include("Navbar.php"); ?>
    <div class="Main-container">
        <div class="Title">
            <h2 >ALL Manga</h2>
        </div>

        <div class ="Filter-container" id ="filters">
            <div class ="Drop-Down-Filter">
                <select name="DropDown" id="SortingFilter" >
                    <option value="" disabled="" selected="" class="DropText">Sort By</option>
                    <option value="Ascending Price">Ascending Price</option>
                    <option value="Descending Price">Descending Price</option>
                    <option value="Ascending Alphabetics">Ascending Alphabetics</option>
                    <option value="Descending Alphabetics">Descending Alphabetics</option>
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

    <script>
        $(document).ready(function()){
            $("#DropDown").on('change',function(){
                var value = $(this).val();
                alert (value);
            };)
        };
        



    </script>



</body>
</html>
