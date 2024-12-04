<?php
// session_start();
include "../Header_Footer/fixed_header.php";

// Check if all expected GET parameters are available
$userType = isset($_GET['user_type']) ? filter_input(INPUT_GET, 'user_type', FILTER_SANITIZE_STRING) : null;
$userId = isset($_GET['user_id']) ? filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT) : null;
$productId = isset($_GET['product_id']) ? filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_NUMBER_INT) : null;
$totalAmount = isset($_GET['total_amount']) ? filter_input(INPUT_GET, 'total_amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : null;
$quantity = isset($_GET['quantity']) ? filter_input(INPUT_GET, 'quantity', FILTER_SANITIZE_NUMBER_INT) : null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenithZone</title>
    <link rel="icon" href="../assets/images/logo/ZenithZone.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link
        href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css"
        rel="stylesheet" />
    <link
        href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css"
        rel="stylesheet"
        type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</head>

<body class="bg-gray-100">

    <div class="container mt-48 mb-4 sm:mt-40 mb-4  mx-auto p-6 bg-white rounded-lg shadow-lg max-w-screen-lg">
        <!-- Header Notification -->
        <div class="bg-orange-500 text-white font-semibold p-3 rounded-t-lg">
            <p>🔔 Collect payment voucher & get extra savings on your purchase!</p>
        </div>

        <!-- Select Payment Method Section -->
        <h2 class="mt-4 text-lg font-semibold">Select Payment Method</h2>
        <div class="payment-methods flex flex-wrap gap-4 mt-4">
            <!-- Credit/Debit Card Option -->
            <div class="payment-option flex-1 flex flex-col items-center p-4 bg-gray-100 rounded-lg border border-gray-300 cursor-pointer transition-transform transform hover:scale-105 hover:border-orange-500" onclick="showPaymentForm('card')">
                <img src="./Picture/JD-01-512.webp" alt="Credit/Debit Card" class="w-12 h-12 mb-2">
                <p class="text-center text-sm md:block hidden">Credit/Debit Card</p>
            </div>

            <!-- Nagad Option -->
            <div class="payment-option flex-1 flex flex-col items-center p-4 bg-gray-100 rounded-lg border border-gray-300 cursor-pointer transition-transform transform hover:scale-105 hover:border-orange-500" onclick="showPaymentForm('nagad')">
                <img src="./Picture/1679248787Nagad-Logo.webp" alt="Nagad" class="w-12 h-12 mb-2">
                <p class="text-center text-sm md:block hidden">Nagad</p>
            </div>

            <!-- bKash Option -->
            <div class="payment-option flex-1 flex flex-col items-center p-4 bg-gray-100 rounded-lg border border-gray-300 cursor-pointer transition-transform transform hover:scale-105 hover:border-orange-500" onclick="showPaymentForm('bkash')">
                <img src="./Picture/bkash.png" alt="Save bKash Account" class="w-12 h-12 mb-2">
                <p class="text-center text-sm md:block hidden">Save bKash Account</p>
            </div>

            <!-- Cash on Delivery Option -->
            <div class="payment-option flex-1 flex flex-col items-center p-4 bg-gray-100 rounded-lg border border-gray-300 cursor-pointer transition-transform transform hover:scale-105 hover:border-orange-500" onclick="showPaymentForm('cod')">
                <img src="./Picture/cash.png" alt="Cash on Delivery" class="w-12 h-12 mb-2">
                <p class="text-center text-sm md:block hidden">Cash on Delivery</p>
            </div>
        </div>

        <!-- Order Summary Section -->
        <div class="order-summary mt-6 p-4 bg-gray-50 rounded-lg text-right border">
            <p>Subtotal (<span><?= htmlspecialchars($quantity); ?></span> item and shipping fee included): ৳ <?= htmlspecialchars(number_format($totalAmount, 2)); ?></p>
            <p class="text-orange-500 font-bold text-lg">Total Amount: ৳<?= htmlspecialchars(number_format($totalAmount, 2)); ?></p>
        </div>

        <!-- Payment Forms -->
        <div id="card" class="payment-form mt-6 p-6 bg-white rounded-lg shadow-lg border hidden">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Credit/Debit Card Payment</h3>
            <div class="space-y-4">
                <div>
                    <label class="block mb-1 text-gray-600 font-medium">Card Number</label>
                    <div class="relative">
                        <input type="text" placeholder="Card number" class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <i class="fas fa-credit-card absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div>
                    <label class="block mb-1 text-gray-600 font-medium">Name on Card</label>
                    <div class="relative">
                        <input type="text" placeholder="Name on card" class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-600 font-medium">Expiry Date</label>
                        <div class="relative">
                            <input type="text" placeholder="MM/YY" class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <i class="fas fa-calendar-alt absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-600 font-medium">CVV</label>
                        <div class="relative">
                            <input type="text" placeholder="CVV" class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
            <button class="w-full mt-5 bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-lg font-semibold hover:from-orange-600 hover:to-red-600 transition">Pay Now</button>
        </div>

        <div id="nagad" class="payment-form mt-6 p-6 bg-white rounded-lg shadow-lg border hidden">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Nagad Payment</h3>
            <p class="text-gray-600 mb-4">Please ensure the following before you proceed:</p>
            <ul class="list-disc ml-5 text-sm text-gray-600 mb-4 space-y-2">
                <li>You have an activated Nagad Account</li>
                <li>You can receive an OTP on your registered Mobile Number</li>
                <li>You have sufficient balance in your account</li>
            </ul>
            <button class="w-full mt-5 bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-lg font-semibold hover:from-orange-600 hover:to-red-600 transition">Pay Now</button>
        </div>

        <div id="bkash" class="payment-form mt-6 p-6 bg-white rounded-lg shadow-lg border hidden">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">bKash Payment</h3>
            <p class="text-gray-600 mb-4">1) For first-time users, enter your bKash Wallet Number and OTP to save the account.</p>
            <p class="text-gray-600 mb-4">2) For subsequent transactions, enter your bKash PIN.</p>
            <button class="w-full mt-5 bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-lg font-semibold hover:from-orange-600 hover:to-red-600 transition">Pay Now</button>
        </div>

        <div id="cod" class="payment-form mt-6 p-6 bg-white rounded-lg shadow-lg border hidden">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Cash on Delivery</h3>
            <p class="text-gray-600 mb-4">Proceed with your order and pay cash upon delivery.</p>
            <button onclick="confirmOrder()" class="w-full mt-5 bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-lg font-semibold hover:from-orange-600 hover:to-red-600 transition">Confirm Order</button>
        </div>
    </div>

    <?php
    include "../Header_Footer/footer.php";
    ?>

    <script>
        function showPaymentForm(formId) {
            // Hide all payment forms
            const forms = document.querySelectorAll('.payment-form');
            forms.forEach(form => form.classList.add('hidden'));

            // Show the selected payment form
            document.getElementById(formId).classList.remove('hidden');
        }



        function confirmOrder() {
            var userId = <?= json_encode($userId); ?>;
            var productId = <?= json_encode($productId); ?>;
            var userType = <?= json_encode($userType); ?>;
            var quantity = <?= json_encode($quantity); ?>;
            var totalAmount = <?= json_encode($totalAmount); ?>;

            var url = 'confirm_order.php?user_id=' + encodeURIComponent(userId) +
                '&product_id=' + encodeURIComponent(productId) +
                '&user_type=' + encodeURIComponent(userType) +
                '&quantity=' + encodeURIComponent(quantity) +
                '&total_amount=' + encodeURIComponent(totalAmount);

            window.location.href = url;
        }
    </script>
</body>

</html>