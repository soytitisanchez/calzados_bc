<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "calzados_bc";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar productos
$sql = "SELECT id, nombre, precio, imagen FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Productos - Tienda de Calzado</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }

        h1 {
            color: #343a40;
        }

        .producto {
            border: 1px solid #ddd;
            margin: 15px 0;
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .producto:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .volver {
            display: inline-block;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .volver:hover {
            background-color: #0056b3;
        }

        .cart-summary {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 300px;
            z-index: 1000;
        }

        .cart-summary h2 {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .cart-item p {
            margin: 0;
            font-size: 14px;
        }

        .btn-cart {
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            width: 100%;
            font-size: 16px;
        }

        .btn-cart:hover {
            background-color: #218838;
        }

        .btn-add {
            background-color: #007bff;
            color: white;
            width: 100%;
            border-radius: 5px;
            padding: 8px;
        }

        .btn-add:hover {
            background-color: #0056b3;
        }

        .cart-icon {
            position: fixed;
            bottom: 10px;
            right: 10px;
            background-color: #28a745;
            border-radius: 50%;
            padding: 15px;
            color: white;
            font-size: 24px;
            cursor: pointer;
            z-index: 999;
        }

        .cart-icon:hover {
            background-color: #218838;
        }

        /* Modal de confirmación */
        .modal-header, .modal-footer {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body>

    <h1>Productos Disponibles</h1>

    <div class="row">
        <?php
        // Conexión a la base de datos
        $conn = new mysqli("localhost", "root", "", "calzados_bc");

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consultar productos
        $sql = "SELECT id, nombre, precio, imagen FROM productos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Mostrar productos disponibles
            while ($row = $result->fetch_assoc()) {
                echo "<div class='producto col-md-3'>";
                echo "<h3>" . htmlspecialchars($row["nombre"]) . "</h3>";
                echo "<p>Precio: $" . htmlspecialchars($row["precio"]) . "</p>";
                echo "<img src='" . htmlspecialchars($row["imagen"]) . "' alt='" . htmlspecialchars($row["nombre"]) . "'>";
                echo "<button class='btn btn-add' onclick='addToCart(" . $row["id"] . ", \"" . htmlspecialchars($row["nombre"]) . "\", " . $row["precio"] . ")'>Agregar al Carrito</button>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay productos disponibles.</p>";
        }

        $conn->close();
        ?>
    </div>

    <!-- Resumen del carrito -->
    <div class="cart-summary">
        <h2>Carrito</h2>
        <div id="cartItems"></div>
        <hr>
        <div id="totalAmount">
            <p class="font-weight-bold">Total: $<span id="totalPrice">0</span></p>
        </div>
        <button class="btn-cart" onclick="checkout()">Realizar Compra</button>
    </div>

    <!-- Icono del carrito flotante -->
    <div class="cart-icon" onclick="showCart()">
        <i class="fas fa-shopping-cart"></i>
    </div>

    <!-- Modal para confirmación de compra -->
    <div class="modal" tabindex="-1" id="checkoutModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmación de Compra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas realizar la compra?</p>
                    <p><strong>Total a pagar: $<span id="finalPrice"></span></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="confirmCheckout()">Confirmar Compra</button>
                </div>
            </div>
        </div>
    </div>

    <a href="dashboard.php" class="volver">Volver</a>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let cart = [];
        let totalPrice = 0;

        // Función para agregar productos al carrito
        function addToCart(productId, productName, productPrice) {
            const product = { id: productId, name: productName, price: productPrice };
            cart.push(product);
            totalPrice += productPrice;

            updateCart();
        }

        // Actualizar el carrito de compras
        function updateCart() {
            const cartItems = document.getElementById("cartItems");
            cartItems.innerHTML = ''; // Limpiar el contenido actual

            cart.forEach(item => {
                const div = document.createElement('div');
                div.classList.add('cart-item');
                div.innerHTML = `<p>${item.name}</p><p>$${item.price}</p>`;
                cartItems.appendChild(div);
            });

            // Actualizar total
            document.getElementById('totalPrice').innerText = totalPrice;
        }

        // Función para proceder al pago
        function checkout() {
            if (cart.length === 0) {
                alert('Tu carrito está vacío. Agrega productos para comprar.');
                return;
            }
            document.getElementById('finalPrice').innerText = totalPrice;
            $('#checkoutModal').modal('show');
        }

        // Confirmar la compra
        function confirmCheckout() {
            // Preparar datos para enviar al servidor
            const cartData = cart.map(item => ({
                id: item.id,
                cantidad: 1, // Supón que solo estás comprando una cantidad de cada producto
                precio: item.price
            }));

            // Realizar una solicitud AJAX para procesar la compra
            $.post('procesar_compra.php', {
                cart: cartData,
                totalPrice: totalPrice
            }, function(response) {
                alert(response);
                cart = []; // Vaciar carrito después de la compra
                totalPrice = 0;
                updateCart();
                $('#checkoutModal').modal('hide');
            });
        }

        // Mostrar carrito al hacer clic en el icono flotante
        function showCart() {
            document.querySelector('.cart-summary').style.display = 'block';
        }
    </script>
</body>
</html>
