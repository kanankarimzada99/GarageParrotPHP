<?php
try
{
  $pdo = new PDO("mysql:dbname="._DB_NAME_.";host="._DOMAIN_.";charset=utf8mb4",_DB_USER_,_DB_PASSWORD_);
}
catch(Exception $e)
{
  die("Erreur: ".$e->getMessage());
}