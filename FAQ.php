<div class="faq-container">
  <h2 class="faq-title">Frequently Asked Questions</h2>

  <div class="faq-item">
    <button class="faq-question">What is Manga4u?</button>
    <div class="faq-answer">
      <p>Manga4u is a digital platform that offers a wide selection of manga titles across genres like Shonen, Seinen, Comedy, and Sports. We aim to make manga accessible and enjoyable for everyone.</p>
    </div>
  </div>

  <div class="faq-item">
    <button class="faq-question">Do I need an account to buy a manga?</button>
    <div class="faq-answer">
      <p>An account is required to browse our catalog. However, creating an account allows you to browse different genres of manga and view our user interface.</p>
    </div>
  </div>

  <div class="faq-item">
    <button class="faq-question">How often is new manga added?</button>
    <div class="faq-answer">
      <p>We update our collection weekly with new chapters and titles based on popularity, seasonal releases, and user requests.</p>
    </div>
  </div>

  <div class="faq-item">
    <button class="faq-question">Can I request a manga to be added?</button>
    <div class="faq-answer">
      <p>Yes! You can send requests via our contact form or email us at Manga4u@gmail.com. We review all submissions and try to fulfill popular requests.</p>
    </div>
  </div>

  <div class="faq-item">
    <button class="faq-question">What genres do you offer?</button>
    <div class="faq-answer">
      <p>We offer a wide range including Shonen, Seinen, Romance, Comedy, Horror, Slice of Life, Sports, Fantasy, and more. You can filter by genre in the search bar.</p>
    </div>
  </div>
</div>

<link rel="stylesheet" href="CSS/faq.css" />
<script>
  document.querySelectorAll(".faq-question").forEach(button => {
    button.addEventListener("click", () => {
      const answer = button.nextElementSibling;
      answer.classList.toggle("open");
    });
  });
</script>