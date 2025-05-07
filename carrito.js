// Obtener referencias a los elementos relevantes del DOM
const cartButton = document.getElementById('cart-button');
const cartModal = document.getElementById('cart-modal');
const closeButton = document.querySelector('.cart-modal .close');
const cartItems = document.getElementById('cart-items');
const totalPriceElement = document.querySelector('.total-price');
const checkoutButton = document.getElementById('checkout-button');

// Array para almacenar los artículos en el carrito
let cartContents = getCartFromCookies();


// Function para guardar en las cookies
function saveCart() {
  document.cookie = `cartContents=${encodeURIComponent(cartContents.map(item => `${item.id},${item.name},${item.price},${item.quantity || 1}`).join('|'))}; path=/`;
}

// Función para obtener el carrito desde las cookies
function getCartFromCookies() {
  const name = 'cartContents=';
  const decodedCookie = decodeURIComponent(document.cookie);
  const ca = decodedCookie.split(';');
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) === ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length, c.length).split('|').map(item => {
        const [id, name, price, quantity] = item.split(',');
        return { id, name, price: parseFloat(price), quantity: parseInt(quantity, 10) };
      });
    }
  }
  return [];
}

// Función para agregar un artículo al carrito
function addToCart(productId, productName, price) {
  // Agregar el artículo al array cartContents
  cartContents.push({ id: productId, name: productName, price: price });
  saveCart();
  // Actualizar la interfaz de usuario del carrito
  updateCartUI();
}

// Función para actualizar la interfaz de usuario del carrito
function updateCartUI() {
  // Actualizar el conteo de artículos en el carrito
  document.getElementById('cart-count').textContent = cartContents.length;

  // Actualizar la visualización de los artículos en el carrito
  cartItems.innerHTML = '';
  cartContents.forEach((item, index) => {
    const itemElement = document.createElement('div');
    itemElement.classList.add('cart-item');
    itemElement.innerHTML = `
      <span class="item-name">Nombre: <span class="item-name-value">${item.name}</span></span>
      <span class="item-price">Price: S/. <span class="item-price-value">${item.price}</span></span>
      <div class="quantity-controls">
        <button class="decrease-quantity" data-index="${index}">-</button>
        <span class="item-quantity">${item.quantity || 1}</span>
        <button class="increase-quantity" data-index="${index}">+</button>
      </div>
    `;
    cartItems.appendChild(itemElement);
  });

  // Actualizar el precio total
  const totalPrice = cartContents.reduce((total, item) => total + (item.price * (item.quantity || 1)), 0);
  totalPriceElement.textContent = totalPrice.toFixed(2);
}

// Event listeners para abrir y cerrar el modal del carrito
cartButton.addEventListener('click', () => {
  cartModal.style.display = 'block';
  setTimeout(() => {
    cartModal.classList.add('visible');
  }, 10);
});

closeButton.addEventListener('click', () => {
  cartModal.classList.remove('visible');
  setTimeout(() => {
    cartModal.style.display = 'none';
  }, 300);
});

//Event listener para el botón de checkout
checkoutButton.addEventListener('click', () => {
    const whatsappAPI = "https://api.whatsapp.com/send?phone=+51 984680341";
    let message = `¡Hola! Me interesa el siguiente pedido:\n\n`;
    cartContents.forEach(item => {
    message += `- ${item.name} (Cantidad: ${item.quantity}) - Precio: S/. ${item.price}\n`;
    });
    const totalPrice = cartContents.reduce((total, item) => total + (item.price * (item.quantity || 1)), 0);
    message += `\nTotal: S/. ${totalPrice.toFixed(2)}`;

    const whatsappURL = `${whatsappAPI}&text=${encodeURIComponent(message)}`;

    //   // Abrir la conversación de WhatsApp en una nueva ventana o pestaña
    window.open(whatsappURL, "_blank");
});

// Event listener para el botón de checkout
//checkoutButton.addEventListener('click', () => {
  // Implementar la funcionalidad de checkout aquí
  //window.location.href="ckeckout.php";
//});

// Event listeners para los botones "Agregar al carrito"
const addToCartButtons = document.querySelectorAll('.add-to-cart');
addToCartButtons.forEach((button) => {
  button.addEventListener('click', (event) => {
    const productCard = event.target.closest('.tarjeta');
    const productId = productCard.dataset.id;
    const productName = productCard.dataset.name;
    const price = parseFloat(productCard.dataset.price);
    addToCart(productId, productName, price);
  });
});

// Event listener para los botones "Aumentar cantidad" y "Disminuir cantidad"
cartItems.addEventListener('click', (event) => {
  if (event.target.classList.contains('increase-quantity')) {
    const index = parseInt(event.target.dataset.index);
    cartContents[index].quantity = (cartContents[index].quantity || 1) + 1;
    updateCartUI();
  } else if (event.target.classList.contains('decrease-quantity')) {
    const index = parseInt(event.target.dataset.index);
    if (cartContents[index].quantity > 1) {
      cartContents[index].quantity--;
    } else {
      cartContents.splice(index, 1);
    }
    updateCartUI();
  }
});

// Inicialización de la interfaz del carrito al cargar la página
updateCartUI();