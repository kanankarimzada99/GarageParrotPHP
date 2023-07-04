<?php

function getSchedulesById(PDO $pdo, int|string $id): array|bool
{
  $query = $pdo->prepare("SELECT * FROM schedules WHERE id=:id");
  $query->bindValue(":id", $id, PDO::PARAM_INT);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);
  return $result;
}


function getSchedules(PDO $pdo): array|bool
{
  //order schedules by descending order
  $sql = "SELECT * FROM schedules ORDER BY id";
  $query = $pdo->prepare($sql);
  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getTotalSchedules(PDO $pdo):int|bool
{
  $sql = "SELECT COUNT(*) as total FROM schedules";
  $query = $pdo->prepare($sql);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);
  return $result['total'];
}

function saveSchedule(PDO $pdo, string $day, string $morningOpen, string $morningClose,string $afternoonOpen, string $afternoonClose,  int $id = null): bool
{
  if ($id === null) {
    $query = $pdo->prepare("INSERT INTO schedules (day, morningOpen, morningClose, afternoonOpen, afternoonClose)"
      . "VALUES(:day, :morningOpen, :morningClose, :afternoonOpen, afternoonClose)");
  } else {
    $query = $pdo->prepare("UPDATE `schedules` SET `day` = :day, "
      . "`morningOpen` = :morningOpen, "
      . "`morningClose` = :morningClose, "
      . "`afternoonOpen` = :afternoonOpen, "
      . "`afternoonClose` = :afternoonClose WHERE `id` =:id;");

    $query->bindValue(':id', $id, $pdo::PARAM_INT);
  }

  $query->bindValue(':day', $day, $pdo::PARAM_STR);
  $query->bindValue(':morningOpen', $morningOpen, $pdo::PARAM_STR);
  $query->bindValue(':morningClose', $morningClose, $pdo::PARAM_STR);
  $query->bindValue(':afternoonOpen', $afternoonOpen, $pdo::PARAM_STR);
  $query->bindValue(':afternoonClose', $afternoonClose, $pdo::PARAM_STR);
  return $query->execute();
}

function deleteSchedule(PDO $pdo, int $id): bool
{
  $query = $pdo->prepare("DELETE FROM schedules WHERE id = :id");
  $query->bindValue(':id', $id, $pdo::PARAM_INT);
  $query->execute();

  if ($query->rowCount()> 0) {
    return true;
  }else {
    return false;
  }
}