<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./reset.css">
  <link rel="stylesheet" href="./style.css">
  <title>Menu</title>
</head>
<body>
  <?php require_once("database.php");
    ?>
  <div class="contenedor">
    <h1 id="titulo">Store Manager</h1>
    <a href="./addP.php" class="menu">Añadir productos</a>
    <a href="./listP.php" class="menu">Lista productos</a>
    <a href="./addS.php" class="menu">Añadir tiendas</a>
    <a href="./listS.php" class="menu">Lista tiendas</a>
      </a>
  </div>
</body>
</html>
