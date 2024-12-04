<?php
session_start();
include "../Database_Connection/DB_Connection.php";

// Get artist ID from session
$artistId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$errorMsg = '';
$successMsg = '';

if ($artistId) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate form inputs
        $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
        $amount = floatval($_POST['amount']); // Ensure it's a valid number

        // Validate if amount is positive, payment method is valid, and sufficient balance exists
        if ($amount > 0 && in_array($paymentMethod, ['credit_debit_card', 'nagad', 'bkash'])) {
            // Get current wallet balance
            $walletQuery = "
            SELECT balance FROM artist_wallet WHERE artist_id = ?";
            
            if ($stmt = $conn->prepare($walletQuery)) {
                $stmt->bind_param("i", $artistId);
                $stmt->execute();
                $stmt->bind_result($currentBalance);
                $stmt->fetch();
                $stmt->close();

                // Check if there is enough balance
                if ($currentBalance >= $amount) {
                    // Deduct the amount from the artist's wallet
                    $updateWalletQuery = "
                    UPDATE artist_wallet
                    SET balance = balance - ?
                    WHERE artist_id = ?";

                    if ($stmtUpdate = $conn->prepare($updateWalletQuery)) {
                        $stmtUpdate->bind_param("di", $amount, $artistId);
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
    $errorMsg = "Artist not logged in.";
}

// Redirect back to the frontend with success or error message
$_SESSION['successMsg'] = $successMsg;
$_SESSION['errorMsg'] = $errorMsg;
header("Location: Artist_dashboard.php");
exit();
?>
