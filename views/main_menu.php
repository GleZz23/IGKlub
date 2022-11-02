<?php
include_once('../templates/head.php');
include_once('../modules/connection.php');
session_start();
?>
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
          <h1>Iragazkiak</h1>
          <h2>Ordenatu honela:</h2>
          <form action="" method="post">
            <select name="order-by" id="order-by">
              <option value="id_libro">Igoera-denbora</option>
              <option value="titulo">Izenburua</option>
              <option value="escritor">Idazlea</option>
              <option value="nota_media">Balorazio</option>
              <option value="edad_media">Adina</option>
            </select>
            <select name="order" id="order">
              <option value="ASC">Goranzkoa</option>
              <option value="DESC">Beheranzkoa</option>
            </select>
            <button>Iragazi</button>
          </form>
        </aside>
        <!-- BARRA DE BUSQUEDA -->
        <div class="search-bar" >
        <form action="" method="post"> 
          <input type="text" placeholder="Izenburua, idazlea..." name="search" id="search" autocomplete="off" value="<?php if (isset($_REQUEST['search'])) echo $_REQUEST['search'] ?>">
          <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        </div>
        <!-- BOTON DEL MENU HAMBURGUESA -->
        <button id="profile">
          <i class="fa-solid fa-bars"></i>
        </button>
        <aside class="profile">
          <?php
          echo '<h1>'.$_SESSION['nickname'].'</h1>';
          echo '<a href="main_menu.php"><i class="fa-solid fa-house"></i>Hasiera</a>
                <a href="new_book.php"><i class="fa-solid fa-book"></i>Igo liburu bat</a>
                <a href="personal_area.php"><i class="fa-solid fa-user"></i>Area pertsonala</a>';
          if ($_SESSION['role'] === 'irakasle') {
            echo '<a href="class.php"><i class="fa-solid fa-users-rectangle"></i>Nire taldeak</a>
                  <a href="requests.php"><i class="fa-solid fa-question"></i>Eskaerak</a>';
          } else if ($_SESSION['role'] === 'admin') {
            echo '<a href="management.php"><i class="fa-solid fa-gear"></i>Administrazioa</a></h1>';
          }
          echo '<a href="../modules/logout.php"><i class="fa-solid fa-user-slash"></i>Saioa itxi</a>';
          ?>
        </aside>
      </section>
    </header>
    <main>
      <?php
      // Recojo todos los valores de los libros en una variable
      $query = 'SELECT libro.* FROM libro, solicitud_libro WHERE libro.id_libro = solicitud_libro.id_libro AND solicitud_libro.estado = "aceptado"';
      
      // Busqueda personalizada
      if (isset($_REQUEST['search']) && $_REQUEST['search'] !== '') {
        $search= $_REQUEST['search'];
        $query = $query.' AND (titulo LIKE "%'.$search.'%" OR escritor LIKE "%'.$search.'%" OR etiqueta LIKE "%'.$search.'%")';
      }

      // Filtros de busqueda
      if (isset($_REQUEST['order-by']) && isset($_REQUEST['order'])) {
        $filter = $_REQUEST['order-by'];
        $order = $_REQUEST['order'];
        $query = $query.' ORDER BY '.$filter.' '.$order;
      }

      $query = $miPDO->prepare($query);
      $query->execute();
      $results = $query->fetchAll();

      if ($results) {
        if (isset($_REQUEST['search']) && $_REQUEST['search'] !== '') {
          echo '<div class="search-view">
                  <h2>Bilaketa: "'.$_REQUEST['search'].'"</h2>
                </div>';
        }
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
                  <a href="book_info.php?liburua='.$book['id_libro'] .'">Liburu orria</a>
                </div>
              </div>
            </div>';
        }
        echo '</section>';
      } else {
        echo '<h1>Ez da ezer aurkitu</h1>';
      }
      ?>
  </main>
  <footer>
    
  </footer>
</body>
</html>
