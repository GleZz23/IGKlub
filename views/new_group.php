<?php
include_once('../templates/head.php');
include_once('../modules/connection.php');
session_start();
?>
  <link rel="stylesheet" href="../styles/new_class.css">
  <title>Gela sortu | IGKlub</title>
  </head>
<body>
<form action="" method="post">
    <h1>Talde bat sortu</h1>
    <!-- Nombre del grupo -->
    <div class="input-container">
      <i class="fa-solid fa-heading"></i>
      <input type="text" name="title" id="title" placeholder="Taldearen izena" autofocus value="<?php if (isset($_REQUEST['nickname'])) echo $_REQUEST['nickname'] ?>">
    </div>
    <!-- Error: Nombre del grupo -->
    <div class="error hidden" id="title-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>.</p>
    </div>
    <!-- Centro -->
    <div class="input-container">
        <i class="fa-solid fa-language"></i>
        <select name="school" id="school">
            <option value="-" selected>Ikastetxea</option>
        <?php
            $query = $miPDO->prepare('SELECT * FROM centro ORDER BY nombre ASC');
            $query->execute();
            $results = $query->fetchAll();

            foreach ($results as $position => $school) {
                echo '<option value="'.$school['id_centro'].'">'.$school['nombre'].'</option>';
            }
        ?>
        </select>
    </div>
    <!-- Nivel -->
    <div class="input-container">
      <i class="fa-solid fa-heading"></i>
      <input type="text" name="level" id="level" placeholder="" value="<?php if (isset($_REQUEST['nickname'])) echo $_REQUEST['nickname'] ?>">
    </div>
    <!-- Error: Nivel -->
    <div class="error hidden" id="title-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>.</p>
    </div>
    <!-- Curso -->
    <div class="input-container">
      <i class="fa-solid fa-heading"></i>
      <input type="text" name="title" id="title" placeholder="Taldearen izena" value="<?php if (isset($_REQUEST['nickname'])) echo $_REQUEST['nickname'] ?>">
    </div>
    <!-- Error: Curso -->
    <div class="error hidden" id="title-error">
      <i class="fa-solid fa-circle-exclamation"></i>
      <p>.</p>
    </div>
    <button>Igo liburua</button>
  </form>
</body>