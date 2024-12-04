<?php
session_start();
// Include the database connection file
include "../Database_Connection/DB_Connection.php";

// Initialize variables
$errorMsg = '';
$artDetails = [];

// Check if 'art_id' is provided in the URL
if (isset($_GET['art_id']) && !empty($_GET['art_id'])) {
    $artId = intval($_GET['art_id']);  // Sanitize the input to prevent SQL injection

    // Query to fetch art details
    $artQuery = "SELECT art_name, art_description, art_img, final_bid_price
                 FROM art_gallery
                 WHERE art_id = ? AND bid_status = 'closed'"; // Only show closed bid art
    if ($stmt = $conn->prepare($artQuery)) {
        $stmt->bind_param("i", $artId);  // Bind the art ID to the query
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the art exists
        if ($result->num_rows > 0) {
            $artDetails = $result->fetch_assoc();
        } else {
            $errorMsg = "Art piece not found or the bid is still active.";
        }
        $stmt->close();
    } else {
        $errorMsg = "Error preparing the query: " . $conn->error;
    }
} else {
    $errorMsg = "Art ID not provided.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the payment method
    $paymentMethod = $_POST['payment_method'];

    // Handle payment and order placement logic
    $orderStatus = '';
    if ($paymentMethod == 'wallet') {
        // Assuming there's a wallet balance check and deduction
        $walletBalance = getWalletBalance($_SESSION['user_id']);  // Custom function to get the wallet balance
        if ($walletBalance >= $artDetails['final_bid_price']) {
            // Deduct from wallet and place order
            $orderStatus = placeOrder($artId, $_SESSION['user_id'], $paymentMethod);
            deductFromWallet($_SESSION['user_id'], $artDetails['final_bid_price']);
            
            // Add to order_items table
            $orderId = getLastOrderId();  // Get the last inserted order ID
            addOrderItem($orderId, $artId, 1, $artDetails['final_bid_price']);  // Add the item to order_items
        } else {
            $errorMsg = "Insufficient wallet balance.";
        }
    } else {
        // Handle other payment methods (Card, Nagad, bKash)
        $orderStatus = placeOrder($artId, $_SESSION['user_id'], $paymentMethod);
        
        // Get the last order ID and add the item to order_items
        if ($orderStatus === 'success') {
            $orderId = getLastOrderId();  // Get the last inserted order ID
            addOrderItem($orderId, $artId, 1, $artDetails['final_bid_price']);  // Add the item to order_items
        }
    }

    if ($orderStatus === 'success') {
        header("Location: order_confirmation.php");  // Redirect to order confirmation page
        exit;
    } else {
        $errorMsg = "Order placement failed. Please try again.";
    }
}

// Helper function for placing order (simplified)
function placeOrder($artId, $userId, $paymentMethod) {
    global $conn;
    $orderQuery = "INSERT INTO orders (customer_id, payment_method, order_date)
                   VALUES (?, ?, NOW())";
    if ($stmt = $conn->prepare($orderQuery)) {
        $stmt->bind_param("is", $userId, $paymentMethod);
        $stmt->execute();
        return 'success';
    }
    return 'failure';
}

// Helper function for getting the last order ID
function getLastOrderId() {
    global $conn;
    $query = "SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1";
    if ($stmt = $conn->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($orderId);
        $stmt->fetch();
        return $orderId;
    }
    return 0;
}

// Helper function for adding an item to order_items table
function addOrderItem($orderId, $artId, $quantity, $orderAmount) {
    global $conn;
    $query = "INSERT INTO order_items (order_id, product_id, quantity, order_amount, art_id)
              VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("iiidi", $orderId, $artId, $quantity, $orderAmount, $artId);
        $stmt->execute();
    }
}

// Helper function for getting wallet balance
function getWalletBalance($userId) {
    global $conn;
    $query = "SELECT balance FROM customer_wallet WHERE customer_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($balance);
        $stmt->fetch();
        return $balance;
    }
    return 0;
}

// Helper function for deducting from wallet
function deductFromWallet($userId, $amount) {
    global $conn;
    $query = "UPDATE customer_wallet SET balance = balance - ? WHERE customer_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("di", $amount, $userId);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">
    <form method="POST" action="" id="paymentForm">
    <div class="max-w-7xl mx-auto">
        <div class="gap-8 mt-8">
            <!-- Art Details -->
            <div class="flex-1 bg-white rounded-xl shadow-lg p-4">
                <h2 class="text-2xl font-bold mb-6 text-center">Art Details</h2>

                <?php if (!empty($artDetails)) : ?>
                    <div class="flex justify-center mb-6">
                        <img src="../Art/<?= htmlspecialchars($artDetails['art_img']); ?>" alt="<?= htmlspecialchars($artDetails['art_name']); ?>" class="w-64 h-64 object-cover rounded-md shadow-sm">
                    </div>
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-medium"><?= htmlspecialchars($artDetails['art_name']); ?></h3>
                        <p class="text-sm text-gray-500"><?= htmlspecialchars($artDetails['art_description']); ?></p>
                        <p class="text-lg font-bold text-orange-500 mt-4">Price: ৳<?= number_format($artDetails['final_bid_price'], 2); ?></p>
                    </div>
                    
                    <!-- Make Payment Button -->
                    <button class="mt-6 px-8 py-2 bg-orange-500 text-white rounded-lg" type="button" onclick="showPaymentOptions()">Make Payment</button>

                    <!-- Payment Method Selection Section (Hidden initially) -->
                    <div id="paymentOptions" class="hidden mt-6">
                        <h2 class="mt-4 text-lg font-semibold">Select Payment Method</h2>
                        <div class="payment-methods flex flex-wrap gap-4 mt-4">
                            <div class="payment-option flex-1 flex flex-col items-center p-4 bg-gray-100 rounded-lg border border-gray-300 cursor-pointer transition-transform transform hover:scale-105 hover:border-orange-500" onclick="showPaymentForm('card')">
                                <img src="../Buy/Picture/JD-01-512.webp" alt="Credit/Debit Card" class="w-12 h-12 mb-2">
                                <p class="text-center text-sm md:block hidden">Credit/Debit Card</p>
                            </div>
                            <div class="payment-option flex-1 flex flex-col items-center p-4 bg-gray-100 rounded-lg border border-gray-300 cursor-pointer transition-transform transform hover:scale-105 hover:border-orange-500" onclick="showPaymentForm('nagad')">
                                <img src="../Buy/Picture/1679248787Nagad-Logo.webp" alt="Nagad" class="w-12 h-12 mb-2">
                                <p class="text-center text-sm md:block hidden">Nagad</p>
                            </div>
                            <div class="payment-option flex-1 flex flex-col items-center p-4 bg-gray-100 rounded-lg border border-gray-300 cursor-pointer transition-transform transform hover:scale-105 hover:border-orange-500" onclick="showPaymentForm('bkash')">
                                <img src="../Buy/Picture/bkash-logo-1.png" alt="bKash" class="w-12 h-12 mb-2">
                                <p class="text-center text-sm md:block hidden">bKash</p>
                            </div>
                            <div class="payment-option flex-1 flex flex-col items-center p-4 bg-gray-100 rounded-lg border border-gray-300 cursor-pointer transition-transform transform hover:scale-105 hover:border-orange-500" onclick="showPaymentForm('wallet')">
                                <i class="fa fa-wallet text-4xl text-orange-500"></i>
                                <p class="text-center text-sm">Wallet</p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-center text-red-500"><?= $errorMsg; ?></p>
                <?php endif; ?>
            </div>

            <!-- Payment Form -->
            <div id="paymentFormContainer" class="flex-1 bg-white rounded-xl shadow-lg p-8">
                <div id="walletPaymentForm" class="hidden">
                    <h3 class="text-xl font-medium mb-4">Wallet Payment</h3>
                    <div class="text-lg text-gray-700 mb-4">Your Wallet Balance: ৳<?= number_format(getWalletBalance($_SESSION['user_id']), 2); ?></div>
                    <button type="submit" name="payment_method" value="wallet" class="px-6 py-2 bg-green-500 text-white rounded-lg w-full">Pay with Wallet</button>
                </div>
                
                <div id="cardPaymentForm" class="hidden">
                    <h3 class="text-xl font-medium mb-4">Credit/Debit Card Payment</h3>
                    <button type="submit" name="payment_method" value="card" class="px-6 py-2 bg-green-500 text-white rounded-lg w-full">Pay with Card</button>
                </div>

                <div id="nagadPaymentForm" class="hidden">
                    <h3 class="text-xl font-medium mb-4">Nagad Payment</h3>
                    <button type="submit" name="payment_method" value="nagad" class="px-6 py-2 bg-green-500 text-white rounded-lg w-full">Pay with Nagad</button>
                </div>

                <div id="bkashPaymentForm" class="hidden">
                    <h3 class="text-xl font-medium mb-4">bKash Payment</h3>
                    <button type="submit" name="payment_method" value="bkash" class="px-6 py-2 bg-green-500 text-white rounded-lg w-full">Pay with bKash</button>
                </div>
            </div>
        </div>
    </div>
    </form>

    <script>
        function showPaymentOptions() {
            document.getElementById('paymentOptions').classList.remove('hidden');
        }

        function showPaymentForm(paymentMethod) {
            // Hide all payment forms
            const paymentForms = ['walletPaymentForm', 'cardPaymentForm', 'nagadPaymentForm', 'bkashPaymentForm'];
            paymentForms.forEach(form => document.getElementById(form).classList.add('hidden'));

            // Show the selected payment form
            document.getElementById(paymentMethod + 'PaymentForm').classList.remove('hidden');
        }
    </script>
</body>
</html>
