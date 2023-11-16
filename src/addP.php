<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./reset.css">
  <link rel="stylesheet" href="./style.css">
  <title>Añadir Producto</title>
</head>
<body>
<div class="contenedor">
  <?php
  require_once("database.php");
  $name = $description = $brand = $price = $cost = $weight = $dimensions = $last_updated = $nameErr = $descriptionErr = $brandErr = $priceErr = $costErr = $weightErr = $dimensionsErr = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $error = false;
      if (empty($_POST["name"])) {
          $nameErr = "Nombre es obligatorio";
          $error = true;
      } elseif (ctype_upper($_POST["name"][0])) {
          $name = test_input($_POST["name"]);
      } else {
          $nameErr = "El nombre debe empezar con mayuscula";
          $error = true;
      }
      if (empty($_POST["description"])) {
          $description = "";
      } else {
          $description = test_input($_POST["description"]);
      }
      if (empty($_POST["brand"])) {
          $brand = "";
      } else {
          $brand = test_input($_POST["brand"]);
      }
      if (empty($_POST["price"])) {
          $priceErr = "Precio es obligatorio";
          $error = true;
      } elseif ($_POST["price"] > 0) {
          $price = test_input($_POST["price"]);
      } else {
          $priceErr = "Precio debe ser positivo";
      }
      if (empty($_POST["cost"])) {
          $costErr = "Coste es obligatorio";
          $error = true;
      } elseif ($_POST["cost"] > 0) {
          $cost = test_input($_POST["cost"]);
      } else {
          $costErr = "Coste debe ser positivo";
      }
      if (empty($_POST["weight"])) {
          $weight = "";
      } else {
          $weight = test_input($_POST["weight"]);
      }
      if (empty($_POST["dimensions"])) {
          $dimensions = "";
      } else {
          $dimensions = test_input($_POST["dimensions"]);
      }
      if ($error === false) {
          $sql = src\Database::getInstance()->getConnection()->prepare("INSERT INTO Products (name, description, brand, price, cost, weight, dimensions, last_updated) VALUES (?, ?, ?, ?, ?, ?, ?, NULL)");
          $sql->bind_param("sssdddd", $name, $description, $brand, $price, $cost, $weight, $dimensions);
          $sql->execute();
          $id = src\Database::getInstance()->getConnection()->insert_id;
          $resultado = src\Database::getInstance()->getConnection()->query("SELECT * FROM Store");
          $stock = 0;
          if ($resultado->num_rows > 0) {
              while ($row = $resultado->fetch_assoc()) {
                  $sql = src\Database::getInstance()->getConnection()->prepare("INSERT INTO Stores_Products(id_store, id_product, stock_quantity) VALUES (?, ?, ?)");
                  $sql->bind_param("iii", $row['id'], $id, $stock);
                  $sql->execute();
              }
          }
      }
  }

  function test_input($data)
  {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

    ?>
  <h1 id="titulo">Crear Producto</h1>
  <form method="post" class="addForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      Nombre: <input type="text" name="name" placeholder="Nombre" value="<?php echo $name ?>"><?php echo $nameErr; ?> <br>
      Descripcion: <input type="text" name="description" placeholder="Descripcion" value="<?php echo $description ?>"><?php echo $descriptionErr; ?><br>
      Marca: <input type="text" name="brand" placeholder="Marca" value="<?php echo $brand ?>"><?php echo $brandErr; ?> <br>
      Precio: <input type="number" step=0.1 name="price" placeholder="Precio" value="<?php echo $price ?>"><?php echo $priceErr; ?> <br>
      Coste: <input type="number" step=0.1 name="cost" placeholder="Coste" value="<?php echo $cost ?>"><?php echo $costErr; ?> <br>
      Peso: <input type="number" step=0.1 name="weight" placeholder="Peso" value="<?php echo $weight ?>"><?php echo $weightErr; ?> <br>
      Dimensiones: <input type="number" step=0.1 name="dimensions" placeholder="Dimensiones" value="<?php echo $dimensions ?>"><?php echo $dimensionsErr; ?> <br>
      <button type="submit" class="crear">Crear Producto</button>
  </form>
  <a href="./index.php" class='atras btnAnimado'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 330 330' class='svgIcon'><path xmlns="http://www.w3.org/2000/svg" id="XMLID_92_" d="M111.213,165.004L250.607,25.607c5.858-5.858,5.858-15.355,0-21.213c-5.858-5.858-15.355-5.858-21.213,0.001  l-150,150.004C76.58,157.211,75,161.026,75,165.004c0,3.979,1.581,7.794,4.394,10.607l150,149.996  C232.322,328.536,236.161,330,240,330s7.678-1.464,10.607-4.394c5.858-5.858,5.858-15.355,0-21.213L111.213,165.004z"/></svg>
</a>
</div>
</body>
</html>
