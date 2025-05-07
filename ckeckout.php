<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="header1.css">
  <link rel="stylesheet" href="checkout.css">
  <title>Checkout</title>
  
</head>
<body>
<header>
        <section class="header_social-medias">
            <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        </section>
        <section class="navegacion">
            <div class="content_nav">
                <div class="content_logo">

                    <a href="index.php">
                        <img src="img/logo/logo_jya.png" alt="Logo">
                    </a>
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
                    <a href="login.php"><img src="img/iconos/usuario (2).png" alt=""><span>Usuario</span></a>
                    <a href="#" id="cart-button"><img src="img/iconos/carro_compras.png" alt="">Carrito (<span id="cart-count">0</span>)</a>
                </div>
            </div>
        </section>

    </header>
 <main>
  <div class="table-responsive">
    <table id="cart-items">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Precio (S/.)</th>
          <th>Cantidad</th>
        </tr>
      </thead>
      <tbody>
        <!-- Los artículos del carrito se agregarán aquí -->
      </tbody>
    </table>
  </div>
  <div class="total-price-container">Total: S/. <span class="total-price">0.00</span></div>
  <button id="checkout-button">Pagar</button>
 </main>
    


  <script src="checkout.js"></script>
</body>
</html>
