<!-- if image car doesn't exist  -->
<?php
  if($car['image'] === "" ||$car['image'] === null){
    $imagePath = '/assets/images/no-image.svg';
  }else {
    $imagePath = '/uploads/images/'.$car['image'];
  }
?>

<div class="card">
  <div class="card-header">
    <img class="card-img-top heigth-200" src="<?=$imagePath;?>"
      alt="<?=$car['brand']." ".$car['model']." ".$car['year'];?>">
  </div>
  <div class="card-body heigth-280">
    <h4 class="card-title"><?=$car['brand'];?></h4>
    <p><?=$car['model'];?></p>
    <p class="card-text">
      <span><?=$car['year'];?></span> | <span><?=$car['kilometers']?></span> |
      <span><?=$car['gearbox'];?></span> | <span><?=$car['fuel'];?></span> |
    </p>
    <hr>
    <!-- number format 2 000,00 €  -->
    <p class="price"><?=number_format($car['price'], 2, ',', ' ');?> €</p>
    <a href="voiture-details.php?id=<?=$car['id'];?>" class=" btn-wire large">Details</a>
  </div>
</div>