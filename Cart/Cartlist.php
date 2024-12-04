<?php
// Include the database connection file
include "../Database_Connection/DB_Connection.php";

$products = [];
$errorMsg = ''; // Variable to hold error messages


// Check if 'user_id' is passed as a parameter
if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $customer_id = intval($_GET['user_id']);  // Convert user ID to integer to ensure safety

    // Prepare and execute the query to fetch the user's cart
    $cartQuery = "SELECT cart_id FROM carts WHERE customer_id = ?";
    if ($stmt = $conn->prepare($cartQuery)) {
        $stmt->bind_param("i", $customer_id);
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
    <style>
        #orderSummary {
    height: 300px;
    overflow-y: auto;
}
    </style>
</head>
<?php
include "../Header_Footer/fixed_header.php";
?>

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
    <?php
    include"../Header_Footer/footer.php";
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const selectAllCheckbox = document.getElementById("selectAll");
            const productCheckboxes =
                document.querySelectorAll(".product-checkbox");
            const subtotalElement = document.getElementById("subtotal");
            const totalElement = document.getElementById("total");
            const shippingElement = document.getElementById("shipping");

            selectAllCheckbox.addEventListener("change", function() {
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
                    button.addEventListener("click", function() {
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
                button.addEventListener("click", function() {
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
            .addEventListener("click", function() {
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
        modalBackdrop.addEventListener("click", function() {
            document.getElementById("orderSummary").classList.add("hidden");
            modalBackdrop.classList.add("hidden");
        });
    </script>
    <script>
function deleteCartItem(cartItemId) {
    fetch('../Cart/delete_cart_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'cart_item_id=' + cartItemId
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Item deleted successfully!');
            location.reload(); // Reload the page to reflect the deletion
        } else {
            alert('Error deleting item: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

</script>

</body>

</html>