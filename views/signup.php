<?php 
  include_once('../templates/head.php');
  include_once('../modules/connection.php');

  $role = $_GET['role'];

?>

  <title>Erregistratu | IGKlub</title>
  <link rel="stylesheet" href="../styles/signup.css">
</head>
<body>
  <form action="" method="post">
  <h1>Erregistratu</h1>
  <!-- Nickname -->
  <div class="input-container">
    <i class="fa-solid fa-user"></i>
    <input type="text" name="nickname" id="nickname" placeholder="Nickname" autofocus>
  </div>
  <!-- Error: Nickname -->
  <?php
  if ($nickname_error) {
    echo '<div class="error" id="error-email">
            <i class="fa-solid fa-circle-exclamation"></i>
            <p>Nickname hau dagoeneko erabiltzen ari da. Saiatu beste bat.</p>
          </div>';
  }
  ?>
  <!-- Email -->
  <div class="input-container">
    <i class="fa-solid fa-at"></i>
    <input type="email" name="email" id="email" placeholder="Email-a">
  </div>
  <!-- Error: Email -->
  <?php
  if ($email_error) {
    echo '<div class="error" id="error-email">
            <i class="fa-solid fa-circle-exclamation"></i>
            <p>Email hau dagoeneko erabiltzen ari da. Saiatu beste bat.</p>
          </div>';
  }
  ?>
  <!-- Nombre completo -->
  <div class="input-container">
    <i class="fa-solid fa-address-card"></i>
    <div>
      <input type="text" name="name" id="name" placeholder="Izena">
      <input type="text" name="surnames" id="surnames" placeholder="Abizenak">
    </div>
  </div>
  <!-- Fecha de nacimiento -->
  <div class="input-container">
    <i class="fa-solid fa-cake-candles"></i>
    <input type="text" id="date" name="date" placeholder="Jaioteguna" onfocus="(this.type='date')">
  </div>
  
  <?php
  $role = $_GET['role'];
  if ($role === 'Irakasle') {
    // Telefono
    echo '<div class="input-container">
            <i class="fa-solid fa-phone"></i>
            <input type="tel" id="phone" name="phone" placeholder="Telefono zenbakia">
          </div>';
    // Centro
    echo '<div class="input-container">
            <i class="fa-solid fa-school"></i>
            <select name="school" id="school">
              <option value="-" selected>Ikastetxea</option>';

    $query = $miPDO->prepare('SELECT * FROM centro ORDER BY nombre ASC');
    $query->execute();
    $results = $query->fetchAll();
  
    foreach ($results as $posotion => $school) {
      echo '<option value="'.$school['id_centro'].'">'.$school['nombre'].'</option>';
    }

    echo '</select>
          </div>';
    }
  ?>
  
  <!-- Contraseñas -->
  <div class="input-container">
    <i class="fa-solid fa-key"></i>
    <div>
      <input type="password" name="password" id="password" placeholder="Pasahitza">
      <input type="password" name="password2" id="password2" placeholder="Pasahitza egiaztatu">
    </div>
  </div>
  <!-- Contrato -->
    
  <!-- Rol -->
  <input type="hidden" name="role" value="<?php $role ?>">
  <button>Erregistratu</button>
</form>
</body>
</html>