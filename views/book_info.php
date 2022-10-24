<?php
  include_once('../modules/connection.php');
  include_once('../templates/head.php');

  $book = $_GET['liburua'];

  $query = $miPDO->prepare('SELECT * FROM libro WHERE id_libro = :book');
  $query->execute(['book' => $book]);
  $results = $query->fetch();
?>
    <link rel="stylesheet" href="../styles/book_info.css">
<<<<<<< HEAD
    <title> <?php echo $book ?> | IGKlub</title>
    <script>
      function myFunction() {
      //   var div= document.getElementById("opinar")
      // var x = document.createElement("TEXTAREA");
      // var t = document.createTextNode("Opina sobre el libro...");
      // div.appendChild(x);
      // x.appendChild(t);
      // // document.div.appendChild(x);
      // document.getElementbyId("si")=x;

      var div= document.getElementById("opinar")
      var textarea = document.createElement("TEXTAREA");
      var br = document.createElement("br");
      var but = document.createElement("button");
      //textarea.style.rows=20;
      newDiv.appendChild(br);
      newDiv.appendChild(textarea);
      newDiv.appendChild(but);

}

function addElement () {
  // crea un nuevo div
  // y añade contenido
  var newDiv = document.getElementByClass("opinar").parentNode;
  var textarea = document.createElement("TEXTAREA");
  var br = document.createElement("br");
  var but = document.createElement("button");
  textarea.style.rows=20;
  newDiv.appendChild(br);
  newDiv.appendChild(textarea);
  newDiv.appendChild(but);

  // añade el elemento creado y su contenido al DOM
  var currentDiv = document.getElementById("div1");
  // document.body.insertBefore(textarea, newDiv);
  // document.body.insertBefore(but, newDiv);

}
</script>
=======
    <title> <?php echo $results['titulo'] ?> | IGKlub</title>
>>>>>>> 5e47c63c65b578b7afb3db04ddabffc53f9ce0d6
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
    <div class="div5">
      <h3>Formato: 
        <?php
        echo '<p>'.$results['formato'].'</p>';
        ?> </h3><br>
        <h3>Edad media: 
        <?php
        echo '<p>'.$results['edad_media'].'</p>';
        ?> </h3><br>
        <h3>Numero de lectores: 
        <?php
        echo '<p>'.$results['num_lectores'].'</p>';
        ?> </h3><br>
        <h3>Nota media: </h3>
        <div class="nota">
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
    </div>
    <br>
    <div id="opinar">
          <h1>Opiniones:</h1><br><br><br>
          <hr>
          <br>
          <input type ="button" value="Opinar" class="opin" onclick="myFunction()">
          <!-- <p id="si"></p> -->
    </div>
  </main>
</body>
</html>