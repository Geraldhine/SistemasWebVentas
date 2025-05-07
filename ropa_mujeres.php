<?php
include 'conexion.php';

$sqlDamas =  "SELECT * FROM categorias INNER JOIN productos ON productos.IdCategoria = categorias.idCategoria WHERE categorias.idCategoria = 2";
$resultDamas = $conn->query($sqlDamas);
$query = isset($_GET['query']) ? $_GET['query'] : '';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-******************" crossorigin="anonymous">
    <link rel="stylesheet" href="categorias.css">
    <link rel="stylesheet" href="header1.css">
    <link rel="stylesheet" href="productos.css">
    <link rel="stylesheet" href="footer.css" />
    <link rel="stylesheet" href="style.css" />

</head>

<body>
    <header>
        <section class="header_social-medias">
            <a href="https://www.facebook.com" target="_blank"><i
                    class="fab fa-facebook-f"></i></a>
            <a href="https://www.twitter.com" target="_blank"><i
                    class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com" target="_blank"><i
                    class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com" target="_blank"><i
                    class="fab fa-linkedin-in"></i></a>
        </section>
        <section class="navegacion">
            <div class="content_nav">
                <div class="content_logo">
                    <img src="img/logo/logo Negro.png" alt="Logo"/>
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
    <main class="shoe-store">
        <section class="categories_list">
            <h2>Categorías</h2>
            <ul>
                <li><a href="ropa_caballeros.php">Caballeros</a></li>
                <li><a href="ropa_mujeres.php">Damas</a></li>
                <li><a href="accesorios.php">Accesorios</a></li>
                <li><a href="calzados.php">Calzados</a></li>
                
            </ul>
        </section>
        <section class="productos">
                <div class="contenido-seccion">
                    <?php if ($resultDamas->num_rows > 0) : ?>
                        <?php while ($row = $resultDamas->fetch_assoc()) : ?>
                            <div class="tarjeta" data-id='<?= $row['idProductos'] ?>' data-name="<?= $row['nombreProducto'] ?>" data-price="<?= $row['precioProducto'] ?>" >
                                <img src='data:image/jpeg;base64,<?= base64_encode($row['imagenProducto']) ?>' alt='Foto de prodcuto '>
                                <div class="informacion_producto">
                                    <h3 class="nombre_producto"><?= $row['nombreProducto'] ?></h3>
                                    <p class="producto_detalle"><?= $row['detalleProducto'] ?></p>
                                    <p class=""><?= $row['nombreCategoria'] ?></p>
                                    <div class="footer_tarjeta">
                                        <span class="producto_precio"> S/. <?= $row['precioProducto'] ?></span>
                                        <button class="add-to-cart"><img src="img/iconos/carro_compras.png" alt=""> Añadir al Carrito</button>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>No hay resultados</p>
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
        <?php $conn->close(); ?>
    </main>
    <footer>
        <nav>
            <ul>
                <li><a href="contactanos.php">Contactos</a></li>
                <li><a href="">Reclamos</a></li>
                <li><a href="">Metodos de pago</a></li>
                <li><a href="">Nosotros</a></li>
            </ul>
        </nav>
        <div class="footer_bottom">
            <p>&copy; 2024 J&A. Todos los derechos reservados.</p>
        
        </div>
    </footer>
    <script src="carrito.js"></script>
    <script src="chatbot.js"></script>
</body>
</html>