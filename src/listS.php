<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./reset.css">
  <link rel="stylesheet" href="./style.css">
  <title>Lista de Stores</title>
</head>
<body>
<div class="contenedor">
  <a href="./addS.php"><button class="crear">Crear tienda</button></a>
  <?php
  require_once("database.php");

  $resultado = src\Database::getInstance()->getConnection()->query("SELECT * FROM Store");

  if ($resultado->num_rows > 0) {
      echo "<table><tr><th>ID</th><th>City</th><th>Email</th><th>Phone</th><th>Editar</th><th>Eliminar</th></tr>";
      while ($row = $resultado->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["id"] . "</td>";
          echo "<td>" . $row["city"] . "</td>";
          echo "<td>" . $row["email"] . "</td>";
          echo "<td>" . $row["phone"] . "</td>";
          echo "<td>";

          // Enlace para actualizar tienda
          echo "<a href='./updateS.php?id={$row['id']}'><button type='submit' name='action' value='editar' class='editar btnAnimado'>
          <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 16 16' class='svgIcon'> <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z' fill='white'></path> </svg>
          </button></a></td> ";

          // Enlace para confirmar eliminación
          echo "<td><a href='./deleteS.php?id={$row['id']}'> <button type='submit' name='action' value='eliminar' class='eliminar btnAnimado'>  <svg viewBox='0 0 15 17.5' fill='currentColor' xmlns='http://www.w3.org/2000/svg' class='svgIcon'>
          <path transform='translate(-2.5 -1.25)' d='M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z' id='Fill'></path>
        </svg></button></a>";

          echo "</td></tr>";
      }
      echo "</table>";
  } else {
      echo "No hay tiendas disponibles.";
  }

    ?>

  <a href="./index.php" class='atras btnAnimado'>
    <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 330 330' class='svgIcon'><path xmlns="http://www.w3.org/2000/svg" id="XMLID_92_" d="M111.213,165.004L250.607,25.607c5.858-5.858,5.858-15.355,0-21.213c-5.858-5.858-15.355-5.858-21.213,0.001  l-150,150.004C76.58,157.211,75,161.026,75,165.004c0,3.979,1.581,7.794,4.394,10.607l150,149.996  C232.322,328.536,236.161,330,240,330s7.678-1.464,10.607-4.394c5.858-5.858,5.858-15.355,0-21.213L111.213,165.004z"/></svg>
  </a>
</div>
</body>
</html>
