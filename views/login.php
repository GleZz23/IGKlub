<?php
  include_once('../modules/connection.php');
  include_once('../templates/head.php');

  session_start();
?>

  <title>Saioa hasi | IGKlub</title>
  <link rel="stylesheet" href="../styles/login.css">
</head>
<body>
  <form action="../modules/login_validation.php" method="get">
    <h1>Saioa hasi</h1>
    <div class="input-container">
      <i class="fa-solid fa-user"></i>
      <input type="text" name="nickname" id="" placeholder="Nickname" autofocus>
    </div>
    <div class="input-container">
      <i class="fa-solid fa-key"></i>
      <input type="password" name="password" id="" placeholder="Pasahitza">
    </div>
    <?php
      $query = $miPDO->prepare('SELECT COUNT(cod_grupo) FROM usuario WHERE nickname =:nickname;');
      $query->execute(['nickname' => $_SESSION['nickname']]);
      $results = $query->fetchColumn();

      if ($query->fetchColumn() <= 0) {
        echo '<div class="input-container">';
        echo '<i class="fa-solid fa-school-lock"></i>';
        echo '<input type="text" name="group_code" id="" placeholder="Taldearen kodea">';
        echo '</div>';
      }
    ?>
    <button>Saioa hasi</button>
  </form>
</body>
</html>