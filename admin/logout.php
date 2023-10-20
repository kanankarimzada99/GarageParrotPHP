<?php
require __DIR__ . '/../lib/config.php';
require __DIR__ . '/../lib/session.php';

//replace the current session ID with a new one to stop session hijacking and session fixation.
session_regenerate_id(true);

//delete session data from the server
session_destroy();

//delete all information from $_SESSION table
unset($_SESSION);

//move to login page
header('location: ../admin/admin.php');
