<?php

function getReviewsById(PDO $pdo, int|string $id): array|bool
{
  $query = $pdo->prepare("SELECT * FROM reviews WHERE id=:id");
  $query->bindValue(":id", $id, PDO::PARAM_INT);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function getReviews(PDO $pdo, int $limit = null, int $page = null): array|bool
{
  //order services by id
  $sql = "SELECT * FROM reviews ORDER BY id DESC";

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

function getTotalReviews(PDO $pdo):int|bool
{
  $sql = "SELECT COUNT(*) as total FROM reviews";
  $query = $pdo->prepare($sql);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);
  return $result['total'];
}

function saveReview(PDO $pdo, string $client, string $comment, string $note, int|null $id): bool
{
  if ($id === null) {
    $query = $pdo->prepare("INSERT INTO reviews (client, comment, note)"
      . "VALUES(:client, :comment, :note);");
  } else {
    $query = $pdo->prepare("UPDATE `reviews` SET `client` = :client, "."`comment` = :comment, "."`note` =:note WHERE `id` =:id;");
    $query->bindValue(':id', $id, $pdo::PARAM_INT);
  }

  $query->bindValue(':client', $client, $pdo::PARAM_STR);
  $query->bindValue(':comment', $comment, $pdo::PARAM_STR);
  $query->bindValue(':note', $note, $pdo::PARAM_STR);
  return $query->execute();
}

function deleteReview(PDO $pdo, int $id): bool
{
  $query = $pdo->prepare("DELETE FROM reviews WHERE id = :id");
  $query->bindValue(':id', $id, $pdo::PARAM_INT);
  $query->execute();

  if ($query->rowCount()> 0) {
    return true;
  }else {
    return false;
  }
}