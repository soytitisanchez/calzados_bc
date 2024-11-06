<?php
// Manejo de la carga de archivos e inserción de productos en la base de datos.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'config.php'; // Archivo de conexión a la base de datos.

    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $imagen = '';

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $ruta_temporal = $_FILES['imagen']['tmp_name'];
        $nombre_imagen = basename($_FILES['imagen']['name']);
        $directorio_destino = 'uploads/' . $nombre_imagen;

        // Mover la imagen al directorio de destino.
        if (move_uploaded_file($ruta_temporal, $directorio_destino)) {
            $imagen = $directorio_destino;
        } else {
            echo '<div class="alert alert-danger">Error al subir la imagen.</div>';
        }
    }

    // Insertar el producto en la base de datos.
    $query = "INSERT INTO productos (nombre, precio, descripcion, imagen) VALUES ('$nombre', '$precio', '$descripcion', '$imagen')";
    if (mysqli_query($conn, $query)) {
        echo '<div class="alert alert-success">Producto registrado exitosamente.</div>';
    } else {
        echo '<div class="alert alert-danger">Error al registrar el producto: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto - Calzados B & C</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .img-preview {
            width: 100%;
            max-width: 250px;
            margin-top: 15px;
            transition: transform 0.2s; /* Efecto de zoom */
        }
        .img-preview:hover {
            transform: scale(1.1); /* Zoom al pasar el mouse */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <a href="dashboard.php" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Volver al Inicio</a>
        <h2>Registrar Producto</h2>
        <form action="registrar_producto.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre del Producto:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen del Producto:</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*" onchange="previewImage(event)">
                <img id="preview" class="img-preview" src="#" alt="Vista previa" style="display: none;">
            </div>
            <button type="submit" class="btn btn-primary">Registrar Producto</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
