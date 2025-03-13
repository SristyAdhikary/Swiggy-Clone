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
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  // card dropdown
  
  document.querySelectorAll('.dropdown-content a').forEach(function (item) {
    item.addEventListener('click', function (event) {
      event.preventDefault();
      var selectedLocation = this.getAttribute('data-location');
      document.getElementById('selected-location').textContent = "Outlet: " + selectedLocation;
      document.querySelector('.dropdown-content').style.display = 'none';
    });
  });
  
  // Optional: Add a click event to close the dropdown when clicking outside
  document.addEventListener('click', function (event) {
    var dropdown = document.querySelector('.dropdown');
    if (!dropdown.contains(event.target)) {
      document.querySelector('.dropdown-content').style.display = 'none';
    }
  });
  
  
  
  
  
  
  
  
  
  
  
  
  
  // food card
  
  $(".open").click(function () {
    var container = $(this).parents(".topic");
    var answer = container.find(".food-card");
    var trigger = container.find(".faq-t");
  
    answer.slideToggle(200);
  
    if (trigger.hasClass("faq-o")) {
      trigger.removeClass("faq-o");
    } else {
      trigger.addClass("faq-o");
    }
  
    if (container.hasClass("expanded")) {
      container.removeClass("expanded");
    } else {
      container.addClass("expanded");
    }
  });
  
  jQuery(document).ready(function ($) {
    $('.question').each(function () {
      $(this).attr('data-search-term', $(this).text().toLowerCase() + $(this).find("ptag").text().toLowerCase());
  
    });
  
    $('.live-search-box').on('keyup', function () {
  
      var searchTerm = $(this).val().toLowerCase();
  
      $('.question').each(function () {
  
        if ($(this).filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
          $(this).parent().parent().show();
        } else {
          $(this).parent().parent().hide();
        }
  
      });
  
    });
  
  });
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  // quantity button
  
  document.addEventListener('DOMContentLoaded', function() {
    // Select all instances of the add buttons
    const allAddButtons = document.querySelectorAll('.add-button');
    
    // Loop through each add button to attach individual event listeners
    allAddButtons.forEach(function(addButton) {
        const container = addButton.closest('.food-image'); // Get the closest parent container (food-image)
        const minusButton = container.querySelector('.minus-button');
        const plusButton = container.querySelector('.plus-button');
        const quantitySpan = container.querySelector('.quantity');
  
        let quantity = 1; // Initial quantity for this specific set of buttons
  
        // Add event listener for the add button
        addButton.addEventListener('click', function() {
            // Hide the "Add" button and show the quantity controls
            addButton.style.display = 'none';
            minusButton.style.display = 'inline';
            quantitySpan.style.display = 'inline';
            plusButton.style.display = 'inline';
        });
  
        // Add event listener for the minus button
        minusButton.addEventListener('click', function() {
            if (quantity > 1) {
                quantity--;
                quantitySpan.textContent = quantity;
            } else {
                // If quantity reaches 1, revert back to "Add" button
                quantity = 1;
                addButton.style.display = 'inline';
                minusButton.style.display = 'none';
                quantitySpan.style.display = 'none';
                plusButton.style.display = 'none';
            }
        });
  
        // Add event listener for the plus button
        plusButton.addEventListener('click', function() {
            quantity++;
            quantitySpan.textContent = quantity;
        });
    });
  });
  
  
  
  
  
  
  
  
  
  
  
  
  // product add nav (down)
  
  document.addEventListener('DOMContentLoaded', function() {
    const allAddButtons = document.querySelectorAll('.add-button');
    let totalItems = 0; // Initialize total items count
    let bottomNav = null;
  
    // Function to show or update the bottom navigation bar
    function updateBottomNav() {
        if (totalItems > 0) { // Only show if there are items
            if (!bottomNav) {
                // Create and display the bottom navigation bar if it doesn't exist
                bottomNav = document.createElement('div');
                bottomNav.className = 'bottom-nav';
                document.body.appendChild(bottomNav);
            }
            bottomNav.innerHTML = `
                <span class="bottom-nav-text">${totalItems} item${totalItems > 1 ? 's' : ''} added</span>
                <button class="view-cart-button">View Cart</button>
            `;
            bottomNav.style.display = 'flex'; // Ensure it is visible and uses flexbox layout
            const viewCartButton = bottomNav.querySelector('.view-cart-button');
            viewCartButton.addEventListener('click', function() {
                // Implement your view cart logic here
                alert('Viewing cart!');
            });
        } else if (bottomNav) {
            // Hide the bottom navigation bar if there are no items
            bottomNav.style.display = 'none';
        }
    }
  
    allAddButtons.forEach(function(addButton) {
        const container = addButton.closest('.food-image');
        const minusButton = container.querySelector('.minus-button');
        const plusButton = container.querySelector('.plus-button');
        const quantitySpan = container.querySelector('.quantity');
  
        let quantity = 0; // Initial quantity for this specific set of buttons
  
        addButton.addEventListener('click', function() {
            // Hide the "Add" button and show the quantity controls
            addButton.style.display = 'none';
            minusButton.style.display = 'inline';
            quantitySpan.style.display = 'inline';
            plusButton.style.display = 'inline';
  
            // Initialize quantity if it's not set
            if (quantity === 0) {
                quantity = 1;
                quantitySpan.textContent = quantity;
            }
  
            totalItems += quantity; // Update total items count
            updateBottomNav(); // Update the bottom nav
        });
  
        minusButton.addEventListener('click', function() {
            if (quantity > 1) {
                quantity--;
                quantitySpan.textContent = quantity;
                totalItems--; // Update total items count
            } else {
                quantity = 0;
                totalItems -= 1; // Ensure correct update when removing the last item
                addButton.style.display = 'inline';
                minusButton.style.display = 'none';
                quantitySpan.style.display = 'none';
                plusButton.style.display = 'none';
            }
            updateBottomNav(); // Update the bottom nav
        });
  
        plusButton.addEventListener('click', function() {
            quantity++;
            quantitySpan.textContent = quantity;
            totalItems++; // Update total items count
            updateBottomNav(); // Update the bottom nav
        });
    });
  
    // Initialize the bottom nav based on the initial total items count
    updateBottomNav();
  });
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  