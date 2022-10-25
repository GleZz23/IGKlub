<?php
include_once('../templates/head.php');
include_once('../modules/connection.php');
session_start();
// FILTROS

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $signup = true;
  $password = $_POST["password"];
  $password = password_hash($password, PASSWORD_DEFAULT);

  $query = $miPDO->prepare('SELECT contrasena FROM usuario WHERE nickname=:nickname');
  $query->execute(['nickname' => $_SESSION['nickname']]);
  $results = $query->fetch();

  // Si la contraseña es igual
  if ($password === $results) {
      $password_error = true;
      $signup = false;
    }
    if ($signup) {
      // Inserto el usuario en la base de datos
      $query = $miPDO->prepare('UPDATE usuario (contrasena) VALUES (:password) WHERE nickname=:nickname');
      $query->execute(['nickname' => $_SESSION['nickname'],'password' => $password]);
  }
  
}
?>

  <!-- <script src="../src/js/hamburgesa.js" defer></script> -->
<html>
  <head>
  <script src="../src/js/profile_validation.js" defer></script>
  <script src="../src/js/profile.js" defer></script>
  <link rel="stylesheet" href="../styles/personal_area.css">
  
  <title>Hasiera | IGKlub</title>
  </head>
<body>
  <header>
    <figure>
      <img src="../src/img/logo/logo.png">
    </figure>
    <section>
      <button id="profile">
        <i class="fa-solid fa-bars"></i>
      </button>
      <aside class="profile">
    <?php
      if($_SESSION['role'] === 'ikasle') {
        echo '<h1>' . $_SESSION['nickname'] . '</h1>';
        echo '<h1><a href="../views/personal_area.php">Area Pertsonala</a> </h1>';
        echo '<h1><a href="../views/main_menu.php">Liburutegia</a></h1>';
              }else echo '<h1>' . $_SESSION['nickname'] . '</h1>';
              echo '<h1><a href="../views/personal_area.php">Area Pertsonala</a> </h1>';
              echo '<h1><a href="../views/main_menu.php">Liburutegia</a></h1>';
              echo '<h1><a href="../views/class.php">Gela</a></h1>';
              echo '<h1><a href="../views/requests.php">Eskaerak</a></h1>';
    ?>
    <!-- PERFIL -->
  </aside>
    </section>
  </header>
  <main>
    <form id="profileForm" action="" method="post">
      <!-- Contraseñas -->
      <div class="input-container">
        <i class="fa-solid fa-key"></i>
        <div>
          <input type="password" name="password" id="password" placeholder="Pasahitza">
          <input type="password" name="password2" id="password2" placeholder="Pasahitza egiaztatu">
        </div>
        <!-- Error: Contraseñas -->
    <div class="error hidden" id="password-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Pasahitzak 4 karaktere izan behar ditu gutxienez eta letra larria, minuskula eta zenbaki bat izan behar ditu.</p>
    </div>
    <div class="error hidden" id="password2-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Bi pasahitzek berdinak izan behar dira.</p>
    </div>
    <?php
    // if ($password_error) {
    //   echo '<div class="error">
    //           <i class="fa-solid fa-circle-exclamation"></i>
    //           <p>Pasahitza berdina sartzen ari zara.</p>
    //         </div>';
    // }
    ?>
      </div>
        <button>Gorde</button>
    </form>
  </main>
  
</body>
</html>