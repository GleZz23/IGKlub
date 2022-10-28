<?php
    include_once('../templates/head.php');
    include_once('../modules/connection.php');
    session_start();
?>
    <script src="../src/js/profile.js" defer></script>
    <script src="../src/js/new_book_validation.js" defer></script>
    <link rel="stylesheet" href="../styles/new_book.css">
    <title>Igo liburu bat | IGKlub</title>
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
                if ($_SESSION['role'] === 'ikasle') {
                    echo '<h1>' . $_SESSION['nickname'] . '</h1>';
                    echo '<h1><a href="../views/personal_area.php">Area Pertsonala</a> </h1>';
                    echo '<h1><a href="../views/main_menu.php">Liburutegia</a></h1>';
                } else
                    echo '<h1>' . $_SESSION['nickname'] . '</h1>';
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
    <form id="singupForm" action="" method="post">
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
        <input type="file" name="cover" id="cover" placeholder="Liburuaren azala">
    </div>
    <!-- Error: Portada -->
    <div class="error hidden" id="cover-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>.</p>
    </div>
    <!-- Idiaoma -->
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
        <textarea id="sinopsis" name="sinopsis" placeholder="Sinopsia" autofocus required autocomplete="off" maxlength="2300"></textarea>
    </div>
    <button>Igo liburua</button>
  </form>
    </main>

</body>

</html>