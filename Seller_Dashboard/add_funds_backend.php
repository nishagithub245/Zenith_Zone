<?php
session_start();
include "../Database_Connection/DB_Connection.php";

// Get seller ID from session
$sellerId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$errorMsg = '';
$successMsg = '';

if ($sellerId) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate form inputs
        $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
        $amount = floatval($_POST['amount']); // Ensure it's a valid number

        // Validate if amount is positive, payment method is valid, and sufficient balance exists
        if ($amount > 0 && in_array($paymentMethod, ['credit_debit_card', 'nagad', 'bkash'])) {
            // Get current wallet balance
            $walletQuery = "
            SELECT balance FROM seller_wallet WHERE seller_id = ?";
            
            if ($stmt = $conn->prepare($walletQuery)) {
                $stmt->bind_param("i", $sellerId);
                $stmt->execute();
                $stmt->bind_result($currentBalance);
                $stmt->fetch();
                $stmt->close();

                // Check if there is enough balance
                if ($currentBalance >= $amount) {
                    // Deduct the amount from the seller's wallet
                    $updateWalletQuery = "
                    UPDATE seller_wallet
                    SET balance = balance - ?
                    WHERE seller_id = ?";

                    if ($stmtUpdate = $conn->prepare($updateWalletQuery)) {
                        $stmtUpdate->bind_param("di", $amount, $sellerId);
                        if ($stmtUpdate->execute()) {
                            // Success message
                            $successMsg = "Withdrawal successful! Amount withdrawn: ৳" . number_format($amount, 2);
                        } else {
                            $errorMsg = "Error updating wallet: " . $conn->error;
                        }
                        $stmtUpdate->close();
                    } else {
                        $errorMsg = "Error preparing wallet update query: " . $conn->error;
                    }
                } else {
                    $errorMsg = "Insufficient balance for withdrawal.";
                }
            } else {
                $errorMsg = "Error preparing wallet balance query: " . $conn->error;
            }
        } else {
            $errorMsg = "Invalid amount, payment method, or insufficient balance.";
        }
    }
} else {
    $errorMsg = "Seller not logged in.";
}

// Redirect back to the frontend with success or error message
$_SESSION['successMsg'] = $successMsg;
$_SESSION['errorMsg'] = $errorMsg;
header("Location: Seller_dashboard.php");
exit();
?>
