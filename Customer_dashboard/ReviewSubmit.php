<?php
// ReviewSubmit.php

session_start();
include "../Database_Connection/DB_Connection.php";

$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderItemId = isset($_POST['order_item_id']) ? $_POST['order_item_id'] : null;
    $reviewDescription = isset($_POST['review_description']) ? $_POST['review_description'] : '';
    $rating = isset($_POST['rating']) ? $_POST['rating'] : 0;

    if ($orderItemId) {
        // Retrieve order details based on order_item_id
        $orderQuery = "SELECT oi.order_id, oi.product_id, o.customer_id
                       FROM order_items oi
                       JOIN orders o ON oi.order_id = o.order_id
                       WHERE oi.order_item_id = ?";

        if ($stmt = $conn->prepare($orderQuery)) {
            $stmt->bind_param("i", $orderItemId);
            $stmt->execute();
            $orderResult = $stmt->get_result();

            if ($orderResult->num_rows > 0) {
                // Get order details (customer_id and product_id)
                $orderData = $orderResult->fetch_assoc();
                $customerId = $orderData['customer_id'];
                $productId = $orderData['product_id'];

                // Validate the input
                if (empty($reviewDescription) || $rating == 0) {
                    $errorMsg = "Please provide a review description and a rating.";
                } else {
                    // Insert the review into the review table
                    $insertQuery = "INSERT INTO review (customer_id, product_id, review_description, rating)
                                    VALUES (?, ?, ?, ?)";

                    if ($insertStmt = $conn->prepare($insertQuery)) {
                        $insertStmt->bind_param("iisi", $customerId, $productId, $reviewDescription, $rating);
                        if ($insertStmt->execute()) {
                            $successMsg = "Thank you for your feedback!";
                        } else {
                            $errorMsg = "Error submitting the review: " . $conn->error;
                        }
                        $insertStmt->close();
                    } else {
                        $errorMsg = "Error preparing insert query: " . $conn->error;
                    }
                }
            } else {
                $errorMsg = "Order item not found.";
            }
            $stmt->close();
        } else {
            $errorMsg = "Error preparing order query: " . $conn->error;
        }
    } else {
        $errorMsg = "Invalid order item ID.";
    }

    // Respond with JSON
    if ($errorMsg) {
        echo json_encode(['status' => 'error', 'message' => $errorMsg]);
    } else {
        echo json_encode(['status' => 'success', 'message' => $successMsg]);
    }
}
?>
