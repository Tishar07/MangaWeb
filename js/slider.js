function initSlider() {
    const slides = document.querySelectorAll(".slide");
    if (slides.length === 0) return;

    let index = 0;

    function showSlide(i) {
        slides.forEach((slide, idx) => {
            slide.style.display = idx === i ? "block" : "none";
        });
    }

    function nextSlide() {
        index = (index + 1) % slides.length;
        showSlide(index);
    }

    showSlide(index);
    setInterval(nextSlide, 4000);
}
