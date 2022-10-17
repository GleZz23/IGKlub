<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
    integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Erregistratu | IGKlub</title>
  <link rel="stylesheet" href="styles/signup.css">
</head>
<body>
  <form action="app/signup_validation.php" method="get">
    <h1>Erregistratu</h1>
    <!-- Nickname -->
    <div class="input-container">
      <i class="fa-solid fa-user"></i>
      <input type="text" name="nickname" id="nickname" placeholder="Nickname" autofocus>
    </div>
    <!-- Email -->
    <div class="input-container">
      <i class="fa-solid fa-at"></i>
      <input type="email" name="email" id="email" placeholder="Email-a">
    </div>
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
    <!-- Contraseñas -->
    <div class="input-container">
      <i class="fa-solid fa-key"></i>
      <div>
        <input type="password" name="password" id="password" placeholder="Pasahitza">
        <input type="password" name="password2" id="password2" placeholder="Pasahitza egiaztatu">
      </div>
    </div>
    <button>Erregistratu</button>
  </form>
</body>
</html>