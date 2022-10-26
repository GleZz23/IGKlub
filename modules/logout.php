<?php
  include_once('connection.php');
  session_start();

  $query = $miPDO->prepare('UPDATE usuario SET online = 0 WHERE nickname = :nickname;');
  $query->execute(['nickname' => $_SESSION['nickname']]);

  session_destroy();
  
  header('Location: ../index.php');
?>