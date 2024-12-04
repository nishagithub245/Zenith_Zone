<?php
session_start();
$errorMsg = isset($_SESSION['errorMsg']) ? $_SESSION['errorMsg'] : '';
$successMsg = isset($_SESSION['successMsg']) ? $_SESSION['successMsg'] : '';
unset($_SESSION['errorMsg'], $_SESSION['successMsg']); // Clear the messages after displaying
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Funds</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-50 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm mx-auto">
            <h2 class="text-2xl font-bold mb-4 text-center">Add Funds to Your Wallet</h2>

            <!-- Show success or error messages -->
            <?php if ($successMsg) { ?>
                <p class="text-green-500 text-center"><?php echo $successMsg; ?></p>
            <?php } elseif ($errorMsg) { ?>
                <p class="text-red-500 text-center"><?php echo $errorMsg; ?></p>
            <?php } ?>

            <!-- Amount Input Field -->
            <form method="POST" action="add_funds_backend.php" class="mt-6">
                <div class="mb-4">
                    <label for="amount" class="block text-gray-600 font-medium mb-2">Enter Amount</label>
                    <input type="number" name="amount" id="amount" placeholder="Enter amount to add" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                </div>

                <!-- Payment Method Selection Section -->
                <h2 class="mt-4 text-lg font-semibold">Select Payment Method</h2>
                <div class="payment-methods flex flex-wrap gap-4 mt-4">
                    <!-- Credit/Debit Card Option -->
                    <div class="payment-option flex-1 flex flex-col items-center p-4 bg-gray-100 rounded-lg border border-gray-300 cursor-pointer transition-transform transform hover:scale-105 hover:border-orange-500" onclick="showPaymentForm('card')">
                        <img src="../Buy/Picture/JD-01-512.webp" alt="Credit/Debit Card" class="w-12 h-12 mb-2">
                        <p class="text-center text-sm md:block hidden">Credit/Debit Card</p>
                    </div>

                    <!-- Nagad Option -->
                    <div class="payment-option flex-1 flex flex-col items-center p-4 bg-gray-100 rounded-lg border border-gray-300 cursor-pointer transition-transform transform hover:scale-105 hover:border-orange-500" onclick="showPaymentForm('nagad')">
                        <img src="../Buy/Picture/1679248787Nagad-Logo.webp" alt="Nagad" class="w-12 h-12 mb-2">
                        <p class="text-center text-sm md:block hidden">Nagad</p>
                    </div>

                    <!-- bKash Option -->
                    <div class="payment-option flex-1 flex flex-col items-center p-4 bg-gray-100 rounded-lg border border-gray-300 cursor-pointer transition-transform transform hover:scale-105 hover:border-orange-500" onclick="showPaymentForm('bkash')">
                        <img src="../Buy/Picture/bkash.png" alt="Save bKash Account" class="w-12 h-12 mb-2">
                        <p class="text-center text-sm md:block hidden">bKash</p>
                    </div>
                </div>

                <!-- Hidden input for payment method -->
                <input type="hidden" name="payment_method" id="payment_method" value="">

                <!-- Payment Forms -->
                <div id="card" class="payment-form mt-6 p-6 bg-white rounded-lg shadow-lg border hidden">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Credit/Debit Card Payment</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block mb-1 text-gray-600 font-medium">Card Number</label>
                            <div class="relative">
                                <input type="text" name="card_number" placeholder="Card number" class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <i class="fas fa-credit-card absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-600 font-medium">Name on Card</label>
                            <div class="relative">
                                <input type="text" name="card_name" placeholder="Name on card" class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">Expiry Date</label>
                                <div class="relative">
                                    <input type="text" name="expiry_date" placeholder="MM/YY" class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <i class="fas fa-calendar-alt absolute left-3 top-3 text-gray-400"></i>
                                </div>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-600 font-medium">CVV</label>
                                <div class="relative">
                                    <input type="text" name="cvv" placeholder="CVV" class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="nagad" class="payment-form mt-6 p-6 bg-white rounded-lg shadow-lg border hidden">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Nagad Payment</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block mb-1 text-gray-600 font-medium">Enter Mobile Number</label>
                            <input type="text" name="nagad_number" placeholder="Mobile number" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>
                </div>

                <div id="bkash" class="payment-form mt-6 p-6 bg-white rounded-lg shadow-lg border hidden">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">bKash Payment</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block mb-1 text-gray-600 font-medium">Enter bKash Account Number</label>
                            <input type="text" name="bkash_number" placeholder="bKash number" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="mt-2 w-full text-center py-3 px-6 rounded-lg bg-gradient-to-r from-teal-400 to-teal-600 text-black border-2 border-teal-600 hover:bg-gradient-to-l hover:from-teal-600 hover:to-teal-400 hover:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500 flex items-center justify-center transition-all duration-300 ease-in-out">
                        <i class="fas fa-plus-circle mr-2"></i> Add Funds
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showPaymentForm(paymentType) {
            document.getElementById('card').classList.add('hidden');
            document.getElementById('nagad').classList.add('hidden');
            document.getElementById('bkash').classList.add('hidden');
            document.getElementById(paymentType).classList.remove('hidden');
            document.getElementById('payment_method').value = paymentType;
        }
    </script>
</body>

</html>