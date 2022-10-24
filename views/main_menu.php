<?php
  include_once('../templates/head.php');
  include_once('../modules/connection.php');
?>
    <script src="../js/hamburgesa.js" defer></script>
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
    <div class="logo">
    <img src="../src/img/logo.png"alt="">
    </div>
    <div class="search-bar">
      <form action="" method="get">
        <input type="text" placeholder="Izenburua, idazlea...">
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
    </div>
    <nav>
      <button id="añadirLibro" ><i class="fa-solid fa-file-circle-plus"></i></button>
    </nav >
  </header>
    <main>

    <div class="cover">
      
      <?php 
      // Recojo todos los valores de los libros en una variable
  $query = $miPDO->prepare('SELECT libro.* FROM libro, solicitud_libro WHERE libro.id_libro = solicitud_libro.id_libro AND solicitud_libro.estado = "aceptado"');
  $query->execute();
  $results = $query->fetchAll();
      foreach ($results as $posotion => $valorLibro){
        
        echo '<div class="contenedor__libro">'
                  ,'<figure>'
                    ,'<img src="../src/img/imagen1.jpg"  alt="">'
                  ,'</figure>'
                ,'<div class="informacion__libro">'
                  ,'<h1 id="title">'.$valorLibro['titulo'].'</h1>'
                  ,'<p id="autor">'.$valorLibro['escritor'].'</p>'
                  ,'<p id="valoration">Balorazioa: '.$valorLibro['nota_media'].'</p>'
                  ,'<input type="button" class="btn_ver-mas" value="Ver mas">'
                ,'</div>'
              ,'</div>';
      }?>
    </div>

    

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