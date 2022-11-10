<?php 
  include('../templates/head.php');
  include_once('../modules/connection.php');

  $nickname_error = false;
  $email_error = false;
  $school_error = false;
  $phone_error = false;

  $type_error = false;
  $size_error = false;
  $format_error = false;

  $signup = true;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['profile'];

    $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $image = getimagesize($file['tmp_name']);

    // No es una imagen
    if (!$image) {
      $type_error = true;
      $signup = false;
    }
    
    // Tamaño no valido
    if ($file['size'] > 5000000) {
      $size_error = true;
      $signup = false;
    }
    
    // Formato no valido
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
      $format_error = true;
      $signup = false;
    }

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
    if ($results['nickname'] === $nickname) {
      $signup = false;
      $nickname_error = true;
    }
  
    // Si el email existe
    if ($results['email'] === $email) {
      $signup = false;
      $email_error = true;
    }

    if ($_GET['role'] === 'Irakasle') {
      $phone = $_POST["phone"];
      $school = $_POST["school"];

      $query = $miPDO->prepare('SELECT nickname, email, telefono FROM usuario WHERE telefono=:phone');
      $query->execute(['phone' => $phone]);
      $results = $query->fetch();

      // Si el telefono existe
      if ($results['telefono'] === $phone) {
        $signup = false;
        $phone_error = true;
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
      $query = $miPDO->prepare('INSERT INTO usuario (nickname, email, nombre, apellidos, fecha_nacimiento, contrasena, rol, imagen) VALUES (:nickname, :email, :name, :surnames, :date, :password, :role, :imagen)');
      $query->execute(['nickname' => $nickname, 'email' => $email, 'name' => $name, 'surnames' => $surnames, 'date' => $date, 'password' => $password, 'role' => $_GET['role'], 'imagen' => $nickname.'.'.$imageFileType]);

      if ($role === 'Irakasle') {
        $query = $miPDO->prepare('UPDATE usuario SET telefono = :phone ,id_centro = :school WHERE nickname = :nickname;');
        $query->execute(['phone' => $phone, 'school' => $school, 'nickname' => $nickname]);
      }

      $rute = '../src/img/profile/'.$nickname.'.jpg';
      move_uploaded_file($file['tmp_name'], $rute);

      header('Location: ../views/login.php');
    }
  }
?>

<script src="../src/js/signup.js" defer></script>
  <title>Erregistratu | IGKlub</title>
  <link rel="stylesheet" href="../styles/signup.css">
</head>
<body>
  <form id="singupForm" action="" method="POST">
    <?php echo '<h1>Erregistratu - '.$_GET['role'].'a</h1>'; ?>
    <!-- Nickname -->
    <div class="input-container">
      <i class="fa-solid fa-user"></i>
      <input type="text" name="nickname" id="nickname" placeholder="Nickname" maxlength="20" autofocus value="<?php if (isset($_POST['nickname'])) echo $_POST['nickname'] ?>">
    </div>
    <!-- Error: Nickname -->
    <div class="error hidden" id="nickname-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Ezizenak 4 eta 20 karaktere izan behar ditu, letraz, zenbakiz, marratxoz (-) eta azpimarraz (_) osatuta.</p>
    </div>
    <?php
    if ($nickname_error) {
      echo '<div class="error php-error">
              <i class="fa-solid fa-circle-exclamation"></i>
              <p>Nickname hau dagoeneko erabiltzen ari da. Saiatu beste bat.</p>
            </div>';
    }
    ?>
    <!-- Imagen de perfil -->
    <div class="input-container">
        <i class="fa-solid fa-camera-retro"></i>
        <input type="text" name="profile" id="profile" placeholder="Profileko argazkia" accept=".jpg,.jpeg,.png" onfocus="(this.type='file')">
    </div>
    <!-- Error: Imagen de perfil -->
    <?php
    if ($type_error) {
    echo '<div class="error php-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            <p>Artxiboak argazki bat izan behar da.</p>
        </div>';
    }
    if ($size_error) {
        echo '<div class="error php-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>Argazkia 5MB baino txikiagoa izan behar da.</p>
            </div>';
    }
    if ($format_error) {
        echo '<div class="error php-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>Argazkia JPG, JPEG edo PNG formatua izan behar da.</p>
            </div>';
    }
    ?>
    <!-- Email -->
    <div class="input-container">
      <i class="fa-solid fa-at"></i>
      <input type="email" name="email" id="email" placeholder="Email-a" value="<?php if (isset($_POST['email'])) echo $_POST['email'] ?>">
    </div>
    <!-- Error: Email -->
    <div class="error hidden" id="email-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Email-aren formatuak ez du balio.</p>
    </div>
    <?php
    if ($email_error) {
      echo '<div class="error php-error">
              <i class="fa-solid fa-circle-exclamation"></i>
              <p>Email hau dagoeneko erabiltzen ari da. Saiatu beste bat.</p>
            </div>';
    }
    ?>
    <!-- Nombre completo -->
    <div class="input-container">
      <i class="fa-solid fa-address-card"></i>
      <div>
        <input type="text" name="name" id="name" placeholder="Izena" value="<?php if (isset($_POST['name'])) echo $_POST['name'] ?>">
        <input type="text" name="surnames" id="surnames" placeholder="Abizenak" value="<?php if (isset($_POST['surnames'])) echo $_POST['surnames'] ?>">
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
      <input type="text" id="date" name="date" placeholder="Jaiotze-data" onfocus="(this.type='date')" value="<?php if (isset($_POST['date'])) echo $_POST['date'] ?>">
    </div>
    <!-- Error: Fecha de nacimiento -->
    <div class="error hidden" id="date-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Data hau ez da baliozkoa.</p>
    </div>
    <?php
    if ($_GET['role'] === 'Irakasle') {
      // Telefono
      echo '<div class="input-container">
              <i class="fa-solid fa-phone"></i>
              <input type="tel" id="phone" name="phone" placeholder="Telefono zenbakia" maxlength="9" value="';
              if (isset($_POST[''])) echo $_POST[''];
      echo    '"></div>';
      // Error: Telefono
      echo '<div class="error hidden" id="phone-error">
              <i class="fa-solid fa-circle-exclamation"></i>
              <p>Telefonoak 6, 7 edo 9rekin hasi behar du. Zenbakiak eta gehienez 9 digitu izan ditzake.</p>
            </div>';
      if ($phone_error) {
        echo '<div class="error php-error">
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
        echo '<div class="error php-error">
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
    <!-- Error: Formulario -->
    <div class="error hidden" id="form-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>Bete formularioa behar bezala.</p>
    </div>
    <!-- Rol -->
    <input type="hidden" id="role" name="role" value="<?php echo $_GET['role']?>">
    <button>Erregistratu</button>
    <p>Baduzu kontu bat? <a href="login.php">Saioa hasi</a></p>
  </form>
</body>
</html>