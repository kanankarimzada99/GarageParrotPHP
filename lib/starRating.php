 <?php

function starRating($rating)
{
  $fullStar = " <i class='fa-solid fa-star'></i>";
  $emptyStar = "<i class='fa-regular fa-star'></i>";

  $output = '';

  //Full stars
  $fullStars = $rating;
  for ($i = 0; $i < $fullStars; $i++) {
    $output .= $fullStar;

  }

  //empty stars
  $emptyStars = 5 - $rating;
  for ($i = 0; $i < $emptyStars; $i++){
    $output .= $emptyStar;

  }

  //return concatenated stars (full + empty star)
  return $output;
}