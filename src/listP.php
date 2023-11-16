<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./reset.css">
  <link rel="stylesheet" href="./style.css">
  <title>Lista Productos</title>
</head>
<body>
  <div class="contenedor">
  <div class="contenedor">
  <a href="./addP.php"><button class="addProduct btnAnimado">
  <svg viewBox="0 0 48 48" class="svgIcon"><path xmlns="http://www.w3.org/2000/svg" d="M41.267,18.557H26.832V4.134C26.832,1.851,24.99,0,22.707,0c-2.283,0-4.124,1.851-4.124,4.135v14.432H4.141   c-2.283,0-4.139,1.851-4.138,4.135c-0.001,1.141,0.46,2.187,1.207,2.934c0.748,0.749,1.78,1.222,2.92,1.222h14.453V41.27   c0,1.142,0.453,2.176,1.201,2.922c0.748,0.748,1.777,1.211,2.919,1.211c2.282,0,4.129-1.851,4.129-4.133V26.857h14.435   c2.283,0,4.134-1.867,4.133-4.15C45.399,20.425,43.548,18.557,41.267,18.557z"/></svg>
  </button></a>
  <?php
  require_once("database.php");
  $resultado = src\Database::getInstance()->getConnection()->query("SELECT * FROM Products");
  if ($resultado->num_rows > 0) {
      echo "<table><tr><th>ID</th><th>Nombre</th><th>Actualizar</th><th>Eliminar</th><th>Ver Stock</th></tr>";
      while ($row = $resultado->fetch_assoc()) {
          echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td><a href='./updateP.php?id=$row[id]'>
          <button type='submit' name='action' value='editar' class='editar btnAnimado'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 16 16' class='svgIcon'> <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z' fill='white'></path> </svg>
            </button>
          </a></td><td><a href='./deleteP.php?id=$row[id]'>
          <button type='submit' name='action' value='eliminar' class='eliminar btnAnimado'>  <svg viewBox='0 0 15 17.5' fill='currentColor' xmlns='http://www.w3.org/2000/svg' class='svgIcon'>
            <path transform='translate(-2.5 -1.25)' d='M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z' id='Fill'></path>
          </svg></button>
          </a></td>
          <td><a href='./stock.php?id=$row[id]'>
          <button type='submit' name='action' value='stock' class='stock btnAnimado'>  <svg viewBox='0 0 15 17.5' fill='currentColor' xmlns='http://www.w3.org/2000/svg' class='svgIcon'>
          <path xmlns='http://www.w3.org/2000/svg' d='M14.12 4 8.62.85a1.28 1.28 0 0 0-1.24 0L1.88 4a1.25 1.25 0 0 0-.63 1.09V11a1.25 1.25 0 0 0 .63 1l5.5 3.11a1.28 1.28 0 0 0 1.24 0l5.5-3.11a1.25 1.25 0 0 0 .63-1V5.05A1.25 1.25 0 0 0 14.12 4zm-6.74 9.71-2.13-1.2v-5.3l2.13 1.16zM8 7.29 5.92 6.15l4.81-2.67 2.09 1.18zm0-5.35 1.46.82-4.84 2.69-1.44-.79zM2.5 5.71l1.5.82v5.27L2.5 11zm6.12 8V8.37l4.88-2.66V11z'/>
          </svg></button>
          </a></td>
          </tr>";
      }
      echo "</table>";
  }
    ?>
<a href="./index.php" class='atras btnAnimado'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 330 330' class='svgIcon'><path xmlns="http://www.w3.org/2000/svg" id="XMLID_92_" d="M111.213,165.004L250.607,25.607c5.858-5.858,5.858-15.355,0-21.213c-5.858-5.858-15.355-5.858-21.213,0.001  l-150,150.004C76.58,157.211,75,161.026,75,165.004c0,3.979,1.581,7.794,4.394,10.607l150,149.996  C232.322,328.536,236.161,330,240,330s7.678-1.464,10.607-4.394c5.858-5.858,5.858-15.355,0-21.213L111.213,165.004z"/></svg>
</a>
    </div>
</body>
</html>
