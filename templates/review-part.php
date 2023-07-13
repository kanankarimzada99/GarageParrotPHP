<div class="carousel-item">

  <div class="carousel-caption">
    <div class="stars">
      <?= starRating($review['note']); ?>
    </div>
    <i class="fa-sharp fa-solid fa-quote-left quote-left"></i>
    <p>
      <?= $review['comment']; ?>
    </p>
    <i class="fa-sharp fa-solid fa-quote-right quote-right"></i>
    <div class="name-caption"><?= $review['client']; ?></div>
  </div>
</div>