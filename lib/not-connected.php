<?php
//if user not connected
if(!isset($_SESSION['user'])){
  header('location: ../admin/index.php');
  exit();
}
?>