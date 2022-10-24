<?php
  include_once('../templates/head.php');
  include_once('../modules/connection.php');
  session_start();
  // FILTROS
?>
    <!-- <script src="../src/js/hamburgesa.js" defer></script> -->
    <script src="../src/js/main_menu.js" defer></script>
    <link rel="stylesheet" href="../styles/main_menu.css">
    <title>Hasiera | IGKlub</title>
</head>
<body>
<?php
  include_once('../templates/head.php');
?>
    <link rel="stylesheet" href="../styles/main_menu.css">
    <title>Hasiera | IGKlub</title>
</head>
<body>
  <header>
    <figure>
      <img src="../src/img/logo/logo.png">
    </figure>
    <section>
      <button id="filters">
        <i class="fa-solid fa-filter"></i>
      </button>
      <div class="search-bar">
        <form action="" method="get">
          <input type="text" placeholder="Izenburua, idazlea...">
          <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
      </div>
      <button id="profile">
        <i class="fa-solid fa-bars"></i>
      </button>
    </section>
  </header>
  <main>
    <aside class="filters">
      <h1>FILTROS</h1>
      <form action="" method="post">
        <!-- FILTROS -->
        <button>Filtrar</button>
      </form>
    </aside>
    <?php
      // Recojo todos los valores de los libros en una variable
      $mainQuery = 'SELECT libro.* FROM libro, solicitud_libro WHERE libro.id_libro = solicitud_libro.id_libro AND solicitud_libro.estado = "aceptado"';
      $filter = 'ORDER BY id_libro DESC';
      $query = $miPDO->prepare($mainQuery.$filter);
      $query->execute();
      $results = $query->fetchAll();

    

    </main>
    <footer class="footer">
            <div class="footer__addr">
              <h1 class="footer__logo">Guri buruz</h1>
                  
              <h2>Kontaktua</h2>
              
              <address>
                © I.E.S. Miguel de Unamuno B.H.I.<br>
                    
                <a class="footer__btn" href="mailto:leireirakas21@gmail.com">Gmail</a>
              </address>
            </div>
            
            <ul class="footer__nav">
              <li class="nav__item">
                <h2 class="nav__title">Edukiak</h2>
          
                <ul class="nav__ul">
                  <li>
                    <a href="#">Profila</a>
                  </li>
          
                  <li>
                    <a href="#">Liburuak</a>
                  </li>
                      
                  <li>
                    <a href="#">Iritzia</a>
                  </li>
                </ul>
              </li>
              
              
              <li class="nav__item">
                <h2 class="nav__title">Kredituak</h2>
                
                <ul class="nav__ul">
                  <li>
                    <a href="https://fptxurdinaga.hezkuntza.net/es/web/Guest">FP Txurdinaga</a>
                  </li>
                  
                  <li>
                    <p>Txurdinaga LHII Lanbide Heziketako azken ikasturteko 2º ikasleek diseinatu dute webgune hau (Andrei,Ciprian,Iker,Iñigo).</p>
                  </li>
                </ul>
              </li>
            </ul>
            
            <div class="legal">
              <p>&copy; 2022 IGKlub. All rights reserved.</p>
              
              <div class="legal__links">
                <span><span class="heart"></span> 
                Bigarren Hezkuntzako gazte askok maite dute irakurketa. Hala ere, liburu-dendetan hainbeste liburu daude non ez dakigun nondik hasi. Webgune honetan gazteentzako eta ez hain gazteentzako liburuak daude: arrakastatsuenak, baita gustatu ez zaizkigunak ere. Bilatu eta gozatu!</span>
              </div>
            </div>
          </footer>

    
</body>
</html>