<?php
include("php/db_connect.php"); 
session_start();


if (!isset($_GET['id'])) {
    die("No manga ID provided. Access like: MangaPage.php?id=1");
}

$mangaID = intval($_GET['id']);

$_SESSION['lastMangaID'] = $mangaID;


$sql = "
    SELECT m.MangaID, m.MangaName, m.FrontCover, m.MangaDescription AS Description, m.Price,
           a.AuthorName, g.GenreName,m.UnitsAvailable
    FROM Manga m
    LEFT JOIN Author a ON m.AuthorID = a.AuthorID
    LEFT JOIN Manga_Genre mg ON m.MangaID = mg.MangaID
    LEFT JOIN Genre g ON mg.GenreID = g.GenreID
    WHERE m.MangaID = ?
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $mangaID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Manga not found.");
}


$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

$manga = [
    'MangaID' => $rows[0]['MangaID'],
    'MangaName' => $rows[0]['MangaName'],
    'FrontCover' => $rows[0]['FrontCover'],
    'Author' => $rows[0]['AuthorName'],
    'Description' => $rows[0]['Description'],
    'Price' => $rows[0]['Price'],
    'UnitsAvailable' => $rows[0]['UnitsAvailable'],
    'Genres' => []
];

foreach ($rows as $row) {
    if ($row['GenreName'] && !in_array($row['GenreName'], $manga['Genres'])) {
        $manga['Genres'][] = $row['GenreName'];
    }
}

$review_sql = "
    SELECT r.Description AS ReviewText, u.FirstName, u.LastName,r.Rating
    FROM Reviews r
    LEFT JOIN Users u ON r.UserID = u.UserID
    WHERE r.MangaID = ?
    ORDER BY r.ReviewID DESC
";
$review_stmt = mysqli_prepare($conn, $review_sql);
mysqli_stmt_bind_param($review_stmt, "i", $mangaID);
mysqli_stmt_execute($review_stmt);
$review_result = mysqli_stmt_get_result($review_stmt);
$reviews = mysqli_fetch_all($review_result, MYSQLI_ASSOC);



if (isset($_POST['submit_review']) && isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];
    $reviewText = trim($_POST['review']);
    $rating = intval($_POST['rating']);

    if ($reviewText !== "" && $rating >= 1 && $rating <= 5) {
        $insert_sql = "INSERT INTO Reviews (UserID, MangaID, Description, Rating) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($stmt, "iisi", $userID, $mangaID, $reviewText, $rating);
        if (mysqli_stmt_execute($stmt)) {
            echo "<p style='color:green;'>Review submitted successfully!</p>";
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        } else {
            echo "<p style='color:red;'>Error submitting review.</p>";
        }
    } else {
        echo "<p style='color:red;'>Please provide valid rating and review text.</p>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($manga['MangaName']) ?></title>
<link rel="icon" href="Assets/favicon.png" type="image/x-icon">
<link rel="stylesheet" href="CSS/base.css">
<link rel="stylesheet" href="CSS/MangaPage.css">
</head>
<body>

<div class="manga-page">
    <div class="cover-frame">
        <img src="<?= htmlspecialchars($manga['FrontCover']) ?>" alt="<?= htmlspecialchars($manga['MangaName']) ?>" class="manga-cover">
    </div>
    <div class="manga-details">
        <h1><?= htmlspecialchars($manga['MangaName']) ?></h1>
        <p><strong>Author:</strong> <?= htmlspecialchars($manga['Author']) ?></p>
        <p class="genres"><strong>Genres:</strong>
            <?php foreach ($manga['Genres'] as $genre): ?>
                <span><?= htmlspecialchars($genre) ?></span>
            <?php endforeach; ?>
        </p>
        <p><strong>Description:</strong></p>
        <p><?= nl2br(htmlspecialchars($manga['Description'])) ?></p>
        <p><strong>Price:</strong> Rs <?= htmlspecialchars($manga['Price']) ?></p>
        <button class="cart-button" 
            <?php if($manga['UnitsAvailable'] == 0) echo 'disabled style="background:gray; cursor:not-allowed;"'; ?>>
            <?php if($manga['UnitsAvailable'] == 0) echo 'Out of Stock'; else echo 'Add to '; ?>
        </button>
    </div>
</div>


<div class="reviews-section">
    <h2>Recent Reviews</h2>
    <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $review): ?>
            <div class="review-card">
                <h4><?= htmlspecialchars($review['FirstName'] . ' ' . $review['LastName']) ?></h4>
                <p class="review-rating">
                    <?php
                    $rating = intval($review['Rating']);
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) echo "★"; 
                        else echo "☆"; 
                    }
                    ?>
                </p>
                <p><?= nl2br(htmlspecialchars($review['ReviewText'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No reviews yet.</p>
    <?php endif; ?>
</div>

<?php if (isset($_SESSION['UserID'])): ?>
<div class="review-form">
    <h2>Leave a Review</h2>
    <form method="post" action="">
        <label for="rating">Rating:</label>
        <select name="rating" id="rating" required>
            <option value="">--Select--</option>
            <option value="1">1 - Poor</option>
            <option value="2">2 - Fair</option>
            <option value="3">3 - Good</option>
            <option value="4">4 - Very Good</option>
            <option value="5">5 - Excellent</option>
        </select>
        <br><br>
        <label for="review">Review:</label>
        <textarea name="review" id="review" rows="4" required></textarea>
        <br><br>
        <button type="submit" name="submit_review">Submit Review</button>
    </form>
</div>
<?php endif; ?>
<?php include("Footer.php");?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(".cart-button").on("click", function() {
        const mangaID = <?= $manga['MangaID'] ?>;
        const button = $(this);

        $.ajax({
            url: "php/cart_actions.php",
            type: "POST",
            data: { action: "add", MangaID: mangaID },
            success: function(response) {
                const data = JSON.parse(response);
                let addedMsg = button.siblings(".added-msg");
                if (addedMsg.length === 0) {
                    addedMsg = $('<span class="added-msg" style="color:green; margin-left:10px; font-weight:bold;">Added</span>');
                    button.after(addedMsg);
                } else {
                    addedMsg.text("Added").show();
                }
                setTimeout(() => {
                    addedMsg.fadeOut(400);
                }, 1000);
                if (typeof updateCartCount === "function") {
                    updateCartCount();
                }
            },
            error: function() {
                console.error("Error adding manga to cart.");
            }
        });
    });
});
</script>

</body>
</html>
