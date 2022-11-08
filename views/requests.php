<?php
include_once('../templates/head.php');
include_once('../modules/connection.php');
session_start();
// FILTROS
?>

<!-- <script src="../src/js/hamburgesa.js" defer></script> -->

<head>
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
      <!-- BOTON DEL MENU HAMBURGUESA -->
      <button id="profile">
        <i class="fa-solid fa-user"></i>
      </button>
      <aside class="profile">
        <?php
          echo '<div class="profile-img">
                  <figure style="background: url(../src/img/profile/' . $_SESSION['profile_img'] . '); background-position: center; background-size: cover;"></figure>
                </div>';
          echo '<a href="personal_area.php"><i class="fa-solid fa-user"></i>Area pertsonala</a>';
          echo '<a href="../modules/logout.php"><i class="fa-solid fa-user-slash"></i>Saioa itxi</a>';

          ?>
        <button class="close-profile">Itxi <i class="fa-solid fa-angles-right"></i></button>
      </aside>
    </section>
    <nav class="menu">

      <?php
      // echo '<div class="profile-img">
      //         <figure style="background: url(../src/img/profile/'.$_SESSION['profile_img'].'); background-position: center; background-size: cover;"></figure>
      //       </div>';
      echo '<a href="main_menu.php"><i class="fa-solid fa-house"></i>Hasiera</a>
                <span class="newBookButton"><i class="fa-solid fa-book"></i>Igo liburu bat</span>';
      if ($_SESSION['role'] === 'irakasle') {
        echo '<a href="groups.php"><i class="fa-solid fa-users-rectangle"></i>Nire taldeak</a>';
      } else if ($_SESSION['role'] === 'admin') {
        echo '<a href="management.php"><i class="fa-solid fa-gear"></i>Administrazioa</a></h1>';
      }
      echo '<a href="personal_area.php"><i class="fa-solid fa-user"></i>Area pertsonala</a>';
      ?>

    </nav>
    </aside>
    </section>
  </header>
  <main>

  </main>

</body>

</html>