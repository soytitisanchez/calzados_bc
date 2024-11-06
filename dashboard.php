    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calzados B & C - Dashboard</title>
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <!-- FontAwesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <body>

        <div class="container mt-5">
            <!-- Jumbotron de bienvenida -->
            <div class="jumbotron text-center">
                <h1 class="display-4">Bienvenido a Calzados B & C</h1>
                <p class="lead">Gestione productos, ventas y más en un solo lugar.</p>
                <hr class="my-4">
                <p>Seleccione una opción a continuación para empezar.</p>
            </div>

        
            <!-- Fila de tarjetas -->
            <div class="row text-center">
                <!-- Tarjeta para registrar producto -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-box"></i> Registrar Producto</h5>
                            <p class="card-text">Agrega nuevos productos a tu inventario.</p>
                            <a href="registrar_producto.php" class="btn btn-primary">Ir</a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta para registrar venta -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-shopping-cart"></i> Registrar Venta</h5>
                            <p class="card-text">Registra las ventas realizadas en la tienda.</p>
                            <a href="registrar_venta.php" class="btn btn-primary">Ir</a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta para registrar cliente -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user-plus"></i> Registrar Cliente</h5>
                            <p class="card-text">Registra nuevos clientes en el sistema.</p>
                            <a href="registrar_cliente.php" class="btn btn-primary">Ir</a>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta para ver productos -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-eye"></i> Ver Productos</h5>
                            <p class="card-text">Aquí podrás elegir tus calzados favoritos para cada ocasión.</p>
                            <a href="ver_productos.php" class="btn btn-primary">Ir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script para búsqueda -->
        <script>
            function searchFunction() {
                let input = document.getElementById('searchInput').value.toLowerCase();
                let cards = document.getElementsByClassName('card');
                for (let i = 0; i < cards.length; i++) {
                    let cardText = cards[i].innerText.toLowerCase();
                    if (cardText.includes(input)) {
                        cards[i].style.display = 'block';
                    } else {
                        cards[i].style.display = 'none';
                    }
                }
            }
        </script>

        <!-- Bootstrap JS y dependencias -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>
