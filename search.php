<?php

include 'conexion.php';
// Obtener el término de búsqueda
$query = isset($_GET['query']) ? $_GET['query'] : '';
$searchTerms = ['chompa', 'zapatilla', 'calzado', 'jeans', 'top', 'polo', 'billetera', 'blusa'];
$searchTermLower = strtolower($query);

// Preparar la consulta SQL
$sql = "SELECT * FROM productos WHERE LOWER(nombreProducto) LIKE ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Vincular el parámetro de búsqueda
    $likeQuery = $searchTermLower . '%'; // Buscar productos que comiencen con el término de búsqueda
    $stmt->bind_param("s", $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Error al preparar la consulta: " . $conn->error;
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
    <link rel="stylesheet" href="header1.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="productos.css">
    <link rel="stylesheet" href="categorias.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <section class="navegacion">
            <div class="content_nav">
                <div class="content_logo">

                     <img src="img/logo/logo_jya.png" alt="Logo">
                    <!-- <section class="eslogan">
                <h1>Venta de ropa, calzados y accesorios</h1>
            </section> -->
                </div>
                <nav>
                    <ul>
                        <li><a href="index.php">Inicio</a></li>
                        <li>
                            <a href="categorias.php">Categorias</a>
                            <ul class="submenu">
                                <li><a href="ropa_caballeros.php">Caballeros</a></li>
                                <li><a href="ropa_mujeres.php">Damas</a></li>
                                <li><a href="calzados.php">Calzados</a></li>
                                <li><a href="accesorios.php">Accesorios</a></li>
                            </ul>
                        </li>
                        <li><a href="contactanos.php">Contacto</a></li>
                    </ul>
                </nav>

                <div class="content_item">
                    <form action="search.php" method="GET">
                        <input type="text" name="query" placeholder="Buscar productos, marcas y más..." value="<?php echo htmlspecialchars($query); ?>">
                        <button type="submit">Buscar</button>
                    </form>
                    <a href="#"><img src="img/iconos/usuario (2).png" alt=""> <span> Acceso</span></a>
                    <a href="#" id="cart-button"><img src="img/iconos/carro_compras.png" alt="">Carrito (<span id="cart-count">0</span>)</a>
                </div>
            </div>
        </section>
    </header>
    <main>
        <h1>Resultados de búsqueda para "<?php echo htmlspecialchars($query); ?>"</h1>
        <section class="productos">
            <div class="contenido-seccion">
                <?php if ($result && $result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <div class="tarjeta" data-id='<?= $row['idProductos'] ?>' data-name="<?= $row['nombreProducto'] ?>" data-price="<?= $row['precioProducto'] ?>">
                            <img src='data:image/jpeg;base64,<?= base64_encode($row['imagenProducto']) ?>' alt='Foto de producto'>
                            <div class="informacion_producto">
                                <h3 class="nombre_producto"><?= $row['nombreProducto'] ?></h3>
                                <p class="producto_detalle"><?= $row['detalleProducto'] ?></p>
                                <div class="footer_tarjeta">
                                    <span class="producto_precio"> S/. <?= $row['precioProducto'] ?></span>
                                    <button class="add-to-cart"><img src="img/iconos/carro_compras.png" alt=""> Añadir al Carrito</button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>No se encontraron productos.</p>
                <?php endif; ?>
            </div>
        </section>
        <div id="cart-modal" class="cart-modal">
            <div class="cart-content">
                <span class="close">&times;</span>
                <h2>Carrito de Compras</h2>
                <div id="cart-items"></div>
                <div class="cart-total">
                    <span>Total: S/. <span class="total-price">0.00</span></span>
                    <button id="checkout-button">Pagar</button>
                </div>
            </div>
        </div>

    </main>
</body>
<footer>
    <nav>
        <ul>
            <li><a href="contactanos.php">Contactos</a></li>
            <li><a href="">Reclamos</a></li>
            <li><a href="">Metodos de pago</a></li>
            <li><a href="nosotros.php">Nosotros</a></li>
        </ul>
    </nav>
    <div class="footer_bottom">
        <p>&copy; 2024 J&A. Todos los derechos reservados.</p>

    </div>
</footer>

</html>
<script src="carrito.js"></script>
<script src="chatbot.js"></script>
<?php
if ($stmt) {
    $stmt->close();
}
$conn->close();
?>