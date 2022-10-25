<?php
  include_once('../templates/head.php');
  include_once('../modules/connection.php');

  $error = false;
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];

    $login = true;

    $query = $miPDO->prepare('SELECT nickname, contrasena FROM usuario WHERE nickname =:nickname;');
    $query->execute(['nickname' => $nickname]);
    $results = $query->fetch();

    if (empty($results['nickname']) || !password_verify($password, $results['contrasena'])) {
      $login = false;
      $error = true;
    }
    
    if ($login) {
      $query = $miPDO->prepare('SELECT nickname, nombre, apellidos,fecha_nacimiento, email, rol FROM usuario WHERE nickname =:nickname;');
      $query->execute(['nickname' => $nickname]);
      $results = $query->fetch();

      session_start();
      $_SESSION['nickname'] = $results['nickname'];
      $_SESSION['name'] = $results['nombre'];
      $_SESSION['surnames'] = $results['apellidos'];
      $_SESSION['date'] = $results['fecha_nacimiento'];
      $_SESSION['email'] = $results['email'];
      $_SESSION['role'] = $results['rol'];

      $query = $miPDO->prepare('SELECT rol, cod_grupo FROM usuario WHERE nickname =:nickname;');
      $query->execute(['nickname' => $nickname]);
      $results = $query->fetch();

      if ($results['rol'] !== 'ikasle') {
        header('Location: ../views/main_menu.php?orria=1');
      } else {
        if (empty($results['cod_grupo'])) {
          header('Location: ../views/join_group.php');
        } else {
          header('Location: ../views/main_menu.php?orria=1');
        }
      }
    }
  }
?>

  <title>Saioa hasi | IGKlub</title>
  <link rel="stylesheet" href="../styles/login.css">
</head>
<body>
  <form action="" method="post">
    <h1>Saioa hasi</h1>
    <div class="input-container">
      <i class="fa-solid fa-user"></i>
      <input type="text" name="nickname" id="" placeholder="Nickname" autofocus>
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
</body>
</html>