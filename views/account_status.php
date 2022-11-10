<?php 
  include('../templates/head.php');
  include_once('../modules/connection.php');

  $activator = '';

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
      $query = $miPDO->prepare('SELECT nickname, nombre, apellidos, email, estado, rol, imagen, fecha_nacimiento, id_centro FROM usuario WHERE nickname =:nickname;');
      $query->execute(['nickname' => $nickname]);
      $results = $query->fetch();

      $query = $miPDO->prepare('SELECT nombre FROM centro WHERE id_centro = :id_centro;');
      $query->execute(['id_centro' => $results['id_centro']]);
      $centro = $query->fetch();

      if ($results['estado'] === 'espera') {
        switch ($results['rol']) {
          case 'irakasle':
              $activator = '<b>administratzaile bat</b>';
              break;
          case 'ikasle':
              $activator = '<b>zure irakaslea</b>';
              break;
        }
        echo "<h1>Kaixo $nickname</h1>";
        echo '<p>Kontua oraindik ez da aktibatu. Itxaron '.$activator.' aktibatu arte.</p>';
        echo '<a href="account_status.php">Egiaztatu berriro</a>';
      } else if ($results['estado'] === 'denegado') {
        $query = $miPDO->prepare('DELETE FROM usuario WHERE nickname =:nickname;');
        $query->execute(['nickname' => $nickname]);

        $rute = '../src/img/profile/'.$nickname.'.jpg';
        unlink($rute);

        echo "<h1>Barkatu $nickname</h1>";
        echo '<p>Zure kontua <b>desaktibatu</b> da, baldintzak betetzen ez dituelako. Saiatu kontu berri bat sortzen.</p>';
        echo '<a href="../index.php">Sortu kontu berri bat</a>';
        
        session_destroy();
      } else if ($results['estado'] === 'aceptado') {
        $_SESSION['nickname'] = $results['nickname'];
        $_SESSION['name'] = $results['nombre'];
        $_SESSION['surnames'] = $results['apellidos'];
        $_SESSION['email'] = $results['email'];
        $_SESSION['role'] = $results['rol'];
        $_SESSION['date'] = $results['fecha_nacimiento'];
        $_SESSION['school'] = $centro['nombre'];
        $_SESSION['profile_img'] = $results['imagen'];

        header('Location: ../views/main_menu.php');
      }
    ?>
  </section>
</body>