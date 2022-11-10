<?php
include('../templates/head.php');
include_once('../modules/connection.php');
session_start();
// FILTROS
?>
  <script src="../src/js/area_personal_valorated_books.js" defer></script>  
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
    </nav>
    <section>
    <!-- BOTON DEL MENU HAMBURGUESA -->
    <div class="burguer-menu hidden">
      <button id="profile">
        <i class="fa-solid fa-bars"></i>
      </button>
      <aside class="profile">
        <?php
          echo '<div class="profile-img">
                  <figure style="background: url(../src/img/profile/'.$_SESSION['profile_img'].'); background-position: center; background-size: cover;"></figure>
                </div>';
          echo '<a href="main_menu.php"><i class="fa-solid fa-house"></i>Hasiera</a>
                  <span class="newBookButton"><i class="fa-solid fa-book"></i>Igo liburu bat</span>
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
      <div class="profile-data">
        <h1><?php echo $_SESSION['name'] ?> <?php echo $_SESSION['surnames'] ?> </h1>
        <h2 id="nickname"><?php echo $_SESSION['nickname']?></h2>
        <p id="fec_nacimiento">Jaiotza data: <?php echo $_SESSION['date']?></p>
        <p id="email">Email-a: <?php echo $_SESSION['email']?></p>
        <p id="school">Ikastetxea: <?php echo $_SESSION['school']?></p>
        <div class="actions">
          <button id="profile_edit_btn" onclick="location.href='../views/change_personal_area.php'"><i class="fa-solid fa-key"></i> Pasahitza aldatu</button>
          <button><i class="fa-solid fa-trash-can"></i> Kontua ezabatu</button>
        </div>
      </div>
    </div>

    <div id="valorated_book">
      <div>
        <h1>Baloratutako liburuak</h1>
      </div>
      <div id="valorated_book_list">
      <?php
      // Recojo todos los valores de los libros en una variable
      $query = $miPDO->prepare('SELECT libro.* FROM libro, valoracion WHERE libro.id_libro = valoracion.id_libro AND valoracion.nickname =:nickname');
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
        echo '<h1>Ez da ezer aurkitu</h1>';
      }
      ?>
      </div>
    </div>
  </main>
</body>
</html>