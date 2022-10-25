<?php
include_once('../templates/head.php');
include_once('../modules/connection.php');
session_start();
// FILTROS
?>

  <!-- <script src="../src/js/hamburgesa.js" defer></script> -->
  <head>
  <script src="../src/js/main_menu.js" defer></script>
  <link rel="stylesheet" href="../styles/main_menu.css">
  <title>Hasiera | IGKlub</title>
  </head>

  <body>
    <header>
      <figure>
        <img src="../src/img/logo/logo.png">
      </figure>
      <section>
        <button id="filters">
          <i class="fa-solid fa-filter"></i>
        </button>
        <aside class="filters">
      <h1>FILTROS</h1>
      <form action="" method="post">
        <!-- FILTROS -->
        <button>Filtrar</button>
      </form>
    </aside>
        <div class="search-bar">
          <form action="" method="get">
            <input type="text" placeholder="Izenburua, idazlea...">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
        </div>
        <button id="profile">
          <i class="fa-solid fa-bars"></i>
        </button>
        <aside class="profile">
      <?php
      echo '<h1>'.$_SESSION['nickname'].'</h1>';
      echo '<a href="personal_area.php"><i class="fa-solid fa-user"></i>Area pertsonala</a>
            <a href="new_book.php"><i class="fa-solid fa-book"></i>Igo liburu bat</a>
            <a href="#"><i class="fa-solid fa-book-bookmark"></i>Nire liburutegia</a>'; // Cambiar enlace
      if ($_SESSION['role'] === 'irakasle') {
        echo '<a href="class.php"><i class="fa-solid fa-chalkboard-user"></i>Nire taldeak</a>
              <a href="requests.php"><i class="fa-solid fa-question"></i>Eskaerak</a>';
      } else if ($_SESSION['role'] === 'admin') {
        echo '<a href="management.php"><i class="fa-solid fa-gear"></i>Adminiztrazioa</a></h1>';
      }
      ?>
  <!-- PERFIL -->
    </aside>
      </section>
    </header>
    
    <main>
      <?php
      // Recojo todos los valores de los libros en una variable
      $query = $miPDO->prepare('SELECT libro.* FROM libro, solicitud_libro WHERE libro.id_libro = solicitud_libro.id_libro AND solicitud_libro.estado = "aceptado"');
      $query->execute();
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
        echo '<h1>Ez da ezer aurkito</h1>';
      }
      ?>
  </main>  
</body>
</html>