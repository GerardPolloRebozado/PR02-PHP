<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./style.css">
    <title>Crear Store</title>
</head>

<body>
<div class="contenedor">
    <?php
    require_once("database.php");
    // No necesitas importar "functions.php" ya que la función test_input está definida a continuación

    // Crear una instancia de la clase Database
    $db = src\Database::getInstance();

    // Obtener las ciudades desde la base de datos
    $cities = $db->getConnection()->query("SELECT id, name FROM Cities");

    $id = $selectedCity = $address = $phone = $email = $opening_time = $closing_time = $last_updated = "";
    $idErr = $cityErr = $addressErr = $phoneErr = $emailErr = $opening_timeErr = $closing_timeErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $error = false;

        // Validación e inicialización de datos
        if (empty($_POST["city"])) {
            $cityErr = "City es obligatorio";
            $error = true;
        } else {
            $selectedCity = test_input($_POST["city"]);
        }

        $address = test_input($_POST["address"]);
        $phone = test_input($_POST["phone"]);
        $email = test_input($_POST["email"]);
        $opening_time = test_input($_POST["opening_time"]);
        $closing_time = test_input($_POST["closing_time"]);

        if (!$error) {
            // Solo ejecuta la inserción si no hay errores de validación
            $sql = $db->getInstance()->getConnection()->prepare("INSERT INTO Store (city, address, phone, email, opening_time, closing_time, last_updated) VALUES (?, ?, ?, ?, ?, ?, NULL)");
            $sql->bind_param("isssss", $selectedCity, $address, $phone, $email, $opening_time, $closing_time);
            $sql->execute();
            $id = src\Database::getInstance()->getConnection()->insert_id;
            $resultado = src\Database::getInstance()->getConnection()->query("SELECT * FROM Products");
            $stock = 0;
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                      $sql = src\Database::getInstance()->getConnection()->prepare("INSERT INTO Stores_Products(id_store, id_product, stock_quantity) VALUES (?, ?, ?)");
                      $sql->bind_param("iii", $id, $row['id'], $stock);
                      $sql->execute();
                }
            }
        }
    }
    ?>
    <h1>Crear Store</h1>
    <form method="post" class="addForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- ID debe ser autoincremental y no debe ser ingresado manualmente -->
        <!-- No es necesario incluir last_updated ya que se establecerá automáticamente en la base de datos -->
        City:
        <select name="city">
            <?php
            // Iterar sobre las ciudades y generar las opciones
            foreach ($cities as $cityOption) {
                echo "<option value='{$cityOption['id']}' name='city'>{$cityOption['name']}</option>";
            }

            function test_input($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            ?>
        </select><br>

        <!-- Otros campos del formulario aquí -->
        <label for="address">Direccion:</label>
        <input type="text" placeholder="Direccion" name="address"><br>

        <label for="phone">Telefono:</label>
        <input type="tel" placeholder="Telefono" name="phone" pattern="[0-9]{9}"><br>

        <label for="email">Email:</label>
        <input type="email" placeholder="Email" name="email"><br>

        <label for="opening_time">Hora de apertura:</label>
        <input type="text" placeholder="Hora de apertura" name="opening_time" min='1' max='24'><br>

        <label for="closing_time">Hora de cierre:</label>
        <input type="text" placeholder="Hora de cierre" name="closing_time" min='1' max='24'><br>

        <!-- last_updated no debe ingresarse manualmente -->
        <button type="submit" class="crear">Crear Store</button>
    </form>
    <a href="./index.php" class='atras btnAnimado'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 330 330' class='svgIcon'><path xmlns="http://www.w3.org/2000/svg" id="XMLID_92_" d="M111.213,165.004L250.607,25.607c5.858-5.858,5.858-15.355,0-21.213c-5.858-5.858-15.355-5.858-21.213,0.001  l-150,150.004C76.58,157.211,75,161.026,75,165.004c0,3.979,1.581,7.794,4.394,10.607l150,149.996  C232.322,328.536,236.161,330,240,330s7.678-1.464,10.607-4.394c5.858-5.858,5.858-15.355,0-21.213L111.213,165.004z"/></svg>
</a>
</div>
</body>
</html>
