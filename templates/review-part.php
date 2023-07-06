<!-- <div class="carousel-item ">
  <div class="carousel-caption">
    <div class="stars">
      <i class="fa-solid fa-star"></i>
      <i class="fa-solid fa-star"></i>
      <i class="fa-solid fa-star"></i>
      <i class="fa-solid fa-star"></i>
      <i class="fa-regular fa-star"></i>
    </div>
    <i class="fa-sharp fa-solid fa-quote-left quote-left"></i>
    <p>
    <?=$review['title']?>
    </p>
    <i class="fa-sharp fa-solid fa-quote-right quote-right"></i>
    <div class="name-caption">Sophia</div>
  </div>
</div>
<div class="carousel-item ">
  <div class="carousel-caption">
    <div class="stars">
      <i class="fa-solid fa-star"></i>
      <i class="fa-solid fa-star"></i>
      <i class="fa-solid fa-star"></i>
      <i class="fa-solid fa-star"></i>
      <i class="fa-regular fa-star"></i>
    </div>
    <i class="fa-sharp fa-solid fa-quote-left quote-left"></i>
    <p>
      Lorem Ipsum is simply dummy text of the printing and
      typesetting industry.
    </p>
    <i class="fa-sharp fa-solid fa-quote-right quote-right"></i>
    <div class="name-caption">Jorge</div>
  </div>
</div> -->



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