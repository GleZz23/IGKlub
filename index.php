<?php 
  include('templates/head.php');
?>
  <title>IGKlub</title>
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/general.css">
</head>
<body>
  <div>
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
  </div>
</body>
</html>