<?php
session_start();
// Include the database connection file
include "../Database_Connection/DB_Connection.php";

$orderItemId = isset($_GET['order_item_id']) ? $_GET['order_item_id'] : null;
$errorMsg = ''; // Variable to hold error messages
$successMsg = ''; // Variable to hold success messages
$orderDetails = null; // Variable to hold the order details

// If order_item_id is provided
if ($orderItemId) {
    // Query to fetch the order details based on order_item_id
    $orderDetailsQuery = "
    SELECT oi.order_item_id, pi.Product_name, pi.Product_image_path, oi.quantity, oi.order_amount, oi.status, oi.created_at AS order_date
    FROM order_items oi
    JOIN product_info pi ON oi.product_id = pi.Product_id
    WHERE oi.order_item_id = ?
    ";

    if ($stmt = $conn->prepare($orderDetailsQuery)) {
        $stmt->bind_param("i", $orderItemId); // Bind the order_item_id to the query
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the order details
            $orderDetails = $result->fetch_assoc();
        } else {
            $errorMsg = "No order details found.";
        }

        $stmt->close();
    } else {
        $errorMsg = "Error preparing the query: " . $conn->error;
    }

    // Check for any success or error messages passed via the URL
    if (isset($_GET['successMsg']) && !empty($_GET['successMsg'])) {
        $successMsg = urldecode($_GET['successMsg']);
    }

    if (isset($_GET['errorMsg']) && !empty($_GET['errorMsg'])) {
        $errorMsg = urldecode($_GET['errorMsg']);
    }
} else {
    $errorMsg = "No order item ID provided.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-50 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Order details -->
        <?php
        if (!empty($orderDetails)) {
            // Determine the color class for the status
            $statusClass = '';
            $statusText = $orderDetails['status'];

            switch ($statusText) {
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

            echo "
            <div class='bg-white rounded-lg shadow-lg p-6 max-w-sm mx-auto'>
                <h2 class='text-2xl font-bold mb-4 text-center'>Order Details</h2>
                <div class='flex flex-col items-center'>
                    <!-- Increased image size -->
                    <img src='{$orderDetails['Product_image_path']}' alt='{$orderDetails['Product_name']}' class='w-36 h-36 object-cover rounded-md shadow-sm'/>
                    <div class='flex flex-col items-center mt-4'>
                        <span class='text-lg font-medium text-gray-900'>{$orderDetails['Product_name']}</span>
                        <span class='text-sm text-gray-500'>Quantity: {$orderDetails['quantity']}</span>
                        <span class='text-lg text-orange-500'>৳{$orderDetails['order_amount']}</span>
                        <span class='text-sm mt-2 $statusClass'>Status: <span class='font-bold'>{$orderDetails['status']}</span></span>
                    </div>
                </div>
                <div class='mt-6 text-center'>
                    <span class='text-sm text-gray-500'>Order Date: " . date("F j, Y", strtotime($orderDetails['order_date'])) . "</span>
                </div>
                
                <!-- Cancel Order Button (only visible if status is 'Pending') -->
                <form method='POST' action='cancel_order.php?order_item_id={$orderItemId}' class='mt-6 text-center'>
                    <button type='submit' name='cancel_order' class='btn btn-sm btn-danger' 
                        " . ($orderDetails['status'] !== 'Pending' ? 'disabled' : '') . ">
                        " . ($orderDetails['status'] === 'Pending' ? 'Cancel Order' : 'Cannot Cancel') . "
                    </button>
                </form>
                
                <div class='mt-4 text-center'>
                    <a href='Customers_dashboard.php' class='btn btn-sm btn-secondary'>Go Back</a>
                </div>
            </div>";
        } else {
            echo "<p class='text-center text-red-500'>$errorMsg</p>";
        }

        // Display Success or Error Messages
        if (!empty($successMsg)) {
            echo "<div class='alert alert-success text-center text-green-600'>$successMsg</div>";
        } elseif (!empty($errorMsg)) {
            echo "<div class='alert alert-danger text-center text-red-600'>$errorMsg</div>";
        }
        ?>
    </div>

    <!-- Modal HTML -->
    <div id="messageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center" style="display:none;">
        <div class="bg-white rounded-lg p-5 shadow text-center">
            <!-- Success Icon -->
            <i class="fa-solid fa-circle-check fa-5x" style="color: #3feeba;"></i>
            <!-- Success Message -->
            <p id="modalMessage" class="mt-4 text-xl font-semibold"></p> <!-- Message will be dynamically set here -->
            <!-- Close Button -->
            <button onclick="hideModal()" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Close</button>
        </div>
    </div>

    <script>
        // Show modal with the appropriate message
        window.onload = function() {
            <?php if (!empty($successMsg)) { ?>
                document.getElementById('modalMessage').innerText = "<?php echo $successMsg; ?>";
                document.getElementById('messageModal').style.display = 'flex';
            <?php } elseif (!empty($errorMsg)) { ?>
                document.getElementById('modalMessage').innerText = "<?php echo $errorMsg; ?>";
                document.getElementById('messageModal').style.display = 'flex';
            <?php } ?>
        };

        // Hide modal
        function hideModal() {
            document.getElementById('messageModal').style.display = 'none';
        }
    </script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
