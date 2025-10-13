<?php

?>

<div class="slider">
    <div class="slides">
        <div class="slide">
            <img src="https://raw.githubusercontent.com/Tishar07/MangaWeb/refs/heads/main/Assets/AOT.webp" alt="Attack on Titan" />
            <div class="caption">
                <h3>Attack On Titan</h3>
                <p>Humanity fights for survival against terrifying titans beyond the walls.</p>
            </div>
        </div>

        <div class="slide">
            <img src="https://raw.githubusercontent.com/Tishar07/MangaWeb/refs/heads/main/Assets/Bleach.webp" alt="Bleach" />
            <div class="caption">
                <h3>Bleach</h3>
                <p>Ichigo Kurosaki becomes a Soul Reaper and protects the living world.</p>
            </div>
        </div>

        <div class="slide">
            <img src="https://raw.githubusercontent.com/Tishar07/MangaWeb/refs/heads/main/Assets/Chainsawman.webp" alt="Chainsaw Man" />
            <div class="caption">
                <h3>Chainsaw Man</h3>
                <p>Denji merges with his pet devil to hunt monsters and survive a brutal world.</p>
            </div>
        </div>

        <div class="slide">
            <img src="https://raw.githubusercontent.com/Tishar07/MangaWeb/refs/heads/main/Assets/GrandBlue.webp" alt="Grand Blue" />
            <div class="caption">
                <h3>Grand Blue</h3>
                <p>A hilarious story of friendship, diving, and endless mischief by the beach.</p>
            </div>
        </div>

        <div class="slide">
            <img src="https://raw.githubusercontent.com/Tishar07/MangaWeb/refs/heads/main/Assets/Haikyuu.webp" alt="Haikyuu!!" />
            <div class="caption">
                <h3>Haikyuu!!</h3>
                <p>A small but passionate volleyball player Hinata aims to reach new heights with his team.</p>
            </div>
        </div>
    </div>

    <div class="slider-buttons">
        <button class="prev"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="next"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</div>

<link rel="stylesheet" href="CSS/slider.css">

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const slides = document.querySelectorAll(".slide");
        const slideContainer = document.querySelector(".slides");
        const totalSlides = slides.length;
        const nextBtn = document.querySelector(".next");
        const prevBtn = document.querySelector(".prev");
        let index = 0;

        function showSlide(i) {
            slideContainer.style.transform = `translateX(-${i * 100}%)`;
        }

        function nextSlide() {
            index = (index + 1) % totalSlides;
            showSlide(index);
        }

        function prevSlide() {
            index = (index - 1 + totalSlides) % totalSlides;
            showSlide(index);
        }

        nextBtn.addEventListener("click", nextSlide);
        prevBtn.addEventListener("click", prevSlide);

        setInterval(nextSlide, 4000);
    });
</script>