<?php
  include_once('../templates/head.php');
  include_once('../modules/connection.php');
  session_start();
?>
    <script src="../src/js/main_menu.js" defer></script>
    <link rel="stylesheet" href="../styles/main_menu.css">
    <title>Administrazioa | IGKlub</title>
</head>
<body>
  <nav>

  </nav>
  <main>
  <!-- Aceptar nuevos profesores -->
  <?php
    $query = $miPDO->prepare('SELECT * FROM usuario WHERE rol = "irakasle" AND estado = "aceptado"');
    $query->execute();
    $results = $query->fetchAll();

    if ($results) {
      echo '<table>
              <tr>
                <th>Nickname</th>
                <th>Izena</th>
                <th>Abizenak</th>
                <th>Email-a</th>
                <th>Telefonoa</th>
                <th>Onartu</th>
              </tr>';
      foreach ($results as $position => $teacher){
        echo '<tr>
                <td>'.$teacher['nickname'].'</td>
                <td>'.$teacher['nombre'].'</td>
                <td>'.$teacher['apellidos'].'</td>
                <td>'.$teacher['email'].'</td>
                <td>'.$teacher['telefono'].'</td>
                <td>
                  <button>Bai</button>
                  <button>Ez</button>
                </td>
              </tr>';
      }
      echo '</table>';
    } else {
      echo '<h1>Oraindik ez dago irakaslerik onartzeko</h1>';
    }
    ?>
  </main>
  <button></button>
</body>
</html>