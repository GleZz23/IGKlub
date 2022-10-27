<?php
include_once('../templates/head.php');
include_once('../modules/connection.php');
session_start();
// FILTROS
?>
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
      <button id="profile">
        <i class="fa-solid fa-bars"></i>
      </button>
      <aside class="profile">
    <?php
      if($_SESSION['role'] === 'ikasle') {
        echo '<h1>' . $_SESSION['nickname'] . '</h1>';
        echo '<h1><a href="../views/personal_area.php">Area Pertsonala</a> </h1>';
        echo '<h1><a href="../views/main_menu.php">Liburutegia</a></h1>';
              }else echo '<h1>' . $_SESSION['nickname'] . '</h1>';
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
    
  </main>
  
</body>
</html>