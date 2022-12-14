<?php
  include('../templates/head.php');
  include_once('../modules/connection.php');

  $error = false;
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = true;

    $query = $miPDO->prepare('SELECT nickname, contrasena FROM usuario WHERE nickname =:nickname;');
    $query->execute(['nickname' => $_REQUEST['nickname']]);
    $results = $query->fetch();

    if (empty($results['nickname']) || !password_verify($_REQUEST['password'], $results['contrasena'])) {
      $login = false;
      $error = true;
    }
    
    if ($login) {
      session_start();
      $_SESSION['nickname'] = $_REQUEST['nickname'];

      $query = $miPDO->prepare('SELECT nickname, nombre, apellidos, email, estado, rol, cod_grupo, fecha_nacimiento, id_centro FROM usuario WHERE nickname = :nickname;');
      $query->execute(['nickname' => $_REQUEST['nickname']]);
      $results = $query->fetch();

      if ($results['rol'] !== 'ikasle') {
        header('Location: ../views/account_status.php');            
      } else {
        if (empty($results['cod_grupo'])) {
          header('Location: ../views/join_group.php');
        } else {
          header('Location: ../views/account_status.php');
        }
      }
    }
  }
?>

  <title>Saioa hasi | IGKlub</title>
  <link rel="stylesheet" href="../styles/login.css">
</head>
<body>
  <div class="general-container">
    <form action="" method="post">
      <h1>Saioa hasi</h1>
      <div class="input-container">
        <i class="fa-solid fa-user"></i>
        <input type="text" name="nickname" id="" placeholder="Nickname" autofocus autocomplete="off">
      </div>
      <div class="input-container">
        <i class="fa-solid fa-key"></i>
        <input type="password" name="password" id="" placeholder="Pasahitza">
      </div>
      <!-- Error -->
      <?php
      if ($error) {
        echo '<div class="error" id="error-email">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>Nickname edo pasahitza okerra. Saiatu berriro</p>
              </div>';
      }
      ?>
      <button>Saioa hasi</button>
    </form>
  </div>
</body>
</html>