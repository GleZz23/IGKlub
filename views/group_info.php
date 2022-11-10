<?php
  include('../templates/head.php');
  include_once('../modules/connection.php');
  include_once('../modules/session_control.php');

  $nickname_error = false;
  $email_error = false;

  $signup_admin = true;

  $query = $miPDO->prepare('SELECT nombre FROM grupo WHERE codigo = :codigo;');
  $query->execute(['codigo' => $_GET['code']]);
  $nombreGrupo = $query->fetch();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    switch ($_REQUEST['form-action']) {
      // Aceptar nuevos profesores
      case 'accept-student':
        switch ($_REQUEST['accept']) {
          case 'yes':
            $query = $miPDO->prepare('UPDATE usuario SET estado = "aceptado" WHERE nickname = :nickname;');
            $query->execute(['nickname' => $_REQUEST['nickname']]);
            break;
  
          case 'no':
            $query = $miPDO->prepare('UPDATE solicitud_grupo SET estado = "denegado" WHERE nickname = :nickname;');
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
        
        // Aceptar o denegar idiomas
        
    }
    header('Location:group_info.php?code='.$_GET['code']);
  }

?>
    <script src="../src/js/management.js" defer></script>
    <link rel="stylesheet" href="../styles/group_info.css">
    <title><?php echo $nombreGrupo['nombre']; ?> | IGKlub</title>
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
      <h1><?php echo $nombreGrupo['nombre']; ?></h1>
      <button class="hidden" id="profile">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="profile-pic">
        <?php
          echo '<a href="personal_area.php" style="background: url(../src/img/profile/'.$_SESSION['profile_img'].'); background-position: center; background-size: cover;"></a>';
        ?>
      </div>
    </nav>
  </header>
  <!-- BOTON DEL MENU HAMBURGUESA -->
  <div class="burguer-menu">
    <aside class="profile">
      <?php
      echo '<div class="profile-img">
      <a href="personal_area.php"><figure style="background: url(../src/img/profile/'.$_SESSION['profile_img'].'); background-position: center; background-size: cover;"></figure></a>
            </div>';
      ?>
      <button id="accept-students"><i class="fa-solid fa-user-check"></i>Ikasleak onartu</button>
      <button id="accept-books"><i class="fa-solid fa-book"></i>Liburuak onartu</button>
      <button id="accept-comments"><i class="fa-solid fa-comments"></i>Iruzkinak onartu</button>
      <button id="accept-languages"><i class="fa-solid fa-language"></i></i>Hizkuntzak onartu</button>
      <a href="main_menu.php"><i class="fa-solid fa-house"></i>Hasiera</a>
      <button class="close-profile">Itxi <i class="fa-solid fa-angles-right"></i></button>
    </aside>
  </div>
  <section class="sticky-menu">
    <button id="accept-students"><i class="fa-solid fa-user-check"></i>Ikasleak onartu</button>
    <button id="accept-books"><i class="fa-solid fa-book"></i>Liburuak onartu</button>
    <button id="accept-comments"><i class="fa-solid fa-comments"></i>Iruzkinak onartu</button>
    <button id="accept-languages"><i class="fa-solid fa-language"></i></i>Hizkuntzak onartu</button>
    <a href="main_menu.php"><i class="fa-solid fa-house"></i>Hasiera</a>
  </section>
  <main>
    <!-- Aceptar nuevos Alumnos -->
    <?php
    $query = $miPDO->prepare('SELECT usuario.*, centro.nombre AS nombre_centro FROM usuario, centro WHERE usuario.rol = "ikasle" AND usuario.estado = "espera" AND usuario.id_centro = centro.id_centro');
    $query->execute();
    $results = $query->fetchAll();

    if ($results) {
      echo '<section class="accept-students">
            <table>
              <tr>
                <th></th>
                <th>Nickname</th>
                <th>Izen-abizenak</th>
                <th>Ikastetxea</th>
                <th>Email-a</th>
                <th>Onartu</th>
              </tr>';
      foreach ($results as $position => $student){
        echo '<tr>
                <td class="profile-img">
                  <figure style="background: url(../src/img/profile/'.$student['imagen'].'); background-position: center; background-size: cover;"></figure>
                </td>
                <td>'.$student['nickname'].'</td>
                <td>'.$student['nombre'].' '.$student['apellidos'].'</td>
                <td>'.$student['nombre_centro'].'</td>
                <td>'.$student['email'].'</td>
                <td class="actions">
                  <form action="" method="post">
                    <input type="hidden" name="form-action" value="accept-student">
                    <input type="hidden" name="nickname" value="'.$student['nickname'].'">
                    <input type="hidden" name="accept" value="yes">
                    <button><i class="fa-solid fa-thumbs-up"></i></button>
                  </form>
              
                  <form action="" method="post">
                    <input type="hidden" name="form-action" value="accept-student">
                    <input type="hidden" name="nickname" value="'.$student['nickname'].'">
                    <input type="hidden" name="accept" value="no">
                    <button><i class="fa-solid fa-thumbs-down"></i></button>
                  </form>
                </td>
              </tr>';
      }
      echo '</table>
            </section>';
    } else {
      echo '<section class="accept-students hidden">
              <h1>Oraindik ez daude ikaslerik onartzeko</h1>
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

    
  </main>
</body>
</html>

    