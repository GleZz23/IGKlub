<?php
  include_once('../modules/connection.php');
  include_once('../templates/head.php');
  session_start();

  $book = $_GET['liburua'];

  $query = $miPDO->prepare('SELECT * FROM libro WHERE id_libro = :book');
  $query->execute(['book' => $book]);
  $results = $query->fetch();
?>
    <link rel="stylesheet" href="../styles/book_info.css">
    <title> <?php echo $results['titulo'] ?> | IGKlub</title>
    <script src="../src/js/book_info.js" defer></script>
</head>
<body>
  <main>
    <figure>
      <?php echo '<img src="../src/img/books/'.$results['id_libro'].'.jpg" alt="'.$results['titulo'].'">' ?>
    </figure>
    <section>
      <!-- Titulo y escritor -->
      <header>
        <?php
          echo '<h1>'.$results['titulo'].'</h1>
                <h2>'.$results['escritor'].'</h2>';
        ?>
        <div class="stars">
          <?php
            if ($results['nota_media'] === 0) {
              for ($i = 0; $i <= 4; $i++) {
                echo '<i class="fa-solid fa-star"></i>';
              }
            } else {
              for ($i = 0; $i <= $results['nota_media']-1; $i++) {
                echo '<i class="calification fa-solid fa-star"></i>';
              }
              for ($i = 0; $i <= 4-$results['nota_media']; $i++) {
                echo '<i class="fa-solid fa-star"></i>';
              }
            }
          ?>
        </div>
      </header>
      <div class="middle-container">
      <!-- Sinopsis -->
        <div class="sinopsis">
          <?php
            echo '<p>'.$results['sinopsis'].'</p>';
          ?>
        </div>
        <!-- Demas datos -->
        <div class="more-info">
          <div>
            <h3>Formatua:</h3>
            <?php
              echo '<p>'.$results['formato'].'</p>';
            ?>
          </div>
          <div>
            <h3>Adina:</h3>
            <?php
              echo '<p>'.$results['edad_media'].'</p>';
            ?>
          </div>
          <div>
            <h3>Irakurleak:</h3>
            <?php
              echo '<p>'.$results['num_lectores'].'</p>';
            ?>
          </div>
        </div>
      </div>
      <!-- Acciones -->
      <div class="actions">
        <a href="#">Liburu hau baloratzea</a> <!-- Cambiar enlace -->
      </div>
    </section>
  </main>
  <!-- Reviews -->
  <section class="reviews">
    <header>
      <div>
        <h1>Iruzkinak</h1>
        <button><i class="fa-solid fa-comment"></i> Komentatu</button>
      </div>
      <form action="" method="post">
        <textarea id="mensaje" name="mensaje" placeholder="<?php echo $results['titulo'] ?> liburuari buruz uste dut..."
        required autocomplete="off" maxlength="2300"></textarea>
        <button>Nire iritzia eman</button>
      </form>
    </header>
    <?php
    $query = $miPDO->prepare('SELECT * FROM comentario WHERE id_libro = :book ORDER BY id_comentario DESC');
    $query->execute(['book' => $book]);
    $results = $query->fetchAll();

    if ($results) {
      foreach ($results as $position => $comment) {
        $id_comentario = $comment['id_comentario'];
        echo '<section class="comments">
                <div class="main-comment">
                  <header>
                    <h1>'.$comment['nickname'].'</h1>';
                    if ($comment['nickname'] === $_SESSION['nickname']) {
                      echo '<button><i class="fa-solid fa-trash-can"></i></button>';
                    } else {
                      echo '<button class="answer-button"><i class="fa-solid fa-reply"></i> Erantzun</button>';
                    }
                    
        echo      '</header>
                  <div class="mensaje">
                    '.$comment['mensaje'].'
                  </div>
                </div>';
    ?>
      <div class="user-answer">
        <header>
          <h1><?php echo $_SESSION['nickname'] ?></h1>
        </header>
        <div class="mensaje">
          <form action="../modules/new_answer.php" method="get">
            <textarea id="mensaje" name="mensaje" autofocus required autocomplete="off" maxlength="2300"></textarea>
            <input type="hidden" name="book" value="<?php echo $_GET['liburua'] ?>">
            <input type="hidden" name="nickname" value="<?php echo $_SESSION['nickname'] ?>">
            <input type="hidden" name="id_comment" value="<?php echo $comment['id_comentario'] ?>">
            <button>Erantzuna eman</button>
          </form>
        </div>
      </div>
    <?php
        $query = $miPDO->prepare('SELECT * FROM respuesta WHERE id_libro = :book AND id_comentario = :id_comentario AND estado = "aceptado" ORDER BY id_respuesta DESC');
        $query->execute(['book' => $book, 'id_comentario' => $id_comentario]);
        $results = $query->fetchAll();

        if ($results) {
          foreach ($results as $position => $answer) {
            echo '<div class="answer">
                    <header>
                      <h1>'.$answer['nickname'].'</h1>';
                      if ($answer['nickname'] === $_SESSION['nickname']) {
                        echo '<button><i class="fa-solid fa-trash-can"></i></button>';
                      }
            echo    '</header>
                    <div class="mensaje">
                      '.$answer['mensaje'].'
                    </div>
                  </div>';
          }
        }
        echo '</section>';
      }
    } else {
      echo '<h1 class="empty">Oraindik ez dago komentariorik</h1>';
    }
    ?>
    </section>
  </section>
</body>
</html>