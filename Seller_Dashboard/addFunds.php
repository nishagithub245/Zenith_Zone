<?php
session_start();
include "../Database_Connection/DB_Connection.php";

$response = [
    'success' => false,
    'message' => ''
];

$customerId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($customerId) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $paymentMethod = $_POST['payment_method'];
        $amount = floatval($_POST['amount']); // Ensure it's a valid number

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
                    $response['success'] = true;
                    $response['message'] = "Funds added successfully!";
                } else {
                    $response['message'] = "Error updating wallet: " . $conn->error;
                }
                $stmt->close();
            } else {
                $response['message'] = "Error preparing wallet update query: " . $conn->error;
            }
        } else {
            $response['message'] = "Invalid amount or payment method.";
        }
    }
} else {
    $response['message'] = "Customer not logged in.";
}

echo json_encode($response);
?>
