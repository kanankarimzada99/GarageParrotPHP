<?php

function verifyUserLogin(PDO $pdo, string $email, string $password)
{
  $query = $pdo->prepare("SELECT * FROM employees WHERE email = :email");
  $query->bindValue(':email', $email, PDO::PARAM_STR);
  $query->execute();
  $user = $query->fetch();

  //Checks if the given hash matches the given options.
  if($user && sha1($password, $user['password'])){
    return $user;
  }else{
    return false;
  }
}

function getEmployeesById(PDO $pdo, int|string $id): array|bool
{
  $query = $pdo->prepare("SELECT * FROM employees WHERE id=:id");
  $query->bindValue(":id", $id, PDO::PARAM_INT);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function getEmployees(PDO $pdo, int $limit = null, int $page = null): array|bool
{

  //order employees by descending order
  $sql = "SELECT * FROM employees ORDER BY id";

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

function getTotalEmployees(PDO $pdo): int|bool
{
  $sql = "SELECT COUNT(*) as total FROM employees";
  $query = $pdo->prepare($sql);
  $query->execute();

  $result = $query->fetch(PDO::FETCH_ASSOC);
  return $result['total'];
}



function changeEmployee(PDO $pdo, string $lastname, string $name, string $email, string $password, int|null $id, string $role="employee"): bool
{

if($id === null){
  $query = $pdo->prepare("INSERT INTO employees (lastname, name, email, password, role)"
  ."VALUES(:lastname, :name, :email, :password, :role);");
  $query->bindValue(':role', $role, $pdo::PARAM_STR);
}else {
  $query = $pdo->prepare("UPDATE `employees` SET `lastname` = :lastname, "."`name` = :name, "."`email` = :email, "."`password` = :password WHERE `employees`.`id` =:id;");
  $query->bindValue(':id', $id, $pdo::PARAM_INT);
}

  $password = password_hash($password, PASSWORD_DEFAULT);
  $query->bindValue(':lastname', $lastname, PDO::PARAM_STR);
  $query->bindValue(':name', $name, PDO::PARAM_STR);
  $query->bindValue(':email', $email, PDO::PARAM_STR);
  $query->bindValue(':password', $password, PDO::PARAM_STR);
 
  return $query->execute();
}

function deleteEmployee(PDO $pdo, int $id):bool
{
  $query=$pdo->prepare("DELETE FROM employees WHERE id =:id");
  $query->bindValue(':id',$id, $pdo::PARAM_INT);
  $query->execute();
  if($query->rowCount()>0){
    return true;
  }else {
    return false;
  }
}