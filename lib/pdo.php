<?php

try
{
  $pdo = new PDO("mysql:dbname=garage_parrot;host=localhost;charset=utf8mb4",'root','Marcos2023dev#');
}
catch(Exception $e)
{
  die("Erreur: ".$e->getMessage());
}