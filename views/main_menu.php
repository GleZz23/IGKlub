<?php
include_once('../templates/head.php');
include_once('../modules/connection.php');
session_start();

$type_error = false;
$size_error = false;
$format_error = false;

$book_format_error = false;
$book_language_error = false;
$book_alternative_language_error = false;

$new_book = true;
$alternative_language = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form-action'])) {
  $file = $_FILES['cover'];

  $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  $image = getimagesize($file['tmp_name']);

  // No es una imagen
  if (!$image) {
    $type_error = true;
    $new_book = false;
  }
  
  // Tamaño no valido
  if ($file['size'] > 5000000) {
    $size_error = true;
    $new_book = false;
  }
  
  // Formato no valido
  if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
    $format_error = true;
    $new_book = false;
  }

  // Si el formato es por defecto
  if ($_REQUEST['format'] === '-') {
      $new_book = false;
      $book_format_error = true;
  }

  // Si el idioma es por defecto
  if ($_REQUEST['language'] === '-') {
      $new_book = false;
      $book_language_error = true;
  }

  if ($new_book) {
      $query = $miPDO->prepare('INSERT INTO libro (titulo, escritor, sinopsis, formato) VALUES (:titulo, :escritor, :sinopsis, :formato)');        
      $query->execute([
          'titulo' => $_REQUEST['title'],
          'escritor' => $_REQUEST['writter'],
          'sinopsis' => nl2br($_REQUEST['sinopsis']),
          'formato' => $_REQUEST['format']
      ]);

      $id_libro = $miPDO->lastInsertId();
      $query = $miPDO->prepare('UPDATE libro SET portada = :portada WHERE id_libro = :id_libro');        
      $query->execute(['portada' => $id_libro.'.'.$imageFileType, 'id_libro' => $id_libro]);
  
      $insert = $miPDO->prepare('INSERT INTO solicitud_libro VALUES (:nickname, :id_libro, "espera")');
      $insert->execute(['nickname' => $_SESSION['nickname'] ,'id_libro' => $id_libro]);
  
      $query = $miPDO->prepare('INSERT INTO idioma_libro VALUES (:id_libro, :idioma, :titulo)');        
      $query->execute(['id_libro' => $id_libro, 'idioma' => $_REQUEST['language'], 'titulo' => $_REQUEST['title']]);

      if (isset($_REQUEST['alternative_language']) && $_REQUEST['alternative_title']) {

          // Si el idioma es por defecto
          if ($_REQUEST['alternative_language'] === '-') {
              $alternative_language = false;
              $book_alternative_language_error = true;
          }

          if ($alternative_language) {
              $query = $miPDO->prepare('INSERT INTO idioma_libro VALUES (:id_libro, :id_idioma, :titulo)');
              $query ->execute(['id_libro' => $id_libro, 'id_idioma' => $_REQUEST['alternative_language'], 'titulo' => $_REQUEST['alternative_title']]);
          }
      }
      
      $rute = '../src/img/books/'.$id_libro.'.jpg';
      move_uploaded_file($file['tmp_name'], $rute);
  }
}

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
  <footer class="footer">
    <div class="footer__addr">
      <h1 class="footer__logo">Guri buruz</h1>
          
      <h2>Kontaktua</h2>
      
      <address>
        © I.E.S. Miguel de Unamuno B.H.I.<br>
            
        <a class="footer__btn" href="mailto:leireirakas21@gmail.com">Gmail</a>
      </address>
    </div>
    
    <ul class="footer__nav">
      <li class="nav__item">
        <h2 class="nav__title">Edukiak</h2>
  
        <ul class="nav__ul">
          <li>
            <a href="#">Profila</a>
          </li>
  
          <li>
            <a href="#">Liburuak</a>
          </li>
              
          <li>
            <a href="#">Iritzia</a>
          </li>
        </ul>
      </li>
      
      
      <li class="nav__item">
        <h2 class="nav__title">Kredituak</h2>
        
        <ul class="nav__ul">
          <li>
            <a href="https://fptxurdinaga.hezkuntza.net/es/web/Guest">FP Txurdinaga</a>
          </li>
          
          <li>
            <p>Txurdinaga LHII Lanbide Heziketako azken ikasturteko 2º ikasleek diseinatu dute webgune hau (Andrei,Ciprian,Iker,Iñigo).</p>
          </li>
        </ul>
      </li>
    </ul>
    
    <div class="legal">
      <p>&copy; 2022 IGKlub. All rights reserved.</p>
      
      <div class="legal__links">
        <span><span class="heart"></span> 
        Bigarren Hezkuntzako gazte askok maite dute irakurketa. Hala ere, liburu-dendetan hainbeste liburu daude non ez dakigun nondik hasi. Webgune honetan gazteentzako eta ez hain gazteentzako liburuak daude: arrakastatsuenak, baita gustatu ez zaizkigunak ere. Bilatu eta gozatu!</span>
      </div>
    </div>
  </footer>
</body>
</html>
