<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./style.css">
    <title>Actualizar Store</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
<div class="contenedor">
    <?php
    require_once("database.php");

    $db = src\Database::getInstance();
    $cities = $db->getConnection()->query("SELECT id, name FROM Cities");

    $selectedCity = $address = $phone = $email = $opening_time = $closing_time = "";
    $cityErr = $addressErr = $phoneErr = $emailErr = $opening_timeErr = $closing_timeErr = "";

    // Obtener el ID de la tienda a actualizar desde la URL
    $id = $_GET['id'];

    // Obtener datos actuales de la tienda
    $resultado = $db->getConnection()->query("SELECT * FROM Store WHERE id = $id");

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $selectedCity = $row['city'];
            $address = $row['address'];
            $phone = $row['phone'];
            $email = $row['email'];
            $opening_time = $row['opening_time'];
            $closing_time = $row['closing_time'];
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $error = false;

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

        // Validación de opening_time
        if (!empty($opening_time) && (!is_numeric($opening_time) || $opening_time < 1 || $opening_time > 24)) {
            $opening_timeErr = "El valor debe ser un número entre 1 y 24.";
            $error = true;
        }

        // Validación de closing_time
        if (!empty($closing_time) && (!is_numeric($closing_time) || $closing_time < 1 || $closing_time > 24)) {
            $closing_timeErr = "El valor debe ser un número entre 1 y 24.";
            $error = true;
        }

        if (!$error) {
            // Validación adicional para evitar inserciones con horas fuera del rango
            if (($opening_time >= 1 && $opening_time <= 24) && ($closing_time >= 1 && $closing_time <= 24)) {
                $sql = $db->getInstance()->getConnection()->prepare("UPDATE Store SET city = ?, address = ?, phone = ?, email = ?, opening_time = ?, closing_time = ?, last_updated = NOW() WHERE id = ?");
                $sql->bind_param("isssssi", $selectedCity, $address, $phone, $email, $opening_time, $closing_time, $id);
                $sql->execute();
            } else {
                // Mostrar mensaje de error si las horas están fuera del rango después de la validación del formulario HTML
                echo "Las horas deben estar en el rango de 1 a 24.";
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
    <h1>Actualizar Store</h1>
    <form method="post" class="addForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $id; ?>">
        City:
        <select name="city">
            <?php
            foreach ($cities as $cityOption) {
                $selected = ($cityOption['id'] == $selectedCity) ? 'selected' : '';
                echo "<option value='{$cityOption['id']}' $selected>{$cityOption['name']}</option>";
            }
            ?>
        </select>
        <span class="error"><?php echo $cityErr; ?></span><br>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo $address; ?>" required>
        <span class="error"><?php echo $addressErr; ?></span><br>

        <label for="phone">Phone:</label>
        <input type="tel" name="phone" pattern="[0-9]{9}" value="<?php echo $phone; ?>" required>
        <span class="error"><?php echo $phoneErr; ?></span><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required>
        <span class="error"><?php echo $emailErr; ?></span><br>

        <label for="opening_time">Opening Time:</label>
        <input type="number" name="opening_time" value="<?php echo $opening_time; ?>">
        <span class="error"><?php echo $opening_timeErr; ?></span><br>

        <label for="closing_time">Closing Time:</label>
        <input type="number" name="closing_time" value="<?php echo $closing_time; ?>">
        <span class="error"><?php echo $closing_timeErr; ?></span><br>

        <button type="submit" class="crear">Actualizar Store</button>
    </form>
    <a href="./index.php" class='atras btnAnimado'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 330 330' class='svgIcon'><path xmlns="http://www.w3.org/2000/svg" id="XMLID_92_" d="M111.213,165.004L250.607,25.607c5.858-5.858,5.858-15.355,0-21.213c-5.858-5.858-15.355-5.858-21.213,0.001  l-150,150.004C76.58,157.211,75,161.026,75,165.004c0,3.979,1.581,7.794,4.394,10.607l150,149.996  C232.322,328.536,236.161,330,240,330s7.678-1.464,10.607-4.394c5.858-5.858,5.858-15.355,0-21.213L111.213,165.004z"/></svg>
</a>
    </div>
</body>
</html>

