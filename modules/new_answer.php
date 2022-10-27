<?php
  include_once('connection.php');
  session_start();

  if (isset($_GET['mensaje'])) {
    // Inserto el usuario en la base de datos
    $query = $miPDO->prepare('INSERT INTO respuesta (id_comentario, nickname, id_libro, mensaje, estado, fecha) VALUES (:id_comentario, :nickname, :id_libro, :mensaje, "espera", NOW())');
    $query->execute(['id_comentario' => $_GET['id_comment'], 'nickname' => $_GET['nickname'], 'id_libro' => $_GET['book'], 'mensaje' => nl2br($_GET['mensaje'])]);

    if ($_SESSION['role'] !== 'ikasle') {
      $query = $miPDO->prepare('SELECT id_respuesta FROM respuesta WHERE id_comentario = :id_comentario AND nickname = :nickname AND id_libro = :id_libro AND mensaje = :mensaje');
      $query->execute(['id_comentario' => $_GET['id_comment'], 'nickname' => $_GET['nickname'], 'id_libro' => $_GET['book'], 'mensaje' => nl2br($_GET['mensaje'])]);
      $results = $query->fetch();

      $query = $miPDO->prepare('UPDATE respuesta SET estado = "aceptado" WHERE id_respuesta = :id_respuesta');
      $query->execute(['id_respuesta' => $results['id_respuesta']]);
    }

    header('Location: ../views/book_info.php?liburua='.$_GET['book']);
  }
?>
