<?php
  include_once('../templates/head.php');
  include_once('../modules/connection.php');
  
  $error = false;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_code = $_POST['group_code'];

    $join = true;

    $query = $miPDO->prepare('SELECT codigo FROM grupo WHERE codigo = :group_code;');
    $query->execute(['group_code' => $group_code]);
    $results = $query->fetch();

    if (empty($results)) {
      $join = false;
      $error = true;
    }

    if ($join) {
      session_start();

      $query = $miPDO->prepare('SELECT id_centro FROM grupo WHERE codigo =:group_code;');
      $query->execute(['group_code' => $group_code]);
      $result = $query->fetch();

      $query = $miPDO->prepare('UPDATE usuario SET id_centro = :school, cod_grupo = :group_code WHERE nickname = :nickname;');
      $query->execute(['school' => $result[''] ,'group_code' => $group_code, 'nickname' => $_SESSION['nickname']]);
    }
  }
?>

  <title>Talde batean sartu | IGKlub</title>
  <link rel="stylesheet" href="../styles/login.css">
</head>
<body>
  <form action="" method="post">
    <h1>Talde batean sartu</h1>
    <div class="input-container">
      <i class="fa-solid fa-lock"></i>
      <input type="text" name="group_code" id="" placeholder="Taldearen kodea" maxlength="5">
    </div>
    <!-- Error -->
    <?php
    if ($error) {
      echo '<div class="error" id="error-email">
              <i class="fa-solid fa-circle-exclamation"></i>
              <p>Talde-kode hau okerra da. Saiatu beste batekin.</p>
            </div>';
      }
    ?>
    <button>Taldean sartu</button>
  </form>
</body>
</html>