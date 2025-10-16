<?php
include 'php/FetchComments.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
                    foreach ($reviews as $review):
                        if (!empty($review['MangaID'])):
                ?>
                        <div class="Commentslide">
                            <a href="manga.php?id=<?= htmlspecialchars($review['MangaID']) ?>" class="manga-link"><h3><?= htmlspecialchars($review['MangaName']) ?></h3> </a>
                            <p class="Commentrating">Rating: <?= htmlspecialchars($review['Rating']) ?></p>
                            <p><?= htmlspecialchars($review['Review']) ?></p>
                            <p><strong>By: </strong><?= htmlspecialchars($review['UserName']) ?></p>
                        </div>
                   
                <?php
                        endif;
                    endforeach;
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
