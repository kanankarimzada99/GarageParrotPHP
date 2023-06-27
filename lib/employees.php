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


function addEmployee(PDO $pdo, string $lastname, string $name, string $email, string $password, $role ="employee")
{
  $sql = "INSERT INTO `employees`(`lastname`,`name`, `email`, `password`, `role`) VALUES (:lastname, :name, :email, :password, :role);";
  
  $query = $pdo->prepare($sql);
  $password = password_hash($password, PASSWORD_DEFAULT);
  $query->bindValue(':lastname', $lastname, PDO::PARAM_STR);
  $query->bindValue(':lastname', $name, PDO::PARAM_STR);
  $query->bindValue(':email', $email, PDO::PARAM_STR);
  $query->bindValue(':password', $password, PDO::PARAM_STR);
  $query->bindValue(':role', $role, PDO::PARAM_STR);

  return $query->execute();
}