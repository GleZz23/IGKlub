<?php 
  include_once('../templates/head.php');
?>

  <title>Erregistratu | IGKlub</title>
  <link rel="stylesheet" href="../styles/signup.css">
</head>
<body>
  <form action="../modules/signup_validation.php" method="get">
    <?php
    $form = $_POST["form"];
    echo '<h1>Erregistratu - '.$form.'a</h1>';
    if ($form === 'Ikasle') {
      include_once('../templates/signup_student.php');
    } else if ($form === 'Irakasle') {
      include_once('../templates/signup_teacher.php');
    }
    ?>
  </form>
</body>
</html>