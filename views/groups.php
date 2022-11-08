<?php
include_once('../templates/head.php');
include_once('../modules/connection.php');
session_start();
?>
<link rel="stylesheet" href="../styles/groups.css">
<title>Nire gelak | IGKlub</title>
</head>

<body>
  <header>
    <section>
      <figure>
        <img src="../src/img/logo/logo.png">
      </figure>
      <h1>
        <?php echo $_SESSION['nickname'] ?>ren taldeak
      </h1>
    </section>
    <nav class="menu">

      <?php
      // echo '<div class="profile-img">
      //         <figure style="background: url(../src/img/profile/'.$_SESSION['profile_img'].'); background-position: center; background-size: cover;"></figure>
      //       </div>';
      echo '<a href="main_menu.php"><i class="fa-solid fa-house"></i>Hasiera</a>
                <span class="newBookButton"><i class="fa-solid fa-book"></i>Igo liburu bat</span>';
      if ($_SESSION['role'] === 'irakasle') {
        echo '
                  <a href="requests.php"><i class="fa-solid fa-question"></i>Eskaerak</a>';
      } else if ($_SESSION['role'] === 'admin') {
        echo '<a href="management.php"><i class="fa-solid fa-gear"></i>Administrazioa</a></h1>';
      }
      echo '<a href="personal_area.php"><i class="fa-solid fa-user"></i>Area pertsonala</a>';

      ?>

    </nav>
  </header>
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
                <h1 id="name">' . $group['codigo'] . '</h1>
                  <h1 id="name">' . $group['nombre'] . '</h1>
                </div>
              </div>
            </div>';
      }
      
    }
    echo '</section>';
    echo '<div class="class-container">
              <a href="new_group.php"><i class="fa-solid fa-users-rectangle"></i>Gela sortu</a>
            </div>';
    ?>
  </main>
</body>

</html>