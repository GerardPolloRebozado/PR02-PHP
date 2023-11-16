<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./style.css">
    <title>Eliminar producto</title>
</head>
<body>
<div class="contenedor">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?<?php echo $_SERVER["QUERY_STRING"]; ?>">
    <?php
    require_once("database.php");
    $id = $_GET['id'];
    echo '<h2>SEGURO QUE QUIERES ELIMINAR EL PRODUCTO CON ID: ' . $id . '</h2>';
    echo '<input type="submit" name="action" value="SI"> <input type="submit" name="action" value="NO">';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];
        if ($action === 'SI') {
            $sql = src\Database::getInstance()->getConnection()->query("DELETE FROM Stores_Products WHERE id_product='$id'");
            $sql = src\Database::getInstance()->getConnection()->query("DELETE FROM Products WHERE id='$id'");
        }
        sleep(1);
        ?>
        <script>
                window.location.replace("/listP.php");
        </script>
        <?php
    }
    ?>
</form>
<a href="./index.php" class='atras btnAnimado'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 330 330' class='svgIcon'><path xmlns="http://www.w3.org/2000/svg" id="XMLID_92_" d="M111.213,165.004L250.607,25.607c5.858-5.858,5.858-15.355,0-21.213c-5.858-5.858-15.355-5.858-21.213,0.001  l-150,150.004C76.58,157.211,75,161.026,75,165.004c0,3.979,1.581,7.794,4.394,10.607l150,149.996  C232.322,328.536,236.161,330,240,330s7.678-1.464,10.607-4.394c5.858-5.858,5.858-15.355,0-21.213L111.213,165.004z"/></svg>
</a>
</div>
</body>
</html>
