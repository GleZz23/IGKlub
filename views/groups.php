<?php
include('../templates/head.php');
include_once('../modules/connection.php');
session_start();
?>
<link rel="stylesheet" href="../styles/groups.css">
<title>Nire gelak | IGKlub</title>
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
        <h1>
        <?php echo $_SESSION['nickname'] ?>ren taldeak
        </h1>
        <button class="hidden" id="profile">
          <i class="fa-solid fa-bars"></i>
        </button>
        <div class="profile-pic">
          <?php
            echo '<a href="personal_area.php" style="background: url(../src/img/profile/'.$_SESSION['profile_img'].'); background-position: center; background-size: cover;"></a>';
          ?>
        </div>
      </nav>
      <section>
        <!-- BOTON DEL MENU HAMBURGUESA -->
        <div class="burguer-menu">
          <aside class="profile">
            <?php
            echo '<div class="profile-img">
                    <figure style="background: url(../src/img/profile/'.$_SESSION['profile_img'].'); background-position: center; background-size: cover;"></figure>
                  </div>';
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
            <button class="close-profile">Itxi <i class="fa-solid fa-angles-right"></i></button>
          </aside>
        </div>
      </section>
    </header>
    <section class="sticky-menu">
      <?php
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
    </section>
  <main>
    <?php
    $query = $miPDO->prepare('SELECT * FROM grupo WHERE profesor = :teacher');
    $query->execute(['teacher' => $_SESSION['nickname']]);
    $results = $query->fetchAll();

    if ($results) {
      echo '<section>';
      foreach ($results as $position => $group) {
        echo '<div class="class-container">';
        echo '<div class="class-overlay">
                <div class="class-info">
                <h1 id="name">' . $group['codigo'] . '</h1><br>

                  <a href="group_info.php?gela=' . $group['codigo'] . '">
                  
                  <h1 id="name">' . $group['nombre'] . '</h1>
                  </a>
                </div>
              </div>
            </div>';
      }
      
    }
    echo '<div class="class-container">
    <a href="new_group.php"><i class="fa-solid fa-users-rectangle"></i>Gela sortu</a>
  </div>';
    echo '</section>';

    ?>
  </main>
</body>

</html>