<!-- if image service doesn't exist  -->
<?php
  if($service['image'] == null){
    $imagePath = 'assets/images/no-image.svg';
  }else {
    $imagePath = 'uploads/images/'.$service['image'];
  }
?>

<div class="card">
  <div class="card-header">
    <img class="card-img-top" src="<?=$imagePath;?>" alt="voiture marque X">
  </div>
  <div class="card-body">
    <h4 class="card-title center"><?=$service['service']?></h4>
    <p class="card-text">
      <?=$service['description']?>
    </p>
  </div>
</div>