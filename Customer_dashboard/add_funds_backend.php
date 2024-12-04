<?php
session_start();
include "../Database_Connection/DB_Connection.php";

// Get customer ID from session
$customerId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$errorMsg = '';
$successMsg = '';

if ($customerId) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate form inputs
        $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
        $amount = floatval($_POST['amount']); // Ensure it's a valid number

        // Validate if amount is positive and payment method is valid
        if ($amount > 0 && in_array($paymentMethod, ['credit_debit_card', 'nagad', 'bkash'])) {
            // Add the amount to the customer's wallet
            $updateWalletQuery = "
            UPDATE customer_wallet
            SET balance = balance + ?
            WHERE customer_id = ?";

            if ($stmt = $conn->prepare($updateWalletQuery)) {
                $stmt->bind_param("di", $amount, $customerId);
                if ($stmt->execute()) {
                    // Success message
                    $successMsg = "Funds added successfully!";
                } else {
                    $errorMsg = "Error updating wallet: " . $conn->error;
                }
                $stmt->close();
            } else {
                $errorMsg = "Error preparing wallet update query: " . $conn->error;
            }
        } else {
            $errorMsg = "Invalid amount or payment method.";
        }
    }
} else {
    $errorMsg = "Customer not logged in.";
}

// Redirect back to the frontend with success or error message
$_SESSION['successMsg'] = $successMsg;
$_SESSION['errorMsg'] = $errorMsg;
header("Location: Customers_dashboard.php");
exit();
?>
