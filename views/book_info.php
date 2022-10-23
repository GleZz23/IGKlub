<?php
  include_once('../modules/connection.php');
  include_once('../templates/head.php');

  $book = $_GET['liburua'];

  $query = $miPDO->prepare('SELECT * FROM libro WHERE titulo = :book');
  $query->execute(['book' => $book]);
  $results = $query->fetch();
?>
    <link rel="stylesheet" href="../styles/book_info.css">
    <title> <?php echo $book ?> | IGKlub</title>
</head>
<body>
  <main>
    <figure>
      <?php echo '<img src="../src/img/books/'.$results['id_libro'].'.jpg" alt="'.$results['titulo'].'">' ?>
    </figure>
    <section>
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
    </section>
    <section class="sinopsis">
      <?php
        echo '<p>'.$results['sinopsis'].'</p>';
      ?>
    </section>
    <div class="div5">Demas datos</div>
  </main>
</body>
</html>