<?php
include 'db_connect.php';

$sql = "SELECT * FROM manga";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
      <div class="manga-item">
        <img src="' . htmlspecialchars($row["FrontCover"]) . '" alt="' . htmlspecialchars($row["MangaDescription"]) . '">
        <p class="price">Rs ' . number_format($row["Price"], 2) . '</p>
      </div>
    ';
    }
} else {
    echo "<p>No manga found.</p>";
}

$conn->close();
