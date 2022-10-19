<?php 
  include_once('../templates/head.php');
  include_once('../modules/connection.php');

  session_start();
  if (isset($_SESSION['nickname'])) {
    $nickname = $_SESSION['nickname'];
  }
?>

  <title>Kontuaren egoera | IGKlub</title>
  <link rel="stylesheet" href="../styles/account_status.css">
</head>
<body>
  <section>
    <?php
      echo "<h1>Kaixo $nickname</h1>";

      $query = $miPDO->prepare('SELECT nickname, nombre, apellidos, email, estado FROM usuario WHERE nickname =:nickname;');
      $query->execute(['nickname' => $nickname]);
      $result = $query->fetch();

      if ($result['estado'] === 'espera') {
        echo '<p>Kontua oraindik ez da aktibatu. Itxaron zure irakasleak aktibatu arte.</p>';
        echo '<a href="account_status.php">Egiaztatu berriro</a>';
      } else if ($result['estado'] === 'denegado') {
        $query = $miPDO->prepare('DELETE FROM usuario WHERE nickname =:nickname;');
        $query->execute(['nickname' => $nickname]);
        echo '<p>Zure kontua desaktibatu da, baldintzak betetzen ez dituelako. Saiatu kontu berri bat sortzen.</p>';
        echo '<a href="../index.php">Sortu kontu berri bat</a>';
        session_destroy();
      } else if ($result['estado'] === 'aceptado') {
        session_start();
        $_SESSION['nickname'] = $result['nickname'];
        $_SESSION['name'] = $result['nombre'];
        $_SESSION['surnames'] = $result['apellidos'];
        $_SESSION['email'] = $result['email'];

        header('Location: ../index.php'); //Cambiar por el menu principal
      }
    ?>
  </section>
</body>