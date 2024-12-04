<?php
session_start();
// Include the database connection file
include "../Database_Connection/DB_Connection.php";

$orders = [];
$errorMsg = ''; // Variable to hold error messages

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if ($userId) { // Check if the user is logged in

    $ordersQuery = "SELECT order_id FROM orders WHERE customer_id = ?";
    if ($stmt = $conn->prepare($ordersQuery)) {
        $stmt->bind_param("i", $userId);  // Bind the user ID to the query
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Fetch all orders for this user
            while ($order = $result->fetch_assoc()) {
                $orderId = $order['order_id'];
                // Fetch the items for each order from the order_items table
                $itemsQuery = "SELECT oi.order_item_id, pi.Product_name, pi.Product_image_path, oi.quantity, oi.order_amount, oi.status
                               FROM order_items oi
                               JOIN product_info pi ON oi.product_id = pi.Product_id
                               WHERE oi.order_id = ?";
                if ($itemsStmt = $conn->prepare($itemsQuery)) {
                    $itemsStmt->bind_param("i", $orderId);
                    $itemsStmt->execute();
                    $itemsResult = $itemsStmt->get_result();
                    $orderItems = [];
                    if ($itemsResult->num_rows > 0) {
                        while ($item = $itemsResult->fetch_assoc()) {
                            $orderItems[] = $item;  // Store each item in the order
                        }
                    } else {
                        // Debugging line: no items found
                        echo "No items found for order #{$order['order_id']}<br>";
                    }
                    // Add the order and its items to the orders array
                    $orders[] = [
                        'order' => $order,
                        'items' => $orderItems
                    ];

                    $itemsStmt->close();
                } else {
                    echo "Error preparing items query: " . $conn->error;
                }
            }
        } else {
            $errorMsg = "No orders found for this user.";
        }
        $stmt->close();
    } else {
        echo "Error preparing orders query: " . $conn->error;
    }
} else {
    $errorMsg = "User ID not provided.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .order-container {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Order List -->
            <div class="flex-1 bg-white rounded-xl shadow-lg p-4">
                <h2 class="text-2xl font-bold mb-6 text-center">Your Order List</h2>

                <?php
                if (!empty($orders)) {
                    echo '<div class="order-container">';
                    foreach ($orders as $orderData) {
                        $order = $orderData['order'];
                        $items = $orderData['items'];

                        // Display the items for the order
                        if (!empty($items)) {
                            echo "<div class='mt-4'>";
                            foreach ($items as $item) {
                                $status = htmlspecialchars($item['status']);  // Safely output the status

                                // Determine the color class for the status
                                switch ($status) {
                                    case 'Canceled':
                                        $statusClass = 'text-red-600';
                                        break;
                                    case 'Pending':
                                        $statusClass = 'text-blue-600';
                                        break;
                                    case 'Complete':
                                        $statusClass = 'text-green-600';
                                        break;
                                    case 'Shipping':
                                        $statusClass = 'text-yellow-500';
                                        break;
                                    default:
                                        $statusClass = 'text-gray-600';
                                        break;
                                }

                                echo <<<HTML
                    <div class="flex items-center justify-between py-4 border-b">
                        <div class="flex items-center space-x-6">
                            <a href="../Products/Product_view.php?product_id={$item['order_item_id']}">
                                <img src="{$item['Product_image_path']}" alt="{$item['Product_name']}" class="w-16 h-16 object-cover rounded-md shadow-sm"/>
                            </a>

                            <div class="flex flex-col">
                                <a href="../Products/Product_view.php?product_id={$item['order_item_id']}">
                                    <span class="text-lg font-medium text-gray-900">{$item['Product_name']}</span>
                                </a>
                                <span class="text-sm text-gray-500">Quantity: {$item['quantity']}</span>
                                <span class="text-lg text-orange-500">৳{$item['order_amount']}</span>
                            </div>
                        </div>

                        <!-- Status centered in the middle -->
                        <div class="flex justify-center items-center">
                            <span class="text-xl font-bold {$statusClass}">Status: {$status}</span>
                        </div>
<!-- View Details Button triggers AJAX -->
<button class="btn btn-sm btn-info view-details" data-order-item-id="{$item['order_item_id']}">View Details</button>
                    </div>
HTML;
                            }
                            echo "</div>";
                        } else {
                            echo "<p>No items found for this order.</p>";
                        }

                        echo "</div>";
                    }
                    echo '</div>';
                } else {
                    echo "<p>$errorMsg</p>";
                }
                ?>


            </div>

        </div>
    </div>
    <!-- Add an area to display order details -->
    <div id="orderDetails" class="mt-8 p-4 bg-white rounded-xl shadow-lg">
        <!-- Order details will be loaded here by AJAX -->
    </div>
    <script>
        // AJAX for "View Details" button
        $(document).ready(function() {
            $('.view-details').click(function() {
                var orderItemId = $(this).data('order-item-id'); // Get the order item ID

                // Check if the orderItemId is being correctly retrieved
                console.log('Order Item ID:', orderItemId);

                $.ajax({
                    url: './Order_details.php', // The file that contains the order details
                    type: 'GET',
                    data: {
                        order_item_id: orderItemId
                    },
                    success: function(response) {
                        console.log('Response:', response); // Check the response data
                        // Insert the response (the order details) into the orderDetails div
                        $('#content').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', status, error); // Log AJAX error if any
                        alert('Error loading order details');
                    }
                });
            });
        });
    </script>
</body>

</html>