<?php

function getCarsById(PDO $pdo, int $id): array|bool
{
  $query = $pdo->prepare('SELECT * FROM cars WHERE id=:id');
  $query->bindValue(":id", $id, PDO::PARAM_INT);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function getCars(PDO $pdo, int $limit = null, int $page = null): array|bool
{
  //order cars by descending order.
  $sql = "SELECT * FROM cars ORDER BY id DESC";

  if ($limit && !$page) {
    $sql .= " LIMIT :limit";
  }

  if ($limit && $page) {

    //add LIMIT at the end $sql request
    $sql .= " LIMIT :offset, :limit";
  }

  $query = $pdo->prepare($sql);

  // bind only if $limit exist
  if ($limit) {
    $query->bindValue(":limit", $limit, PDO::PARAM_INT);
  }

  if ($page) {
    $offset = ($page - 1) * $limit;
    $query->bindValue(":offset", $offset, PDO::PARAM_INT);
  }

  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getTotalCars(PDO $pdo): int|bool
{
  //return total of rows in car table
  $sql = "SELECT COUNT(*) as total FROM cars";
  $query = $pdo->prepare($sql);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);
  return $result['total'];
}

function saveCar(PDO $pdo, string $code, string $brand, string $model, int $year, int $kilometers, string $gearbox, int $number_doors, float $price, string $color, string $fuel, string $co, string $image, int $id = null): bool
{
  //if id car doesnt exist INSERT
  if ($id === null) {
    $query = $pdo->prepare("INSERT INTO cars (code, brand, model, year, kilometers, gearbox, number_doors, price, color, fuel, co, image)"
      . "VALUES(:code, :brand, :model, :year, :kilometers, :gearbox, :number_doors, :price, :color, :fuel, :co, :image)");
  }

  //if id car exist UPDATE 
  else {
    $query = $pdo->prepare("UPDATE `cars` SET `code`= :code, " ."`brand`= :brand, " . "`model`= :model, " . "`year`= :year," . "`kilometers`= :kilometers," . "`gearbox`= :gearbox, " . "`number_doors`= :number_doors,  " . "`price`= :price, " . "`color`= :color,  " . "`fuel`= :fuel, " . "`co`= :co, " . "`image`= :image WHERE `id`=:id;");

    $query->bindValue(':id', $id, $pdo::PARAM_INT);
  }

  $query->bindValue(':code', $code, $pdo::PARAM_STR);
  $query->bindValue(':brand', $brand, $pdo::PARAM_STR);
  $query->bindValue(':model', $model, $pdo::PARAM_STR);
  $query->bindValue(':year', $year, $pdo::PARAM_INT);
  $query->bindValue(':kilometers', $kilometers, $pdo::PARAM_INT);
  $query->bindValue(':gearbox', $gearbox, $pdo::PARAM_STR);
  $query->bindValue(':number_doors', $number_doors, $pdo::PARAM_INT);
  $query->bindValue(':price', $price, $pdo::PARAM_INT);
  $query->bindValue(':color', $color, $pdo::PARAM_STR);
  $query->bindValue(':fuel', $fuel, $pdo::PARAM_STR);
  $query->bindValue(':co', $co, $pdo::PARAM_STR);
  $query->bindValue(':image', $image, $pdo::PARAM_STR);
  return $query->execute();
}

//delete car
function deleteCar(PDO $pdo, int $id): bool
{
  $query = $pdo->prepare('DELETE FROM cars WHERE id = :id');
  $query->bindValue(':id', $id, $pdo::PARAM_INT);
  $query->execute();

  //Returns the number of rows affected by the SQL statement 
  if ($query->rowCount() > 0) {
    return true;
  } else {
    return false;
  }
}