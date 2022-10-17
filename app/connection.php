<?php
  $host = '127.0.0.1';
  $database = 'igklub_database';
  $user = 'igklub';
  $password = '655Yj6Rc$F@x';

  $hostPDO = "mysql:host=$host;dbname=$database;";
  $miPDO = new PDO($hostPDO, $user, $password);
?>