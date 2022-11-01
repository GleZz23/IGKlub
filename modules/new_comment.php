<?php
  include_once('connection.php');
  session_start();

  if (isset($_GET['mensaje'])) {
    // Inserto el usuario en la base de datos
    $query = $miPDO->prepare('INSERT INTO comentario (nickname, id_libro, mensaje, estado, fecha) VALUES (:nickname, :id_libro, :mensaje, "espera", NOW())');
    $query->execute(['nickname' => $_GET['nickname'], 'id_libro' => $_GET['book'], 'mensaje' => nl2br($_GET['mensaje'])]);

    if ($_SESSION['role'] === 'admin') {
      $query = $miPDO->prepare('UPDATE comentario SET estado = "aceptado" WHERE nickname = :nickname AND id_libro = :id_libro AND mensaje = :mensaje');
      $query->execute(['nickname' => $_GET['nickname'], 'id_libro' => $_GET['book'], 'mensaje' => nl2br($_GET['mensaje'])]);
    }

    header('Location: ../views/book_info.php?liburua='.$_GET['book']);
  }
?>
