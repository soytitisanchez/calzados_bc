<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calzados_bc";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Comprobar si se ha enviado el formulario con los productos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar que el carrito no esté vacío
    if (empty($_POST['cart'])) {
        die("Tu carrito está vacío. No se puede procesar la compra.");
    }

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Insertar la venta en la tabla 'ventas'
        $total = $_POST['totalPrice']; // Total de la compra
        $sql = "INSERT INTO ventas (total) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("d", $total);
        $stmt->execute();
        $venta_id = $stmt->insert_id; // Obtener el ID de la venta recién insertada

        // Insertar los productos en la tabla 'detalle_venta'
        foreach ($_POST['cart'] as $producto) {
            $id_producto = $producto['id'];
            $cantidad = $producto['cantidad'];
            $precio = $producto['precio'];

            $sql_detalle = "INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio) 
                            VALUES (?, ?, ?, ?)";
            $stmt_detalle = $conn->prepare($sql_detalle);
            $stmt_detalle->bind_param("iiid", $venta_id, $id_producto, $cantidad, $precio);
            $stmt_detalle->execute();
        }

        // Si todo va bien, confirmar la transacción
        $conn->commit();
        echo "¡Compra realizada con éxito!";

    } catch (Exception $e) {
        // Si ocurre algún error, hacer rollback
        $conn->rollback();
        echo "Error al procesar la compra: " . $e->getMessage();
    }
}

$conn->close();
?>
