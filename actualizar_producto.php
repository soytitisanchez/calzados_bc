<?php
include 'config.php';

if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];
    $producto = $conn->query("SELECT * FROM productos WHERE id = $producto_id")->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $marca = $_POST['marca'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $talla = $_POST['talla'];
        $descripcion = $_POST['descripcion'];

        $sql = "UPDATE productos SET nombre='$nombre', marca='$marca', precio='$precio', stock='$stock', talla='$talla', descripcion='$descripcion' WHERE id = $producto_id";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Producto actualizado exitosamente</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al actualizar el producto: " . $conn->error . "</div>";
        }
    }
} else {
    echo "<div class='alert alert-danger'>No se ha proporcionado un ID de producto válido.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Actualizar Producto</h2>
        <form method="post" class="p-3 border rounded">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" class="form-control" name="nombre" value="<?= $producto['nombre'] ?>" required>
            </div>
            <div class="form-group">
                <label>Marca:</label>
                <input type="text" class="form-control" name="marca" value="<?= $producto['marca'] ?>">
            </div>
            <div class="form-group">
                <label>Precio:</label>
                <input type="number" step="0.01" class="form-control" name="precio" value="<?= $producto['precio'] ?>" required>
            </div>
            <div class="form-group">
                <label>Stock:</label>
                <input type="number" class="form-control" name="stock" value="<?= $producto['stock'] ?>" required>
            </div>
            <div class="form-group">
                <label>Talla:</label>
                <input type="text" class="form-control" name="talla" value="<?= $producto['talla'] ?>">
            </div>
            <div class="form-group">
                <label>Descripción:</label>
                <textarea class="form-control" name="descripcion"><?= $producto['descripcion'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
        </form>
    </div>
</body>
</html>
