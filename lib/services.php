<?php

function getServicesById(PDO $pdo, int|string $id): array|bool
{
  $query = $pdo->prepare("SELECT * FROM services WHERE id=:id");
  $query->bindValue(":id", $id, PDO::PARAM_INT);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);
  return $result;
}


function getServices(PDO $pdo, int $limit = null, int $page = null): array|bool
{
  //order services by descending order
  $sql = "SELECT * FROM services ORDER BY id";

  if ($limit && !$page) {
    $sql .= " LIMIT :limit";
  }

  if ($limit && $page) {


    //add mit at end request
    $sql .= " LIMIT :offset, :limit";
  }

  $query = $pdo->prepare($sql);

  //bind only if $limit exist
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

function getTotalServices(PDO $pdo):int|bool
{
  $sql = "SELECT COUNT(*) as total FROM services";
  $query = $pdo->prepare($sql);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);
  return $result['total'];
}

function saveService(PDO $pdo, string $service, string $description, string $image, int $id = null): bool
{
  if ($id === null) {
    $query = $pdo->prepare("INSERT INTO services (service, description, image)"
      . "VALUES(:service, :description, :image)");
  } else {
    $query = $pdo->prepare("UPDATE `services` SET `service` = :service, "
      . "`description` = :description, "
      . "image =:image WHERE `id` =:id;");

    $query->bindValue(':id', $id, $pdo::PARAM_INT);
  }

  $query->bindValue(':service', $service, $pdo::PARAM_STR);
  $query->bindValue(':description', $description, $pdo::PARAM_STR);
  $query->bindValue(':image', $image, $pdo::PARAM_STR);
  return $query->execute();
}

function deleteService(PDO $pdo, int $id): bool
{
  $query = $pdo->prepare("DELETE FROM services WHERE id = :id");
  $query->bindValue(':id', $id, $pdo::PARAM_INT);
  $query->execute();

  if ($query->rowCount()> 0) {
    return true;
  }else {
    return false;
  }
}





// function getAllServices(PDO $pdo) {
//   $query = $pdo->prepare("SELECT * FROM services");
//   $query->execute();
//   $result = $query->fetchAll(PDO::FETCH_ASSOC);
//   return $result;
// }