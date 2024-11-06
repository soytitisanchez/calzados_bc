<?php
session_start();
require 'config.php';

function calcularTotal($cantidad) {
    return $cantidad * 100; // Cambia esto según tu lógica de precios
}

$facturaGenerada = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $cantidad = $_POST['cantidad'];
    $monto_abonado = $_POST['monto_abonado'];
    
    // Datos del cliente
    $cliente_nombre = $_POST['cliente_nombre'];
    $cliente_apellido = $_POST['cliente_apellido'];
    $cliente_contacto = $_POST['cliente_contacto'];

    // Calcular total y vuelto
    $total = calcularTotal($cantidad);
    $vuelto = $monto_abonado - $total;

    // Guardar datos de la factura para mostrar más tarde
    $facturaDatos = [
        'cliente_nombre' => $cliente_nombre,
        'cliente_apellido' => $cliente_apellido,
        'cliente_contacto' => $cliente_contacto,
        'producto' => 'Calzado Ejemplo', // Cambia esto según tu lógica
        'cantidad' => $cantidad,
        'total' => $total,
        'monto_abonado' => $monto_abonado,
        'vuelto' => $vuelto
    ];

    $facturaGenerada = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .factura {
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .factura h4 {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
    <a href="dashboard.php" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Volver al Inicio</a>
        <h2>Registrar Venta</h2>
        <form method="POST" action="registrar_venta.php">
            <div class="form-group">
                <label for="cliente_nombre">Nombre del Cliente</label>
                <input type="text" class="form-control" id="cliente_nombre" name="cliente_nombre" required>
            </div>

            <div class="form-group">
                <label for="cliente_apellido">Apellido del Cliente</label>
                <input type="text" class="form-control" id="cliente_apellido" name="cliente_apellido" required>
            </div>

            <div class="form-group">
                <label for="cliente_contacto">Teléfono/Contacto</label>
                <input type="text" class="form-control" id="cliente_contacto" name="cliente_contacto" required>
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>

            <div class="form-group">
                <label for="monto_abonado">Monto Abonado</label>
                <input type="number" class="form-control" id="monto_abonado" name="monto_abonado" required>
            </div>

            <button type="submit" class="btn btn-primary">Registrar Venta</button>
        </form>

        <?php if ($facturaGenerada): ?>
            <div class="mt-5 factura">
                <h3>Factura Generada</h3>
                <h4>Calzados B & C</h4>
                <p>Dirección: Calle Ejemplo 123, Ciudad, País</p>
                <p>Teléfono: (123) 456-7890</p>
                <p>Email: contacto@calzadosbc.com</p>
                <hr>
                <p><strong>Cliente:</strong> <?php echo $facturaDatos['cliente_nombre'] . ' ' . $facturaDatos['cliente_apellido']; ?></p>
                <p><strong>Contacto:</strong> <?php echo $facturaDatos['cliente_contacto']; ?></p>
                <p><strong>Producto:</strong> <?php echo $facturaDatos['producto']; ?></p>
                <p><strong>Cantidad:</strong> <?php echo $facturaDatos['cantidad']; ?></p>
                <p><strong>Total:</strong> $<?php echo number_format($facturaDatos['total'], 2); ?></p>
                <p><strong>Monto Abonado:</strong> $<?php echo number_format($facturaDatos['monto_abonado'], 2); ?></p>
                <p><strong>Vuelto:</strong> $<?php echo number_format($facturaDatos['vuelto'], 2); ?></p>
                <p><strong>Fecha:</strong> <?php echo date('d-m-Y'); ?></p>
                <hr>
                <p style="text-align: center;">Gracias por su compra!</p>
            </div>
            <button class="btn btn-success mt-3" onclick="window.print()">Imprimir Factura</button>
            <a href="generar_pdf.php?cliente_nombre=<?php echo urlencode($facturaDatos['cliente_nombre']); ?>&cliente_apellido=<?php echo urlencode($facturaDatos['cliente_apellido']); ?>&cliente_contacto=<?php echo urlencode($facturaDatos['cliente_contacto']); ?>&producto=<?php echo urlencode($facturaDatos['producto']); ?>&cantidad=<?php echo $facturaDatos['cantidad']; ?>&total=<?php echo $facturaDatos['total']; ?>&monto_abonado=<?php echo $facturaDatos['monto_abonado']; ?>&vuelto=<?php echo $facturaDatos['vuelto']; ?>" class="btn btn-primary mt-3">Descargar como PDF</a>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
