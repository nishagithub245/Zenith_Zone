<?php
// Database connection
include "../Database_Connection/DB_Connection.php";

// Check if the required parameters are set
if (isset($_POST['status']) && isset($_POST['order_item_id'])) {
    $status = $_POST['status'];
    $order_item_id = $_POST['order_item_id'];

    // SQL query to update the order item status
    $sql = "UPDATE order_items SET status = ? WHERE order_item_id = ?";

    // Prepare the query
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("si", $status, $order_item_id); // 'si' -> string and integer

        // Execute the query
        if ($stmt->execute()) {
            echo "Order item status updated successfully!";
        } else {
            echo "Failed to update the status.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Failed to prepare the query.";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
