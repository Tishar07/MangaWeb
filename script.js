const slides = document.querySelector(".slides");
const slideCount = document.querySelectorAll(".slide").length;
let index = 0;

function showNextSlide() {
    index++;
    slides.style.transition = "transform 1s ease";
    slides.style.transform = `translateX(-${index * 100}%)`;

    if (index === slideCount) {
        setTimeout(() => {
            slides.style.transition = "none";
            slides.style.transform = "translateX(0)";
            index = 0;
        }, 1000);
    }
}
setInterval(showNextSlide, 4000);