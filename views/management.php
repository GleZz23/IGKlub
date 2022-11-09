<?php
  include_once('../templates/head.php');
  include_once('../modules/connection.php');
  session_start();

  $nickname_error = false;
  $email_error = false;

  $signup_admin = true;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_REQUEST['form-action']) {
      // Aceptar nuevos profesores
      case 'accept-teacher':
        switch ($_REQUEST['accept']) {
          case 'yes':
            $query = $miPDO->prepare('UPDATE usuario SET estado = "aceptado" WHERE nickname = :nickname;');
            $query->execute(['nickname' => $_REQUEST['nickname']]);
            break;
  
          case 'no':
            $query = $miPDO->prepare('UPDATE usuario SET estado = "denegado" WHERE nickname = :nickname;');
            $query->execute(['nickname' => $_REQUEST['nickname']]);
            break;
        }
        break;

      // Aceptar nuevos idiomas
      case 'accept-language':
        switch ($_REQUEST['accept']) {
          case 'yes':
            $query = $miPDO->prepare('SELECT nombre FROM idioma WHERE nombre = :idioma;');
            $query->execute(['idioma' => $_REQUEST['language']]);
            $results = $query->fetchAll();

            if (!$results) {
              $query = $miPDO->prepare('INSERT INTO idioma (nombre) VALUES (:idioma);');
              $query->execute(['idioma' => $_REQUEST['language']]);
            }
            
            $query = $miPDO->prepare('UPDATE solicitud_idioma SET estado = "aceptado" WHERE idioma = :idioma;');
            $query->execute(['idioma' => $_REQUEST['language']]);

            $query = $miPDO->prepare('SELECT id_idioma FROM idioma WHERE nombre = :idioma;');
            $query->execute(['idioma' => $_REQUEST['language']]);
            $id_idioma = $query->fetch();

            $query = $miPDO->prepare('INSERT INTO idioma_libro VALUES (:id_libro, :idioma, :titulo);');
            $query->execute(['id_libro' => $_REQUEST['id_libro'], 'idioma' => $id_idioma['id_idioma'], 'titulo' => $_REQUEST['title']]);
            break;
  
          case 'no':
            $query = $miPDO->prepare('DELETE FROM idioma WHERE idioma = :idioma;');
            $query->execute(['idioma' => $_REQUEST['language']]);
            break;
        }
        break;

      // Aceptar nuevos libros
      case 'accept-book':
        switch ($_REQUEST['accept']) {
          case 'yes':
            $query = $miPDO->prepare('UPDATE solicitud_libro SET estado = "aceptado" WHERE id_libro = :id_libro;');
            $query->execute(['id_libro' => $_REQUEST['id_libro']]);
            break;
  
          case 'no':
            $query = $miPDO->prepare('DELETE FROM libro WHERE id_libro = :id_libro;');
            $query->execute(['id_libro' => $_REQUEST['id_libro']]);
            $rute = '../src/img/books/'.$_REQUEST['id_libro'].'.jpg';
            unlink($rute);
            break;
        }
        break;
      // Aceptar comentarios y respuestas
      case 'accept-comment':
        switch ($_REQUEST['accept']) {
          case 'yes':
            $query = $miPDO->prepare('UPDATE comentario SET estado = "aceptado" WHERE id_comentario = :id_comentario;');
            $query->execute(['id_comentario' => $_REQUEST['id_comentario']]);
            break;
  
          case 'no':
            $query = $miPDO->prepare('DELETE FROM comentario WHERE id_comentario = :id_comentario;');
            $query->execute(['id_comentario' => $_REQUEST['id_comentario']]);
            break;
        }
        break;

        case 'accept-answer':
          switch ($_REQUEST['accept']) {
            case 'yes':
              $query = $miPDO->prepare('UPDATE respuesta SET estado = "aceptado" WHERE id_respuesta = :id_respuesta;');
              $query->execute(['id_respuesta' => $_REQUEST['id_respuesta']]);
              break;
    
            case 'no':
              $query = $miPDO->prepare('DELETE FROM comentario WHERE id_respuesta = :id_respuesta;');
              $query->execute(['id_respuesta' => $_REQUEST['id_respuesta']]);
              break;
          }
          break;
        // Agregar y eliminar nuevos administradores
        case 'delete-admin':
            $query = $miPDO->prepare('UPDATE usuario SET estado = "denegado" WHERE nickname = :nickname;');
            $query->execute(['nickname' => $_POST['nickname']]);
          break;

        case 'new-admin':
          $nickname = $_POST["nickname"];
          $email = $_POST["email"];
          $name = $_POST["name"];
          $surnames = $_POST["surnames"];
          $password = password_hash($nickname, PASSWORD_DEFAULT);
          
          $query = $miPDO->prepare('SELECT nickname, email FROM usuario WHERE nickname=:nickname OR email=:email');
          $query->execute(['nickname' => $nickname, 'email' => $email]);
          $results = $query->fetch();
      
          if (!empty($results)) {
            // Si el nickname existe
            if ($results['nickname'] === $nickname) {
              $signup_admin = false;
              $nickname_error = true;
            }
          
            // Si el email existe
            if ($results['email'] === $email) {
              $signup_admin = false;
              $email_error = true;
            }
          }

          // Si el registro es valido
          if ($signup_admin) {
            // Inserto el usuario en la base de datos
            $query = $miPDO->prepare('INSERT INTO usuario (nickname, email, nombre, apellidos, contrasena, rol, estado) VALUES (:nickname, :email, :name, :surnames, :password, "admin", "aceptado")');
            $query->execute(['nickname' => $nickname, 'email' => $email, 'name' => $name, 'surnames' => $surnames, 'password' => $password]);
          }
          break;
        // Aceptar o denegar idiomas
    }
  }

?>
    <script src="../src/js/management.js" defer></script>
    <link rel="stylesheet" href="../styles/management.css">
    <title>Administrazioa | IGKlub</title>
</head>
<body>
  <header>
    <figure>
      <a href="main_menu.php"><img src="../src/img/logo/logo.png"></a>
    </figure>
    <h1>Administrazioa</h1>
    <button class="hidden" id="profile">
      <i class="fa-solid fa-bars"></i>
    </button>
    <div class="profile-pic">
      <?php
        echo '<a href="personal_area.php" style="background: url(../src/img/profile/'.$_SESSION['profile_img'].'); background-position: center; background-size: cover;"></a>';
      ?>
    </div>
  </header>
  <!-- BOTON DEL MENU HAMBURGUESA -->
  <div class="burguer-menu">
    <aside class="profile">
      <?php
      echo '<div class="profile-img">
              <figure style="background: url(../src/img/profile/'.$_SESSION['profile_img'].'); background-position: center; background-size: cover;"></figure>
            </div>';
      ?>
      <button id="accept-teachers"><i class="fa-solid fa-user-group"></i>Irakasleak onartu</button>
      <button id="accept-books"><i class="fa-solid fa-book"></i>Liburuak onartu</button>
      <button id="accept-comments"><i class="fa-solid fa-comments"></i>Iruzkinak onartu</button>
      <button id="accept-languages"><i class="fa-solid fa-language"></i></i>Hizkuntzak onartu</button>
      <button id="admins"><i class="fa-solid fa-users-gear"></i>Administratzaileak</button>
      <button id="database"><i class="fa-solid fa-database"></i>Datu-basea</button>
      <a href="main_menu.php"><i class="fa-solid fa-house"></i>Hasiera</a>
      <button class="close-profile">Itxi <i class="fa-solid fa-angles-right"></i></button>
    </aside>
  </div>
  <section class="sticky-menu">
  <button id="accept-teachers"><i class="fa-solid fa-user-group"></i>Irakasleak onartu</button>
      <button id="accept-books"><i class="fa-solid fa-book"></i>Liburuak onartu</button>
      <button id="accept-comments"><i class="fa-solid fa-comments"></i>Iruzkinak onartu</button>
      <button id="accept-languages"><i class="fa-solid fa-language"></i></i>Hizkuntzak onartu</button>
      <button id="admins"><i class="fa-solid fa-users-gear"></i>Administratzaileak</button>
      <button id="database"><i class="fa-solid fa-database"></i>Datu-basea</button>
      <a href="main_menu.php"><i class="fa-solid fa-house"></i>Hasiera</a>
  </section>
  <main>
    <!-- Aceptar nuevos profesores -->
    <?php
    $query = $miPDO->prepare('SELECT usuario.*, centro.nombre AS nombre_centro FROM usuario, centro WHERE usuario.rol = "irakasle" AND usuario.estado = "espera" AND usuario.id_centro = centro.id_centro');
    $query->execute();
    $results = $query->fetchAll();

    if ($results) {
      echo '<section class="accept-teachers">
            <table>
              <tr>
                <th></th>
                <th>Nickname</th>
                <th>Izen-abizenak</th>
                <th>Ikastetxea</th>
                <th>Email-a</th>
                <th>Telefonoa</th>
                <th>Onartu</th>
              </tr>';
      foreach ($results as $position => $teacher){
        echo '<tr>
                <td class="profile-img">
                  <figure style="background: url(../src/img/profile/'.$teacher['imagen'].'); background-position: center; background-size: cover;"></figure>
                </td>
                <td>'.$teacher['nickname'].'</td>
                <td>'.$teacher['nombre'].' '.$teacher['apellidos'].'</td>
                <td>'.$teacher['nombre_centro'].'</td>
                <td>'.$teacher['email'].'</td>
                <td>'.$teacher['telefono'].'</td>
                <td class="actions">
                  <form action="" method="post">
                    <input type="hidden" name="form-action" value="accept-teacher">
                    <input type="hidden" name="nickname" value="'.$teacher['nickname'].'">
                    <input type="hidden" name="accept" value="yes">
                    <button><i class="fa-solid fa-thumbs-up"></i></button>
                  </form>
              
                  <form action="" method="post">
                    <input type="hidden" name="form-action" value="accept-teacher">
                    <input type="hidden" name="nickname" value="'.$teacher['nickname'].'">
                    <input type="hidden" name="accept" value="no">
                    <button><i class="fa-solid fa-thumbs-down"></i></button>
                  </form>
                </td>
              </tr>';
      }
      echo '</table>
            </section>';
    } else {
      echo '<section class="accept-teachers hidden">
              <h1>Oraindik ez dago irakaslerik onartzeko</h1>
            </section>';
    }
    ?>
    
    <!-- Aceptar nuevos libros -->
    <?php
      // Recojo todos los valores de los libros en una variable
      $query = $miPDO->prepare('SELECT libro.*, solicitud_libro.nickname FROM libro, solicitud_libro WHERE libro.id_libro = solicitud_libro.id_libro AND solicitud_libro.estado = "espera"');
      $query->execute();
      $books = $query->fetchAll();

      if ($books) {
        echo '<section class="accept-books">';
        foreach ($books as $position => $book) {
          echo '<div class="book-container">';
          if ($book['portada'] === '') {
          echo '<img src="../src/img/books/default.jpg">';
          } else {
          echo '<img src="../src/img/books/'.$book['id_libro'].'.jpg">';
        }
          echo '<div class="book-overlay">
                  <div class="book-info">
                    <h1 id="title">' . $book['titulo'] . '</h1>
                    <p id="autor">' . $book['escritor'] . '</p>
                    <a href="book_info.php?liburua='.$book['id_libro'].'">Liburu orria</a>
                    <div class="actions">
                      <form action="" method="post">
                        <input type="hidden" name="form-action" value="accept-book">
                        <input type="hidden" name="id_libro" value="'.$book['id_libro'].'">
                        <input type="hidden" name="accept" value="yes">
                        <button><i class="fa-solid fa-thumbs-up"></i></button>
                      </form>
                  
                      <form action="" method="post">
                        <input type="hidden" name="form-action" value="accept-book">
                        <input type="hidden" name="id_libro" value="'.$book['id_libro'].'">
                        <input type="hidden" name="accept" value="no">
                        <button><i class="fa-solid fa-thumbs-down"></i></button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>';
        }
        echo '</section>';
      } else {
        echo '<section class="accept-books hidden">
                <h1>Ez daude liburu berriak onartzeko</h1>
              </section>';
      }
      ?>

      <!-- Aceptar comentarios y respuestas -->
      <?php
      $query = $miPDO->prepare('SELECT *, libro.titulo AS libro FROM comentario, libro WHERE estado = "espera" AND comentario.id_libro = libro.id_libro');
      $query->execute();
      $results = $query->fetchAll();

      if ($results) {
        echo '<section class="accept-comments">
              <table>
                <tr>
                  <th></th>
                  <th>Nickname</th>
                  <th>Liburua</th>
                  <th>Iruzkina</th>
                  <th>Onartu</th>
                </tr>';
        foreach ($results as $position => $comment){
          echo '<tr>
                  <td class="profile-img">
                    <figure style="background: url(../src/img/profile/'.$comment['imagen'].'); background-position: center; background-size: cover;"></figure>
                  </td>
                  <td>'.$comment['nickname'].'</td>
                  <td>'.$comment['libro'].'</td>
                  <td>'.$comment['mensaje'].'</td>
                  <td class="actions">
                    <form action="" method="post">
                      <input type="hidden" name="form-action" value="accept-comment">
                      <input type="hidden" name="id_comentario" value="'.$comment['id_comentario'].'">
                      <input type="hidden" name="accept" value="yes">
                      <button><i class="fa-solid fa-thumbs-up"></i></button>
                    </form>
                
                    <form action="" method="post">
                      <input type="hidden" name="form-action" value="accept-comment">
                      <input type="hidden" name="id_comentario" value="'.$comment['id_comentario'].'">
                      <input type="hidden" name="accept" value="no">
                      <button><i class="fa-solid fa-thumbs-down"></i></button>
                    </form>
                  </td>
                </tr>';
        }
        echo '</table>
              </section>';
      } else {
        echo '<section class="accept-comments hidden">
                <h1>Oraindik ez daude iruzkinik onartzeko</h1>
              </section>';
      }
      
      $query = $miPDO->prepare('SELECT *, libro.titulo AS libro FROM respuesta, libro WHERE estado = "espera" AND respuesta.id_libro = libro.id_libro');
      $query->execute();
      $results = $query->fetchAll();

      if ($results) {
        echo '<section class="accept-answers">
              <table>
                <tr>
                  <th></th>
                  <th>Nickname</th>
                  <th>Liburua</th>
                  <th>Iruzkina</th>
                  <th>Onartu</th>
                </tr>';
        foreach ($results as $position => $answer){
          echo '<tr>
                  <td class="profile-img">
                    <figure style="background: url(../src/img/profile/'.$answer['imagen'].'); background-position: center; background-size: cover;"></figure>
                  </td>
                  <td>'.$answer['nickname'].'</td>
                  <td>'.$answer['libro'].'</td>
                  <td>'.$answer['mensaje'].'</td>
                  <td class="actions">
                    <form action="" method="post">
                      <input type="hidden" name="form-action" value="accept-answer">
                      <input type="hidden" name="id_respuesta" value="'.$answer['id_comentario'].'">
                      <input type="hidden" name="accept" value="yes">
                      <button><i class="fa-solid fa-thumbs-up"></i></button>
                    </form>
                
                    <form action="" method="post">
                      <input type="hidden" name="form-action" value="accept-answer">
                      <input type="hidden" name="id_respuesta" value="'.$answer['id_comentario'].'">
                      <input type="hidden" name="accept" value="no">
                      <button><i class="fa-solid fa-thumbs-down"></i></button>
                    </form>
                  </td>
                </tr>';
        }
        echo '</table>
              
              </section>';
      } else {
        echo '<section class="accept-answers hidden">
                <h1>Oraindik ez daude erantzunak onartzeko</h1>
              </section>';
      }
      ?>

    <!-- Aceptar nuevos idiomas -->
    <?php
    $query = $miPDO->prepare('SELECT solicitud_idioma.*, usuario.imagen FROM solicitud_idioma, usuario WHERE solicitud_idioma.estado = "espera" AND solicitud_idioma.nickname = usuario.nickname');
    $query->execute();
    $results = $query->fetchAll();

    if ($results) {
      echo '<section class="accept-languages">
            <table>
              <tr>
                <th></th>
                <th>Nickname</th>
                <th>Hizkuntza</th>
                <th>Onartu</th>
              </tr>';
      foreach ($results as $position => $language){
        echo '<tr>
                <td class="profile-img">
                  <figure style="background: url(../src/img/profile/'.$language['imagen'].'); background-position: center; background-size: cover;"></figure>
                </td>
                <td>'.$language['nickname'].'</td>
                <td>'.$language['idioma'].'</td>
                <td class="actions">
                  <form action="" method="post">
                    <input type="hidden" name="form-action" value="accept-language">
                    <input type="hidden" name="id_libro" value="'.$language['id_libro'].'">
                    <input type="hidden" name="language" value="'.$language['idioma'].'">
                    <input type="hidden" name="title" value="'.$language['titulo'].'">
                    <input type="hidden" name="accept" value="yes">
                    <button><i class="fa-solid fa-thumbs-up"></i></button>
                  </form>
              
                  <form action="" method="post">
                    <input type="hidden" name="form-action" value="accept-language">
                    <input type="hidden" name="language" value="'.$language['idioma'].'">
                    <input type="hidden" name="accept" value="no">
                    <button><i class="fa-solid fa-thumbs-down"></i></button>
                  </form>
                </td>
              </tr>';
      }
      echo '</table>
            </section>';
    } else {
      echo '<section class="accept-languages hidden">
              <h1>Oraindik ez dago hizkuntzarik onartzeko</h1>
            </section>';
    }
    ?>

    <!-- Agregar nuevos administradores -->
    <?php
      $query = $miPDO->prepare('SELECT * FROM usuario WHERE rol = "admin" AND estado != "denegado"');
      $query->execute();
      $results = $query->fetchAll();

      if ($results) {
        echo '<section class="admins">
              <table>
                <tr>
                  <th></th>
                  <th>Nickname</th>
                  <th>Izen-abizenak</th>
                  <th>Email-a</th>
                </tr>';
        foreach ($results as $position => $admin){
          echo '<tr>
                  <td class="profile-img">
                    <figure style="background: url(../src/img/profile/'.$admin['imagen'].'); background-position: center; background-size: cover;"></figure>
                  </td>
                  <td>'.$admin['nickname'].'</td>
                  <td>'.$admin['nombre'].' '.$admin['apellidos'].'</td>
                  <td>'.$admin['email'].'</td>';
          if ($admin['nickname'] !== $_SESSION['nickname']) {
          echo    '<td class="actions">
                    <form action="" method="post">
                      <input type="hidden" name="form-action" value="delete-admin">
                      <input type="hidden" name="nickname" value="'.$admin['nickname'].'">
                      <button><i class="fa-solid fa-trash-can"></i> Kendu</button>
                    </form>
                  </td>';
          }
          
          echo  '</tr>';
        }
        echo '</table>';
      ?>
      <form id="singupForm" action="" method="post">
        <h1>Erregistratu - Administratzailea</h1>
        <!-- Nickname -->
        <div class="input-container">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="nickname" id="nickname" placeholder="Nickname" maxlength="20" autocomplete="none">
        </div>
        <!-- Error: Nickname -->
        <div class="error hidden" id="nickname-error">
          <i class="fa-solid fa-circle-exclamation"></i>
          <p>Ezizenak 4 eta 20 karaktere izan behar ditu, letraz, zenbakiz, marratxoz (-) eta azpimarraz (_) osatuta.</p>
        </div>
        <?php
        if ($nickname_error) {
          echo '<div class="error php-error">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <p>Nickname hau dagoeneko erabiltzen ari da. Saiatu beste bat.</p>
                </div>';
        }
        ?>
        <!-- Email -->
        <div class="input-container">
          <i class="fa-solid fa-at"></i>
          <input type="email" name="email" id="email" placeholder="Email-a">
        </div>
        <!-- Error: Email -->
        <div class="error hidden" id="email-error">
          <i class="fa-solid fa-circle-exclamation"></i>
          <p>Email-aren formatuak ez du balio.</p>
        </div>
        <?php
        if ($email_error) {
          echo '<div class="error php-error">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <p>Email hau dagoeneko erabiltzen ari da. Saiatu beste bat.</p>
                </div>';
        }
        ?>
        <!-- Nombre completo -->
        <div class="input-container">
          <i class="fa-solid fa-address-card"></i>
          <div>
            <input type="text" name="name" id="name" placeholder="Izena">
            <input type="text" name="surnames" id="surnames" placeholder="Abizenak">
          </div>
        </div>
        <!-- Error: Nombre completo -->
        <div class="error hidden" id="name-error">
          <i class="fa-solid fa-circle-exclamation"></i>
          <p>Izenak letra larriz hasi behar du eta letrak soilik izan ditzake.</p>
        </div>
        <div class="error hidden" id="surnames-error">
          <i class="fa-solid fa-circle-exclamation"></i>
          <p>Abizenek letrak soilik izan ditzakete.</p>
        </div>
        <!-- Contraseñas -->
        <div class="input-container">
          <i class="fa-solid fa-key"></i>
          <div>
            <p class="pass-info">Nickname-a bezala izango da.</p>
          </div>
        </div>
        <!-- Error: Formulario -->
        <div class="error hidden" id="form-error">
          <i class="fa-solid fa-circle-exclamation"></i>
          <p>Bete formularioa behar bezala.</p>
        </div>
        <input type="hidden" name="form-action" value="new-admin">
        <button>Erregistratu</button>
      </form>
      </section>
      <?php
      } else {
        echo '<section class="admins hidden">
                <h1>Oraindik ez dago irakaslerik onartzeko</h1>
              </section>';
      }
      ?>
  </main>
</body>
</html>
