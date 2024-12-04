<?php
include "../Database_Connection/DB_Connection.php";

$response = ['status' => 'error', 'message' => 'Unknown error.'];

if (isset($_POST['cart_item_id'])) {
    $cart_item_id = intval($_POST['cart_item_id']);

    // Prepare the SQL query to delete the cart item
    $deleteQuery = "DELETE FROM cart_items WHERE cart_item_id = ?";

    if ($stmt = $conn->prepare($deleteQuery)) {
        $stmt->bind_param("i", $cart_item_id);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Item deleted successfully!';
        } else {
            $response['message'] = 'Failed to delete item.';
        }

        $stmt->close();
    } else {
        $response['message'] = 'Database query failed.';
    }
} else {
    $response['message'] = 'Cart item ID not provided.';
}

echo json_encode($response);
?>