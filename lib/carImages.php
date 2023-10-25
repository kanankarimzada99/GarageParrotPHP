<?php

// function getCarImagesById(PDO $pdo, int $id): array|bool
// {
//   $query = $pdo->prepare('SELECT * FROM cars INNER JOIN carimages ON cars.id=carimages.product_id WHERE product_id=:id');
//   $query->bindValue(":id", $id, PDO::PARAM_INT);
//   $query->execute();
//   $result = $query->fetchAll(PDO::FETCH_ASSOC);
//   return $result;
// }

// function getCarsImagesById(PDO $pdo, int $id): array|bool
// {
//   $query = $pdo->prepare('SELECT carimages.image_path FROM carimages WHERE product_id=:id');
//   $query->bindValue(":id", $id, PDO::PARAM_INT);
//   $query->execute();
//   $result = $query->fetch(PDO::FETCH_ASSOC);
//   return $result;
// }


// function getTotalCarImages(PDO $pdo): int|bool
// {
//   //return total of rows in car table
//   $sql = "SELECT COUNT(*) as total FROM carimages";
//   $query = $pdo->prepare($sql);
//   $query->execute();
//   $result = $query->fetch(PDO::FETCH_ASSOC);
//   return $result['total'];
// }

// function saveCarImages(PDO $pdo, int $product_id, string $image_path): bool
// {
//   //if id car doesnt exist INSERT
//   $query = $pdo->prepare("INSERT INTO carimages (product_id, image_path)"
//     . "VALUES(:product_id, :image_path)");
//   $query->bindValue(':product_id', $product_id, $pdo::PARAM_INT);
//   $query->bindValue(':image_path', $image_path, $pdo::PARAM_STR);
//   return $query->execute();
// }

//delete car
function deleteCarImage(PDO $pdo, int $id): bool
{
  $query = $pdo->prepare('DELETE FROM carimages WHERE id = :id');
  $query->bindValue(':id', $id, $pdo::PARAM_INT);
  $query->execute();

  //Returns the number of rows affected by the SQL statement 
  if ($query->rowCount() > 0) {
    return true;
  } else {
    return false;
  }
}
