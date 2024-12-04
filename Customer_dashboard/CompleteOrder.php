<?php
session_start();
include "../Database_Connection/DB_Connection.php";

$orders = [];
$errorMsg = '';

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if ($userId) {
    $ordersQuery = "SELECT order_id FROM orders WHERE customer_id = ?";
    if ($stmt = $conn->prepare($ordersQuery)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($order = $result->fetch_assoc()) {
                $orderId = $order['order_id'];
                $itemsQuery = "SELECT oi.order_item_id, pi.Product_id, pi.Product_name, pi.Product_image_path, 
                                      oi.quantity, oi.order_amount, oi.status
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
                            if ($item['status'] == 'Complete') {
                                // Check if feedback already exists for this product
                                $checkReviewQuery = "SELECT review_id FROM review WHERE customer_id = ? AND product_id = ?";
                                if ($reviewStmt = $conn->prepare($checkReviewQuery)) {
                                    $reviewStmt->bind_param("ii", $userId, $item['Product_id']);
                                    $reviewStmt->execute();
                                    $reviewStmt->store_result();
                                    if ($reviewStmt->num_rows > 0) {
                                        $item['already_reviewed'] = true; // Feedback exists
                                    } else {
                                        $item['already_reviewed'] = false; // No feedback yet
                                    }
                                    $reviewStmt->close();
                                }
                                $orderItems[] = $item;
                            }
                        }
                    }
                    if (!empty($orderItems)) {
                        $orders[] = [
                            'order' => $order,
                            'items' => $orderItems
                        ];
                    }
                    $itemsStmt->close();
                } else {
                    $errorMsg = "Error preparing items query: " . $conn->error;
                }
            }
        } else {
            $errorMsg = "No orders found for this user.";
        }
        $stmt->close();
    } else {
        $errorMsg = "Error preparing orders query: " . $conn->error;
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
<?php
if (!empty($orders)) {
    echo '<div class="order-container">';
    foreach ($orders as $orderData) {
        $order = $orderData['order'];
        $items = $orderData['items'];

        if (!empty($items)) {
            echo "<div class='mt-4'>";
            foreach ($items as $item) {
                $status = htmlspecialchars($item['status']);
                $statusClass = 'text-green-600';
                $alreadyReviewed = $item['already_reviewed'];

                echo <<<HTML
                <div class="flex items-center justify-between py-4 border-b">
                    <div class="flex items-center space-x-6">
                        <a href="../Products/Product_view.php?product_id={$item['Product_id']}">
                            <img src="{$item['Product_image_path']}" alt="{$item['Product_name']}" class="w-16 h-16 object-cover rounded-md shadow-sm"/>
                        </a>

                        <div class="flex flex-col">
                            <a href="../Products/Product_view.php?product_id={$item['Product_id']}">
                                <span class="text-lg font-medium text-gray-900">{$item['Product_name']}</span>
                            </a>
                            <span class="text-sm text-gray-500">Quantity: {$item['quantity']}</span>
                            <span class="text-lg text-orange-500">৳{$item['order_amount']}</span>
                        </div>
                    </div>

                    <div class="flex justify-center items-center">
                        <span class="text-xl font-bold {$statusClass}">Status: {$status}</span>
                    </div>
HTML;

                if ($alreadyReviewed) {
                    echo <<<HTML
                    <div class="text-green-600 font-bold">You already provided feedback</div>
HTML;
                } else {
                    echo <<<HTML
                    <button class="btn btn-sm btn-primary feedback-btn" data-order-item-id="{$item['order_item_id']}">Provide Feedback</button>
HTML;
                }

                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No completed items found for this order.</p>";
        }

        echo "</div>";
    }
    echo '</div>';
} else {
    echo "<p>$errorMsg</p>";
}
?>

    <script>
        // AJAX for "Provide Feedback" button
        $(document).ready(function() {
            $('.feedback-btn').click(function() {
                var orderItemId = $(this).data('order-item-id'); // Get the order item ID

                // Check if the orderItemId is being correctly retrieved
                console.log('Order Item ID:', orderItemId);

                $.ajax({
                    url: './Provide_feedback.php', // The file to display feedback form
                    type: 'GET',
                    data: {
                        order_item_id: orderItemId
                    },
                    success: function(response) {
                        console.log('Response:', response); // Check the response data
                        // Insert the response (feedback form) into the feedbackForm div
                        $('#content').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', status, error); // Log AJAX error if any
                        alert('Error loading feedback form');
                    }
                });
            });
        });
    </script>
</body>

</html>
