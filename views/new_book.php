<?php
    include_once('../templates/head.php');
    include_once('../modules/connection.php');
    session_start();

    $type_error = false;
    $size_error = false;
    $format_error = false;

    $new_book = true;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $query->execute(['portada' => $id_libro.$imageFileType, 'id_libro' => $id_libro]);
        
            $insert = $miPDO->prepare('INSERT INTO solicitud_libro VALUES (:nickname, :id_libro, "espera")');
            $insert->execute(['nickname' => $_SESSION['nickname'] ,'id_libro' => $id_libro]);
        
            if (isset($_REQUEST['alternative_language']) && $_REQUEST['alternative_title']) {
                $query = $miPDO->prepare('INSERT INTO idioma_libro VALUES (:id_libro, :id_idioma, :titulo)');
                $query ->execute(['id_libro' => $id_libro, 'id_idioma' => $_REQUEST['alternative_language'], 'titulo' => $_REQUEST['alternative_title']]);
            }
            
            $rute = '../src/img/books/'.$id_libro.'.'.$imageFileType;
            move_uploaded_file($file['tmp_name'], $rute);


        }
      }
?>
    <script src="../src/js/new_book.js" defer></script>
    <link rel="stylesheet" href="../styles/new_book.css">
    <title>Igo liburu bat | IGKlub</title>
</head>

<body>
    <header>
        <figure>
            <img src="../src/img/logo/logo.png">
        </figure>
        <section>
            <!-- BOTON DEL MENU HAMBURGUESA -->
            <button id="profile">
                <i class="fa-solid fa-bars"></i>
            </button>
            <section>
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
        <form id="newBookForm" action="" enctype="multipart/form-data" method="post">
            <h1>Igo liburu bat</h1>
            <!-- Titulo del libro -->
            <div class="input-container">
                <i class="fa-solid fa-heading"></i>
                <input type="text" name="title" id="title" placeholder="Izenburua" autofocus value="<?php if (isset($_REQUEST['nickname'])) echo $_REQUEST['nickname'] ?>">
            </div>
            <!-- Error: Titulo del libro -->
            <div class="error hidden" id="title-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>.</p>
            </div>
            <!-- Escritor -->
            <div class="input-container">
                <i class="fa-solid fa-feather"></i>
                <input type="text" name="writter" id="writter" placeholder="Idazlea" value="<?php if (isset($_REQUEST['email'])) echo $_REQUEST['email'] ?>">
            </div>
            <!-- Error: Escritor -->
            <div class="error hidden" id="writter-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>.</p>
            </div>
            <!-- Portada -->
            <div class="input-container">
                <i class="fa-solid fa-file-image"></i>
                <input type="text" name="cover" id="cover" placeholder="Liburuaren azala" accept=".jpg,.jpeg,.png" onfocus="(this.type='file')">
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
                        echo '<option value="'.$language['id_idioma'].'">'.$language['nombre'].'</option>';
                    }
                    ?>
                </select>
            </div>
            <!-- Error: Formato -->
            <div class="error hidden" id="language-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>Aukeratu eskola bat.</p>
            </div>
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
            <div class="error hidden" id="format-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>Aukeratu eskola bat.</p>
            </div>
            <!-- Sinopsis -->
            <div class="input-container">
                <i class="fa-solid fa-marker"></i>
                <textarea id="sinopsis" name="sinopsis" placeholder="Sinopsia" required autocomplete="off" maxlength="2300"></textarea>
            </div>
            <!-- Titulo e idioma alternativos -->
            <button class="alternative-button"><i class="fa-solid fa-arrow-down"></i> Liburu hau beste hizkuntzan irakurri dut</button>
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
                            echo '<option value="'. $language['id_idioma'].'">'.$language['nombre'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!-- Titulo del libro alternativo -->
                <div class="input-container">
                    <i class="fa-solid fa-heading"></i>
                    <input type="text" name="alternative_title" id="alternative_title" placeholder="Izenburua hizkuntza horretan" value="<?php if (isset($_REQUEST['nickname'])) echo $_REQUEST['nickname'] ?>">
                </div>
            </section>
            <!-- Error: Formulario -->
            <div class="error hidden" id="form-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>Bete formularioa behar bezala.</p>
            </div>
            <button>Igo liburua</button>
        </form>
    </main>
</body>
</html>