document.addEventListener("DOMContentLoaded", () => {
  let currentIndex = 0;
  const slider = document.querySelector('.Commentslider');
  const slides = document.querySelectorAll('.Commentslide');
  const slidesToShow = 3;

  if (!slider || slides.length === 0) return;

  function showSlide(index) {
    const totalSlides = slides.length;

    if (index > totalSlides - slidesToShow) currentIndex = 0;
    else if (index < 0) currentIndex = totalSlides - slidesToShow;
    else currentIndex = index;

    const slideWidth = slides[0].offsetWidth + 15; 
    slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
  }


  document.querySelector('.Commentnext').addEventListener('click', () => showSlide(currentIndex + 1));
  document.querySelector('.Commentprev').addEventListener('click', () => showSlide(currentIndex - 1));

 
  setInterval(() => showSlide(currentIndex + 1), 3000);

  showSlide(currentIndex);
});
