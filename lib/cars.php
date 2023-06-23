<?php

// $cars =[
//   ['title'=>'Clio','brand'=>'Renault','year'=>'2017','kilometers'=>20500,'gearbox'=>'manuelle','fuel'=>'essence','price'=>3400,'image'=>'car-card.png'],
//   ['title'=>'Palio','brand'=>'Fiat','year'=>'2012','kilometers'=>20500,'gearbox'=>'manuelle','fuel'=>'diesel','price'=>17000,'image'=>'car-card.png'],
//   ['title'=>'Tesla','brand'=>'Tesla','year'=>'2022','kilometers'=>45000,'gearbox'=>'manuelle','fuel'=>'essence','price'=>28400,'image'=>'car-card.png'],
//   ['title'=>'Clio','brand'=>'Renault','year'=>'2014','kilometers'=>35467,'gearbox'=>'manuelle','fuel'=>'essence','price'=>4000,'image'=>'car-card.png'],
// ];

function getCarById(PDO $pdo, int $id){
 $query = $pdo->prepare('SELECT * FROM cars WHERE id=:id');
 $query->bindValue(":id",$id, PDO::PARAM_INT);
 $query->execute();
 $result = $query->fetch(PDO::FETCH_ASSOC);
 return $result;
}

function getAllCars(PDO $pdo, int $limit = null) {

  //order cars by descending order.
  $sql = "SELECT * FROM cars ORDER BY id DESC";

  if($limit){

    //add LIMIT at the end $sql request
    $sql.= " LIMIT :limit";
  }


  $query = $pdo->prepare($sql);
  
// bind only if $limit exist
  if($limit){
    $query->bindValue(":limit",$limit, PDO::PARAM_INT);
  }

  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}