<?php
$user = $_COOKIE["username"];

if (!isset($user)) {
  header("Location: login.php" );
}
 ?>
