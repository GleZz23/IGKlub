<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
    integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Saioa hasi | IGKlub</title>
  <link rel="stylesheet" href="styles/login.css">
</head>
<body>
  
  <form action="app/login_validation.php" method="get">
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