<?php
// Include the database connection file
include "../Database_Connection/DB_Connection.php";

// // Start the session if not already started
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

// Initialize an array to store product details
$products = [];
$errorMsg = ''; // Variable to hold error messages

// Check if 'user_id' is passed as a parameter
if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $customer_id = intval($_GET['user_id']);  // Convert user ID to integer to ensure safety

    // Prepare and execute the query to fetch the user's cart
    $cartQuery = "SELECT cart_id FROM carts WHERE customer_id = ?";
    if ($stmt = $conn->prepare($cartQuery)) {
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Fetch the cart ID
            $row = $result->fetch_assoc();
            $cart_id = $row['cart_id'];
            
            // Prepare and execute the query to fetch cart items from the product_info table using the cart ID
            $itemsQuery = "SELECT ci.product_id, pi.Product_name, pi.Product_Description, pi.New_price, pi.Product_image_path
                           FROM cart_items ci
                           JOIN product_info pi ON ci.product_id = pi.Product_id
                           WHERE ci.cart_id = ?";
            if ($itemsStmt = $conn->prepare($itemsQuery)) {
                $itemsStmt->bind_param("i", $cart_id);
                $itemsStmt->execute();
                $itemsResult = $itemsStmt->get_result();
                
                if ($itemsResult->num_rows > 0) {
                    while ($product = $itemsResult->fetch_assoc()) {
                        $products[] = $product;  // Store each product data in array
                    }
                } else {
                    $errorMsg = "No products in your cart.";
                }
                $itemsStmt->close();
            }
        } else {
            $errorMsg = "No cart found for this user.";
        }
        $stmt->close();
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
  <title>Document</title>
</head>
<?php
include"../Header_Footer/fixed_header.php";
?>
<body>


</body>
</html>