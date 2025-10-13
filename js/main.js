$(document).ready(function () {

  $("#header").load("html/header.html");
  $("#footer").load("html/footer.html");

  
  $("#slider").load("html/slider.html", function () {
    initSlider(); 
  });


  $("#popular").load("html/popular.html");

  
});
