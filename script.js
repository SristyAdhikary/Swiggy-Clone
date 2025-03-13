document.addEventListener("DOMContentLoaded", function () {
  const container = document.querySelector(".card-slider-main");
  const leftButton = document.querySelector(".arrow-left");
  const rightButton = document.querySelector(".arrow-right");

  function updateButtonState() {
    leftButton.disabled = container.scrollLeft <= 0;
    rightButton.disabled =
      container.scrollLeft + container.offsetWidth >= container.scrollWidth;
  }

  leftButton.addEventListener("click", function () {
    container.scrollBy({
      left: -container.offsetWidth / 2,
      behavior: "smooth",
    });
  });

  rightButton.addEventListener("click", function () {
    container.scrollBy({ left: container.offsetWidth / 2, behavior: "smooth" });
  });
  container.addEventListener("scroll", updateButtonState);
  updateButtonState();
});




















document.addEventListener("DOMContentLoaded", function () {
  const restaurantContainer = document.querySelector(".card-slider");
  const leftRButton = document.querySelector(".restaurant-arrow-left");
  const rightRButton = document.querySelector(".restaurant-arrow-right");


  function updateButtonState() {
    leftRButton.disabled = restaurantContainer.scrollLeft <= 0;
    rightRButton.disabled =
      restaurantContainer.scrollLeft + restaurantContainer.offsetWidth >=
      restaurantContainer.scrollWidth;
  }

  leftRButton.onclick = function () {
    restaurantContainer.scrollBy({
      left: -restaurantContainer.offsetWidth / 2,
      behavior: "smooth",
    });
  };

  rightRButton.onclick = function () {
    restaurantContainer.scrollBy({
      left: restaurantContainer.offsetWidth / 2,
      behavior: "smooth",
    });
  };

  restaurantContainer.addEventListener("scroll", updateButtonState);
  updateButtonState();
});

































document.addEventListener('DOMContentLoaded', () => {
  const filterButtons = document.querySelectorAll('.filter-button');
  const restaurants = document.querySelectorAll('.restu');

  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      const filter = button.getAttribute('data-filter');

      restaurants.forEach(restu => {
        if (filter === 'all' || restu.classList.contains(filter)) {
          restu.style.display = 'block';
        } else {
          restu.style.display = 'none';
        }
      });
    });
  });
});

















document.addEventListener('DOMContentLoaded', function () {
  let cartItemCount = 0;
  let cartItems = [];
  let cartSubtotal = 0;

  // Function to update the cart count in the navbar
  function updateCartCount() {
    document.getElementById('cart-count').innerText = cartItemCount;
  }

  // Function to update the cart modal with current cart items
  function updateCartModal() {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartSubtotalElement = document.getElementById('cart-subtotal');

    // Clear previous cart modal content
    cartItemsContainer.innerHTML = '';
    cartSubtotalElement.innerText = cartSubtotal.toFixed(2);

    // Populate the modal with current cart items
    cartItems.forEach(item => {
      const itemElement = document.createElement('div');
      itemElement.classList.add('cart-item-row');
      itemElement.innerHTML = `
                            <span class="cart-item-name">${item.name}</span>
                            <span class="cart-item-quantity">x${item.quantity}</span>
                            <span class="cart-item-price">₹${(item.price * item.quantity).toFixed(2)}</span>
                        `;
      cartItemsContainer.appendChild(itemElement);
    });
  }

  // Clear the cart modal and count on page reload
  function resetCart() {
    cartItemCount = 0;
    cartItems = [];
    cartSubtotal = 0;

    updateCartCount();
    updateCartModal();
  }

  // Call resetCart to clear everything when the page is refreshed
  resetCart();

  // Event listeners for each "Add" button in the food items
  document.querySelectorAll('.add-button').forEach((addButton, index) => {
    const foodDescription = addButton.parentElement.previousElementSibling;
    const foodName = foodDescription.querySelector('h4').innerText;
    const foodPrice = parseInt(foodDescription.querySelector('p').innerText.replace('₹', ''));

    const quantityContainer = addButton.previousElementSibling;
    const minusButton = quantityContainer.querySelector('.minus-button');
    const plusButton = quantityContainer.querySelector('.plus-button');
    const quantityDisplay = quantityContainer.querySelector('.quantity');

    // "Add" button click event
    addButton.addEventListener('click', function () {
      addButton.style.display = 'none';
      minusButton.style.display = 'inline-block';
      plusButton.style.display = 'inline-block';
      quantityDisplay.style.display = 'inline-block';

      cartItemCount++;
      updateCartCount();

      const existingItemIndex = cartItems.findIndex(item => item.name === foodName);
      if (existingItemIndex > -1) {
        cartItems[existingItemIndex].quantity++;
      } else {
        cartItems.push({ name: foodName, price: foodPrice, quantity: 1 });
      }

      cartSubtotal += foodPrice;
      updateCartModal();
    });

    // "+" button click event
    plusButton.addEventListener('click', function () {
      let currentQuantity = parseInt(quantityDisplay.innerText);
      currentQuantity++;
      quantityDisplay.innerText = currentQuantity;

      cartItemCount++;
      updateCartCount();

      const existingItem = cartItems.find(item => item.name === foodName);
      existingItem.quantity++;
      cartSubtotal += foodPrice;
      updateCartModal();
    });

    // "-" button click event
    minusButton.addEventListener('click', function () {
      let currentQuantity = parseInt(quantityDisplay.innerText);
      if (currentQuantity > 1) {
        currentQuantity--;
        quantityDisplay.innerText = currentQuantity;

        cartItemCount--;
        updateCartCount();

        const existingItem = cartItems.find(item => item.name === foodName);
        existingItem.quantity--;
        cartSubtotal -= foodPrice;
        updateCartModal();
      } else {
        addButton.style.display = 'inline-block';
        minusButton.style.display = 'none';
        plusButton.style.display = 'none';
        quantityDisplay.style.display = 'none';

        cartItemCount--;
        updateCartCount();

        cartItems = cartItems.filter(item => item.name !== foodName);
        cartSubtotal -= foodPrice;
        updateCartModal();
      }
    });
  });

  // Checkout button click event
  document.getElementById('checkout-btn').addEventListener('click', function () {
    const cartItemsInput = document.getElementById('cart-items-input');
    const subtotalInput = document.getElementById('subtotal-input');

    // Send cart data as a JSON string to the hidden input
    cartItemsInput.value = JSON.stringify(cartItems);
    subtotalInput.value = cartSubtotal;
  });

});



// load more 
jQuery(document).ready(function () {
  var shown = 12;
  jQuery(".restu-card").hide();
  jQuery(".restu-card:lt(" + shown + ")").show();

  var items = jQuery(".restu-card").length;
  jQuery("#loadMore").click(function () {
    shown = jQuery(".restu-card:visible").length + 12;
    if (shown < items) {
      jQuery(".restu-card:lt(" + shown + ")").show();
    } else {
      jQuery(".restu-card:lt(" + items + ")").show();
      jQuery("#loadMore").hide();
    }
    jQuery("html, body").animate({ scrollTop: "+=150px" }, 800);
  });
});
































