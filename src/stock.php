<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./style.css">
    <title>Stock</title>
</head>
<body>
<div class="contenedor">
<form method="post" class="addForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?<?php echo $_SERVER["QUERY_STRING"]; ?>">
    <?php
    require_once("database.php");
    $id = $_GET['id'];
    echo '<h1 id="titulo">STOCK DEL PRODUCTO CON ID: ' . $id . '</h1>';
    $resultado = src\Database::getInstance()->getConnection()->query("SELECT * FROM Stores_Products WHERE id_product = $id");
    if ($resultado->num_rows > 0) {
        echo "<table><tr><th>ID Tienda</th><th>Stock</th></tr>";
        $contar = 0;
        while ($row = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td><input type='hidden' name='id_$contar' value='$row[id_store]'>$row[id_store]</td>";
            echo "<td><input type='number' name='stock_$contar' value='$row[stock_quantity]'></td>";
            echo "</tr>";
            $contar++;
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        for ($i = 0; $i < $contar; $i++) {
            $sql = src\Database::getInstance()->getConnection()->prepare("UPDATE Stores_Products SET stock_quantity = ? WHERE id_product = ? AND id_store = ?");
            $sql->bind_param("iii", $_POST['stock_' . $i], $id, $_POST['id_' . $i]);
            $sql->execute();
        }
        ?>
        <script>
            window.location.href = "index.php"
        </script>
        <?php
    }
    ?>
    <a href='./index.php'>
          <button type='submit' name='action' value='editar' class='update btnAnimado'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 16 16' class='svgIcon'> <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z' fill='white'></path> </svg>
            </button>
          </a>
</form>
<a href="./index.php" class='atras btnAnimado'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 330 330' class='svgIcon'><path xmlns="http://www.w3.org/2000/svg" id="XMLID_92_" d="M111.213,165.004L250.607,25.607c5.858-5.858,5.858-15.355,0-21.213c-5.858-5.858-15.355-5.858-21.213,0.001  l-150,150.004C76.58,157.211,75,161.026,75,165.004c0,3.979,1.581,7.794,4.394,10.607l150,149.996  C232.322,328.536,236.161,330,240,330s7.678-1.464,10.607-4.394c5.858-5.858,5.858-15.355,0-21.213L111.213,165.004z"/></svg>
</a>
</div>
</body>
</html>
