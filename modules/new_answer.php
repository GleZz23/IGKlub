<?php
  include_once('connection.php');

  if (isset($_GET['mensaje'])) {
    // Inserto el usuario en la base de datos
    $query = $miPDO->prepare('INSERT INTO respuesta (id_comentario, nickname, id_libro, mensaje, estado) VALUES (:id_comentario, :nickname, :id_libro, :mensaje, "espera")');
    $query->execute(['id_comentario' => $_GET['id_comment'], 'nickname' => $_GET['nickname'], 'id_libro' => $_GET['book'], 'mensaje' => nl2br($_GET['mensaje'])]);

    header('Location: ../views/book_info.php?liburua='.$_GET['book'].'php');
  }
?>