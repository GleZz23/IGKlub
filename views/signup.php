<?php 
  include_once('../templates/head.php');
?>

  <title>Erregistratu | IGKlub</title>
  <link rel="stylesheet" href="../styles/signup.css">
</head>
<body>
  
  <form id="formularioRegistrar" action="../modules/signup_validation.php" method="get" >
    <?php include_once('../templates/signup_student.php'); ?>
  </form>
  <script src="../js/signup_validation.js"></script>
</body>
</html>