<?php
include_once('../templates/head.php');
include_once('../modules/connection.php');
session_start();
?>
  <link rel="stylesheet" href="../styles/class.css">
  <title>Nire gelak | IGKlub</title>
  </head>
<body>
<header>
    <section>
      <figure>
        <img src="../src/img/logo/logo.png">
      </figure>
      <h1>
        <?php echo $_SESSION['nickname']?>ren taldeak
      </h1>
    </section>
  </header>
  <main>
    <?php
    $query = $miPDO->prepare('SELECT * FROM grupo WHERE profesor = :teacher');
    $query->execute(['teacher' => $_SESSION['nickname']]);
    $results = $query->fetchAll();

    if ($results) {
      echo '<section>';
      foreach ($results as $position => $book) {
        echo '<div class="class-container">';
        echo '<div class="book-overlay">
                <div class="book-info">
                  <h1 id="title">' . $book['titulo'] . '</h1>
                  <p id="autor">' . $book['escritor'] . '</p>
                  <a href="book_info.php?liburua='.$book['id_libro'] .'">Liburu orria</a>
                </div>
              </div>
            </div>';
      }
      echo '<div class="class-container">
              <a href="new_group.php"><i class="fa-solid fa-users-rectangle"></i>Gela sortu</a>
            </div>';
    } else {
      echo '<div class="class-container">
              <a href="new_group.php"><i class="fa-solid fa-users-rectangle"></i>Gela sortu</a>
            </div>';
    }
    echo '</section>';
    ?>
  </main>
</body>
</html>