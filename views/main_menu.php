<?php
include('../templates/head.php');
include_once('../modules/connection.php');
include_once('../modules/session_control.php');

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
    $query->execute(
      [
        'titulo' => $_REQUEST['title'],
        'escritor' => $_REQUEST['writter'],
        'sinopsis' => nl2br($_REQUEST['sinopsis']),
        'formato' => $_REQUEST['format']
      ]
    );

    $id_libro = $miPDO->lastInsertId();
    $query = $miPDO->prepare('UPDATE libro SET portada = :portada WHERE id_libro = :id_libro');
    $query->execute(['portada' => $id_libro . '.' . $imageFileType, 'id_libro' => $id_libro]);

    $insert = $miPDO->prepare('INSERT INTO solicitud_libro VALUES (:nickname, :id_libro, "espera")');
    $insert->execute(['nickname' => $_SESSION['nickname'], 'id_libro' => $id_libro]);

    if ($_REQUEST['language'] === 'other') {
      $query = $miPDO->prepare('INSERT INTO solicitud_idioma VALUES (:nickname, :idioma, "espera", :id_libro, :titulo)');
      $query->execute(['nickname' => $_SESSION['nickname'] , 'idioma' => $_REQUEST['new-language'], 'id_libro' => $id_libro, 'titulo' => $_REQUEST['title']]);
    } else {
      $query = $miPDO->prepare('INSERT INTO idioma_libro VALUES (:id_libro, :idioma, :titulo)');
      $query->execute(['id_libro' => $id_libro, 'idioma' => $_REQUEST['language'], 'titulo' => $_REQUEST['title']]);
    }

    if (isset($_REQUEST['alternative_language']) && $_REQUEST['alternative_title']) {

      // Si el idioma es por defecto
      if ($_REQUEST['alternative_language'] === '-') {
        $alternative_language = false;
        $book_alternative_language_error = true;
      }

      if ($alternative_language) {
        if ($_REQUEST['alternative-language'] === 'other') {
          $query = $miPDO->prepare('INSERT INTO solicitud_idioma VALUES (:nickname, :idioma, "espera", :id_libro, :titulo)');
          $query->execute(['nickname' => $_SESSION['nickname'] , 'idioma' => $_REQUEST['new-alternative-language'], 'id_libro' => $id_libro, 'titulo' => $_REQUEST['title']]);
        } else {
          $query = $miPDO->prepare('INSERT INTO idioma_libro VALUES (:id_libro, :id_idioma, :titulo)');
          $query->execute(['id_libro' => $id_libro, 'id_idioma' => $_REQUEST['alternative_language'], 'titulo' => $_REQUEST['alternative_title']]);
        }        
      }
    }

    $rute = '../src/img/books/' . $id_libro . '.jpg';
    move_uploaded_file($file['tmp_name'], $rute);

    header('Location: main_menu.php');
  }
}
?>
  <!-- JAVASCRIPTS -->
  <script src="../src/js/main_menu.js" defer></script>
  <!-- FUENTES -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
  <!-- ESTILOS CSS -->
  <link rel="stylesheet" href="../styles/main_menu.css">
  <title>Hasiera | IGKlub</title>
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
        <!-- BARRA DE BUSQUEDA -->
        <div class="search-container">
          <div class="search-bar" >
            <form action="" method="post"> 
              <input type="text" placeholder="Izenburua, idazlea..." name="search" id="search" autocomplete="off" value="<?php if (isset($_REQUEST['search'])) echo $_REQUEST['search'] ?>">
              <button><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
          </div>
        </div>
        <div class="actions">
          <button id="filters">
            <i class="fa-solid fa-arrow-right-arrow-left"></i>
          </button>
          <span class="newBookButton">
            <i class="fa-solid fa-book-medical"></i>
          </span>
          <button class="hidden" id="profile">
            <i class="fa-solid fa-bars"></i>
          </button>
        </div>
        <div class="profile-pic">
          <?php
            echo '<a href="personal_area.php" style="background: url(../src/img/profile/'.$_SESSION['profile_img'].'); background-position: center; background-size: cover;"></a>';
          ?>
        </div>
      </nav>
      <section>
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
              <option value="num_lectores">Irakurleak</option>
            </select>
            <select name="order" id="order">
              <option value="ASC">Goranzkoa</option>
              <option value="DESC">Beheranzkoa</option>
            </select>
            <button>Iragazi</button>
            <div class="close-filters">Itxi <i class="fa-solid fa-angles-right"></i></di>
          </form>
        </aside>
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
    <?php
      // Recojo todos los valores de los libros en una variable
      $query = 'SELECT libro.* FROM libro, solicitud_libro WHERE libro.id_libro = solicitud_libro.id_libro AND solicitud_libro.estado = "aceptado"';

      // Busqueda personalizada
      if (isset($_REQUEST['search']) && $_REQUEST['search'] !== '') {
        $search = $_REQUEST['search'];
        $query = $query . ' AND (titulo LIKE "%' . $search . '%" OR escritor LIKE "%' . $search . '%" OR etiqueta LIKE "%' . $search . '%")';
      }

      // Filtros de busqueda
      if (isset($_REQUEST['order-by']) && isset($_REQUEST['order'])) {
        $filter = $_REQUEST['order-by'];
        $order = $_REQUEST['order'];
        $query = $query . ' ORDER BY ' . $filter . ' ' . $order;
      }

      $query = $miPDO->prepare($query);
      $query->execute();
      $results = $query->fetchAll();

      if ($results) {
        if (isset($_REQUEST['search']) && $_REQUEST['search'] !== '') {
          echo '<div class="search-view">
                  <h2>Bilaketa: "' . $_REQUEST['search'] . '"</h2>
                </div>';
        }
        echo '<section>';
        foreach ($results as $position => $book) {
          echo '<div class="book-container">';
          if ($book['portada'] === '') {
            echo '<img src="../src/img/books/default.jpg">';
          } else {
            echo '<img src="../src/img/books/' . $book['id_libro'] . '.jpg">';
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
  </main>
  <footer>
    <p>Bigarren Hezkuntzako gazte askok maite dute irakurketa. Hala ere, liburu-dendetan hainbeste liburu daude non ez dakigun nondik hasi. Webgune honetan gazteentzako eta ez hain gazteentzako liburuak daude: arrakastatsuenak, baita gustatu ez zaizkigunak ere. Bilatu eta gozatu!</p>
    <div>
      <p>Kontaktua: <a href="mailto:leireirakas21@gmail.com">leireirakas21@gmail.com</a></p>
      <p>Webgune hau Txurdinagako Lanbide Heziketako azken mailako Iker, Andrei, Iñigo eta Cipri ikasleek diseinatu dute.</p>
    </div>
  </footer>
  <!-- AÑADIR NUEVO LIBRO -->
  <!-- NUEVO LIBRO -->
  <div class="new-book">
    <button class="closeButton"><i class="fa-solid fa-x"></i></button>
    <form id="newBookForm" action="" enctype="multipart/form-data" method="post">
      <h1>Igo liburu bat</h1>
      <!-- Titulo del libro -->
      <div class="input-container">
        <i class="fa-solid fa-heading"></i>
        <input type="text" name="title" id="title" placeholder="Izenburua" autofocus value="<?php if (isset($_REQUEST['title']))
            echo $_REQUEST['title'] ?>">
      </div>
      <!-- Error: Titulo del libro -->
      <div class="error hidden" id="title-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>Egiaztatu izenburua ondo idatzita dagoela.</p>
      </div>
      <!-- Escritor -->
      <div class="input-container">
        <i class="fa-solid fa-feather"></i>
        <input type="text" name="writter" id="writter" placeholder="Egilea" value="<?php if (isset($_REQUEST['writter']))
            echo $_REQUEST['writter'] ?>">
      </div>
      <!-- Error: Escritor -->
      <div class="error hidden" id="writter-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>Egilearen izenak ezin du zenbakirik eduki.</p>
      </div>
      <!-- Portada -->
      <div class="input-container">
        <i class="fa-solid fa-file-image"></i>
        <input type="text" name="cover" id="cover" placeholder="Liburuaren azala" accept=".jpg,.jpeg,.png"
          onfocus="(this.type='file')">
      </div>
      <!-- Error: Portada -->
      <?php
      if ($type_error) {
        echo '<div class="error php-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            <p>Artxiboak argazki bat izan behar da.</p>
        </div>';
      }
      if ($size_error) {
        echo '<div class="error php-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>Argazkia 5MB baino txikiagoa izan behar da.</p>
            </div>';
      }
      if ($format_error) {
        echo '<div class="error php-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>Argazkia JPG, JPEG edo PNG formatua izan behar da.</p>
            </div>';
      }
      ?>
      <!-- Idioma -->
      <div class="input-container">
        <i class="fa-solid fa-language"></i>
        <select name="language" id="language">
          <option value="-" selected>Hizkuntza</option>
          <?php
          $query = $miPDO->prepare('SELECT * FROM idioma ORDER BY id_idioma ASC');
          $query->execute();
          $results = $query->fetchAll();

          foreach ($results as $position => $language) {
            echo '<option value="' . $language['id_idioma'] . '">' . $language['nombre'] . '</option>';
          }
          ?>
          <option value="other">Hizkuntza berria</option>
        </select>
      </div>
      <!-- Error: Idioma -->
      <?php
      if ($book_language_error) {
        echo '<div class="error php-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>Aukeratu hizkuntza bat.</p>
              </div>';
      }
      ?>
      <!-- Nuevo idioma -->
      <section class="new-language hidden">
        <div class="input-container">
          <input type="text" name="new-language" id="new-language" placeholder="Hizkuntza berria">
        </div>
      </section>
      <!-- Formato -->
      <div class="input-container">
        <i class="fa-solid fa-rectangle-list"></i>
        <select name="format" id="format">
          <option value="-" selected>Formatua</option>
          <option value="Nobela">Nobela</option>
          <option value="Nobela grafikoa">Nobela grafikoa</option>
          <option value="Komikia">Komikia</option>
          <option value="Manga">Manga</option>
        </select>
      </div>
      <!-- Error: Formato -->
      <?php
      if ($book_format_error) {
        echo '<div class="error php-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>Aukeratu formatu bat.</p>
              </div>';
      }
      ?>
      <!-- Sinopsis -->
      <div class="input-container">
        <i class="fa-solid fa-marker"></i>
        <textarea id="sinopsis" name="sinopsis" placeholder="Sinopsia" required autocomplete="off"
          maxlength="2300"></textarea>
      </div>
      <!-- Error: Sinopsis -->
      <div class="error hidden" id="sinopsis-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>Sinopsia nahitaezkoa da.</p>
      </div>
      <!-- Titulo e idioma alternativos -->
      <div class="alternative-button">
        <i class="fa-solid fa-arrow-down"></i> Liburu hau beste hizkuntzan irakurri dut
      </div>
      <section class="alternative hidden">
        <!-- Idioma alternativo -->
        <div class="input-container">
          <i class="fa-solid fa-language"></i>
          <select name="alternative_language" id="alternative_language">
            <option value="-" selected>Beste hizkuntza</option>
            <?php
            $query = $miPDO->prepare('SELECT * FROM idioma ORDER BY id_idioma ASC');
            $query->execute();
            $results = $query->fetchAll();

            foreach ($results as $position => $language) {
              echo '<option value="' . $language['id_idioma'] . '">' . $language['nombre'] . '</option>';
            }
            ?>
            <option value="other">Hizkuntza berria</option>
          </select>
        </div>
        <!-- Nuevo idioma -->
        <section class="new-alternative-language hidden">
          <div class="input-container">
            <input type="text" name="new-alternative-language" id="new-alternative-language" placeholder="Hizkuntza berria">
          </div>
        </section>
        <!-- Error: Idioma -->
        <?php
        if ($book_alternative_language_error) {
          echo '<div class="error php-error">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <p>Aukeratu hizkuntza bat.</p>
                </div>';
        }
        ?>
        <!-- Titulo del libro alternativo -->
        <div class="input-container">
          <i class="fa-solid fa-heading"></i>
          <input type="text" name="alternative_title" id="alternative-title" placeholder="Izenburua hizkuntza horretan"
            value="<?php if (isset($_REQUEST['alternative_title']))
              echo $_REQUEST['alternative_title'] ?>">
        </div>
        <!-- Error: Titulo del libro -->
        <div class="error hidden" id="alternative-title-error">
          <i class="fa-solid fa-circle-exclamation"></i>
          <p>Egiaztatu izenburua ondo idatzita dagoela.</p>
        </div>
      </section>
      <!-- Error: Formulario -->
      <div class="error hidden" id="form-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>Bete formularioa behar bezala.</p>
      </div>
      <input type="hidden" name="form-action" value="newbook">
      <button>Liburua igo</button>
    </form>
  </div>
</body>

</html>