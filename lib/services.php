<?php

function getAllServices(PDO $pdo) {
  $query = $pdo->prepare("SELECT * FROM services");
  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}