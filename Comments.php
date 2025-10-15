<?php
include 'php/FetchComments.php';
?>
<h2 class="section-title">Recent Reviews</h2>
<div class="SectionComment">
    <div class="AnimationGif">
        <img src="Assets/CommentAnime.gif" alt="walking duck gif">
    </div>

    <div class="Commentslider-container">
        <div class="Commentslider-wrapper">
            <div class="Commentslider">
                <?php
                if (isset($_SESSION['recentReviews'])) {
                    $reviews = $_SESSION['recentReviews'];
                    foreach ($reviews as $review) {
                        echo '<div class="Commentslide">';
                        echo '<h3>' . htmlspecialchars($review['MangaName']) . '</h3>';
                        echo '<p class="Commentrating">Rating: ' . htmlspecialchars($review['Rating']) . '</p>';
                        echo '<p>' . htmlspecialchars($review['Review']) . '</p>';
                        echo '<p><strong>By: </strong>' . htmlspecialchars($review['UserName']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="Commentslide">No reviews yet.</div>';
                }
                ?>
            </div>

            <button class="Commentprev">&#10094;</button>
            <button class="Commentnext">&#10095;</button>
        </div>
    </div>
</div>

