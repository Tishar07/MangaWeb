$(document).ready(function() {
  $.ajax({
    url: "php/FetchAllManga.php",
    method: "GET",
    dataType: "json",
    success: function(data) {
      const container = $("#popular");
      container.empty();

      data.forEach(manga => {
        const genreList = manga.Genres.join(", ");
        const mangaCard = `
          <div class="manga-card">
            <img src="${manga.FrontCover}" alt="${manga.MangaName}" class="manga-cover">
            <h3 class="manga-title">${manga.MangaName}</h3>
            <p class="manga-price">₨ ${manga.Price}</p>
          </div>
        `;
        container.append(mangaCard);
      });
    },
    error: function(xhr, status, error) {
      console.error("Error fetching manga:", error);
    }
  });
});
