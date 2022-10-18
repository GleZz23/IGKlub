<?php 
  include_once('templates/head.php');
?>

  <title>IGKlub</title>
  <link rel="stylesheet" href="styles/index.css">
</head>
<body>
  <section>
    <h1>IGKlub</h1> <!-- Cambiar por logo -->
    <form action="views/signup.php" method="get">
      <select name="role">
        <option value="Irakasle">Irakasle</option>
        <option value="Ikasle">Ikasle</option>
      </select>
      <p>bezala</p>
      <button>erregistratu</button>
    </form>
    <div class="horizontal-bar"></div>
    <a href="views/login.php">Saioa hasi</a>
  </section>
</body>
</html>