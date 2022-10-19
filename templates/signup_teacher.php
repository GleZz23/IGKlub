<?php
  include_once('../modules/connection.php');
  $nickname_error = false;
  $email_error = false;
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $_POST["nickname"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $surnames = $_POST["surnames"];
    $date = $_POST["date"];
    $phone = $_POST["phone"];
    $school = $_POST["school"];
    $password = $_POST["password"];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $role = $_POST["role"];

    // Comprobar que el nickname o el email no existe en la base de datos
    $registro = true;

    $query = $miPDO->prepare('SELECT nickname, email FROM usuario WHERE nickname=:nickname OR email=:email');
    $query->execute(['nickname' => $nickname, 'email' => $email]);
    $results = $query->fetch();
  
    // Si el nickname existe
    if (!empty($results['nickname'])) {
      $registro = false;
      $nickname_error = true;
    }
  
    // Si el email existe
    if (!empty($results['email'])) {
      $registro = false;
      $email_error = true;
    }

    // Si el registro es valido
    if ($registro) {
      // Inserto el usuario en la base de datos
      $query = $miPDO->prepare('INSERT INTO usuario (nickname, email, telefono, nombre, apellidos, fecha_nacimiento, contrasena, rol, id_centro) VALUES (:nickname, :email, :phone, :name, :surnames, :date, :password, :role, :school)');
      $query->execute(['nickname' => $nickname, 'email' => $email, 'phone' => $phone, 'name' => $name, 'surnames' => $surnames, 'date' => $date, 'password' => $password, 'role' => $role, 'school' => $school]);
      header('Location: ../views/login.php');
    }
  }
?>

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
  <!-- Telefono -->
  <div class="input-container">
    <i class="fa-solid fa-phone"></i>
    <input type="tel" id="phone" name="phone" placeholder="Telefono zenbakia">
  </div>
  <!-- Centro -->
  <div class="input-container">
  <i class="fa-solid fa-school"></i>
    <select name="school" id="school">
      <option value="-" selected>Ikastetxea</option>
    <?php
      include_once('../modules/connection.php');

      $query = $miPDO->prepare('SELECT * FROM centro ORDER BY nombre ASC');
      $query->execute();
      $results = $query->fetchAll();

      foreach ($results as $posotion => $school) {
        echo '<option value="'.$school['id_centro'].'">'.$school['nombre'].'</option>';
      }
    ?>
  </select>
  </div>
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
  <input type="hidden" name="role" value="Irakasle">
  <button>Erregistratu</button>
</form>