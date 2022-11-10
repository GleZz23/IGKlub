<?php
  include('../templates/head.php');
  include_once('../modules/connection.php');
  include_once('../modules/session_control.php');
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
      <h1><?php echo $_SESSION['nickname'] ?>ren taldeak</h1>
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
            <a href="personal_area.php"><i class="fa-solid fa-user"></i>Area pertsonala</a>';
      if ($_SESSION['role'] === 'irakasle') {
        echo '<a href="groups.php"><i class="fa-solid fa-users-rectangle"></i>Nire taldeak</a>';
      } else if ($_SESSION['role'] === 'admin') {
        echo '<a href="management.php"><i class="fa-solid fa-gear"></i>Administrazioa</a></h1>';
      }
      echo '<a href="../modules/logout.php"><i class="fa-solid fa-user-slash"></i>Saioa itxi</a>';
    ?>
  </section>
  <main>
    <?php
      $query = $miPDO->prepare('SELECT grupo.*, centro.nombre AS school FROM grupo, centro WHERE grupo.profesor = :teacher AND grupo.id_centro = centro.id_centro');
      $query->execute(['teacher' => $_SESSION['nickname']]);
      $results = $query->fetchAll();

      if ($results) {
        echo '<section>';
        foreach ($results as $position => $group) {
          echo '<div class="class-container">
                  <header>
                    <h1 id="name">'.$group['nombre'] .'</h1>
                    <h1 id="code">'.$group['codigo'].'</h1>
                  </header>
                  <div class="class-info">
                    <p id="teacher">'.$group['profesor'].'</p>
                    <p id="school">'.$group['school'].'</p>
                    <p id="level">'.$group['curso'].' - '.$group['nivel'].'</p>
                  </div>
                  <a href="group_info.php?code='.$group['codigo'].'"><i class="fa-solid fa-circle-info"></i>Taldea ikusi</a>
                </div>';
        }
      }
      echo '<div class="new-class-container">
              <span id="new-group" href="new_group.php"><i class="fa-solid fa-users-rectangle"></i>Gela sortu</span>
            </div>';
      echo '</section>';
    ?>
  </main>
  <div class="new-group">
    <button class="closeButton"><i class="fa-solid fa-x"></i></button>
    <form id="newGroupForm" action="" method="post">
      <h1>Talde berri bat sortu</h1>
      <!-- Nombre del grupo -->
      <div class="input-container">
        <i class="fa-solid fa-heading"></i>
        <input type="text" name="title" id="title" placeholder="Taldearen izena" autofocus value="<?php if (isset($_REQUEST['nickname'])) echo $_REQUEST['nickname'] ?>">
      </div>
      <!-- Error: Nombre del grupo -->
      <div class="error hidden" id="title-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>.</p>
      </div>
      <!-- Centro -->
      <div class="input-container">
        <i class="fa-solid fa-school"></i>
        <select name="school" id="school">
            <option value="-" selected>Ikastetxea</option>
        <?php
            $query = $miPDO->prepare('SELECT * FROM centro ORDER BY nombre ASC');
            $query->execute();
            $results = $query->fetchAll();

            foreach ($results as $position => $school) {
                echo '<option value="'.$school['id_centro'].'">'.$school['nombre'].'</option>';
            }
        ?>
        </select>
      </div>
      <!-- Curso -->
      <div class="input-container">
        <i class="fa-solid fa-list-ol"></i>
        <input type="text" name="curso" id="title" placeholder="Kurtzoa" value="<?php if (isset($_REQUEST['nickname'])) echo $_REQUEST['nickname'] ?>">
      </div>
      <!-- Error: Curso -->
      <div class="error hidden" id="title-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>.</p>
      </div>
      <!-- Nivel -->
      <div class="input-container">
        <i class="fa-solid fa-hashtag"></i>
        <input type="text" name="level" id="level" placeholder="Maila" value="<?php if (isset($_REQUEST['nickname'])) echo $_REQUEST['nickname'] ?>">
      </div>
      <!-- Error: Nivel -->
      <div class="error hidden" id="title-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>.</p>
      </div>
      <button>Taldea sortu</button>
    </form>
  </div>
</body>
</html>