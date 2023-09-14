<?php

session_set_cookie_params([
  'lifetime' => 86400,
  'path' => '/',
  'domain' => _DOMAIN_,
  'httponly' => true
]);

//start session
session_start();

//employees don't have permission to visit some pages
function adminOnly()
{
  if ($_SESSION['user']['role'] === 'employee') {
    header("location: /admin/liste-voitures.php");
  }
}
