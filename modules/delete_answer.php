<?php
  include_once('connection.php');

  if (isset($_GET['id_answer'])) {
    $query = $miPDO->prepare('DELETE FROM respuesta WHERE id_respuesta = :id_respuesta');
    $query->execute(['id_respuesta' => $_GET['id_answer']]);

    header('Location: ../views/book_info.php?liburua='.$_GET['book']);
  }
?>
