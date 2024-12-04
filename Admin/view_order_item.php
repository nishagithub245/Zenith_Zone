<?php
// Database connection
include "../Database_Connection/DB_Connection.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the order_item_id from the URL parameter
$order_item_id = isset($_GET['order_item_id']) ? $_GET['order_item_id'] : 0;

if ($order_item_id == 0) {
    die("Invalid order item ID.");
}

// SQL query to fetch order item details along with customer and product info
$sql = "SELECT oi.order_item_id, 
               oi.quantity, 
               oi.order_amount, 
               oi.status,
               c.first_name, 
               c.last_name, 
               p.Product_name, 
               p.Product_id,
               p.New_price 
        FROM order_items oi
        JOIN product_info p ON oi.product_id = p.Product_id
        JOIN orders o ON oi.order_id = o.order_id
        JOIN customer_info c ON o.customer_id = c.customer_id
        WHERE oi.order_item_id = ?";

// Prepare the query
$stmt = $conn->prepare($sql);

// Check if the query was prepared successfully
if ($stmt === false) {
    die("SQL prepare failed: " . $conn->error);
}

// Bind the order_item_id parameter to the SQL query
$stmt->bind_param("i", $order_item_id);  // 'i' for integer parameter
$stmt->execute();

// Get the result of the query
$result = $stmt->get_result();

// Check if the order item exists
if ($result->num_rows > 0) {
    // Fetch the order item data
    $row = $result->fetch_assoc();

    // Display the order details
    echo "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>View Order Item</title>
              <!-- Include Tailwind CSS from CDN -->
              <script src='https://cdn.tailwindcss.com'></script>
              <!-- Include jQuery -->
              <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
          </head>
          <body class='bg-gray-100 p-6'>

              <!-- Container -->
              <div class='container mx-auto p-6 bg-white shadow-xl rounded-xl'>
                  <h1 class='text-4xl font-semibold text-gray-800 mb-6 text-center'>Order Item Details</h1>

                  <!-- Order Item Information -->
                  <div class='bg-gray-50 p-6 rounded-lg shadow-md'>
                      <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                          
                          <div class='space-y-3'>
                              <p class='text-lg text-gray-700'><strong>Customer Name:</strong> {$row['first_name']} {$row['last_name']}</p>
                              <p class='text-lg text-gray-700'><strong>Product ID:</strong> {$row['Product_id']}</p>
                              <p class='text-lg text-gray-700'><strong>Product Name:</strong> {$row['Product_name']}</p>
                          </div>
                          
                          <div class='space-y-3'>
                              <p class='text-lg text-gray-700'><strong>Product Price:</strong> Tk. {$row['New_price']}</p>
                              <p class='text-lg text-gray-700'><strong>Quantity:</strong> {$row['quantity']}</p>
                              <p class='text-lg text-gray-700'><strong>Order Amount:</strong> Tk. {$row['order_amount']}</p>
                          </div>
                      </div>
                  </div>

                  <!-- Status Change Form -->
                  <div class='mt-6 bg-white p-6 rounded-lg shadow-md'>
                      <label for='status' class='block text-gray-700 text-lg'>Change Status:</label>
                      <select id='status' class='mt-2 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600'>
                          <option value='Pending'" . ($row['status'] == 'Pending' ? ' selected' : '') . ">Pending</option>
                          <option value='Shipping'" . ($row['status'] == 'Shipping' ? ' selected' : '') . ">Shipping</option>
                          <option value='Complete'" . ($row['status'] == 'Complete' ? ' selected' : '') . ">Complete</option>
                          <option value='Canceled'" . ($row['status'] == 'Canceled' ? ' selected' : '') . ">Canceled</option>
                      </select>
                      <button id='update-status' class='mt-4 w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 focus:outline-none'>
                          Update Status
                      </button>
                  </div> 
              </div>

              <script>
                  // Handle the status update via AJAX
                  $('#update-status').click(function() {
                      var status = $('#status').val();
                      var order_item_id = {$row['order_item_id']};

                      $.ajax({
                          url: './update_order_status.php',
                          type: 'POST',
                          data: {status: status, order_item_id: order_item_id},
                          success: function(response) {
                              alert(response);
                              window.location.href = './Admin_dashboard.php'; 
                          },
                          error: function() {
                              alert('An error occurred while updating the status.');
                          }
                      });
                  });
              </script>
          </body>
          </html>";
} else {
    echo "Order item not found.";
}

// Close the connection
$stmt->close();
$conn->close();
