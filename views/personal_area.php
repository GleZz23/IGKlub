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
    <div id="profile_container">
      <div class="profile_data">
        <img src="" alt=""> <!--imagen de PERFIL -->
        <h1><?php echo $_SESSION['name'] ?> <?php echo $_SESSION['surnames'] ?> </h1>
      </div>
      <div class="profile_data">
        <h2 id="nickname">Nickname: <?php echo $_SESSION['nickname']?></h2>
        <h2 id="fec_nacimiento">Jaiotza data: <?php echo $_SESSION['date']?></h2>
        <h2 id="email">Emaila: <?php echo $_SESSION['email']?></h2> 
      </div>
      <button id="profile_edit_btn" onclick="location.href='../views/change_personal_area.php'">Pasahitza aldatu</button>
    </div>
  </main>
  
</body>
</html>