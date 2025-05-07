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



  // Función para actualizar la interfaz de usuario del carrito en la página de checkout
  function updateCheckoutUI() {
    const cartItems = document.querySelector('#cart-items tbody');
    const totalPriceElement = document.querySelector('.total-price');
    const cartContents = getCartFromCookies();

    // Actualizar la visualización de los artículos en el carrito
    cartItems.innerHTML = '';
    cartContents.forEach((item) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${item.name}</td>
        <td>${item.price.toFixed(2)}</td>
        <td>${item.quantity}</td>
      `;
      cartItems.appendChild(row);
    });

    // Actualizar el precio total
    const totalPrice = cartContents.reduce((total, item) => total + (item.price * item.quantity), 0);
    totalPriceElement.textContent = totalPrice.toFixed(2);
  }
  // Inicialización de la interfaz del carrito al cargar la página
 updateCheckoutUI();
// const botonPagar = document.querySelector('.boton-pagar');

// Event listener para el botón de checkout
checkoutButton.addEventListener('click', () => {
    realizarpago();
    // Implementar la funcionalidad de checkout aquí
    window.location.href="index.php";
  });

function realizarpago(){
    console.log('Se esta realizando pago');
}
  // Event listener para el botón de checkout
//  Pagar.addEventListener('click', () => {
//    const whatsappAPI = "https://api.whatsapp.com/send?phone=+51984680341";
//    let message = `¡Hola! Me interesa el siguiente pedido:\n\n`;
//    cartContents.forEach(item => {
//      message += `- ${item.name} (Cantidad: ${item.quantity}) - Precio: S/. ${item.price}\n`;
//    });
//    const totalPrice = cartContents.reduce((total, item) => total + (item.price * (item.quantity || 1)), 0);
//    message += `\nTotal: S/. ${totalPrice.toFixed(2)}`;

//    const whatsappURL = `${whatsappAPI}&text=${encodeURIComponent(message)}`;

//    // Abrir la conversación de WhatsApp en una nueva ventana o pestaña
//    window.open(whatsappURL, "_blank");
//  });



