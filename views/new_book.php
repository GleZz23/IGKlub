<?php
include_once('../templates/head.php');
include_once('../modules/connection.php');
session_start();
// FILTROS
?>

<!-- <script src="../src/js/hamburgesa.js" defer></script> -->

<head>
    <script src="../src/js/profile.js" defer></script>
    <script src="../src/js/new_book_validation.js" defer></script>
    <link rel="stylesheet" href="../styles/new_book.css">
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
        <form action="" id="add_book_form">
            <div id="add_book_form_header">
                <h1>Liburu barria sartu</h1>
            </div>
            <div id="add_book_form_container">
                <!-- Titulo -->
                <div class="input_container">
                    <input type="text" id="title" name="title" placeholder="Titulua">
                </div>
                <!-- Error titulo -->
                <div class="error hidden" id="title-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <p>Titulua sartzea beharrezkoa da.</p>
                </div>
                <!--Escritor  -->
                <div class="input_container">
                    <input type="text" id="writter" name="writter" placeholder="Idazlea">
                </div>
                <!-- Error escritor -->
                <div class="error hidden" id="writter-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <p>Idazlea sartzea beharrezkoa da.</p>
                </div>
                <!-- Sinopsis -->
                <div class="input_container">
                    <input type="text" id="sinopsis" name="sinopsis" placeholder="Sinopsia">
                </div>
                <!-- Error sinopsis -->
                <div class="error hidden" id="sinopsis-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <p>Sinopsia sartzea beharrezkoa da.</p>
                </div>
                <!--Idioma  -->
                <div class="input_container">
                    <input type="text" id="language" name="language" placeholder="Hizkuntza">
                </div>
                <!-- Error idioma -->
                <div class="error hidden" id="language-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <p>Hizkuntza sartzea beharrezkoa da.</p>
                </div>
                <!-- Formato -->
                <div class="input_container">
                    <label>Formatua </label><select id="format" name="format">
                        <option value="Nobela">Nobela</option>
                        <option value="Komikia">Komikia</option>
                        <option value="Nobela grafikoa">Nobela grafikoa</option>
                        <option value="Manga">Manga</option>
                    </select>
                </div>
                <!-- Error formato -->
                <div class="error hidden" id="format-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <p>Formatua sartzea beharrezkoa da.</p>
                </div>
                <!-- Imagen  -->
                <div class="input_container">
                    <label>Irudia </label><input type="file" id="image" name="image" accept="image/jpg" required>
                </div>
                <!-- Etiqueta -->
                <div class="input_container">
                    <input type="text" id="label" name="label">
                </div>
            </div>
            <button>Konfirmatu</button>
        </form>
    </main>

</body>

</html>