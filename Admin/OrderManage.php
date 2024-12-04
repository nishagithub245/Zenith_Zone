<?php
// Database connection
include "../Database_Connection/DB_Connection.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get order items with product name, quantity, order amount, and status
$sql = "SELECT oi.order_item_id, p.Product_name, oi.quantity, oi.order_amount, oi.status
        FROM order_items oi
        JOIN product_info p ON oi.product_id = p.Product_id
        ORDER BY 
            FIELD(oi.status, 'Pending', 'Shipping', 'Complete', 'Canceled')";

$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Start the HTML structure
    echo "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>Order Items List</title>
              <!-- Include Tailwind CSS from CDN -->
              <script src='https://cdn.tailwindcss.com'></script>
          </head>
          <body class='bg-gray-100 p-6'>

              <div class='container mx-auto p-6 bg-white shadow-md rounded-lg'>
                  <h1 class='text-3xl font-semibold text-gray-800 mb-6'>Order Items</h1>

                  <!-- Table -->
                  <div class='overflow-x-auto'>
                      <table class='min-w-full table-auto bg-white shadow-lg rounded-lg border border-gray-200'>
                          <thead class='bg-gray-800 text-white'>
                              <tr>
                                  <th class='px-4 py-2 text-left text-xs sm:text-sm'>Order Item ID</th>
                                  <th class='px-4 py-2 text-left text-xs sm:text-sm'>Product Name</th>
                                  <th class='px-4 py-2 text-left text-xs sm:text-sm'>Quantity</th>
                                  <th class='px-4 py-2 text-left text-xs sm:text-sm'>Order Amount</th>
                                  <th class='px-4 py-2 text-left text-xs sm:text-sm'>Status</th>
                                  <th class='px-4 py-2 text-left text-xs sm:text-sm'>Actions</th> <!-- Add Actions column -->
                              </tr>
                          </thead>
                          <tbody class='text-gray-700'>";

    // Output each row of the result
    while ($row = $result->fetch_assoc()) {
        // Determine the status class based on the order status
        switch (strtolower($row['status'])) {
            case 'pending':
                $status_class = 'yellow'; // Yellow for Pending
                break;
            case 'complete':
            case 'shipping':
                $status_class = 'green'; // Green for Complete and Shipping
                break;
            case 'canceled':
                $status_class = 'red'; // Red for Canceled
                break;
            default:
                $status_class = 'gray'; // Default gray color if status is unknown
        }

        // Button for "View"
        $view_url = "view_order_item.php?order_item_id=" . $row['order_item_id']; // Create a URL for the view page

        echo "<tr class='border-t border-gray-200'>
                <td class='px-4 py-2 text-xs sm:text-sm'>{$row['order_item_id']}</td>
                <td class='px-4 py-2 text-xs sm:text-sm'>{$row['Product_name']}</td>
                <td class='px-4 py-2 text-xs sm:text-sm'>{$row['quantity']}</td>
                <td class='px-4 py-2 text-xs sm:text-sm'>{$row['order_amount']}</td>
                <td class='px-4 py-2 text-xs sm:text-sm'>
                    <span class='bg-{$status_class}-200 text-{$status_class}-800 py-1 px-2 rounded-full'>{$row['status']}</span>
                </td>
                <td class='px-4 py-2 text-xs sm:text-sm'>
    <!-- View Button, using a data attribute to store the order_item_id -->
    <button class='bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 view-order-item' data-order-item-id='{$row['order_item_id']}'>
        View
    </button>
</td>
              </tr>";
    }

    // End the table
    echo "  </tbody>
          </table>
          </div>
          </div>

          <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
          <script>
    $(document).ready(function() {
        // When the View button is clicked
        $('.view-order-item').click(function() {
            var order_item_id = $(this).data('order-item-id'); // Get the order_item_id from the button data attribute
            
            $.ajax({
                url: 'view_order_item.php',  // This is the URL of the view page
                type: 'GET',
                data: { order_item_id: order_item_id }, // Send the order_item_id in the request
                success: function(response) {
                    // When the request is successful, load the response into the content area
                    $('#content').html(response);
                },
                error: function() {
                    alert('An error occurred while loading the order item details.');
                }
            });
        });
    });
</script>

          
          </body>
          </html>";
} else {
    echo "No order items found.";
}

// Close the connection
$conn->close();
