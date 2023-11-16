<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./style.css">
    <title>Actualizar productos</title>
</head>
<body>
<div class="contenedor">
    <h1>Actualizar producto</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?<?php echo $_SERVER["QUERY_STRING"]; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php
    require_once("database.php");

    $name = $description = $brand = $price = $cost = $weight = $dimensions = $last_updated = $nameErr = $descriptionErr = $brandErr = $priceErr = $costErr = $weightErr = $dimensionsErr = "";
    $id = $_GET['id'];
    $resultado = src\Database::getInstance()->getConnection()->query("SELECT * FROM Products WHERE ID = $id");

    if ($resultado->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Nombre</th><th>Descripcion</th><th>Marca</th><th>Precio</th><th>Coste</th><th>Peso</th><th>Dimensiones</th><th>Ultima modificacion</th><th>Actualizar</th></tr>";
        while ($row = $resultado->fetch_assoc()) {
            echo "<tr><td>$row[id]</td><td><input type='text' value='$row[name]' name='name'></input></td><td><input type='text' value='$row[description]' name='description'></input></td><td><input type='text' value='$row[brand]' name='brand'></input></td><td><input type='number' value='$row[price]' name='price'></input></td><td><input type='text' value='$row[cost]' name='cost'></input></td><td><input type='text' value='$row[weight]' name='weight'></input></td><td><input type='number' value='$row[dimensions]' name='dimensions'></input></td>
            <td>$row[last_updated]</td><td><input type='submit' value='Editar'></td></tr> ";
        }
        echo "</table></form>";
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Nombre es obligatorio";
            $error = true;
        } else {
            $name = test_input($_POST["name"]);
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
        } else {
            $price = test_input($_POST["price"]);
        }
        if (empty($_POST["cost"])) {
            $costErr = "Coste es obligatorio";
            $error = true;
        } else {
            $cost = test_input($_POST["cost"]);
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
        if ($error == false) {
            $sql = src\Database::getInstance()->getConnection()->prepare("UPDATE Products SET name = ?, description = ?, brand = ?, price = ?, cost = ?, weight = ?, dimensions = ?, last_updated = NOW() WHERE id = ?");
            $sql->bind_param("sssddddi", $name, $description, $brand, $price, $cost, $weight, $dimensions, $id);
            $sql->execute();
            ?>
            <script>
                window.location.replace("/listP.php");
            </script>
            <?php
        } else {
            echo $nameErr . $descriptionErr . $brandErr . $priceErr . $costErr . $weightErr . $dimensionsErr;
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
    <a href="./index.php" class='atras btnAnimado'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 330 330' class='svgIcon'><path xmlns="http://www.w3.org/2000/svg" id="XMLID_92_" d="M111.213,165.004L250.607,25.607c5.858-5.858,5.858-15.355,0-21.213c-5.858-5.858-15.355-5.858-21.213,0.001  l-150,150.004C76.58,157.211,75,161.026,75,165.004c0,3.979,1.581,7.794,4.394,10.607l150,149.996  C232.322,328.536,236.161,330,240,330s7.678-1.464,10.607-4.394c5.858-5.858,5.858-15.355,0-21.213L111.213,165.004z"/></svg>
</a>
</div>
</body>
</html>
