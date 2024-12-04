<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shopping Cart</title>
    <link
      href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0/dist/tailwind.min.css"
      rel="stylesheet"
    />
  </head>
  <?php
  include"../Database_Connection/DB_Connection.php";
  ?>
  <body class="bg-gray-50 font-sans">
    <?php
    include"../Header_Footer/fixed_header.php";
    ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="flex flex-col lg:flex-row gap-8">
        <!-- Product List -->
        <div class="flex-1 bg-white rounded-xl shadow-lg p-4">
          <!-- Select All and Delete All -->
          <div class="flex justify-between items-center mb-6 text-gray-700">
            <label class="flex items-center space-x-2">
              <input
                type="checkbox"
                id="selectAll"
                class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500"
              />
              <span>Select All</span>
            </label>
            <button
              class="flex items-center space-x-1 text-red-500 hover:text-red-700"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 01 16.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                />
              </svg>
              <span>Delete All</span>
            </button>
          </div>

          <!-- Product Entries -->
          <div class="divide-y divide-gray-200">
            <!-- Example Product -->
            <div class="py-4 flex justify-between items-center" id="product1">
              <div class="flex items-center space-x-6">
                <input
                  type="checkbox"
                  class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 product-checkbox"
                />
                <img
                  src="https://via.placeholder.com/80?text=Product"
                  alt="Product"
                  class="w-16 h-16 object-cover rounded-md shadow-sm"
                />
                <div class="flex flex-col">
                  <span class="text-lg font-medium text-gray-900"
                    >Product Name</span
                  >
                  <span class="text-sm text-gray-500">Description...</span>
                  <span class="text-lg text-orange-500 product-price"
                    >৳300</span
                  >
                </div>
              </div>
              <div>
                <!-- Delete Button -->
                <button class="text-red-500 hover:text-red-700 p-2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="w-6 h-6"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 01 16.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                    />
                  </svg>
                </button>
              </div>
              <div class="flex items-center space-x-2">
                <!-- Quantity Control -->
                <button
                  class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded shadow hover:shadow-md transition duration-200 ease-in-out quantity-decrease"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    class="w-5 h-5"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 12h12"
                    />
                  </svg>
                </button>
                <input
                  type="text"
                  class="text-center w-12 form-input rounded-md border-gray-300 quantity-input"
                  value="1"
                  min="1"
                />
                <button
                  class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded shadow hover:shadow-md transition duration-200 ease-in-out quantity-increase"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    class="w-5 h-5"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 6v12m6-6H6"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Button to view order summary -->
        <button
          id="viewDetails"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg lg:hidden"
        >
          View Details
        </button>

        <!-- Order Summary -->
        <div
          id="orderSummary"
          class="hidden lg:block lg:w-80 bg-white rounded-xl shadow-lg p-8"
        >
          <h2 class="text-2xl font-bold mb-4">Order Summary</h2>
          <p class="text-lg mb-3">Subtotal: ৳<span id="subtotal">0</span></p>
          <p class="text-lg mb-3">
            Shipping Fee: ৳<span id="shipping">50</span>
          </p>
          <p class="text-lg mb-6">Total: ৳<span id="total">50</span></p>
          <button
            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg"
          >
            Proceed to Checkout
          </button>
        </div>

        <!-- Modal Backdrop -->
        <div
          id="modalBackdrop"
          class="hidden fixed inset-0 bg-black bg-opacity-50"
        ></div>
      </div>
    </div>
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const selectAllCheckbox = document.getElementById("selectAll");
        const productCheckboxes =
          document.querySelectorAll(".product-checkbox");
        const subtotalElement = document.getElementById("subtotal");
        const totalElement = document.getElementById("total");
        const shippingElement = document.getElementById("shipping");

        selectAllCheckbox.addEventListener("change", function () {
          productCheckboxes.forEach((checkbox) => {
            checkbox.checked = this.checked;
          });
          updateOrderSummary();
        });

        productCheckboxes.forEach((checkbox) => {
          checkbox.addEventListener("change", updateOrderSummary);
        });

        document
          .querySelectorAll(".quantity-increase, .quantity-decrease")
          .forEach((button) => {
            button.addEventListener("click", function () {
              const input = this.parentNode.querySelector(".quantity-input");
              let currentValue = parseInt(input.value);
              const isIncrement = this.classList.contains("quantity-increase");
              if (isIncrement && currentValue < 99) {
                input.value = currentValue + 1;
              } else if (!isIncrement && currentValue > 1) {
                input.value = currentValue - 1;
              }
              updateOrderSummary();
            });
          });

        document.querySelectorAll("button.text-red-500").forEach((button) => {
          button.addEventListener("click", function () {
            this.closest(".py-4.flex").remove();
            updateOrderSummary();
          });
        });

        function updateOrderSummary() {
          let subtotal = 0;
          document.querySelectorAll(".py-4.flex").forEach((product) => {
            const checkbox = product.querySelector(".product-checkbox");
            if (checkbox.checked) {
              const price = parseFloat(
                product
                  .querySelector(".product-price")
                  .textContent.replace("৳", "")
              );
              const quantity = parseInt(
                product.querySelector(".quantity-input").value
              );
              subtotal += price * quantity;
            }
          });

          const shipping = subtotal > 0 ? 50 : 0;
          const total = subtotal + shipping;

          subtotalElement.textContent = subtotal;
          shippingElement.textContent = shipping;
          totalElement.textContent = total;
        }
      });
      document
        .getElementById("viewDetails")
        .addEventListener("click", function () {
          const orderSummary = document.getElementById("orderSummary");
          const modalBackdrop = document.getElementById("modalBackdrop");

          // Toggle the visibility of the order summary and backdrop
          if (orderSummary.classList.contains("hidden")) {
            orderSummary.classList.remove("hidden");
            orderSummary.classList.add(
              "fixed",
              "inset-0",
              "z-50",
              "overflow-y-auto"
            );
            modalBackdrop.classList.remove("hidden");
          } else {
            orderSummary.classList.add("hidden");
            orderSummary.classList.remove(
              "fixed",
              "inset-0",
              "z-50",
              "overflow-y-auto"
            );
            modalBackdrop.classList.add("hidden");
          }
        });

      // Add listener to the modal backdrop to close the modal when clicked
      modalBackdrop.addEventListener("click", function () {
        document.getElementById("orderSummary").classList.add("hidden");
        modalBackdrop.classList.add("hidden");
      });
    </script>
  </body>
</html>
