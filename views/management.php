<?php
  include_once('../templates/head.php');
  include_once('../modules/connection.php');
  session_start();

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
      // Aceptar nuevos libros
      case 'accept-book':
        switch ($_REQUEST['accept']) {
          case 'yes':
            $query = $miPDO->prepare('UPDATE solicitud_libro SET estado = "aceptado" WHERE id_libro = :id_libro;');
            $query->execute(['id_libro' => $_REQUEST['id_libro']]);
            break;
  
          case 'no':
            $query = $miPDO->prepare('DELETE FROM solicitud_libro WHERE id_libro = :id_libro;');
            $query->execute(['id_libro' => $_REQUEST['id_libro']]);
            break;
        }
        break;
    }
  }

?>
    <script src="../src/js/management.js" defer></script>
    <link rel="stylesheet" href="../styles/management.css">
    <title>Administrazioa | IGKlub</title>
</head>
<body>
  <header>
    <section>
      <figure>
        <img src="../src/img/logo/logo.png">
      </figure>
      <h1>Administrazioa</h1>
    </section>
    <nav>
      <button id="accept-teachers">Irakasleak onartu</button>
      <button id="accept-books">Liburuak onartu</button>
      <button id="new-admin">Administratzaileak</button>
      <button id="database">Datu-basea</button>
      <a href="main_menu.php">Hasiera joan</a>
    </nav>
  </header>
  
  <main>
    <!-- Aceptar nuevos profesores -->
      <?php
      $query = $miPDO->prepare('SELECT usuario.*, centro.nombre AS nombre_centro FROM usuario, centro WHERE usuario.rol = "irakasle" AND usuario.id_centro = centro.id_centro AND usuario.estado = "espera"');
      $query->execute();
      $results = $query->fetchAll();

      if ($results) {
        echo '<section class="accept-teachers hidden">
              <table>
                <tr>
                  <th>Nickname</th>
                  <th>Izen-abizenak</th>
                  <th>Ikastetxea</th>
                  <th>Email-a</th>
                  <th>Telefonoa</th>
                  <th>Onartu</th>
                </tr>';
        foreach ($results as $position => $teacher){
          echo '<tr>
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
        echo '<section class="accept-books hidden">';
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
  </main>
</body>
</html>
