<?php
// Start the session
session_start();

// Include the database connection file
include "../Database_Connection/DB_Connection.php"; // Make sure the path is correct
$response = array('message' => 'Your order has been placed successfully!');

// Check if all required GET parameters are set
if (isset($_GET['user_id'], $_GET['product_id'], $_GET['quantity'], $_GET['total_amount'])) {
    // Sanitize GET parameters
    $userId = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $productId = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_NUMBER_INT);
    $quantity = filter_input(INPUT_GET, 'quantity', FILTER_SANITIZE_NUMBER_INT);
    $totalAmount = filter_input(INPUT_GET, 'total_amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Check if customer (user_id) exists in the orders table
    $query = "SELECT order_id FROM orders WHERE customer_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $userId); // Bind the customer_id to the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // If no order exists for this user, create a new order
        $insertOrderQuery = "INSERT INTO orders (customer_id) VALUES (?)";
        $insertStmt = $conn->prepare($insertOrderQuery);
        if ($insertStmt === false) {
            die("Error preparing order insertion statement: " . $conn->error);
        }
        $insertStmt->bind_param("i", $userId); // Bind the customer_id
        $insertStmt->execute();

        // Get the newly created order_id
        $orderId = $insertStmt->insert_id;
    } else {
        // If the user already has an order, use the existing order_id
        $orderData = $result->fetch_assoc();
        $orderId = $orderData['order_id'];
    }

    // Insert a new row for the same product in order_items
    $insertOrderItemQuery = "INSERT INTO order_items (order_id, Sh_product_id, quantity, order_amount, created_at, status) 
                             VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, 'Pending')";
    $orderItemStmt = $conn->prepare($insertOrderItemQuery);
    if ($orderItemStmt === false) {
        die("Error preparing order item insertion statement: " . $conn->error);
    }
    $orderItemStmt->bind_param("iiid", $orderId, $productId, $quantity, $totalAmount);
    $orderItemStmt->execute();

    if ($orderItemStmt->affected_rows > 0) {
        // If the order item was successfully inserted
        $_SESSION['message'] = "Your Order has been placed successfully!";
        // JavaScript to redirect to the parent page (previous page)
        echo '<script type="text/javascript">
                window.history.back();
              </script>';
        exit(); // Exit after redirect
    } else {
        // If there was an error inserting the order item
        $_SESSION['message'] = "Error adding order item: " . $conn->error;
        echo '<script type="text/javascript">
        window.history.back();
      </script>';
        exit();
    }

    // Close the prepared statements and database connection
    $stmt->close();
    if (isset($insertStmt)) {
        $insertStmt->close(); // Close only if initialized
    }
    if (isset($orderItemStmt)) {
        $orderItemStmt->close(); // Close only if initialized
    }
    $conn->close();
} else {
    // If required parameters are missing, output an error message
    die("Required parameters are missing.");
}
