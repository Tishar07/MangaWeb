<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title></title>
  <style>

    .slider-section {
      margin-top: 0;
      padding: 0;
    }

    .slider {
      width: 100%;
      max-width: 100%;
      margin: 0 auto;
      position: relative;
      overflow: hidden;
      height: 500px;
    }

    .slides-wrapper {
      overflow: hidden;
      width: 100%;
      height: 100%;
    }

    .slides {
      display: flex;
      transition: transform 0.5s ease-in-out;
      height: 100%;
    }

    .slide {
      width: 100%;
      flex-shrink: 0;
      box-sizing: border-box;
      position: relative;
      height: 100%;
    }

    .slide a {
      display: block;
      width: 100%;
      height: 100%;
      text-decoration: none;
      color: inherit;
      position: relative;
    }

    .slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(70%);
    }

    .caption {
      position: absolute;
      bottom: 30px;
      left: 20px;
      background: rgba(0, 0, 0, 0.6);
      padding: 15px 20px;
      border-radius: 8px;
      max-width: 90%;
    }

    .caption h3 {
      font-size: 22px;
      color: #f44336;
      margin-bottom: 6px;
    }

    .caption p {
      font-size: 14px;
      color: #ddd;
    }

    .prev,
    .next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: #000000a1;
      color: #f44336;
      border: none;
      padding: 10px 14px;
      cursor: pointer;
      border-radius: 50%;
      font-size: 18px;
      transition: background 0.3s;
      z-index: 10;
    }

    .prev:hover,
    .next:hover {
      background: #000000ff;
    }

    .prev {
      left: 10px;
    }

    .next {
      right: 10px;
    }
  </style>
</head>

<body>
  <div class="slider-section">
    <div class="slider">
      <div class="slides-wrapper">
        <div class="slides">
          <div class="slide">
            <a href="manga.php?id=4">
              <img src="https://raw.githubusercontent.com/Tishar07/MangaWeb/refs/heads/main/Assets/Bleach.webp" alt="Bleach" />
              <div class="caption">
                <h3>Bleach</h3>
                <p>Ichigo Kurosaki becomes a Soul Reaper and protects the living world.</p>
              </div>
            </a>
          </div>

          <div class="slide">
            <a href="manga.php?id=6">
              <img src="https://raw.githubusercontent.com/Tishar07/MangaWeb/refs/heads/main/Assets/Chainsawman.webp" alt="Chainsaw Man" />
              <div class="caption">
                <h3>Chainsaw Man</h3>
                <p>Denji merges with his pet devil to hunt monsters and survive a brutal world.</p>
              </div>
            </a>
          </div>

          <div class="slide">
            <a href="manga.php?id=9">
              <img src="https://raw.githubusercontent.com/Tishar07/MangaWeb/refs/heads/main/Assets/GrandBlue.webp" alt="Grand Blue" />
              <div class="caption">
                <h3>Grand Blue</h3>
                <p>A hilarious story of friendship, diving, and endless mischief by the beach.</p>
              </div>
            </a>
          </div>

          <div class="slide">
            <a href="manga.php?id=1">
              <img src="https://raw.githubusercontent.com/Tishar07/MangaWeb/refs/heads/main/Assets/AOT.webp" alt="Attack on Titan" />
              <div class="caption">
                <h3>Attack On Titan</h3>
                <p>Humanity fights for survival against terrifying titans beyond the walls.</p>
              </div>
            </a>
          </div>

          <div class="slide">
            <a href="manga.php?id=10">
              <img src="https://raw.githubusercontent.com/Tishar07/MangaWeb/refs/heads/main/Assets/Haikyuu.webp" alt="Haikyuu!!" />
              <div class="caption">
                <h3>Haikyuu!!</h3>
                <p>A small but passionate volleyball player Hinata aims to reach new heights with his team.</p>
              </div>
            </a>
          </div>
        </div>
      </div>

      <button class="prev">&#10094;</button>
      <button class="next">&#10095;</button>
    </div>
  </div>

  <script>

    document.addEventListener("DOMContentLoaded", function () {
      const slides = document.querySelectorAll(".slide");
      const slideContainer = document.querySelector(".slides");
      const nextBtn = document.querySelector(".next");
      const prevBtn = document.querySelector(".prev");
      let currentIndex = 0;

      function showSlide(index) {
        const totalSlides = slides.length;
        if (index >= totalSlides) currentIndex = 0;
        else if (index < 0) currentIndex = totalSlides - 1;
        else currentIndex = index;

        const slideWidth = slides[0].offsetWidth;
        slideContainer.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
      }

      nextBtn.addEventListener("click", () => showSlide(currentIndex + 1));
      prevBtn.addEventListener("click", () => showSlide(currentIndex - 1));

      setInterval(() => showSlide(currentIndex + 1), 4000);

      showSlide(currentIndex);
    });
    
  </script>

</body>

</html>
