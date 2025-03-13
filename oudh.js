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
























// add button

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

      // Set button color to #ff8c00 using inline styles
      addButton.style.backgroundColor = '#ff8c00';
      minusButton.style.backgroundColor = '#ff8c00';
      plusButton.style.backgroundColor = '#ff8c00';

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















