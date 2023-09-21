<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if(!isset($_SESSION['LOGGED_IN']) || $_SESSION['LOGGED_IN'] != true) {
  // last request was more than 30 minutes ago or user is not logged in
  @session_unset();     // unset $_SESSION variable for the run-time 
  @session_destroy();   // destroy session data in storage

  if (headers_sent()) {
    die("Redirect failed. Please click on this link: <a href=login.php>");
  } else {
	exit(header("Location: login.php"));
  }
	exit;
}

// update activity 
$_SESSION['LAST_ACTIVITY'] = time();
 
?>
