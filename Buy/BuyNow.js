function updateOrderSummary() {
    var quantityInput = document.getElementById('quantityInput'); // Ensure this input is correctly referenced in your HTML
    var pricePerItem = <?= $product['New_price']; ?>;
    var quantity = quantityInput ? parseInt(quantityInput.value) : <?= $quantity ?>;
    var itemTotal = quantity * pricePerItem;
    var deliveryFee = parseInt(document.getElementById('delivery-fee').innerText.replace('৳ ', ''));
    var total = itemTotal + deliveryFee;

    document.getElementById('itemTotal').innerText = `৳ ${itemTotal.toFixed(2)}`;
    document.getElementById('order-summary-total').innerText = `৳ ${total.toFixed(2)}`;
  }

  document.addEventListener('DOMContentLoaded', function() {
    updateOrderSummary(); // Initial update on page load
    document.getElementById('quantityInput').addEventListener('change', updateOrderSummary); // Update on quantity change
  });

  // Function to handle pickup point selection
  function selectPickupPoint(point) {
    document.getElementById("address-type").classList.replace("bg-red-500", "bg-blue-500");
    document.getElementById("address-icon").className = "fas fa-map-marker-alt mr-2";
    document.getElementById("address-type").innerHTML = `<i class="fas fa-map-marker-alt mr-2"></i> Pick-up`;
    const deliveryFee = 40; // Set the new delivery fee for pickup
    document.getElementById('delivery-fee').innerText = `৳ ${deliveryFee}`;
    document.getElementById('delivery-fees').innerText = `৳ ${deliveryFee}`;
    updateOrderSummary(); // Update the order summary to reflect new fee
  }

  function toggleDropdown() {
    document.getElementById("pickup-dropdown").classList.toggle("hidden");
  }

  document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const endDate = new Date();
    endDate.setDate(today.getDate() + 4);

    function formatDate(date) {
      const options = {
        day: '2-digit',
        month: 'short'
      };
      return new Intl.DateTimeFormat('en-US', options).format(date);
    }

    const deliveryDateText = `Guaranteed by ${formatDate(today)} - ${formatDate(endDate)}`;
    document.getElementById('guaranteed-delivery-date').textContent = deliveryDateText;
  });