document.addEventListener("DOMContentLoaded", () => {
  loadComponent("header", "html/header.html");
  loadComponent("slider", "html/slider.html", initSlider);
  loadComponent("popular", "html/popular.html");
  loadComponent("footer", "html/footer.html");
});

function loadComponent(id, file, callback) {
  fetch(file)
    .then((response) => {
      if (!response.ok) throw new Error(`Failed to load ${file}`);
      return response.text();
    })
    .then((data) => {
      document.getElementById(id).innerHTML = data;
      if (callback) callback(); 
    })
    .catch((error) => console.error(error));
}
