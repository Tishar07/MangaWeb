<?php
include("php/db_connect.php");
include("php/FetchAllManga.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga List</title>
    <link rel="icon" href="Assets/favicon.png" type="image/x-icon">
    
    
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

        <div class ="Filter-container" id ="Sorting">
            <div class ="Drop-Down-Filter">
                <select name="DropDown" id="SortingFilter" >
                    <option value="Default" selected="" class="DropText">Sort By</option>
                    <option value="Ascending Price">Ascending Price</option>
                    <option value="Descending Price">Descending Price</option>
                    <option value="Ascending Alphabetics">Ascending Alphabetics</option>
                    <option value="Descending Alphabetics">Descending Alphabetics</option>
                </select>
            </div>


            <div class="checkbox-container">
                <?php
                $sql = "SELECT GenreName FROM Genre" ;
                $result= mysqli_query($conn,$sql);
                if($result){
                    while($row=mysqli_fetch_assoc($result)){
                        $genre = $row['GenreName'];
                        if (!empty($genre)){
                        echo '<input type="checkbox" id="'.$genre.'" name="Genres" value="'.$genre.'">
                              <label for="genre_'.$genre.'">'.$genre.'</label><br>';                            
                        }
                    }
                }
                ?>
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

    <div class="manga-container">
    <?php 
    $MangaData = $_SESSION['MangaData'] ?? [];
    if (!empty($MangaData)) {
        foreach ($MangaData as $manga): 
    ?>
            <div class="manga-card">
                <p><?php echo htmlspecialchars($manga['MangaName']); ?></p>
                <img src="<?php echo $manga['FrontCover']; ?>" alt="Manga Cover">
                <h3 class="Price">
                    <br>
                    Rs <?php echo htmlspecialchars($manga['Price']); ?>
                </h3>
                

                <button class="add-to-cart-btn" data-manga-id="<?php echo $manga['MangaID']; ?>">Add to Cart</button>
            </div>
        <?php endforeach;
    } else {
        echo "<p>No manga data available.</p>";
    }
    ?>
</div>


<script src="js/cart.js"></script>
    <?php include("Footer.php");?>

<script>
$(document).ready(function() {

    
    function fetchManga() {
        var selectedGenres = [];
        $("input[name='Genres']:checked").each(function() {
            selectedGenres.push($(this).val());
        });

        var sortOption = $("#SortingFilter").val();

        $.ajax({
            url: "php/FetchFiltering.php",
            type: "POST",
            data: { genres: selectedGenres, sort: sortOption },
            beforeSend: function() {
                $(".manga-container").html("<span>Loading...</span>");
            },
            success: function(response) {
                $(".manga-container").html(response);
            },
            error: function(xhr, status, error) {
                $(".manga-container").html("<p>Error loading manga.</p>");
                console.log("AJAX Error:", error);
            }
        });
    }

    
    $("input[name='Genres']").on('change', fetchManga);
    $("#SortingFilter").on('change', fetchManga);
});

</script>
<script src="js/cart.js"></script>




</body>
</html>
