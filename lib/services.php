<?php

// $services =[
//   ['title'=>'eletric','description'=>'Magnis risus aptent tempus a molestie dapibus euismod augue maecenas sapien laoreet pretium, ultrices parturient scelerisque proin','image'=>'01-eletric.jpg'],
//   ['title'=>'Motor','description'=>'Risus aptent tempus a molestie dapibus euismod augue maecenas sapien laoreet pretium, ultrices parturient scelerisque proin','image'=>'02-engine_repair.jpg'],
//   ['title'=>'batterie','description'=>'Aptent tempus a molestie dapibus euismod augue maecenas sapien laoreet pretium, ultrices parturient scelerisque proin','image'=>'03-car_battery.jpg'],
// ];



function getAllServices(PDO $pdo) {
  $query = $pdo->prepare("SELECT * FROM services");
  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}