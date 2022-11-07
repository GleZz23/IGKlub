<?php
  include_once('connection.php');

  if (isset($_GET['id_comment'])) {
    $query = $miPDO->prepare('DELETE FROM comentario WHERE id_comentario = :id_comentario');
    $query->execute(['id_comentario' => $_GET['id_comment']]);

    $query = $miPDO->prepare('UPDATE valoracion SET comentario = NULL WHERE id_comentario = :id_comentario');
    $query->execute(['id_comentario' => $_GET['id_comment']]);

    header('Location: ../views/book_info.php?liburua='.$_GET['book']);
  }
?>
