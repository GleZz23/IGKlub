<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/menu-principal.css">
    <title>IGKlub-MenuPrincipal </title>
</head>
<body>
    <header> 
    <div class ="container__header">   
        <div class="logo">
            <img src="../src/img/logo.png" alt=""> 
        </div> 
       
        <div class="barra__busqueda">
            <form class="" action="" method="GET">
            <input class="buscador" type="text" name="buscador"> 
            <input class="botonBuscar" type="submit" name="enviar" value="buscar">
            </form>
        </div>  
        <div class="agregar__libro">
            <input class="botonAñadir" type="button" class="btn__añadir-libro" value="Subir nuevo libro"> 
        </div>
    
    
        <div class = "bars__menu">
            <span class="line1__bars-menu"></span>
            <span class="line2__bars-menu"></span>
            <span class="line3__bars-menu"></span>
        </div>
        
    </div> 

    </header>
    <div class="barra__filtros"> 
        <nav>
        <ul>
            <li><a href="">Tipo</a></li>
            <ul>
                <li><a href="">Submenu1</a></li>
                <li><a href="">Submenu2</a></li>
                <li><a href="">Submenu3</a></li>
                <li><a href="">Submenu4</a></li>
            </ul>
            <li><a href="">Hizkuntza</a></li>
            <ul>  
                <li><a href="">Submenu1</a></li>
                <li><a href="">Submenu2</a></li>
                <li><a href="">Submenu3</a></li>
                <li><a href="">Submenu4</a></li>
            </ul>
            <li><a href="">Egikea</a></li>
              <ul>
                <li><a href="">Submenu1</a></li>
                <li><a href="">Submenu2</a></li>
                <li><a href="">Submenu3</a></li>
                <li><a href="">Submenu4</a></li>
              </ul>
            <li><a href="">Gaia</a></li>
            <ul>
                <li><a href="">Submenu1</a></li>
                <li><a href="">Submenu2</a></li>
                <li><a href="">Submenu3</a></li>
                <li><a href="">Submenu4</a></li>
            </ul>

        </ul>
    </nav></div>
   
    <main>

    <div class="cover">
        <div class="contenedor__libros1">
      
       
        <img src="../src/img/imagen1.jpg"  alt="">
        <aside>Lo que queremos hacer es colocar este texto al lado derecho de la imagen, algo así como se observa en periódicos o revistas.</aside>
        <input type="button" class="btn_ver-mas" value="Ver mas">
        </div>
        <div class="contenedor__libros2">
        
        <img src="../src/img/imagen2.jpg"  alt="">
        <aside>Lo que queremos hacer es colocar este texto al lado derecho de la imagen, algo así como se observa en periódicos o revistas.</aside>
        <input type="button" class="btn_ver-mas" value="Ver mas">
        </div>
        <div class="contenedor__libros3">
        
        <img src="../src/img/imagen3.jpg"  alt="">
        <aside>Lo que queremos hacer es colocar este texto al lado derecho de la imagen, algo así como se observa en periódicos o revistas.</aside>
        <input type="button" class="btn_ver-mas" value="Ver mas">
        </div>
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

    <script src="../js/hamburgesa.js"></script>
</body>
</html>