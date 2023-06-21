<?php

// $cars =[
//   ['title'=>'Clio','brand'=>'Renault','year'=>'2017','kilometers'=>20500,'gearbox'=>'manuelle','fuel'=>'essence','price'=>3400,'image'=>'car-card.png'],
//   ['title'=>'Palio','brand'=>'Fiat','year'=>'2012','kilometers'=>20500,'gearbox'=>'manuelle','fuel'=>'diesel','price'=>17000,'image'=>'car-card.png'],
//   ['title'=>'Tesla','brand'=>'Tesla','year'=>'2022','kilometers'=>45000,'gearbox'=>'manuelle','fuel'=>'essence','price'=>28400,'image'=>'car-card.png'],
//   ['title'=>'Clio','brand'=>'Renault','year'=>'2014','kilometers'=>35467,'gearbox'=>'manuelle','fuel'=>'essence','price'=>4000,'image'=>'car-card.png'],
// ];

function getCarById(array $cars, int $id){
  if(isset($cars[$id])){
    return $cars[$id];
  }
  return false;
}

function getAllCars(PDO $pdo) {
  $query = $pdo->prepare("SELECT * FROM cars");
  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}