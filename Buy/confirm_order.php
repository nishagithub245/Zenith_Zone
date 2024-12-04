<?php
// Include the database connection file
include "../Database_Connection/DB_Connection.php"; // Make sure the path is correct
$response = array('message' => 'Your order has been placed successfully!');

if (isset($_GET['user_id'], $_GET['product_id'], $_GET['quantity'], $_GET['total_amount'])) {
    $userId = $_GET['user_id'];
    $productId = $_GET['product_id'];
    $quantity = $_GET['quantity'];
    $totalAmount = $_GET['total_amount'];

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
        $insertOrderQuery = "INSERT INTO orders (customer_id) VALUES (?)";
        $insertStmt = $conn->prepare($insertOrderQuery);
        if ($insertStmt === false) {
            die("Error preparing order insertion statement: " . $conn->error);
        }
        $insertStmt->bind_param("i", $userId); // Bind the customer_id
        $insertStmt->execute();

        $orderId = $insertStmt->insert_id;
    } else {
        $orderData = $result->fetch_assoc();
        $orderId = $orderData['order_id'];
    }

    // Insert a new row for the same product in order_items, even if the product already exists
    $insertOrderItemQuery = "INSERT INTO order_items (order_id, product_id, quantity, order_amount, created_at, status) 
                             VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, 'Pending')";
    $orderItemStmt = $conn->prepare($insertOrderItemQuery);
    if ($orderItemStmt === false) {
        die("Error preparing order item insertion statement: " . $conn->error);
    }
    $orderItemStmt->bind_param("iiid", $orderId, $productId, $quantity, $totalAmount);
    $orderItemStmt->execute();

    if ($orderItemStmt->affected_rows > 0) {
        $_SESSION['message'] = "Your Order has been placed successfully!";
        $showModal = true;
    } else {
        $_SESSION['message'] = "Error adding order item: " . $conn->error;
        $showModal = true;
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
}
