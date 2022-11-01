<?php
  $host = '127.0.0.1';
  $database = 'igklub_database';
  $user = 'root';
  $password = '';

  $hostPDO = "mysql:host=$host;dbname=$database;";
  $miPDO = new PDO($hostPDO, $user, $password);
?>