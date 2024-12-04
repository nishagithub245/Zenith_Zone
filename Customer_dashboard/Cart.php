<?php
session_start();
// Include the database connection file
include "../Database_Connection/DB_Connection.php";

$products = [];
$errorMsg = ''; // Variable to hold error messages

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($userId) { // Check if the user is logged in

    // Prepare and execute the query to fetch the user's cart
    $cartQuery = "SELECT cart_id FROM carts WHERE customer_id = ?";
    if ($stmt = $conn->prepare($cartQuery)) {
        $stmt->bind_param("i", $userId);  // Bind the user ID to the query
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the cart ID
            $row = $result->fetch_assoc();
            $cart_id = $row['cart_id'];

            // Prepare and execute the query to fetch cart items from the product_info table using the cart ID
            $itemsQuery = "SELECT ci.cart_item_id, ci.product_id AS Product_id, pi.Product_name, pi.Product_Description, pi.New_price, pi.Product_image_path
               FROM cart_items ci
               JOIN product_info pi ON ci.product_id = pi.Product_id
               WHERE ci.cart_id = ?";

            if ($itemsStmt = $conn->prepare($itemsQuery)) {
                $itemsStmt->bind_param("i", $cart_id);
                $itemsStmt->execute();
                $itemsResult = $itemsStmt->get_result();

                if ($itemsResult->num_rows > 0) {
                    while ($product = $itemsResult->fetch_assoc()) {
                        $products[] = $product;  // Store each product data in array
                    }
                } else {
                    $errorMsg = "No products in your cart.";
                }
                $itemsStmt->close();
            }
        } else {
            $errorMsg = "No cart found for this user.";
        }
        $stmt->close();
    }
} else {
    $errorMsg = "User ID not provided.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        #orderSummary {
            height: 300px;
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-50 mt-36 font-sans">
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
                            class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" />
                        <span>Select All</span>
                    </label>
                    <button
                        class="flex items-center space-x-1 text-red-500 hover:text-red-700">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            class="w-6 h-6">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 01 16.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Delete All</span>
                    </button>
                </div>

                <!-- Product Entries -->
                <?php
                echo '<style>
                .product-container {
                  max-height: 500px; /* Adjust based on your UI requirements */
                  overflow-y: auto;
                }
                </style>';
                // Ensure $products array and $errorMsg are properly initialized and accessible here
                if (!empty($products)) {
                    echo '<div class="product-container">';
                    foreach ($products as $product) {
                        // Using heredoc syntax properly
                        echo <<<HTML
        <div class="py-4 flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 product-checkbox"/>
                <a href="../Products/Product_view.php?product_id={$product['Product_id']}">
    <img src="{$product['Product_image_path']}" alt="{$product['Product_name']}" class="w-16 h-16 object-cover rounded-md shadow-sm"/>
</a>

                <div class="flex flex-col">
                <a href="../Products/Product_view.php?product_id={$product['Product_id']}">
<span class="text-lg font-medium text-gray-900">{$product['Product_name']}
</span>
</a>

                    <!-- <span class="text-sm text-gray-500">{$product['Product_Description']}</span> -->
                    <span class="text-lg text-orange-500 product-price">৳{$product['New_price']}</span>
                </div>
            </div>
            <button class="text-red-500 hover:text-red-700 p-2" onclick="deleteCartItem({$product['cart_item_id']})">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M19 7l-.867 12.142A2 2 0 01 16.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
    </button>
            <div class="flex items-center space-x-2">
                <button class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded shadow hover:shadow-md transition duration-200 ease-in-out quantity-decrease">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h12"></path>
                    </svg>
                </button>
                <input type="text" class="text-center w-12 form-input rounded-md border-gray-300 quantity-input" value="1" min="1"/>
                <button class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded shadow hover:shadow-md transition duration-200 ease-in-out quantity-increase">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"></path>
                    </svg>
                </button>
            </div>
        </div>
HTML;
                    }
                    echo '</div>';
                } else {
                    echo "<p>$errorMsg</p>";
                }
                ?>

            </div>

            <!-- Button to view order summary -->
            <button
                id="viewDetails"
                class="w-full mb-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg lg:hidden">
                View Details
            </button>

            <!-- Order Summary -->
            <div
                id="orderSummary"
                class="hidden lg:block lg:w-80 bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-4">Order Summary</h2>
                <p class="text-lg mb-3">Subtotal: ৳<span id="subtotal">0</span></p>
                <p class="text-lg mb-3">
                    Shipping Fee: ৳<span id="shipping">50</span>
                </p>
                <p class="text-lg mb-6">Total: ৳<span id="total">50</span></p>
                <button
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg">
                    Proceed to Checkout
                </button>
            </div>

            <!-- Modal Backdrop -->
            <div
                id="modalBackdrop"
                class="hidden fixed inset-0 bg-black bg-opacity-50"></div>
        </div>
    </div>

    <!-- Place this script right before the closing </body> tag -->
    <script>
        const selectAllCheckbox = document.getElementById("selectAll");
        const productCheckboxes = document.querySelectorAll(".product-checkbox");
        const quantityInputs = document.querySelectorAll(".quantity-input");
        const subtotalElement = document.getElementById("subtotal");
        const totalElement = document.getElementById("total");
        const shippingElement = document.getElementById("shipping");

        // Select all checkbox behavior
        selectAllCheckbox.addEventListener("change", function() {
            productCheckboxes.forEach((checkbox) => {
                checkbox.checked = this.checked;
            });
            updateOrderSummary(); // Update summary when all checkboxes are toggled
        });

        // Add change event listener to individual product checkboxes
        productCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", updateOrderSummary);
        });

        // Increase and Decrease button logic
        document.querySelectorAll(".quantity-increase, .quantity-decrease").forEach((button) => {
            button.addEventListener("click", function() {
                const input = this.closest(".py-4").querySelector(".quantity-input"); // Find the input field in the current product row
                let currentValue = parseInt(input.value);
                const isIncrement = this.classList.contains("quantity-increase");

                // Increment or decrement the value
                if (isIncrement && currentValue < 99) {
                    input.value = currentValue + 1;
                } else if (!isIncrement && currentValue > 1) {
                    input.value = currentValue - 1;
                }

                updateOrderSummary(); // Update the order summary after changing the quantity
            });
        });

        // Remove cart item
        document.querySelectorAll("button.text-red-500").forEach((button) => {
            button.addEventListener("click", function() {
                this.closest(".py-4").remove(); // Remove the product row
                updateOrderSummary(); // Update the order summary after removal
            });
        });

        // Update order summary based on selected items and quantities
        function updateOrderSummary() {
            let subtotal = 0;
            let hasSelectedItems = false;

            document.querySelectorAll(".py-4.flex").forEach((product) => {
                const checkbox = product.querySelector(".product-checkbox");
                if (checkbox.checked) {
                    hasSelectedItems = true; // Flag to check if any item is selected
                    const price = parseFloat(product.querySelector(".product-price").textContent.replace("৳", ""));
                    const quantity = parseInt(product.querySelector(".quantity-input").value);
                    subtotal += price * quantity; // Add price * quantity to subtotal
                }
            });

            const shipping = hasSelectedItems ? 50 : 0; // Set shipping fee if there are selected items
            const total = subtotal + shipping; // Total = subtotal + shipping

            // Update the DOM elements with calculated values
            subtotalElement.textContent = subtotal.toFixed(2);
            shippingElement.textContent = shipping;
            totalElement.textContent = total.toFixed(2);
        }

        // Initialize order summary on page load
        updateOrderSummary();

        // Add listener to the modal backdrop to close the modal when clicked
        const modalBackdrop = document.getElementById("modalBackdrop");
        if (modalBackdrop) {
            modalBackdrop.addEventListener("click", function() {
                document.getElementById("orderSummary").classList.add("hidden");
                modalBackdrop.classList.add("hidden");
            });
        }

        function deleteCartItem(cartItemId) {
            fetch('./delete_cart_item.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'cart_item_id=' + cartItemId // Send the cart_item_id
                })
                .then(response => response.json()) // Parse the JSON response
                .then(data => {
                    if (data.status === 'success') {
                        alert('Item deleted successfully!');
                        location.reload(); // Reload the page to reflect the deletion
                    } else {
                        alert('Error deleting item: ' + data.message); // Display error message
                    }
                })
                .catch(error => {
                    console.error('Error:', error); // Log any fetch errors
                });
        }
    </script>


</body>

</html>