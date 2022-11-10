<?php
  session_start();
  if (empty($_SESSION)) {
    var_dump($_SESSION);
    header('Location: ../index.php');
  }
?>