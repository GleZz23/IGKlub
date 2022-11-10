<?php
  include('../templates/head.php');
  include_once('../modules/connection.php');
  include_once('../modules/session_control.php');

  $password_error = false;
  $change = true;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Consulto la contraseña en la BBDD
    $query = $miPDO->prepare('SELECT contrasena FROM usuario WHERE nickname=:nickname');
    $query->execute(['nickname' => $_SESSION['nickname']]);
    $result = $query->fetch();

    // Compruebo que la contraseña introducida es igual a la contraseña de la BBDD
    if (!password_verify($_REQUEST["password"], $result['contrasena'])) {
      $change = false;
      $password_error = true;
    }

    // Cambio la contraseña en la BBDD
    if ($change) {
      $query = $miPDO->prepare('UPDATE usuario SET contrasena = :pass WHERE nickname = :nickname');
      $query->execute(['nickname' => $_SESSION['nickname'],'pass' => password_hash($_REQUEST['new-password'],PASSWORD_DEFAULT)]);

      header('Location: personal_area.php');
    }
  }
?>
  <script src="../src/js/personal_area.js" defer></script>  
  <link rel="stylesheet" href="../styles/personal_area.css">
  <title>Area pertsonala | IGKlub</title>
</head>
<body>
  <header>
    <figure>
      <a href="main_menu.php"><img src="../src/img/logo/logo.png"></a>
    </figure>
    <nav>
      <figure>
        <a href="main_menu.php"><img src="../src/img/logo/logo.png"></a>
      </figure>
      <h1>Area pertsonala</h1>
      <button class="hidden" id="profile">
          <i class="fa-solid fa-bars"></i>
        </button>
    </nav>
    
  </header>
  <section class="sticky-menu">
    <?php
      echo '<a href="main_menu.php"><i class="fa-solid fa-house"></i>Hasiera</a>
            <a href="personal_area.php"><i class="fa-solid fa-user"></i>Area pertsonala</a>';
      if ($_SESSION['role'] === 'irakasle') {
        echo '<a href="groups.php"><i class="fa-solid fa-users-rectangle"></i>Nire taldeak</a>
              <a href="requests.php"><i class="fa-solid fa-question"></i>Eskaerak</a>';
      } else if ($_SESSION['role'] === 'admin') {
        echo '<a href="management.php"><i class="fa-solid fa-gear"></i>Administrazioa</a></h1>';
      }
      echo '<a href="../modules/logout.php"><i class="fa-solid fa-user-slash"></i>Saioa itxi</a>';
    ?>
  </section>
  <main>
    <div class="profile-container">
      <?php
        echo '<div class="profile-img">
                <figure style="background: url(../src/img/profile/'.$_SESSION['profile_img'].'); background-position: center; background-size: cover;"></figure>
              </div>';
      ?>
      <!-- BOTON DEL MENU HAMBURGUESA -->
      <div class="burguer-menu">
        <aside class="profile">
          <?php
          echo '<div class="profile-img">
                  <a href="personal_area.php"><figure style="background: url(../src/img/profile/'.$_SESSION['profile_img'].'); background-position: center; background-size: cover;"></figure></a>
                </div>';
          echo '<a href="main_menu.php"><i class="fa-solid fa-house"></i>Hasiera</a>
                <a href="personal_area.php"><i class="fa-solid fa-user"></i>Area pertsonala</a>';
          if ($_SESSION['role'] === 'irakasle') {
            echo '<a href="groups.php"><i class="fa-solid fa-users-rectangle"></i>Nire taldeak</a>
                  <a href="requests.php"><i class="fa-solid fa-question"></i>Eskaerak</a>';
          } else if ($_SESSION['role'] === 'admin') {
            echo '<a href="management.php"><i class="fa-solid fa-gear"></i>Administrazioa</a></h1>';
          }
          echo '<a href="../modules/logout.php"><i class="fa-solid fa-user-slash"></i>Saioa itxi</a>';
          ?>
          <button class="close-profile">Itxi <i class="fa-solid fa-angles-right"></i></button>
        </aside>
      </div>
      </section>
      <div class="profile-data">
        <h1><?php echo $_SESSION['name'] ?> <?php echo $_SESSION['surnames'] ?> </h1>
        <h2 id="nickname"><?php echo $_SESSION['nickname']?></h2>
        <p id="email">Email-a: <?php echo $_SESSION['email']?></p>
        <p id="fec_nacimiento">Jaiotze-data: <?php echo $_SESSION['date']?></p>
        <p id="telefono">Telefonoa: <?php echo $_SESSION['phone']?></p>
        <?php
          if ($_SESSION['role'] !== 'admin') {
            echo '<p id="school">Ikastetxea: '.$_SESSION['school'].'</p>';
          }
        ?>
        <div class="actions">
          <button id="change-password"><i class="fa-solid fa-key"></i> Pasahitza aldatu</button>
          <!-- <button><i class="fa-solid fa-trash-can"></i> Kontua ezabatu</button> -->
        </div>
      </div>
    </div>
    <!-- LIBROS VALORADOS -->
    <div class="valorated-books">
      <div>
        <h1>Baloratutako liburuak</h1>
      </div>
      <div class="book-list">
      <?php
      // Recojo todos los valores de los libros en una variable
      $query = $miPDO->prepare('SELECT libro.* FROM libro, valoracion WHERE libro.id_libro = valoracion.id_libro AND valoracion.nickname =:nickname ORDER BY valoracion.fecha DESC');
      $query->execute(['nickname' => $_SESSION['nickname'] ]);
      $results = $query->fetchAll();

      if ($results) {
        echo '<section>';
        foreach ($results as $position => $book) {
          echo '<div class="book-container">';
          if ($book['portada'] === '') {
          echo '<img src="../src/img/books/default.jpg">';
          } else {
          echo '<img src="../src/img/books/'.$book['id_libro'].'.jpg">';
        }
          echo '<div class="book-overlay">
                  <div class="book-info">
                    <h1 id="title">' . $book['titulo'] . '</h1>
                    <p id="autor">' . $book['escritor'] . '</p>
                    <div class="stars">';
                      if ($book['nota_media'] === 0) {
                        for ($i = 0; $i <= 4; $i++) {
                        echo '<i class="fa-solid fa-star"></i>';
                        }
                      } else {
                        for ($i = 0; $i <= $book['nota_media'] - 1; $i++) {
                          echo '<i class="calification fa-solid fa-star"></i>';
                        }
                        for ($i = 0; $i <= 4 - $book['nota_media']; $i++) {
                          echo '<i class="fa-solid fa-star"></i>';
                        }
                      }
              echo '</div>
                  <a href="book_info.php?liburua=' . $book['id_libro'] . '">Liburu orria</a>
                </div>
              </div>
            </div>';
        }
        echo '</section>';
      } else {
        echo '<h1>Oraindik ez duzu libururik baloratu</h1>';
      }
      ?>
      </div>
    </div>
  </main>
  <div class="change-password">
    <button class="closeButton"><i class="fa-solid fa-x"></i></button>
    <form id="changePasswordForm" action="" method="post">
      <!-- Contraseña actual -->
      <div class="input-container">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password" id="password" placeholder="Oraingo pasahitza">
      </div>
      <!-- Error: Contraseña actual -->
      <?php
        if ($password_error) {
          echo '<div class="error php-error" id="password">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <p>Oraingo pasahitza ez da zuzena.</p>
                </div>';
        }
      ?>
      <!-- Contraseñas nuevas -->
      <div class="input-container">
        <i class="fa-solid fa-key"></i>
        <div>
          <input type="password" name="new-password" id="new-password" placeholder="Pasahitza berria">
          <input type="password" name="new-password2" id="new-password2" placeholder="Pasahitza egiaztatu">
        </div>
      </div>
      <!-- Error: Contraseñas nuevas -->
      <div class="error hidden" id="password-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>Pasahitzak 4 karaktere izan behar ditu gutxienez eta letra larria, minuskula eta zenbaki bat izan behar ditu.</p>
      </div>
      <div class="error hidden" id="password2-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>Bi pasahitzek berdinak izan behar dira.</p>
      </div>
      <!-- Error: Formulario -->
      <div class="error hidden" id="form-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>Bete formularioa behar bezala.</p>
      </div>
      <button>Pasahitza aldatu</button>
    </form>
  </div>
</body>
</html>