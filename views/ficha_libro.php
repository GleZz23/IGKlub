<?php
  include_once('../templates/head.php');
?>
    <link rel="stylesheet" href="../styles/ficha_libro.css">
    <title>Hasiera | IGKlub</title>
</head>
<body>
  <header>
    <div class="logo">

    </div>
    <div class="search-bar">
      <form action="" method="get">
        <input type="text" placeholder="Izenburua, idazlea...">
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
    </div>
    <nav>

    </nav>
  </header>
   
    <main>

    <section class="contenedor">
        <figure>
        <img src="../src/img/imagen1.jpg"  alt="">
        </figure>
    <article class="art1">
        <h2>CREA TU PORTADA DEL LIBRO</h2><br>
        <h1>Gerard L.Staff</h1><br>
        <h3>Novela</h3><br>
        <h3>Sinopsis</h3><br>
        <p>
            Charlie Bucket es un niño proveniente de una familia pobre que pasa la mayor parte de su tiempo soñando sobre el chocolate que rara vez se puede permitir comer. Las cosas cambian cuando Willy Wonka, el dueño del famoso imperio Wonka Chocolates, anuncia la celebración de un concurso en el que cinco billetes dorados han sido escondidos en cinco tabletas de chocolate. Charlie será uno de los cinco afortunados en encontrar uno de los billetes que dan acceso a un tour por la fábrica de chocolate.
        </p><br>
        <h2>Nota media: 4</h2><br>

    </article>
    <article class="art2">
        <h1>Edad Media letores: 5 urte</h1><br>
        <h2>Numero de lectores: 12</h2><br>
        <h2>Idiomas leidas por los lectores:</h2>
    </article>
    </section>
    <div class="iritzi">
    <h1>Opina el libro:</h1><br>
    <textarea rows="10" cols="20">Idatzi zure iritzia...</textarea>
    <br>
    <input type="button" name="boton" value="Opina">
    </div>
    <br>
    <div id="opi">
    <h1 id="opinion">Opiniones:</h1>

    </div>


    </main>
    <br>
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

    <script src="../js/hamburgesa.js"></script>
</body>
</html>