<?php 
  include_once('../templates/head.php');
  include_once('../modules/connection.php');

  $nickname_error = false;
  $email_error = false;
  $school_error = false;
  $phone_error = false;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $signup = true;

    $nickname = $_POST["nickname"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $surnames = $_POST["surnames"];
    $date = $_POST["date"];
    $password = $_POST["password"];
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = $miPDO->prepare('SELECT nickname, email, telefono FROM usuario WHERE nickname=:nickname OR email=:email');
    $query->execute(['nickname' => $nickname, 'email' => $email]);
    $results = $query->fetch();

    // Si el nickname existe
    if ($nickname !== '') {
      if ($results['nickname'] === $nickname) {
        $signup = false;
        $nickname_error = true;
      }
    }
  
    // Si el email existe
    if ($email !== '') {
      if ($results['email'] === $email) {
        $signup = false;
        $email_error = true;
      }
    }

    if ($_GET['role'] === 'Irakasle') {
      $phone = $_POST["phone"];
      $school = $_POST["school"];

      $query = $miPDO->prepare('SELECT telefono FROM usuario WHERE telefono=:phone');
      $query->execute(['phone' => $phone]);
      $results = $query->fetch();

      // Si el telefono existe
      if ($phone !== '') {
        if ($results['telefono'] === $phone) {
          $signup = false;
          $phone_error = true;
        }
      }
    
      // Si el centro es por defecto
      if ($school === '-') {
        $signup = false;
        $school_error = true;
      }
    }

    // Si el registro es valido
    if ($signup) {
      // Inserto el usuario en la base de datos
      $query = $miPDO->prepare('INSERT INTO usuario (nickname, email, nombre, apellidos, fecha_nacimiento, contrasena, rol) VALUES (:nickname, :email, :name, :surnames, :date, :password, :role)');
      $query->execute(['nickname' => $nickname, 'email' => $email, 'name' => $name, 'surnames' => $surnames, 'date' => $date, 'password' => $password, 'role' => $_GET['role']]);

      if ($_GET['role'] === 'Irakasle') {
        $query = $miPDO->prepare('UPDATE usuario SET telefono = :phone ,id_centro = :school WHERE nickname = :nickname;');
        $query->execute(['phone' => $phone, 'school' => $school, 'nickname' => $nickname]);
      }
      header('Location: ../views/login.php');
    }
  }
?>

<script src="../js/signup_validation.js" defer></script>
  <title>Erregistratu | IGKlub</title>
  <link rel="stylesheet" href="../styles/signup.css">
</head>
<body>
  <form id="singupForm" action="" method="post">
    <?php echo '<h1>Erregistratu - '.$_GET['role'].'a</h1>'; ?>
    <!-- Nickname -->
    <div class="input-container">
      <i class="fa-solid fa-user"></i>
      <input type="text" name="nickname" id="nickname" placeholder="Nickname" maxlength="20" autofocus>
    </div>
    <!-- Error: Nickname -->
    <div class="error hidden" id="nickname-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Ezizenak 4 eta 20 karaktere izan behar ditu, letraz, zenbakiz, marratxoz (-) eta azpimarraz (_) osatuta.</p>
    </div>

    <?php
    if ($nickname_error) {
      echo '<div class="error">
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
    <div class="error hidden" id="email-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Email-aren formatuak ez du balio.</p>
    </div>
    <?php
    if ($email_error) {
      echo '<div class="error">
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
    <!-- Error: Nombre completo -->
    <div class="error hidden" id="name-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Izenak letra larriz hasi behar du eta letrak soilik izan ditzake.</p>
    </div>
    <div class="error hidden" id="surnames-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Abizenek letrak soilik izan ditzakete.</p>
    </div>
    <!-- Fecha de nacimiento -->
    <div class="input-container">
      <i class="fa-solid fa-cake-candles"></i>
      <input type="text" id="date" name="date" placeholder="Jaioteguna" onfocus="(this.type='date')">
    </div>
    
    <?php
    if ($_GET['role'] === 'Irakasle') {
      // Telefono
      echo '<div class="input-container">
              <i class="fa-solid fa-phone"></i>
              <input type="tel" id="phone" name="phone" placeholder="Telefono zenbakia" maxlength="9">
            </div>';
      // Error: Telefono
      echo '<div class="error hidden" id="phone-error">
              <i class="fa-solid fa-circle-exclamation"></i>
              <p>Telefonoak 6, 7 edo 9rekin hasi behar du. Zenbakiak eta gehienez 9 digitu izan ditzake.</p>
            </div>';
      if ($phone_error) {
        echo '<div class="error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>Telefono-zenbaki hau beste kontu batekin erregistratuta dago jada.</p>
              </div>';
      }
      // Centro
      echo '<div class="input-container">
              <i class="fa-solid fa-school"></i>
              <select name="school" id="school">
                <option value="-" selected>Ikastetxea</option>';

      $query = $miPDO->prepare('SELECT * FROM centro ORDER BY nombre ASC');
      $query->execute();
      $results = $query->fetchAll();
    
      foreach ($results as $position => $school) {
        echo '<option value="'.$school['id_centro'].'">'.$school['nombre'].'</option>';
      }

      echo '</select>
            </div>';
      }
      // Error: Centro
      if ($school_error) {
        echo '<div class="error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>Aukeratu eskola bat.</p>
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
    <!-- Error: Contraseñas -->
    <div class="error hidden" id="password-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Pasahitzak 4 karaktere izan behar ditu gutxienez eta letra larria, minuskula eta zenbaki bat izan behar ditu.</p>
    </div>
    <div class="error hidden" id="password2-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Bi pasahitzek berdinak izan behar dira.</p>
    </div>
    <!-- Contrato -->
    <div class="input-checkbox">
      <input type="checkbox" id="termns" name="termns">
      <label for="checkbox">Irakurri eta onartzen ditut <a href="#">zehaztapenak eta baldintzak</a></label>
    </div>
    <!-- Error: Contraseñas -->
    <div class="error hidden" id="form-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Bete formularioa behar bezala.</p>
    </div>
    <!-- Rol -->
    <input type="hidden" name="role" value="<?php $_GET['role'] ?>">
    <button>Erregistratu</button>
  </form>
</body>
</html>