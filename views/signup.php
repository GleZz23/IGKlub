<?php 
  include_once('../templates/head.php');
?>

  <title>Erregistratu | IGKlub</title>
  <link rel="stylesheet" href="../styles/signup.css">
</head>
<body>
  <form action="../modules/signup_validation.php" method="get">
    <?php
    $role = $_GET['role'];
    echo '<h1>Erregistratu - '.$role.'a</h1>';
    if ($role === 'Ikasle') {
      include_once('../templates/signup_student.php');
    } else if ($role === 'Irakasle') {
      include_once('../templates/signup_teacher.php');
    }
    ?>
  </form>
</body>
</html>