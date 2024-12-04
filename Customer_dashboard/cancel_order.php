<?php
session_start();
// Include the database connection file
include "../Database_Connection/DB_Connection.php";

$orderItemId = isset($_GET['order_item_id']) ? $_GET['order_item_id'] : null;
$errorMsg = ''; // Variable to hold error messages
$successMsg = ''; // Variable to hold success messages

// If order_item_id is provided
if ($orderItemId) {
    // Handle the order cancellation
    $updateQuery = "UPDATE order_items SET status = 'Canceled' WHERE order_item_id = ?";

    if ($updateStmt = $conn->prepare($updateQuery)) {
        $updateStmt->bind_param("i", $orderItemId);
        if ($updateStmt->execute()) {
            $successMsg = "Your order has been canceled successfully.";
        } else {
            $errorMsg = "Error updating the order status.";
        }
        $updateStmt->close();
    } else {
        $errorMsg = "Error preparing the cancel query: " . $conn->error;
    }
} else {
    $errorMsg = "No order item ID provided.";
}

// Redirect back to the referring page with success or error message
$redirectURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'order_details.php';  // Default to 'order_details.php' if no referer

header("Location: $redirectURL?order_item_id=$orderItemId&" . 
       ($successMsg ? "successMsg=" . urlencode($successMsg) : "errorMsg=" . urlencode($errorMsg)));
exit;
?>