<?php 
  include_once('../templates/head.php');
?>

  <title>Saioa hasi | IGKlub</title>
  <link rel="stylesheet" href="../styles/login.css">
</head>
<body>
  <form action="../modules/login_validation.php" method="get">
    <h1>Saioa hasi</h1>
    <div class="input-container">
      <i class="fa-solid fa-user"></i>
      <input type="text" name="nickname" id="" placeholder="Nickname" autofocus>
    </div>
    <div class="input-container">
      <i class="fa-solid fa-key"></i>
      <input type="password" name="password" id="" placeholder="Pasahitza">
    </div>
    <input type="submit" name="enviar" value="Saioa hasi"></input>
  </form>
</body>
</html>